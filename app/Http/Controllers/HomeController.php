<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\Kuota;
use App\Models\AlertMessage;

class HomeController extends Controller
{
    public function index()
    {
        // --- 1. DATA UMUM ---
        $kuotas = Kuota::all();

        // AMBIL ALERT MESSAGE DARI DATABASE (ADMIN)
        $alertData = AlertMessage::where('key', 'pkl_warning')->first();
        $pesan_admin = ($alertData && $alertData->is_active) ? $alertData->message : null;

        // Sorting Kuota
        $monthOrder = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4, 'Mei' => 5, 'Juni' => 6,
            'Juli' => 7, 'Agustus' => 8, 'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];

        $kuotas = $kuotas->sort(function ($a, $b) use ($monthOrder) {
            $aParts = explode(' ', $a->bulan);
            $bParts = explode(' ', $b->bulan);
            $aMonth = $monthOrder[$aParts[0]] ?? 0;
            $bMonth = $monthOrder[$bParts[0]] ?? 0;
            $aYear = (int)($aParts[1] ?? 0);
            $bYear = (int)($bParts[1] ?? 0);
            return $aYear === $bYear ? $aMonth <=> $bMonth : $aYear <=> $bYear;
        })->values();

        // --- 2. LOGIKA ALUR ---
        $stepStatus = [1 => 'active', 2 => 'pending', 3 => 'pending'];
        $pendaftaran = null;
        $profileComplete = false;
        $suratMitraNotification = false;

        if (Auth::check()) {
            $user = Auth::user();
            $profileComplete = !empty($user->asal_sekolah) && !empty($user->jurusan) && !empty($user->no_telp);

            $stepStatus[1] = 'completed';
            $stepStatus[2] = 'active';

            $pendaftaran = Pendaftaran::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($pendaftaran) {
                $stepStatus[2] = 'completed';
                $stepStatus[3] = 'active';

                // ✅ FIX: normalisasi status (biar "REJECTED", "rejected", dll kebaca)
                $status = strtolower($pendaftaran->status ?? '');

                // Step 3 dianggap selesai jika sudah ada keputusan (approved/diterima/ditolak/rejected)
                if (in_array($status, ['approved', 'diterima', 'ditolak', 'rejected'], true)) {
                    $stepStatus[3] = 'completed';
                }

                if ($pendaftaran->surat_mitra_signed && !session('surat_mitra_visited_' . $pendaftaran->id)) {
                    $suratMitraNotification = true;
                }
            }
        }

        return view('home', compact(
        'kuotas',
        'pesan_admin',
        'pendaftaran',
        'stepStatus',
        'profileComplete',
        'suratMitraNotification'
        ));
    }

    public function timBps()
    {
        $pendaftaranStatus = null;
        $suratMitraNotification = false;

        if (Auth::check()) {
            $pendaftaran = Pendaftaran::where('user_id', Auth::user()->id)->first();
            if ($pendaftaran) {
                $pendaftaranStatus = $pendaftaran->status;
                if ($pendaftaran->surat_mitra_signed && !session('surat_mitra_visited_' . $pendaftaran->id)) {
                    $suratMitraNotification = true;
                }
            }
        }

        return view('tim-bps', compact('pendaftaranStatus', 'suratMitraNotification'));
    }
}
