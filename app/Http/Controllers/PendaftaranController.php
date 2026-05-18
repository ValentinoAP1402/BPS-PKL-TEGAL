<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Kuota;
use App\Models\SuratUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    /**
     * Halaman Informasi (landing/infomasi kuota + status user)
     */
    public function index()
    {
        $kuotas = Kuota::all();

        // Sort kuotas in chronological order (January to December)
        $monthOrder = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4, 'Mei' => 5, 'Juni' => 6,
            'Juli' => 7, 'Agustus' => 8, 'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        $kuotas = $kuotas->sort(function ($a, $b) use ($monthOrder) {
            $aParts = explode(' ', $a->bulan);
            $bParts = explode(' ', $b->bulan);

            $aMonth = $monthOrder[$aParts[0]] ?? 0;
            $bMonth = $monthOrder[$bParts[0]] ?? 0;
            $aYear  = (int)($aParts[1] ?? 0);
            $bYear  = (int)($bParts[1] ?? 0);

            if ($aYear !== $bYear) return $aYear <=> $bYear;
            return $aMonth <=> $bMonth;
        })->values();

        $pendaftaranStatus = null;
        $suratMitraNotification = false;

        if (Auth::check()) {
            // ✅ ambil pendaftaran TERBARU (karena user bisa daftar berkali-kali)
            $pendaftaran = Pendaftaran::where('user_id', Auth::id())
                ->latest()
                ->first();

            if ($pendaftaran) {
                $pendaftaranStatus = $pendaftaran->status;

                if ($pendaftaran->surat_mitra_signed && !session('surat_mitra_visited_' . $pendaftaran->id)) {
                    $suratMitraNotification = true;
                }
            }
        }

        return view('informasi', compact('kuotas', 'pendaftaranStatus', 'suratMitraNotification'));
    }

    /**
     * Tampilkan form pendaftaran
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mendaftar PKL.');
        }

        $user = Auth::user();
        $profileComplete = !empty($user->asal_sekolah) && !empty($user->jurusan) && !empty($user->no_telp);

        if (!$profileComplete) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil Anda terlebih dahulu sebelum mendaftar PKL.');
        }

        /**
         * ✅ FIX UTAMA:
         * User hanya dilarang daftar lagi jika masih ada pengajuan AKTIF (pending/diproses).
         * Jika statusnya rejected/approved/completed => boleh daftar lagi.
         */
        $masihAktif = Pendaftaran::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'menunggu', 'diproses', 'process'])
            ->exists();

        if ($masihAktif) {
            return redirect()->route('home')->with('error', 'Anda masih memiliki pengajuan PKL yang sedang diproses.');
        }

        return view('pendaftaran.form', compact('profileComplete'));
    }

    /**
     * Simpan pendaftaran
     */
    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mendaftar PKL.');
        }

        $user = Auth::user();

        // Cek apakah profil sudah lengkap
        $profileComplete = !empty($user->asal_sekolah) && !empty($user->jurusan) && !empty($user->no_telp);

        if (!$profileComplete) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil Anda terlebih dahulu sebelum mendaftar PKL.');
        }

        // Cek apakah user masih punya pendaftaran yang sedang diproses
        $masihAktif = Pendaftaran::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'menunggu', 'diproses', 'process'])
            ->exists();

        if ($masihAktif) {
            return redirect()->back()->with('error', 'Anda masih memiliki pengajuan PKL yang sedang diproses.');
        }

        // Validasi upload dan tanggal
        $validationRules = [
            'surat_keterangan_pkl' => 'required|file|mimes:pdf|max:2048',
            'tanggal_mulai_pkl' => 'required|date',
            'tanggal_selesai_pkl' => 'required|date|after_or_equal:tanggal_mulai_pkl',
        ];

        $request->validate($validationRules);

        // Tentukan bulan tahun dari tanggal mulai
        Carbon::setLocale('id');
        $tanggalMulai = Carbon::parse($request->tanggal_mulai_pkl);
        $bulanTahun = $tanggalMulai->translatedFormat('F Y'); // contoh: Januari 2026

        // Cari kuota berdasarkan bulan
        $kuota = Kuota::where('bulan', $bulanTahun)->first();

        if (!$kuota) {
            return redirect()->back()->with('error', 'Kuota PKL untuk periode ' . $bulanTahun . ' belum tersedia. Silakan hubungi admin.');
        }

        // Cek apakah kuota masih tersedia
        if (!$kuota->isAvailable()) {
            return redirect()->back()->with('error', 'Maaf, kuota PKL untuk periode ' . $bulanTahun . ' sudah penuh.');
        }

        // Upload file ke storage private
        $path = $request->file('surat_keterangan_pkl')->store('surat_pkl', 'private');

        $pendaftaranAktif = Pendaftaran::where('user_id', Auth::id())
            ->whereIn('status', ['pending','approved'])
            ->first();

        if ($pendaftaranAktif) {
            return back()->with('error','Anda masih memiliki pendaftaran PKL yang sedang diproses.');
        }

            // Simpan pendaftaran baru
            Pendaftaran::create([
            'user_id' => Auth::id(),
            'kuota_id' => $kuota->id,
            'surat_keterangan_pkl' => $path,
            'tanggal_mulai_pkl' => $request->tanggal_mulai_pkl,
            'tanggal_selesai_pkl' => $request->tanggal_selesai_pkl,
            'status' => 'pending',

            // Ambil data dari profil user
            'nama_lengkap' => $user->name,
            'asal_sekolah' => $user->asal_sekolah,
            'jurusan' => $user->jurusan,
            'email' => $user->email,
            'no_hp' => $user->no_telp,
        ]);

        return redirect()->route('home')->with('success_registration', true);
    }

    /**
     * Preview Surat Balasan
     */
    public function previewSuratBalasan()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // ✅ ambil pendaftaran terbaru milik user
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->latest()
            ->first();

        if (!$pendaftaran || !$pendaftaran->surat_balasan_pkl) {
            return redirect()->route('home')->with('error', 'Surat balasan belum tersedia.');
        }

        // ✅ Prioritas: private
        if (Storage::disk('private')->exists($pendaftaran->surat_balasan_pkl)) {
            return response()->file(
                Storage::disk('private')->path($pendaftaran->surat_balasan_pkl),
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="surat_balasan.pdf"',
                ]
            );
        }

        // ✅ Fallback: public (file lama)
        if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
            return response()->file(
                Storage::disk('public')->path($pendaftaran->surat_balasan_pkl),
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="surat_balasan.pdf"',
                ]
            );
        }

        return redirect()->route('home')->with('error', 'File surat balasan tidak ditemukan.');
    }

    /**
     * Download Surat Balasan
     */
    public function downloadSuratBalasan()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = auth()->user();

        // Ambil pendaftaran terbaru milik user
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->first();

        if (!$pendaftaran || !$pendaftaran->surat_balasan_pkl) {
            return redirect()->back()->with('error', 'Surat balasan belum tersedia.');
        }

        $path = $pendaftaran->surat_balasan_pkl;

        $nama = $pendaftaran->nama_lengkap ?: $user->name;
        $downloadName = 'Surat_Balasan_PKL_' . preg_replace('/\s+/', '_', $nama) . '.pdf';

        // ✅ Prioritas: private (lebih aman)
        if (Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->download($path, $downloadName);
        }

        // Fallback: public (file lama)
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $downloadName);
        }

        return redirect()->back()->with('error', 'File surat balasan tidak ditemukan.');
    }

    /**
     * Halaman Surat Mitra Signed
     */
    public function suratMitraSigned()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // ✅ ambil pendaftaran terbaru
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Anda harus mengisi pendaftaran terlebih dahulu sebelum dapat melihat surat mitra.');
        }

        // Mark notification as read
        session(['surat_mitra_visited_' . $pendaftaran->id => true]);

        $suratUploads = $pendaftaran->suratUploads;

        return view('pendaftaran.surat_mitra_signed', compact('pendaftaran', 'suratUploads'));
    }

    public function uploadSuratTandaTangan()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // ✅ ambil pendaftaran terbaru
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Anda harus mengisi pendaftaran terlebih dahulu sebelum dapat mengupload surat.');
        }

        $suratUploads = $pendaftaran->suratUploads;

        return view('pendaftaran.upload_surat_tanda_tangan', compact('suratUploads'));
    }

    public function storeSuratTandaTangan(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'surat_tanda_tangan' => 'required|file|mimes:pdf|max:2048',
        ]);

        // ✅ ambil pendaftaran terbaru
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Anda harus mengisi pendaftaran terlebih dahulu sebelum dapat mengupload surat.');
        }

        $file = $request->file('surat_tanda_tangan');
        $path = $file->store('surat_tanda_tangan', 'private');

        SuratUpload::create([
            'pendaftaran_id' => $pendaftaran->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => (int) ceil($file->getSize() / 1024), // KB
        ]);

        return redirect()->route('upload.surat.tanda.tangan')->with('success', 'Surat tanda tangan berhasil diupload.');
    }

    public function deleteSuratUpload($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $suratUpload = SuratUpload::with('pendaftaran')->findOrFail($id);

        // Anti-IDOR: cek kepemilikan via user_id, bukan email
        if ((int) $suratUpload->pendaftaran->user_id !== (int) Auth::id()) {
            return redirect()->route('upload.surat.tanda.tangan')->with('error', 'Anda tidak memiliki akses untuk menghapus surat ini.');
        }

        Storage::disk('private')->delete($suratUpload->file_path);
        $suratUpload->delete();

        return redirect()->route('upload.surat.tanda.tangan')->with('success', 'Surat berhasil dihapus.');
    }

    public function pendaftaranBerhasil()
    {
        return view('pendaftaran.pendaftaran_berhasil');
    }

    /**
     * AJAX cek kuota
     */
    public function checkQuota(Request $request)
    {
        try {
            $date = $request->query('date');

            if (!$date) {
                return response()->json(['error' => 'Tanggal wajib diisi'], 400);
            }

            Carbon::setLocale('id');
            $tanggalMulai = Carbon::parse($date);
            $bulanTahun = $tanggalMulai->translatedFormat('F Y');

            $kuota = Kuota::where('bulan', $bulanTahun)->first();

            if (!$kuota) {
                return response()->json([
                    'available' => false,
                    'message' => 'Kuota untuk bulan ' . $bulanTahun . ' belum dibuka oleh Admin.'
                ]);
            }

            $sisa = (int) $kuota->available_slots;

            if ($sisa > 0) {
                return response()->json([
                    'available' => true,
                    'message' => "Tersedia " . $sisa . " slot untuk " . $bulanTahun,
                    'sisa_kuota' => $sisa
                ]);
            }

            return response()->json([
                'available' => false,
                'message' => "Mohon maaf, kuota untuk " . $bulanTahun . " sudah penuh."
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
        }
    }
}