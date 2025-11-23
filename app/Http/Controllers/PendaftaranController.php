<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Kuota;
use App\Models\SuratUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        $kuotas = Kuota::all();

        // Sort kuotas in chronological order (January to December)
        $monthOrder = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4, 'Mei' => 5, 'Juni' => 6,
            'Juli' => 7, 'Agustus' => 8, 'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        $kuotas = $kuotas->sort(function ($a, $b) use ($monthOrder) {
            // Parse bulan and tahun from "Bulan Tahun" format
            $aParts = explode(' ', $a->bulan);
            $bParts = explode(' ', $b->bulan);

            $aMonth = $monthOrder[$aParts[0]] ?? 0;
            $bMonth = $monthOrder[$bParts[0]] ?? 0;
            $aYear = (int)($aParts[1] ?? 0);
            $bYear = (int)($bParts[1] ?? 0);

            // Sort by year first, then by month
            if ($aYear !== $bYear) {
                return $aYear <=> $bYear;
            }
            return $aMonth <=> $bMonth;
        })->values();

        $pendaftaranStatus = null;
        $suratMitraNotification = false;
        if (Auth::check()) {
            $pendaftaran = Pendaftaran::where('email', Auth::user()->email)->first();
            if ($pendaftaran) {
                $pendaftaranStatus = $pendaftaran->status;
                if ($pendaftaran->surat_mitra_signed && !session('surat_mitra_visited_' . $pendaftaran->id)) {
                    $suratMitraNotification = true;
                }
            }
        }

        return view('informasi', compact('kuotas', 'pendaftaranStatus', 'suratMitraNotification')); // Halaman Informasi & Kuota
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.google')->with('error', 'Anda harus login terlebih dahulu untuk mendaftar PKL.');
        }
        return view('pendaftaran.form'); // Form Pendaftaran
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.google')->with('error', 'Anda harus login terlebih dahulu untuk mendaftar PKL.');
        }

        // Log request data untuk debug
        Log::info('Pendaftaran store request', $request->all());

        try {
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'asal_sekolah' => 'required|string|max:255',
                'jurusan' => 'required|string|max:255',
                'email' => 'required|email|unique:pendaftarans,email',
                'no_hp' => 'required|string|max:20',
                'surat_keterangan_pkl' => 'required|file|mimes:pdf|max:2048',
                'tanggal_mulai_pkl' => 'required|date',
                'tanggal_selesai_pkl' => 'required|date|after_or_equal:tanggal_mulai_pkl',
            ]);

            Log::info('Validation passed');

            // Tentukan bulan tahun untuk referensi
            $tanggalMulai = Carbon::parse($request->tanggal_mulai_pkl);
            $bulanTahun = $tanggalMulai->translatedFormat('F Y');

            // Cari kuota untuk bulan tersebut
            $kuota = Kuota::where('bulan', $bulanTahun)->first();

            if (!$kuota) {
                return redirect()->back()->with('error', 'Kuota PKL untuk periode ' . $bulanTahun . ' belum tersedia. Silakan hubungi admin.');
            }

            // Periksa apakah kuota masih tersedia
            if (!$kuota->isAvailable()) {
                return redirect()->back()->with('error', 'Maaf, kuota PKL untuk periode ' . $bulanTahun . ' sudah penuh.');
            }

            $path = $request->file('surat_keterangan_pkl')->store('surat_pkl', 'public');

            Log::info('File stored at: ' . $path);

            $pendaftaran = Pendaftaran::create([
                'nama_lengkap' => $request->nama_lengkap,
                'asal_sekolah' => $request->asal_sekolah,
                'jurusan' => $request->jurusan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'surat_keterangan_pkl' => $path,
                'tanggal_mulai_pkl' => $request->tanggal_mulai_pkl,
                'tanggal_selesai_pkl' => $request->tanggal_selesai_pkl,
                'status' => 'pending', // Pastikan default status pending
                'kuota_id' => $kuota->id, // Set kuota_id
            ]);

            Log::info('Pendaftaran created with ID: ' . $pendaftaran->id);

            return redirect()->route('pendaftaran.pendaftaran_berhasil');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            throw $e; // Laravel akan handle redirect dengan errors
        } catch (\Exception $e) {
            Log::error('Error in pendaftaran store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran. Silakan coba lagi.');
        }
    }

    public function suratMitraSigned()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.google')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $pendaftaran = Pendaftaran::where('email', Auth::user()->email)->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Anda harus mengisi pendaftaran terlebih dahulu sebelum dapat melihat surat mitra.');
        }

        // Mark notification as read by setting session flag
        session(['surat_mitra_visited_' . $pendaftaran->id => true]);

        $suratUploads = $pendaftaran->suratUploads;

        return view('pendaftaran.surat_mitra_signed', compact('pendaftaran', 'suratUploads'));
    }

    public function uploadSuratTandaTangan()
    {
        $pendaftaran = Pendaftaran::where('email', Auth::user()->email)->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Anda harus mengisi pendaftaran terlebih dahulu sebelum dapat mengupload surat.');
        }

        $suratUploads = $pendaftaran->suratUploads;

        return view('pendaftaran.upload_surat_tanda_tangan', compact('suratUploads'));
    }

    public function storeSuratTandaTangan(Request $request)
    {
        $request->validate([
            'surat_tanda_tangan' => 'required|file|mimes:pdf|max:2048',
        ]);

        $file = $request->file('surat_tanda_tangan');
        $path = $file->store('surat_tanda_tangan', 'public');

        // Simpan ke pendaftaran user yang sedang login
        $pendaftaran = Pendaftaran::where('email', Auth::user()->email)->first();
        if ($pendaftaran) {
            SuratUpload::create([
                'pendaftaran_id' => $pendaftaran->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => round($file->getSize() / 1024), // KB
            ]);
        }

        return redirect()->route('upload.surat.tanda.tangan')->with('success', 'Surat tanda tangan berhasil diupload.');
    }

    public function deleteSuratUpload($id)
    {
        $suratUpload = SuratUpload::findOrFail($id);

        // Pastikan user hanya bisa hapus surat upload miliknya sendiri
        if ($suratUpload->pendaftaran->email !== Auth::user()->email) {
            return redirect()->route('upload.surat.tanda.tangan')->with('error', 'Anda tidak memiliki akses untuk menghapus surat ini.');
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($suratUpload->file_path);

        // Hapus record dari database
        $suratUpload->delete();

        return redirect()->route('upload.surat.tanda.tangan')->with('success', 'Surat berhasil dihapus.');
    }

    public function pendaftaranBerhasil()
    {
        return view('pendaftaran.pendaftaran_berhasil');
    }

    public function checkQuota(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['error' => 'Date parameter is required'], 400);
        }

        $tanggalMulai = Carbon::parse($date);
        $bulanTahun = $tanggalMulai->translatedFormat('F Y');

        $kuota = Kuota::where('bulan', $bulanTahun)->first();

        if (!$kuota) {
            return response()->json([
                'available' => false,
                'message' => 'Kuota belum tersedia untuk periode ini'
            ]);
        }

        $available = $kuota->isAvailable();

        return response()->json([
            'available' => $available,
            'available_slots' => $kuota->available_slots,
            'total_quota' => $kuota->jumlah_kuota,
            'bulan' => $bulanTahun
        ]);
    }
}
