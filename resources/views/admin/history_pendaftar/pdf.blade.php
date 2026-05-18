<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>History Pendaftaran - {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111827; }
        h2 { margin: 0 0 12px 0; font-size: 18px; }
        .sub { margin: 0 0 14px 0; color:#6b7280; }

        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #d1d5db; padding: 8px; vertical-align: top; }
        th { background: #f3f4f6; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: .04em; color:#374151; }

        .muted { color:#6b7280; font-size: 10px; }
        .nowrap { white-space: nowrap; }

        /* Lebar kolom mirip web */
        .w-no { width: 4%; text-align:center; }
        .w-mhs { width: 18%; }
        .w-kampus { width: 15%; }
        .w-periode { width: 14%; }
        .w-status { width: 10%; }
        .w-keputusan { width: 14%; }
        .w-alasan { width: 25%; }

        .badge {
            display:inline-block; padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 700;
        }
        .ok { background:#dcfce7; color:#166534; }
        .no { background:#fee2e2; color:#991b1b; }
        .warn { background:#ffedd5; color:#9a3412; }
    </style>
</head>
<body>
    <h2>History Pendaftaran Magang BPS Kota Tegal - Tahun {{ $year }}</h2>

    <table>
        <thead>
            <tr>
                <th class="w-no">No</th>
                <th class="w-mhs">Nama Pendaftar</th>
                <th class="w-kampus">Asal Univ/Sekolah & Jurusan</th>
                <th class="w-periode">Periode</th>
                <th class="w-status">Status</th>
                <th class="w-keputusan">Tanggal Keputusan</th>
                <th class="w-alasan">Alasan</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @forelse($histories as $p)
                @php
                    $st = strtolower($p->status ?? '');
                    $statusLabel = match($st) {
                        'approved','diterima' => 'Diterima',
                        'rejected','ditolak'  => 'Ditolak',
                        'pending','menunggu'  => 'Menunggu',
                        default => $st ? ucfirst($st) : '-'
                    };

                    $badgeClass = match($st) {
                        'approved','diterima' => 'ok',
                        'rejected','ditolak'  => 'no',
                        default => 'warn'
                    };

                    $nama   = $p->nama_lengkap ?? '-';
                    $email  = $p->email ?? '-';
                    $kampus = $p->asal_sekolah ?? '-';
                    $jur    = $p->jurusan ?? '-';

                    $mulai   = $p->tanggal_mulai_pkl ? \Carbon\Carbon::parse($p->tanggal_mulai_pkl)->format('d M Y') : '-';
                    $selesai = $p->tanggal_selesai_pkl ? \Carbon\Carbon::parse($p->tanggal_selesai_pkl)->format('d M Y') : '-';

                    $decideAt = $p->decided_at ?? $p->updated_at;
                    $tanggalKeputusan = $decideAt ? \Carbon\Carbon::parse($decideAt)->format('d M Y H:i') : '-';

                    $alasan = in_array($st, ['rejected','ditolak'], true)
                        ? ($p->rejection_reason ?? '-')
                        : '-';
                @endphp

                <tr>
                    <td class="w-no">{{ $no++ }}</td>

                    <td class="w-mhs">
                        <div style="font-weight:700;">{{ $nama }}</div>
                        <div class="muted">{{ $email }}</div>
                    </td>

                    <td class="w-kampus">
                        <div style="font-weight:700;">{{ $kampus }}</div>
                        <div class="muted">{{ $jur }}</div>
                    </td>

                    <td class="w-periode">
                        <div style="font-weight:700;">{{ $mulai }}</div>
                        <div class="muted">s/d {{ $selesai }}</div>
                    </td>

                    <td class="w-status">
                        <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                    </td>

                    <td class="w-keputusan nowrap" style="font-weight:700;">
                        {{ $tanggalKeputusan }}
                    </td>

                    <td class="w-alasan">
                        {{ $alasan }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 18px; color:#6b7280;">
                        Tidak ada data history untuk tahun {{ $year }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>