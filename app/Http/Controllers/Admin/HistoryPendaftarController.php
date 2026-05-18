<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HistoryPendaftarController extends Controller
{
    /**
     * Halaman History Pendaftar (INDEX)
     * - hanya status diterima/ditolak
     * - include data yang sudah diarsipkan (soft deleted)
     */
    public function index(Request $request)
    {
        $year = (int) $request->get('year', now()->year);

        // Ambil daftar tahun yang tersedia (berdasarkan decided_at atau updated_at)
        $availableYears = Pendaftaran::withTrashed()
            ->selectRaw("YEAR(COALESCE(decided_at, updated_at)) as y")
            ->whereNotNull(DB::raw("COALESCE(decided_at, updated_at)"))
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->distinct()
            ->orderByDesc('y')
            ->pluck('y');

        // Data histories + pagination (agar blade aman karena pakai links())
        $histories = Pendaftaran::withTrashed()
            ->with('user')
            ->whereYear(DB::raw("COALESCE(decided_at, updated_at)"), $year)
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->orderByDesc(DB::raw("COALESCE(decided_at, updated_at)"))
            ->paginate(10)
            ->withQueryString();

        return view('admin.history_pendaftar.index', compact('histories', 'availableYears', 'year'));
    }

    /**
     * Export Excel sesuai tabel web History Pendaftaran
     */
    public function exportExcel(Request $request)
    {
        $year = (int) $request->get('year', now()->year);
        $histories = $this->getHistoryData($year);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("History {$year}");

        // Judul
        $sheet->setCellValue('A1', "History Pendaftaran Magang BPS Kota Tegal - Tahun {$year}");
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Header sesuai tabel web
        $headers = ['No', 'Nama Pendaftar', 'Asal Univ/Sekolah & Jurusan', 'Periode', 'Status', 'Tanggal Keputusan', 'Alasan'];

        $startHeaderRow = 3;
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . $startHeaderRow, $h);
            $col++;
        }

        // Style header
        $headerRange = "A{$startHeaderRow}:G{$startHeaderRow}";
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
        $sheet->getStyle($headerRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Isi data
        $row = $startHeaderRow + 1;
        $no = 1;

        foreach ($histories as $p) {
            $nama  = $p->nama_lengkap ?? ($p->user->name ?? '-');
            $email = $p->email ?? ($p->user->email ?? '-');

            $kampus = $p->asal_sekolah ?? '-';
            $jur    = $p->jurusan ?? '-';

            $mulai = $p->tanggal_mulai_pkl ? \Carbon\Carbon::parse($p->tanggal_mulai_pkl)->format('d M Y') : '-';
            $selesai = $p->tanggal_selesai_pkl ? \Carbon\Carbon::parse($p->tanggal_selesai_pkl)->format('d M Y') : '-';

            $st = strtolower((string) ($p->status ?? ''));
            $statusLabel = $this->mapStatusLabel($st);

            $decideAtRaw = $p->decided_at ?? $p->updated_at;
            $tanggalKeputusan = $decideAtRaw ? \Carbon\Carbon::parse($decideAtRaw)->format('d M Y, H:i') : '-';

            $alasan = in_array($st, ['rejected', 'ditolak'])
                ? ($p->rejection_reason ?? '-')
                : '-';

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", "{$nama}\n{$email}");
            $sheet->setCellValue("C{$row}", "{$kampus}\n{$jur}");
            $sheet->setCellValue("D{$row}", "{$mulai} s/d {$selesai}");
            $sheet->setCellValue("E{$row}", $statusLabel);
            $sheet->setCellValue("F{$row}", $tanggalKeputusan);
            $sheet->setCellValue("G{$row}", $alasan);

            $sheet->getStyle("A{$row}:G{$row}")->getAlignment()->setWrapText(true);
            $sheet->getStyle("A{$row}:G{$row}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $row++;
        }

        // Lebar kolom
        foreach (range('A', 'G') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "history_pendaftar_{$year}.xlsx";
        $tempPath = storage_path("app/{$filename}");
        $writer->save($tempPath);

        return Response::download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Export PDF sesuai tabel web History Pendaftaran
     */
    public function exportPdf(Request $request)
    {
        $year = (int) $request->get('year', now()->year);
        $histories = $this->getHistoryData($year);

        $pdf = Pdf::loadView('admin.history_pendaftar.pdf', [
            'year' => $year,
            'histories' => $histories,
        ])->setPaper('a4', 'landscape');

        $filename = "history_pendaftar_{$year}.pdf";
        return $pdf->download($filename);
    }

    /**
     * Delete history PERMANEN hanya super admin (guard admin)
     * Route ini sudah ada middleware auth.admin.super, tapi kita double-check.
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Akses ditolak.');
        }

        // Dengan withTrashed() kita bisa hapus permanen baik yang masih aktif maupun yang sudah diarsipkan
        $p = Pendaftaran::withTrashed()->findOrFail($id);

        // Permanen
        $p->forceDelete();

        return back()->with('success', 'History pendaftar berhasil dihapus permanen.');
    }

    /**
     * Ambil data history (tanpa pagination) untuk export
     */
    private function getHistoryData(int $year)
    {
        return Pendaftaran::withTrashed()
            ->with('user')
            ->whereYear(DB::raw("COALESCE(decided_at, updated_at)"), $year)
            ->whereIn('status', ['approved', 'rejected', 'diterima', 'ditolak'])
            ->orderByDesc(DB::raw("COALESCE(decided_at, updated_at)"))
            ->get();
    }

    private function mapStatusLabel(string $st): string
    {
        return match ($st) {
            'approved', 'diterima' => 'Diterima',
            'rejected', 'ditolak'  => 'Ditolak',
            'pending', 'menunggu'  => 'Menunggu',
            default => $st ? ucfirst($st) : '-',
        };
    }
}