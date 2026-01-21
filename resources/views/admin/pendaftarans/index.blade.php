@extends('admin.layouts.app')

@section('title', 'Daftar Pendaftar PKL')

{{-- 1. NAVBAR BRANDING --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0f172a; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
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
        :root { --primary: #4f46e5; --danger: #ef4444; --success: #10b981; --text-dark: #1e293b; --text-light: #64748b; --border: #e2e8f0; --bg-surface: #ffffff; --bg-body: #f8fafc; }
        .wrapper { width: 100%; max-width: 100%; box-sizing: border-box; }
        
        /* --- CARD STYLE --- */
        .card {
            background: var(--bg-surface);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            overflow: hidden; /* Penting agar tabel tidak keluar */
            margin-bottom: 24px;
        }

        /* --- TOOLBAR (Search & Filter) --- */
        .toolbar { padding: 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px; border-bottom: 1px solid var(--border); flex-wrap: wrap; background: #fcfcfc; }
        .tab-group { display: flex; gap: 4px; background: #f1f5f9; padding: 4px; border-radius: 8px; }
        .tab-link {
            padding: 8px 16px; font-size: 0.85rem; font-weight: 600; text-decoration: none; color: var(--text-light); border-radius: 6px; transition: all 0.2s;
        }
        .tab-link.active { background: white; color: var(--primary); box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .tab-link:hover:not(.active) { color: var(--text-dark); background: rgba(255,255,255,0.5); }
        
        .search-box { position: relative; }
        .search-input {
            padding: 10px 16px 10px 40px; border-radius: 8px; border: 1px solid var(--border);
            font-size: 0.9rem; outline: none; width: 280px; transition: border 0.2s;
        }
        .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }

        /* --- TABLE --- */
        .table-responsive { overflow-x: auto; width: 100%; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; /* Mencegah tabel menyempit jelek */ }
        
        thead th {
            background: #f8fafc; text-align: left; padding: 16px 24px;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-light); border-bottom: 1px solid var(--border);
        }
        
        tbody td {
            padding: 16px 24px; border-bottom: 1px solid var(--border);
            vertical-align: middle; /* KUNCI KERAPIHAN */
            color: var(--text-dark); font-size: 0.9rem;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: #f9fafb; }

        /* --- COMPONENTS --- */
        .user-info { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 40px; height: 40px; border-radius: 50%; background: #e0e7ff;
            color: var(--primary); display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }
        .info-text h4 { margin: 0; font-size: 0.95rem; font-weight: 600; color: var(--text-dark); }
        .info-text p { margin: 2px 0 0; font-size: 0.8rem; color: var(--text-light); }

        .status-badge {
            display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600; text-transform: capitalize;
        }
        .st-success { background: #dcfce7; color: #166534; }
        .st-danger { background: #fee2e2; color: #991b1b; }
        .st-warning { background: #ffedd5; color: #9a3412; }

        .btn-action {
            width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s; background: transparent;
            color: var(--text-light); margin-left: 4px;
        }
        .btn-action:hover { background: #f1f5f9; color: var(--text-dark); }
        .btn-action.view:hover { color: var(--primary); background: #e0e7ff; }
        .btn-action.reject:hover { color: #d97706; background: #fef3c7; }
        .btn-action.delete:hover { color: var(--danger); background: #fee2e2; }

        .btn-upload {
            padding: 8px 14px; background: var(--primary); color: white; border-radius: 6px;
            font-size: 0.8rem; font-weight: 600; border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-upload:hover { background: #4338ca; }
        
        .file-link {
            color: var(--primary); font-weight: 600; font-size: 0.85rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .file-link:hover { text-decoration: underline; }

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
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        background: rgba(255, 255, 255, 0.4); /* Warna putih transparan */
        backdrop-filter: blur(8px); /* INI YANG MEMBUAT EFEK BLUR */
        z-index: 99999; /* Pastikan di atas semua elemen */
        display: none; /* Hidden by default */
        flex-direction: column; 
        align-items: center; 
        justify-content: center;
        opacity: 0; 
        transition: opacity 0.3s ease;
    }

    .loading-overlay.active {
        opacity: 1;
    }

    .spinner {
        width: 50px; 
        height: 50px;
        border: 5px solid #e2e8f0; 
        border-top: 5px solid #4f46e5; /* Warna Primary */
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

    @keyframes spin { 
        0% { transform: rotate(0deg); } 
        100% { transform: rotate(360deg); } 
    }
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
                            <th width="25%">Mahasiswa</th>
                            <th width="15%">Asal Kampus</th>
                            <th width="15%">Periode</th>
                            <th width="10%">Lihat Surat</th>
                            <th width="15%">Surat Balasan</th>
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
                                <div style="font-weight: 500;">{{ $pendaftaran->asal_sekolah }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">{{ $pendaftaran->jurusan ?? '-' }}</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai_pkl)->format('d M Y') }}
                                </div>
                                <div style="font-size: 0.8rem; color: var(--text-light);">
                                    s/d {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai_pkl)->format('d M Y') }}
                                </div>
                                {{-- Status Badge Kecil dibawah tanggal --}}
                                @php
                                    $st = strtolower($pendaftaran->status);
                                    $cls = match($st) {
                                        'approved', 'diterima' => 'st-success',
                                        'rejected', 'ditolak' => 'st-danger',
                                        default => 'st-warning'
                                    };
                                @endphp
                                <div style="margin-top: 6px;">
                                    <span class="status-badge {{ $cls }}">{{ ucfirst($pendaftaran->status) }}</span>
                                </div>
                            </td>
                            <td>
                                @if($pendaftaran->surat_keterangan_pkl)
                                    <a href="{{ asset('storage/' . $pendaftaran->surat_keterangan_pkl) }}" target="_blank" class="file-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path></svg>
                                        Lihat Surat
                                    </a>
                                @else
                                    <span style="color: #cbd5e1;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pendaftaran->surat_balasan_pkl)
                                    <a href="{{ asset('storage/' . $pendaftaran->surat_balasan_pkl) }}" target="_blank" class="file-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path></svg>
                                        Lihat File
                                    </a>
                                @else
                                    @if(!in_array(strtolower($pendaftaran->status), ['ditolak', 'rejected']))
                                        <button type="button" class="btn-upload" onclick="showUploadModal(event, '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ $pendaftaran->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                            Upload
                                        </button>
                                    @else
                                        <span style="color: #cbd5e1;">-</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end;">
                                    
                                    @if(in_array(strtolower($pendaftaran->status), ['pending', 'menunggu']))
                                        {{-- Reject --}}
                                        <button class="btn-action reject" title="Tolak" onclick="showRejectModal(event, '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ $pendaftaran->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        </button>
                                    @else
                                        {{-- Delete --}}
                                        <button class="btn-action delete" title="Hapus" onclick="openModal('deleteModal', '{{ $pendaftaran->user ? $pendaftaran->user->name : $pendaftaran->nama_lengkap }}', '{{ route('admin.pendaftarans.destroy', $pendaftaran) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-light);">
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
            <div class="modal-body">
                <p>Yakin ingin menolak pendaftaran <strong id="rejectName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('rejectModal')" style="padding: 8px 16px; background: white; border: 1px solid var(--border); border-radius: 6px; cursor: pointer;">Batal</button>
                <form id="rejectForm" method="POST">
                    @csrf
                    <button type="submit" style="padding: 8px 16px; background: #d97706; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Ya, Tolak</button>
                </form>
            </div>
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
                if(document.getElementById(id.replace('Modal', 'Name')))
                    document.getElementById(id.replace('Modal', 'Name')).innerText = name;
            }
            if(url) {
                if(document.getElementById(id.replace('Modal', 'Form')))
                    document.getElementById(id.replace('Modal', 'Form')).action = url;
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
        }

        // Handle Upload Form Submit
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal('uploadModal');
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.style.cssText = 'margin-bottom: 20px; padding: 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; color: #15803d; font-weight: 500; display: flex; align-items: center; gap: 10px;';
                    successDiv.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' + data.message;
                    document.querySelector('.wrapper').prepend(successDiv);
                    // Reload page after 2 seconds
                    setTimeout(() => location.reload(), 2000);
                } else {
                    // Show error
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat upload');
            });
        });

        // Close when clicking outside
        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
    const uploadForm = document.getElementById('uploadForm');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            // JANGAN PAKAI e.preventDefault(); biar form submit normal dan halaman reload
            
            // 1. Tutup modal upload
            document.getElementById('uploadModal').style.display = 'none';
            
            // 2. Tampilkan Loading Overlay
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.display = 'flex';
            
            // 3. Efek animasi muncul
            setTimeout(() => {
                overlay.classList.add('active');
            }, 5);
        });
    }
});
    </script>
@endsection