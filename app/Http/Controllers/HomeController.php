<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\Kuota;
use App\Models\AlumniPkl;

class HomeController extends Controller
{
    public function index()
    {
        $suratMitraNotification = false;
        $hasPendaftaran = false;
        $kuotas = Kuota::all();
        $alumni = AlumniPkl::where('is_active', true)->get();

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
        if (Auth::check()) {
            $pendaftaran = Pendaftaran::where('email', Auth::user()->email)->first();
            if ($pendaftaran) {
                $hasPendaftaran = true;
                $pendaftaranStatus = $pendaftaran->status;
                if ($pendaftaran->surat_mitra_signed && !session('surat_mitra_visited_' . $pendaftaran->id)) {
                    $suratMitraNotification = true;
                }
            }
        }

        return view('home', compact('suratMitraNotification', 'hasPendaftaran', 'pendaftaranStatus', 'kuotas', 'alumni'));
    }

    public function timBps()
    {
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

        return view('tim-bps', compact('pendaftaranStatus', 'suratMitraNotification'));
    }
}
