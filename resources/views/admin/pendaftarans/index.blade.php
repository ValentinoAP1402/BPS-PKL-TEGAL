@extends('admin.layouts.app')

@section('title', 'Daftar Pendaftar PKL')

{{-- 1. NAVBAR BRANDING --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0f172a; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">Data Pendaftar</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Melihat info dari pendaftar</span>
        </div>
    </div>
@endsection

@section('navbar-actions')
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('admin.dashboard') }}"
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: #64748b; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; border: 1px solid #e2e8f0; transition: all 0.2s;"
           onmouseover="this.style.background='#f8fafc'; this.style.color='#334155';"
           onmouseout="this.style.background='white'; this.style.color='#64748b';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>
    </div>
@endsection

{{-- 2. KONTEN UTAMA --}}
@section('content')
    <style>
        /* --- RESET & BASIC --- */
        :root {
            --primary: #4f46e5;
            --danger: #ef4444;
            --success: #10b981;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --bg-surface: #ffffff;
            --bg-body: #f8fafc;
        }
        .wrapper { width: 100%; max-width: 100%; box-sizing: border-box; }

        /* --- CARD STYLE --- */
        .card {
            background: var(--bg-surface);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }

        /* --- TOOLBAR (Search & Filter) --- */
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

        .search-box { position: relative; }

        .search-input {
            padding: 10px 16px 10px 40px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.9rem;
            outline: none;
            width: 280px;
            transition: border 0.2s;
        }
        .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }

        /* --- TABLE --- */
        .table-responsive { overflow-x: auto; width: 100%; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }

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
        }

        tbody td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: #f9fafb; }

        /* --- COMPONENTS --- */
        .info-text h4 { margin: 0; font-size: 0.95rem; font-weight: 600; color: var(--text-dark); }
        .info-text p { margin: 2px 0 0; font-size: 0.8rem; color: var(--text-light); }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .st-success { background: #dcfce7; color: #166534; }
        .st-danger { background: #fee2e2; color: #991b1b; }
        .st-warning { background: #ffedd5; color: #9a3412; }

        .btn-action {
            width: 34px; height: 34px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; border: none; cursor: pointer;
            transition: all 0.2s; background: transparent;
            color: var(--text-light); margin-left: 4px;
        }
        .btn-action:hover { background: #f1f5f9; color: var(--text-dark); }
        .btn-action.reject:hover { color: #d97706; background: #fef3c7; }
        .btn-action.delete:hover { color: var(--danger); background: #fee2e2; }

        .btn-upload {
            padding: 8px 14px;
            background: var(--primary);
            color: white;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-upload:hover { background: #4338ca; }

        .file-link {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 1px;
            line-height: 1.2;
            padding: 4px 0;
        }
        .file-link:hover { text-decoration: underline; }

        /* ✅ SAMAKAN layout kolom Lihat Surat & Surat Balasan */
        .hidden-file-input { display: none !important; }

        .action-stack{
            display:inline-flex;
            flex-direction:column;
            gap:1px;
            align-items:flex-start;
        }

        .action-stack form{ margin:0; }

        /* --- MODAL --- */
        .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); }
        .modal-content {
            background: white; margin: 10vh auto; padding: 0; border-radius: 16px; width: 90%; max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: slideDown 0.3s ease; overflow: hidden;
        }
        @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .modal-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: #fcfcfc; }
        .modal-title { font-weight: 700; font-size: 1.1rem; color: var(--text-dark); margin: 0; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

        .loading-overlay {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(8px);
            z-index: 99999;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .loading-overlay.active { opacity: 1; }

        .spinner {
            width: 50px; height: 50px;
            border: 5px solid #e2e8f0;
            border-top: 5px solid #4f46e5;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .loading-text {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            background: white;
            padding: 10px 24px;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        @keyframes spin { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }
    </style>

    <div class="wrapper">
        {{-- FLASH ALERT --}}
        @if(session('success'))
            <div style="margin-bottom: 20px; padding: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; color: #15803d; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="margin-bottom: 20px; padding: 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-weight: 500;">
                {{ session('error') }}
            </div>
        @endif

        {{-- CARD CONTAINER --}}
        <div class="card">
            {{-- Toolbar --}}
            <div class="toolbar">
                <form action="{{ route('admin.pendaftarans.index') }}" method="GET" class="search-box">
                    @if($request->has('filter')) <input type="hidden" name="filter" value="{{ $request->filter }}"> @endif
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari nama atau kampus..." value="{{ $request->search }}">
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="24%">Nama Pendaftar</th>
                            <th width="24%">Asal Univ/Sekolah & Jurusan</th>
                            <th width="12%">Periode</th>
                            <th width="10%">Status</th>
                            <th width="10%">Lihat Surat</th>
                            <th width="12%">Surat Balasan</th>
                            <th width="10%" style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $index => $pendaftaran)
                        <tr>
                            <td style="text-align: center; color: var(--text-light);">{{ $pendaftarans->firstItem() + $index }}</td>

                            <td>
                                <div class="info-text">
                                    <h4>{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}</h4>
                                    <p>{{ $pendaftaran->user ? $pendaftaran->user->email : $pendaftaran->email }}</p>
                                </div>
                            </td>

                            <td>
                                <div style="font-weight: 500;">
                                    {{ $pendaftaran->user ? $pendaftaran->user->asal_sekolah : $pendaftaran->asal_sekolah }}
                                </div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">
                                    🎓 {{ $pendaftaran->user ? $pendaftaran->user->jurusan : ($pendaftaran->jurusan ?? '-') }}
                                </div>
                            </td>

                            {{-- ✅ PERIODE (HANYA TANGGAL) --}}
                            <td>
                                <div style="font-size: 0.85rem; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai_pkl)->format('d M Y') }}
                                </div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">
                                    s/d {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai_pkl)->format('d M Y') }}
                                </div>
                            </td>

                            {{-- ✅ STATUS (KOLOM BARU) --}}
                            <td>
                                @php
                                    $st = strtolower($pendaftaran->status ?? '');

                                    $cls = match($st) {
                                        'approved', 'diterima' => 'st-success',
                                        'rejected', 'ditolak'  => 'st-danger',
                                        default                => 'st-warning'
                                    };

                                    $statusText = match($st) {
                                        'approved', 'diterima' => 'Diterima',
                                        'rejected', 'ditolak'  => 'Ditolak',
                                        'pending', 'menunggu'  => 'Menunggu',
                                        default                => $pendaftaran->status ? ucfirst($pendaftaran->status) : '-'
                                    };
                                @endphp

                                <span class="status-badge {{ $cls }}">{{ $statusText }}</span>
                            </td>

                            {{-- ✅ Lihat Surat --}}
                            <td>
                                @if($pendaftaran->surat_keterangan_pkl)
                                    <div class="action-stack">
                                        <a href="{{ route('admin.pendaftarans.surat_pkl.preview', $pendaftaran->id) }}"
                                           target="_blank"
                                           class="file-link">
                                            <i class="fa-regular fa-file-lines"></i>
                                            Lihat Surat
                                        </a>
                                        <a href="{{ route('admin.pendaftarans.surat_pkl.download', $pendaftaran->id) }}"
                                           class="file-link">
                                            <i class="fa-solid fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                @else
                                    <span style="color:#cbd5e1;">-</span>
                                @endif
                            </td>

                            {{-- ✅ Surat Balasan (SAMA STYLE dengan Lihat Surat) --}}
                            <td>
                                @if($pendaftaran->surat_balasan_pkl)
                                    <div class="action-stack">
                                        <a href="{{ route('admin.pendaftarans.surat_balasan.preview', $pendaftaran->id) }}?v={{ urlencode($pendaftaran->updated_at) }}"
                                           target="_blank"
                                           class="file-link">
                                            <i class="fa-regular fa-file"></i>
                                            Lihat File
                                        </a>

                                        <a href="{{ route('admin.pendaftarans.surat_balasan.download', $pendaftaran->id) }}"
                                           class="file-link">
                                            <i class="fa-solid fa-download"></i>
                                            Download
                                        </a>

                                        <form action="{{ route('admin.pendaftarans.surat_balasan.replace', $pendaftaran->id) }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file"
                                                   name="surat_balasan_pkl"
                                                   accept="application/pdf"
                                                   required
                                                   class="hidden-file-input"
                                                   id="replace_file_{{ $pendaftaran->id }}"
                                                   onchange="this.form.submit()">

                                            <a href="#"
                                               class="file-link"
                                               onclick="event.preventDefault(); document.getElementById('replace_file_{{ $pendaftaran->id }}').click();">
                                                <i class="fa-solid fa-rotate"></i>
                                                Ganti
                                            </a>
                                        </form>
                                    </div>
                                @else
                                    @php
                                        $st_balasan = strtolower($pendaftaran->status ?? '');
                                        $canUploadBalasan = $pendaftaran->surat_keterangan_pkl && in_array($st_balasan, ['pending', 'menunggu']);
                                    @endphp

                                    @if($canUploadBalasan)
                                        <div class="action-stack">
                                            <a href="#"
                                               class="file-link"
                                               onclick="showUploadModal(event, '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ $pendaftaran->id }}')">
                                                <i class="fa-solid fa-upload"></i>
                                                Upload
                                            </a>
                                        </div>
                                    @else
                                        <span style="color:#cbd5e1;">-</span>
                                    @endif
                                @endif
                            </td>

                            {{-- ✅ Aksi --}}
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end;">
                                    @if(in_array(strtolower($pendaftaran->status ?? ''), ['pending', 'menunggu']))
                                        <button class="btn-action reject" title="Tolak"
                                            onclick="showRejectModal(event, '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ $pendaftaran->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                            </svg>
                                        </button>
                                    @else
                                        <button class="btn-action delete" title="Hapus"
                                            onclick="openModal('deleteModal', '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ route('admin.pendaftarans.destroy', $pendaftaran) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-light);">
                                <div style="margin-bottom: 10px; opacity: 0.5;">📂</div>
                                Belum ada data pendaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pendaftarans->hasPages())
                <div style="padding: 16px 24px; border-top: 1px solid var(--border);">
                    {{ $pendaftarans->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL UPLOAD --}}
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Upload Surat Balasan</h3>
                <span style="cursor: pointer; font-size: 1.5rem;" onclick="closeModal('uploadModal')">&times;</span>
            </div>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p style="margin-bottom: 16px; color: var(--text-light);">Upload file PDF untuk <strong id="uploadName" style="color: var(--text-dark);"></strong>.</p>
                    <input type="file" name="surat_balasan_pkl" accept=".pdf" required style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('uploadModal')" style="padding: 8px 16px; background: white; border: 1px solid var(--border); border-radius: 6px; cursor: pointer;">Batal</button>
                    <button type="submit" class="btn-upload" style="font-size: 0.9rem;">Simpan & Terima</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div id="rejectModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header" style="background: #fffbeb;">
                <h3 class="modal-title" style="color: #92400e;">Konfirmasi Tolak</h3>
                <span style="cursor: pointer;" onclick="closeModal('rejectModal')">&times;</span>
            </div>

            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="margin-bottom: 12px;">
                        Yakin ingin menolak pendaftaran <strong id="rejectName"></strong>?
                    </p>

                    <label for="rejection_reason"
                        style="display:block; font-size: 0.9rem; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">
                        Alasan penolakan <span style="color:#ef4444;">*</span>
                    </label>

                    <textarea
                        id="rejection_reason"
                        name="rejection_reason"
                        rows="4"
                        required
                        placeholder="Contoh: Berkas belum lengkap / kuota bulan terkait sudah penuh / jurusan tidak sesuai, dll."
                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 10px; resize: vertical; outline: none;"
                    ></textarea>

                    <small style="display:block; margin-top: 6px; color: var(--text-light);">
                        Alasan ini akan tampil di dashboard & profil pendaftar.
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="button"
                        onclick="closeModal('rejectModal')"
                        style="padding: 8px 16px; background: white; border: 1px solid var(--border); border-radius: 6px; cursor: pointer;">
                        Batal
                    </button>

                    <button type="submit"
                        style="padding: 8px 16px; background: #d97706; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                        Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header" style="background: #fef2f2;">
                <h3 class="modal-title" style="color: #991b1b;">Hapus Permanen?</h3>
                <span style="cursor: pointer;" onclick="closeModal('deleteModal')">&times;</span>
            </div>
            <div class="modal-body">
                <p>Data <strong id="deleteName"></strong> akan dihapus selamanya. Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('deleteModal')" style="padding: 8px 16px; background: white; border: 1px solid var(--border); border-radius: 6px; cursor: pointer;">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding: 8px 16px; background: #ef4444; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Sedang Memproses File...</div>
    </div>

    <script>
        // Modal Helper
        function openModal(id, name, url) {
            document.getElementById(id).style.display = 'block';
            if(name) {
                const el = document.getElementById(id.replace('Modal', 'Name'));
                if(el) el.innerText = name;
            }
            if(url) {
                const form = document.getElementById(id.replace('Modal', 'Form'));
                if(form) form.action = url;
            }
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        // Show Upload Modal
        function showUploadModal(event, name, asalSekolah, id) {
            event.preventDefault();
            document.getElementById('uploadModal').style.display = 'block';
            document.getElementById('uploadName').innerText = name + ' (' + asalSekolah + ')';
            document.getElementById('uploadForm').action = '/admin/pendaftarans/' + id + '/upload-surat-balasan';
        }

        // Show Reject Modal
        function showRejectModal(event, name, asalSekolah, id) {
            event.preventDefault();
            document.getElementById('rejectModal').style.display = 'block';
            document.getElementById('rejectName').innerText = name + ' (' + asalSekolah + ')';
            document.getElementById('rejectForm').action = '/admin/pendaftarans/' + id + '/reject';

            // Reset input alasan setiap kali modal dibuka
            const reason = document.getElementById('rejection_reason');
            if (reason) {
                reason.value = '';
                setTimeout(() => reason.focus(), 50);
            }
        }

        // Close when clicking outside
        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const uploadForm = document.getElementById('uploadForm');

            if (uploadForm) {
                uploadForm.addEventListener('submit', function() {
                    document.getElementById('uploadModal').style.display = 'none';

                    const overlay = document.getElementById('loadingOverlay');
                    overlay.style.display = 'flex';

                    setTimeout(() => {
                        overlay.classList.add('active');
                    }, 5);
                });
            }
        });
    </script>
@endsection