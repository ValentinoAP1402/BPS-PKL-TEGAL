@extends('admin.layouts.app')

@section('title', 'History Pendaftar')

@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0f172a; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3v18h18"></path>
                <path d="M18 17V9"></path>
                <path d="M13 17V5"></path>
                <path d="M8 17v-3"></path>
            </svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">History Pendaftaran</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Rekap pendaftar (filter & export)</span>
        </div>
    </div>
@endsection

@section('navbar-actions')
    <div style="display:flex; gap:10px;">
        <a href="{{ route('admin.dashboard') }}"
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: #64748b; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; border: 1px solid #e2e8f0; transition: all 0.2s;"
           onmouseover="this.style.background='#f8fafc'; this.style.color='#334155';"
           onmouseout="this.style.background='white'; this.style.color='#64748b';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>
    </div>
@endsection

@section('content')
@php
    $isSuperAdmin = auth()->guard('admin')->check();
    $year = $year ?? (int) request('year', now()->year);
    $availableYears = $availableYears ?? collect([$year]);
@endphp

<style>
    :root {
        --primary: #453de4;
        --danger: #ef4444;
        --success: #10b981;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --border: #e2e8f0;
        --bg-surface: #ffffff;
        --bg-body: #f8fafc;
    }

    /* ✅ wrapper */
    .wrapper { width: 100%; max-width: 100%; box-sizing: border-box; }

    /* ✅ full width container (biar melebar sampai tanda hijau) */
    .container,
    .content-wrapper .container,
    .content .container,
    main .container {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 28px !important;
        padding-right: 28px !important;
    }

    @media (min-width: 1536px){
        .container,
        .content-wrapper .container,
        .content .container,
        main .container {
            padding-left: 48px !important;
            padding-right: 48px !important;
        }
    }

    /* --- CARD --- */
    .card {
        background: var(--bg-surface);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-bottom: 24px;
        width: 100%;
    }

    /* --- TOOLBAR --- */
    .toolbar {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
        background: #fcfcfc;
    }

    .toolbar-left { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
    .toolbar-right { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

    .search-box { position: relative; }
    .search-input {
        padding: 10px 16px 10px 40px;
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 0.9rem;
        outline: none;
        width: 280px;
        transition: border 0.2s;
        background: #fff;
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.10);
    }
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }

    .select {
        height: 40px;
        min-width: 130px;
        padding: 0 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-weight: 700;
        color: #0f172a;
        outline: none;
        background: #fff;
    }

    .btn {
    height: 40px;
    padding: 0 18px;
    font-size: 0.90rem;
    border-radius: 999px;
    border: none;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all .2s ease;
    white-space: nowrap;
    }

    /* Tombol Terapkan */
    .btn {
        background: rgb(69, 61, 228);
        color: #ffffff;
    }
    .btn:hover {
        background: rgb(69, 61, 228);
        transform: translateY(-1px);
    }

    /* Export Excel */
    .btn-success {
        background: rgb(50, 201, 16);
        color: #ffffff;
    }
    .btn-success:hover {
        background: rgb(50, 201, 16);
        transform: translateY(-1px);
    }

    /* Export PDF */
    .btn-danger {
        background: rgb(255, 0, 0);
        color: #ffffff;
    }
    .btn-danger:hover {
        background: rgb(255, 0, 0);
        transform: translateY(-1px);
    }

    /* --- TABLE --- */
    .table-responsive { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; }
    table {
        width: 100%;
        border-collapse: collapse;
        
    }

    thead th {
        background: #f8fafc;
        text-align: left;
        padding: 16px 24px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-light);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    tbody td {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
        vertical-align: top;
        color: var(--text-dark);
        font-size: 0.9rem;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background-color: #f9fafb; }

    /* --- COMPONENTS --- */
    .info-text h4 { margin: 0; font-size: 0.95rem; font-weight: 600; color: var(--text-dark); }
    .info-text p  { margin: 2px 0 0; font-size: 0.8rem; color: var(--text-light); }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        white-space: nowrap;
    }
    .st-success { background: #dcfce7; color: #166534; }
    .st-danger  { background: #fee2e2; color: #991b1b; }
    .st-warning { background: #ffedd5; color: #9a3412; }

    .btn-action {
        width: 34px; height: 34px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; border: none; cursor: pointer;
        transition: all 0.2s; background: transparent;
        color: var(--text-light);
        margin-left: 4px;
    }
    .btn-action:hover { background: #f1f5f9; color: var(--text-dark); }
    .btn-action.delete:hover { color: var(--danger); background: #fee2e2; }

    .muted { color: var(--text-light); font-weight: 600; font-size: 0.85rem; }
    .text-center {
    text-align: center;
    }

    /* ✅ tanggal keputusan selalu kelihatan */
    .decide-cell{
        font-weight: 600;
        white-space: nowrap;
    }

    /* ✅ alasan rapi, tidak bikin layout rusak */
    .reason-cell{
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.35;
        word-break: break-word;
        overflow-wrap: anywhere;

    }
</style>

<div class="wrapper">
    @if(session('success'))
        <div style="margin-bottom: 20px; padding: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; color: #15803d; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="margin-bottom: 20px; padding: 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="toolbar">
            <div class="toolbar-left">
                <div class="search-box">
                    <span class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input id="searchHistory" type="text" class="search-input" placeholder="Cari nama atau kampus...">
                </div>

                <form method="GET" action="{{ route('admin.history_pendaftar.index') }}"
                      style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <label style="font-weight:700;color:#334155;">Filter Tahun:</label>
                    <select name="year" class="select">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ (int)$year === (int)$y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn">Terapkan</button>
                </form>
            </div>

            <div class="toolbar-right">
                <a class="btn btn-success" href="{{ route('admin.history_pendaftar.export_excel', ['year' => $year]) }}">Export Excel</a>
                <a class="btn btn-danger" href="{{ route('admin.history_pendaftar.export_pdf', ['year' => $year]) }}">Export PDF</a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="historyTable">
                <thead>
                    <tr>
                        <th style="width:4%;">No</th>
                        <th style="width:18%;">Nama Pendaftar</th>
                        <th style="width:18%;">Asal Univ/Sekolah & Jurusan</th>
                        <th style="width:10%;">Periode</th>
                        <th style="width:1%;">Status</th>
                        <th style="width:12%;">Tanggal Keputusan</th>
                        <th style="width:20%;">Alasan</th>
                        @if($isSuperAdmin)
                            <th style="width:6%; text-align:right;">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                @forelse($histories as $pendaftaran)
                    @php
                        $st = strtolower($pendaftaran->status ?? '');
                        $cls = match($st) {
                            'approved', 'diterima' => 'st-success',
                            'rejected', 'ditolak'  => 'st-danger',
                            default               => 'st-warning',
                        };

                        $statusLabel = match($st) {
                            'approved', 'diterima' => 'Diterima',
                            'rejected', 'ditolak'  => 'Ditolak',
                            default => ucfirst($st ?: '-'),
                        };

                        $no = ($histories->firstItem() ?? 1) + $loop->index;

                        $nama   = $pendaftaran->nama_lengkap ?? '-';
                        $email  = $pendaftaran->email ?? '-';
                        $kampus = $pendaftaran->asal_sekolah ?? '-';
                        $jur    = $pendaftaran->jurusan ?? '-';

                        $mulai   = $pendaftaran->tanggal_mulai_pkl ? \Carbon\Carbon::parse($pendaftaran->tanggal_mulai_pkl)->format('d M Y') : '-';
                        $selesai = $pendaftaran->tanggal_selesai_pkl ? \Carbon\Carbon::parse($pendaftaran->tanggal_selesai_pkl)->format('d M Y') : '-';

                        $decide = optional($pendaftaran->decided_at ?? $pendaftaran->updated_at)->format('d M Y H:i') ?? '-';

                        $alasan = in_array($st, ['rejected','ditolak'], true) ? ($pendaftaran->rejection_reason ?? '-') : '-';

                        $rowSearch = strtolower($nama.' '.$email.' '.$kampus.' '.$jur);
                    @endphp

                    <tr class="history-row" data-search="{{ $rowSearch }}">
                        <td style="text-align:center;" class="muted">{{ $no }}</td>

                        <td>
                            <div class="info-text">
                                <h4>{{ $nama }}</h4>
                                <p>{{ $email }}</p>
                            </div>
                        </td>

                        <td>
                            <div style="font-weight: 500;">{{ $kampus }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">{{ $jur }}</div>
                        </td>

                        {{-- ✅ PERIODE: HANYA TANGGAL --}}
                        <td>
                            <div style="font-size: 0.85rem; font-weight: 500;">{{ $mulai }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">s/d {{ $selesai }}</div>
                        </td>

                        <td>
                            <span class="status-badge {{ $cls }}">{{ $statusLabel }}</span>
                        </td>

                        {{-- ✅ TANGGAL KEPUTUSAN (dibenerin) --}}
                        <td class="decide-cell">{{ $decide }}</td>

                        {{-- ✅ ALASAN (dibenerin) --}}
                        <td class="reason-cell" title="{{ $alasan }}">
                            {{ $alasan }}
                        </td>

                        @if($isSuperAdmin)
                            <td style="text-align:right;">
                                <form action="{{ route('admin.history_pendaftar.destroy', $pendaftaran->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus permanen data ini?');"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus Permanen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                            <path d="M10 11v6"></path>
                                            <path d="M14 11v6"></path>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isSuperAdmin ? 8 : 7 }}" style="text-align: center; padding: 40px; color: var(--text-light);">
                            Belum ada data history untuk tahun {{ $year }}.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($histories->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid var(--border);">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    (function(){
        const input = document.getElementById('searchHistory');
        const rows  = document.querySelectorAll('.history-row');
        if(!input) return;

        input.addEventListener('input', function(){
            const q = (this.value || '').toLowerCase().trim();
            rows.forEach(r => {
                const hay = (r.getAttribute('data-search') || '');
                r.style.display = hay.includes(q) ? '' : 'none';
            });
        });
    })();
</script>
@endsection 