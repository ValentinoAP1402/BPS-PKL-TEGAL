<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Kuota;
use App\Models\Pendaftaran;
use App\Models\SuratUpload;
use App\Models\AlertMessage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function replaceSuratBalasan(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'surat_balasan_pkl' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5MB
        ]);

        // Upload file baru (PUBLIC)
        $newPath = $request->file('surat_balasan_pkl')->store('surat_balasan', 'public');

        // Hapus file lama (kalau ada) - cek public dulu lalu private
        if (!empty($pendaftaran->surat_balasan_pkl)) {
            if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
                Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
            } elseif (Storage::disk('private')->exists($pendaftaran->surat_balasan_pkl)) {
                Storage::disk('private')->delete($pendaftaran->surat_balasan_pkl);
            }
        }

        // Simpan path baru + update status
        $pendaftaran->surat_balasan_pkl = $newPath;
        $pendaftaran->status = 'approved';
        $pendaftaran->decided_at = now();
        $pendaftaran->rejection_reason = null;
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Surat balasan berhasil diganti.');
    }

    public function index()
    {
        // SoftDeletes: query default TIDAK menghitung yang trashed -> aman
        $total_pendaftar = Pendaftaran::count();

        $bulan_sekarang = Carbon::now()->translatedFormat('F Y');
        $kuota_bulan_ini = Kuota::where('bulan', $bulan_sekarang)->first()?->available_slots ?? 0;

        // Catatan: ini perhitungan global, bukan kuota per-bulan
        $total_kuota_tersedia = Kuota::sum('jumlah_kuota') - Pendaftaran::where('status', 'approved')->count();

        $surat_mitra = Pendaftaran::whereNotNull('surat_mitra_signed')->count();

        return view('admin.dashboard', compact('total_pendaftar', 'kuota_bulan_ini', 'total_kuota_tersedia', 'surat_mitra'));
    }

    public function listPendaftarans(Request $request)
    {
        // Data Pendaftar: tampilkan semua status (menunggu/diterima/ditolak/dll)
        // SoftDeletes: yang diarsip (trashed) TIDAK ikut tampil di sini -> sesuai konsep "arsip"
        $query = Pendaftaran::with('user')->orderBy('created_at', 'desc');

        if ($request->has('filter') && $request->filter === 'surat_mitra') {
            $query->whereNotNull('surat_tanda_tangan');
        }

        $pendaftarans = $query->paginate(10)->withQueryString();
        return view('admin.pendaftarans.index', compact('pendaftarans', 'request'));
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
            'surat_mitra_signed' => 'required|file|mimes:pdf|max:5120',
        ]);

        $suratUpload = SuratUpload::findOrFail($id);

        if ($request->hasFile('surat_mitra_signed')) {
            // hapus file lama
            if ($suratUpload->surat_mitra_signed && Storage::disk('public')->exists($suratUpload->surat_mitra_signed)) {
                Storage::disk('public')->delete($suratUpload->surat_mitra_signed);
            }

            $path = $request->file('surat_mitra_signed')->store('surat_mitra_signed', 'public');
            $suratUpload->surat_mitra_signed = $path;
            $suratUpload->save();

            // Update pendaftaran
            $suratUpload->pendaftaran->surat_mitra_signed = $path;

            $statusLama = $suratUpload->pendaftaran->status;
            $suratUpload->pendaftaran->status = 'approved';
            $suratUpload->pendaftaran->decided_at = now();
            $suratUpload->pendaftaran->rejection_reason = null;
            $suratUpload->pendaftaran->save();

            // Notif
            $suratUpload->pendaftaran->notify(new \App\Notifications\SuratMitraSignedNotification($suratUpload->pendaftaran));

            if ($statusLama !== 'approved') {
                $suratUpload->pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($suratUpload->pendaftaran, 'approved'));
            }
        }

        return redirect()->route('admin.surat_mitra')
            ->with('success', 'Surat mitra yang sudah ditandatangani berhasil diupload dan status pendaftaran telah diubah menjadi Diterima.');
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('admin.pendaftarans.show', compact('pendaftaran'));
    }

    public function approvePendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status === 'approved') {
            return redirect()->route('admin.pendaftarans.index')->with('warning', 'Pendaftaran ini sudah di-approve sebelumnya.');
        }

        $tanggalMulai = Carbon::parse($pendaftaran->tanggal_mulai_pkl);
        $bulanTahun = $tanggalMulai->translatedFormat('F Y');

        $kuota = Kuota::where('bulan', $bulanTahun)->first();

        if (!$kuota || $kuota->available_slots <= 0) {
            return redirect()->route('admin.pendaftarans.show', $pendaftaran->id)
                ->with('error', 'Gagal approve: Kuota PKL untuk bulan ' . $bulanTahun . ' sudah penuh atau tidak tersedia.');
        }

        if (!$pendaftaran->kuota_id) {
            $pendaftaran->kuota_id = $kuota->id;
        }

        $pendaftaran->status = 'approved';
        $pendaftaran->rejection_reason = null;
        $pendaftaran->decided_at = now();
        $pendaftaran->save();

        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'approved'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran berhasil di-approve.');
    }

    public function rejectPendaftaran(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 3 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $pendaftaran->rejection_reason = trim($validated['rejection_reason']);
        $pendaftaran->status = 'rejected';
        $pendaftaran->decided_at = now();
        $pendaftaran->save();

        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'rejected'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran berhasil di-reject.');
    }

    public function completePendaftaran(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== 'approved') {
            return redirect()->route('admin.pendaftarans.index')->with('warning', 'Pendaftaran hanya bisa diselesaikan jika statusnya APPROVED.');
        }

        $pendaftaran->status = 'completed';
        $pendaftaran->save();

        $pendaftaran->notify(new \App\Notifications\PendaftaranStatusNotification($pendaftaran, 'completed'));

        return redirect()->route('admin.pendaftarans.index')->with('success', 'Pendaftaran PKL atas nama ' . $pendaftaran->nama_lengkap . ' telah berhasil diselesaikan.');
    }

    public function downloadSuratTandaTangan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_tanda_tangan) {
            return redirect()->back()->with('error', 'File surat tanda tangan tidak ditemukan.');
        }

        $downloadName = 'Surat_TTD_' . preg_replace('/\s+/', '_', $pendaftaran->nama_lengkap) . '.pdf';

        if (Storage::disk('private')->exists($pendaftaran->surat_tanda_tangan)) {
            return Storage::disk('private')->download($pendaftaran->surat_tanda_tangan, $downloadName);
        }

        if (Storage::disk('public')->exists($pendaftaran->surat_tanda_tangan)) {
            return Storage::disk('public')->download($pendaftaran->surat_tanda_tangan, $downloadName);
        }

        return redirect()->back()->with('error', 'File surat tanda tangan tidak ditemukan.');
    }

    public function downloadSuratKeterangan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_keterangan_pkl) {
            return redirect()->route('admin.pendaftarans.index')->with('error', 'File surat keterangan PKL tidak ditemukan.');
        }

        $downloadName = 'Surat_PKL_' . preg_replace('/\s+/', '_', $pendaftaran->nama_lengkap) . '.pdf';

        if (Storage::disk('private')->exists($pendaftaran->surat_keterangan_pkl)) {
            return Storage::disk('private')->download($pendaftaran->surat_keterangan_pkl, $downloadName);
        }

        if (Storage::disk('public')->exists($pendaftaran->surat_keterangan_pkl)) {
            return Storage::disk('public')->download($pendaftaran->surat_keterangan_pkl, $downloadName);
        }

        return redirect()->route('admin.pendaftarans.index')->with('error', 'File surat keterangan PKL tidak ditemukan.');
    }

    public function previewSuratPkl($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_keterangan_pkl) {
            abort(404);
        }

        if (Storage::disk('private')->exists($pendaftaran->surat_keterangan_pkl)) {
            return response()->file(Storage::disk('private')->path($pendaftaran->surat_keterangan_pkl), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="surat_pkl.pdf"',
            ]);
        }

        if (Storage::disk('public')->exists($pendaftaran->surat_keterangan_pkl)) {
            return response()->file(Storage::disk('public')->path($pendaftaran->surat_keterangan_pkl), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="surat_pkl.pdf"',
            ]);
        }

        abort(404);
    }

    public function downloadSuratPkl($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_keterangan_pkl) {
            abort(404);
        }

        $downloadName = 'Surat_PKL_' . preg_replace('/\s+/', '_', $pendaftaran->nama_lengkap) . '.pdf';

        if (Storage::disk('private')->exists($pendaftaran->surat_keterangan_pkl)) {
            return Storage::disk('private')->download($pendaftaran->surat_keterangan_pkl, $downloadName);
        }

        if (Storage::disk('public')->exists($pendaftaran->surat_keterangan_pkl)) {
            return Storage::disk('public')->download($pendaftaran->surat_keterangan_pkl, $downloadName);
        }

        abort(404);
    }

    public function previewSuratBalasan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_balasan_pkl) {
            return redirect()->back()->with('error', 'File surat balasan tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
            $path = Storage::disk('public')->path($pendaftaran->surat_balasan_pkl);
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="surat_balasan.pdf"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }

        if (Storage::disk('private')->exists($pendaftaran->surat_balasan_pkl)) {
            $path = Storage::disk('private')->path($pendaftaran->surat_balasan_pkl);
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="surat_balasan.pdf"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }

        return redirect()->back()->with('error', 'File surat balasan tidak ditemukan.');
    }

    public function downloadSuratBalasan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if (!$pendaftaran->surat_balasan_pkl) {
            return redirect()->back()->with('error', 'File surat balasan tidak ditemukan.');
        }

        $downloadName = 'Surat_Balasan_' . preg_replace('/\s+/', '_', $pendaftaran->nama_lengkap) . '.pdf';

        if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
            return Storage::disk('public')->download($pendaftaran->surat_balasan_pkl, $downloadName);
        }

        if (Storage::disk('private')->exists($pendaftaran->surat_balasan_pkl)) {
            return Storage::disk('private')->download($pendaftaran->surat_balasan_pkl, $downloadName);
        }

        return redirect()->back()->with('error', 'File surat balasan tidak ditemukan.');
    }

    public function destroyPendaftaran(Pendaftaran $pendaftaran)
    {
        // Soft delete = arsip, JANGAN hapus file pendukung (untuk keperluan history/export/audit)
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftarans.index')
            ->with('success', 'Pendaftaran atas nama ' . $pendaftaran->nama_lengkap . ' berhasil diarsipkan.');
    }

    // ================= SURAT BALASAN =================

    public function uploadSuratBalasan(Request $request, $id)
    {
        $request->validate([
            'surat_balasan_pkl' => 'required|file|mimes:pdf|max:2048',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->surat_balasan_pkl) {
            if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
                Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
            }
        }

        $file = $request->file('surat_balasan_pkl');
        $path = $file->store('surat_balasan', 'public');

        $statusLama = $pendaftaran->status;

        $pendaftaran->update([
            'surat_balasan_pkl'  => $path,
            'status'             => 'approved',
            'decided_at'         => now(),
            'rejection_reason'   => null,
        ]);

        if ($statusLama !== 'approved') {
            $pendaftaran->notify(new \App\Notifications\SuratBalasanNotification($pendaftaran));
        }

        $message = 'Surat berhasil diupload dan status pendaftaran telah diubah menjadi Diterima.';

        if (!($request->expectsJson() || $request->ajax())) {
            return redirect()->back()->with('success', $message);
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function deleteSuratBalasan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->surat_balasan_pkl) {
            if (Storage::disk('public')->exists($pendaftaran->surat_balasan_pkl)) {
                Storage::disk('public')->delete($pendaftaran->surat_balasan_pkl);
            }

            $pendaftaran->update([
                'surat_balasan_pkl' => null,
            ]);

            return redirect()->back()->with('success', 'Surat balasan PKL berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada surat balasan untuk dihapus.');
    }

    // ================= HISTORY PENDAFTAR (LEGACY) =================
    // NOTE:
    // Di routes/web.php kamu sudah pakai HistoryPendaftarController.
    // Method legacy ini tidak dipakai oleh route saat ini. Jika ingin, boleh dihapus.

    public function historyPendaftar(Request $request)
    {
        $tahun = (int)($request->get('tahun', now()->year));

        $histories = Pendaftaran::withTrashed()
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->whereYear('created_at', $tahun)
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.history_pendaftar.index', compact('histories', 'tahun'));
    }

    public function exportHistoryPendaftarExcel(Request $request)
    {
        $tahun = (int)($request->get('tahun', now()->year));

        $rows = Pendaftaran::withTrashed()
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->whereYear('created_at', $tahun)
            ->orderByDesc('updated_at')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Nama Lengkap',
            'Jurusan',
            'Tanggal Submit',
            'Periode PKL',
            'Status',
            'Tanggal Keputusan',
            'Alasan (jika ditolak)',
        ];

        foreach ($headers as $i => $h) {
            $sheet->setCellValueByColumnAndRow($i + 1, 1, $h);
        }

        $r = 2;
        foreach ($rows as $p) {
            $statusLabel = in_array(strtolower((string)$p->status), ['approved', 'diterima'])
                ? 'Diterima'
                : 'Ditolak';

            $sheet->setCellValueByColumnAndRow(1, $r, $p->nama_lengkap);
            $sheet->setCellValueByColumnAndRow(2, $r, $p->jurusan);
            $sheet->setCellValueByColumnAndRow(3, $r, optional($p->created_at)->format('d-m-Y'));
            $sheet->setCellValueByColumnAndRow(4, $r, $p->tanggal_mulai_pkl . ' s/d ' . $p->tanggal_selesai_pkl);
            $sheet->setCellValueByColumnAndRow(5, $r, $statusLabel);
            $sheet->setCellValueByColumnAndRow(6, $r, optional($p->decided_at ?? $p->updated_at)->format('d-m-Y'));
            $sheet->setCellValueByColumnAndRow(7, $r, in_array(strtolower((string)$p->status), ['rejected','ditolak']) ? ($p->rejection_reason ?? '-') : '-');

            $r++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "history_pendaftar_{$tahun}.xlsx";

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportHistoryPendaftarPdf(Request $request)
    {
        $tahun = (int)($request->get('tahun', now()->year));

        $histories = Pendaftaran::withTrashed()
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->whereYear('created_at', $tahun)
            ->orderByDesc('updated_at')
            ->get();

        $pdf = Pdf::loadView('admin.history_pendaftar.pdf', compact('histories', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("history_pendaftar_{$tahun}.pdf");
    }

    // ================= ALERT MESSAGE =================

    public function alertMessage()
    {
        $alertMessage = AlertMessage::where('key', 'pkl_warning')->first();
        return view('admin.alert_message', compact('alertMessage'));
    }

    public function updateAlertMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $isActive = $request->boolean('is_active');

        AlertMessage::updateOrCreate(
            ['key' => 'pkl_warning'],
            [
                'message' => $request->message,
                'is_active' => $isActive
            ]
        );

        return redirect()->route('admin.alert_message')->with('success', 'Konfigurasi pesan berhasil diperbarui.');
    }
}