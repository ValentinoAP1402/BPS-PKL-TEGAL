<?php

namespace App\Http\Controllers;

use App\Models\Kuota;
use App\Models\Pendaftaran;
use App\Models\SuratUpload;
use App\Models\AlumniPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung statistik untuk dashboard
        $total_pendaftar = Pendaftaran::count();
        $bulan_sekarang = Carbon::now()->translatedFormat('F Y');
        $kuota_bulan_ini = Kuota::where('bulan', $bulan_sekarang)->first()?->available_slots ?? 0;

        // Hitung total kuota tersedia dari semua bulan
        $total_kuota_tersedia = Kuota::sum('jumlah_kuota') - Pendaftaran::where('status', 'approved')->count();

        $surat_mitra = Pendaftaran::whereNotNull('surat_mitra_signed')->count();

        // Tampilan dashboard admin
        return view('admin.dashboard', compact('total_pendaftar', 'kuota_bulan_ini', 'total_kuota_tersedia', 'surat_mitra'));
    }

    public function listPendaftarans(Request $request)
    {
        $query = Pendaftaran::orderBy('created_at', 'desc');

        if ($request->has('filter') && $request->filter === 'surat_mitra') {
            $query->whereNotNull('surat_tanda_tangan');
        }

        $pendaftarans = $query->get();
        return view('admin.pendaftarans.index', compact('pendaftarans'));
    }

    public function kelolaSuratMitra()
    {
        $pendaftarans = Pendaftaran::whereHas('suratUploads')
            ->with('suratUploads')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.surat_mitra', compact('pendaftarans'));
    }

    public function uploadSuratMitraSigned(Request $request, $id)
    {
        $request->validate([
            'surat_mitra_signed' => 'required|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        $suratUpload = SuratUpload::findOrFail($id);

        if ($request->hasFile('surat_mitra_signed')) {
            // Delete old file if exists
            if ($suratUpload->surat_mitra_signed && Storage::exists($suratUpload->surat_mitra_signed)) {
                Storage::delete($suratUpload->surat_mitra_signed);
            }

            // Store new file
            $path = $request->file('surat_mitra_signed')->store('surat_mitra_signed', 'public');
            $suratUpload->surat_mitra_signed = $path;
            $suratUpload->save();

            // Update pendaftaran surat_mitra_signed field for notification
            $suratUpload->pendaftaran->surat_mitra_signed = $path;
            $suratUpload->pendaftaran->save();

            // Kirim notifikasi email ke calon PKL
            $suratUpload->pendaftaran->notify(new \App\Notifications\SuratMitraSignedNotification($suratUpload->pendaftaran));
        }

        return redirect()->route('admin.surat_mitra')->with('success', 'Surat mitra yang sudah ditandatangani berhasil diupload.');
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('admin.pendaftarans.show', compact('pendaftaran'));
    }

    public function approvePendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Pastikan pendaftaran belum pernah di-approve sebelumnya untuk menghindari pengurangan kuota ganda
        if ($pendaftaran->status === 'approved') {
            return redirect()->route('admin.pendaftarans.index')->with('warning', 'Pendaftaran ini sudah di-approve sebelumnya.');
        }

        // 1. Tentukan bulan dan tahun dari tanggal mulai PKL pendaftar
        $tanggalMulai = Carbon::parse($pendaftaran->tanggal_mulai_pkl);
        $bulanTahun = $tanggalMulai->translatedFormat('F Y'); // Format harus sama dengan yang di admin kuota

        // 2. Cari kuota untuk bulan tersebut
        $kuota = Kuota::where('bulan', $bulanTahun)->first();

        // 3. Cek ketersediaan kuota sebelum approve
        if (!$kuota || $kuota->available_slots <= 0) {
            // Jika kuota tidak tersedia, jangan approve
            return redirect()->route('admin.pendaftarans.show', $pendaftaran->id)
                             ->with('error', 'Gagal approve: Kuota PKL untuk bulan ' . $bulanTahun . ' sudah penuh atau tidak tersedia.');
        }

        // 4. Set kuota_id jika belum ada (untuk pendaftaran lama)
        if (!$pendaftaran->kuota_id) {
            $pendaftaran->kuota_id = $kuota->id;
        }

        // 5. Ubah status pendaftaran menjadi 'approved' (kuota otomatis berkurang via available_slots)
        $pendaftaran->status = 'approved';
        $pendaftaran->save();

        // Kirim notifikasi email
        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'approved'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran berhasil di-approve.');
    }

    public function rejectPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Jika pendaftaran sebelumnya sudah di-approve, kuota otomatis kembali via available_slots
        if ($pendaftaran->status === 'approved') {
            $pendaftaran->status = 'rejected';
            $pendaftaran->save();
            // Kirim notifikasi email
            $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'rejected'));
            return redirect()->route('admin.pendaftarans.index')->with('info', 'Pendaftaran di-reject. Kuota telah dikembalikan.');
        }

        $pendaftaran->status = 'rejected';
        $pendaftaran->save();

        // Kirim notifikasi email
        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'rejected'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran berhasil di-reject.');
    }

    public function completePendaftaran(Pendaftaran $pendaftaran) // Gunakan Route Model Binding
    {
        // Pastikan hanya pendaftaran yang sudah approved yang bisa diselesaikan
        if ($pendaftaran->status !== 'approved') {
            return redirect()->route('admin.pendaftarans.index')->with('warning', 'Pendaftaran hanya bisa diselesaikan jika statusnya APPROVED.');
        }

        $pendaftaran->status = 'completed'; // Ubah status menjadi 'completed'
        $pendaftaran->save();

        // Kirim notifikasi email
        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'completed'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran PKL atas nama ' . $pendaftaran->nama_lengkap . ' telah berhasil diselesaikan.');
    }

    public function downloadSuratTandaTangan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_tanda_tangan || !Storage::disk('public')->exists($pendaftaran->surat_tanda_tangan)) {
            return redirect()->route('admin.pendaftarans.show', $pendaftaran->id)->with('error', 'File surat tanda tangan tidak ditemukan.');
        }

        return response()->download(storage_path('app/public/' . $pendaftaran->surat_tanda_tangan));
    }

    public function destroyPendaftaran(Pendaftaran $pendaftaran) // Gunakan Route Model Binding
    {
        // Untuk menghapus, kuota otomatis kembali jika status approved/completed via available_slots
        // Hapus file surat jika ada
        if ($pendaftaran->surat_keterangan_pkl && Storage::disk('public')->exists($pendaftaran->surat_keterangan_pkl)) {
            Storage::disk('public')->delete($pendaftaran->surat_keterangan_pkl);
        }
        if ($pendaftaran->surat_tanda_tangan && Storage::disk('public')->exists($pendaftaran->surat_tanda_tangan)) {
            Storage::disk('public')->delete($pendaftaran->surat_tanda_tangan);
        }
        if ($pendaftaran->surat_mitra_signed && Storage::disk('public')->exists($pendaftaran->surat_mitra_signed)) {
            Storage::disk('public')->delete($pendaftaran->surat_mitra_signed);
        }
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran atas nama ' . $pendaftaran->nama_lengkap . ' berhasil dihapus.');
    }

    // Alumni PKL Management
    public function alumniPklIndex()
    {
        $alumni = AlumniPkl::orderBy('created_at', 'desc')->get();
        return view('admin.alumni_pkl.index', compact('alumni'));
    }

    public function alumniPklCreate()
    {
        return view('admin.alumni_pkl.create');
    }

    public function alumniPklStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alumni_pkl', 'public');
        }

        AlumniPkl::create([
            'nama_lengkap' => $request->nama_lengkap,
            'universitas' => $request->universitas,
            'foto' => $fotoPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.alumni_pkl.index')->with('success', 'Alumni PKL berhasil ditambahkan.');
    }

    public function alumniPklEdit($id)
    {
        $alumni = AlumniPkl::findOrFail($id);
        return view('admin.alumni_pkl.edit', compact('alumni'));
    }

    public function alumniPklUpdate(Request $request, $id)
    {
        $alumni = AlumniPkl::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = $alumni->foto;
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
                Storage::disk('public')->delete($alumni->foto);
            }
            $fotoPath = $request->file('foto')->store('alumni_pkl', 'public');
        }

        $alumni->update([
            'nama_lengkap' => $request->nama_lengkap,
            'universitas' => $request->universitas,
            'foto' => $fotoPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.alumni_pkl.index')->with('success', 'Alumni PKL berhasil diperbarui.');
    }

    public function alumniPklDestroy($id)
    {
        $alumni = AlumniPkl::findOrFail($id);

        // Delete photo if exists
        if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
            Storage::disk('public')->delete($alumni->foto);
        }

        $alumni->delete();

        return redirect()->route('admin.alumni_pkl.index')->with('success', 'Alumni PKL berhasil dihapus.');
    }

    public function alumniPklToggleStatus($id)
    {
        $alumni = AlumniPkl::findOrFail($id);
        $alumni->update(['is_active' => !$alumni->is_active]);

        $status = $alumni->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.alumni_pkl.index')->with('success', 'Status alumni PKL berhasil ' . $status . '.');
    }

    public function uploadSuratBalasan(Request $request, $id)
{
    $request->validate([
        'surat_balasan' => 'required|file|mimes:pdf|max:2048',
    ]);

    $pendaftaran = Pendaftaran::findOrFail($id);

    // Hapus file lama jika ada
    if ($pendaftaran->surat_balasan_pkl) {
        Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
    }

    // Upload file baru
    $file = $request->file('surat_balasan');
    $path = $file->store('surat_balasan', 'public');

    $pendaftaran->update([
        'surat_balasan_pkl' => $path,
    ]);

    // Kirim notifikasi email ke calon PKL
    $pendaftaran->notify(new \App\Notifications\SuratBalasanNotification($pendaftaran));

    return redirect()->back()->with('success', 'Surat balasan PKL berhasil diupload.');
}

public function deleteSuratBalasan($id)
{
    $pendaftaran = Pendaftaran::findOrFail($id);
    
    if ($pendaftaran->surat_balasan_pkl) {
        Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
        
        $pendaftaran->update([
            'surat_balasan_pkl' => null,
        ]);

        return redirect()->back()->with('success', 'Surat balasan PKL berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'Tidak ada surat balasan untuk dihapus.');
}
}
