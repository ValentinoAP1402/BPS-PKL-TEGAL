@extends('admin.layouts.app')

@section('title', 'Kelola Alumni PKL')

{{-- 1. NAVBAR BRANDING (KIRI) --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        {{-- Icon Box (Indigo Theme) --}}
        <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #4338ca; box-shadow: 0 4px 10px rgba(67, 56, 202, 0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 0.85rem; font-weight: 500; color: #64748b; letter-spacing: 0.02em;">
                Menu Admin
            </span>
            <span style="font-size: 1.15rem; font-weight: 700; color: #1e293b; letter-spacing: -0.02em;">
                Kelola Alumni PKL
            </span>
        </div>
    </div>
@endsection

{{-- 2. NAVBAR ACTIONS (KANAN - DUA TOMBOL) --}}
@section('navbar-actions')
    <div style="display: flex; align-items: center; gap: 12px;">
        
        {{-- A. Tombol Kembali ke Dashboard --}}
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

        {{-- B. Tombol Tambah Alumni (Dipindah ke Header) --}}
        <a href="{{ route('admin.alumni_pkl.create') }}" 
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #4f46e5; color: white; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);"
           onmouseover="this.style.background='#4338ca'; this.style.transform='translateY(-1px)';"
           onmouseout="this.style.background='#4f46e5'; this.style.transform='translateY(0)';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Tambah Alumni</span>
        </a>

    </div>
@endsection

{{-- 3. KONTEN UTAMA --}}
@section('content')
    <style>
        /* --- CUSTOM CSS --- */
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        /* Toolbar Section (Hanya Search Box sekarang) */
        .toolbar {
            margin-bottom: 30px;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 400px; /* Lebar search box */
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
            outline: none;
            background: var(--bg-card);
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        /* Grid Layout */
        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        /* Card Design */
        .alumni-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .alumni-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .avatar-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            padding: 4px;
            background: white;
            border: 1px solid var(--border);
            margin-bottom: 16px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .card-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .card-uni {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #f1f5f9; color: #475569; }
        .dot { width: 6px; height: 6px; border-radius: 50%; }

        /* Actions Footer */
        .card-actions {
            margin-top: 20px; width: 100%; padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            display: flex; justify-content: center; gap: 12px;
        }

        .action-btn {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            border: none; cursor: pointer; transition: all 0.2s;
            background: transparent;
        }

        .btn-edit { color: var(--warning); background: #fffbeb; }
        .btn-edit:hover { background: #fcd34d; color: #78350f; }

        .btn-toggle { color: var(--primary); background: #eef2ff; }
        .btn-toggle:hover { background: #c7d2fe; color: #312e81; }

        .btn-delete { color: var(--danger); background: #fef2f2; }
        .btn-delete:hover { background: #fee2e2; color: #991b1b; }

        /* Modal Styles */
        .modal {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        }
        .modal-content {
            background-color: #fff; margin: 10% auto; padding: 0;
            border-radius: 16px; width: 90%; max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideDown 0.3s ease-out; overflow: hidden;
        }
        @keyframes slideDown { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        /* Empty State */
        .empty-state {
            grid-column: 1 / -1; text-align: center; padding: 60px 20px;
            background: white; border-radius: 16px; border: 2px dashed var(--border);
            color: var(--text-muted);
        }
    </style>

    {{-- Toolbar: Hanya Search Box (Tombol Tambah sudah pindah ke atas) --}}
    <div class="toolbar">
        <form action="{{ route('admin.alumni_pkl.index') }}" method="GET" class="search-box">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="search-input" 
                   placeholder="Cari nama atau universitas..." 
                   value="{{ request('search') }}">
        </form>
    </div>

    {{-- Alert Notification --}}
    @if(session('success'))
        <div id="alertSuccess" style="background: #ecfdf5; border-left: 4px solid #10b981; color: #064e3b; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#064e3b; cursor:pointer; font-size:1.2rem;">&times;</button>
        </div>
    @endif

    {{-- Grid Content --}}
    <div class="alumni-grid">
        @forelse($alumni as $alumnus)
            <div class="alumni-card">
                {{-- Foto Profile --}}
                <div class="avatar-container">
                    <img src="{{ Storage::url($alumnus->foto) }}" alt="{{ $alumnus->nama_lengkap }}" class="avatar-img">
                </div>

                {{-- Info Text --}}
                <h3 class="card-name">{{ $alumnus->nama_lengkap }}</h3>
                <p class="card-uni">{{ $alumnus->universitas }}</p>

                {{-- Status Badge --}}
                <div class="status-badge {{ $alumnus->is_active ? 'status-active' : 'status-inactive' }}">
                    <span class="dot" style="background: currentColor;"></span>
                    {{ $alumnus->is_active ? 'Active' : 'Hidden' }}
                </div>

                {{-- Action Buttons --}}
                <div class="card-actions">
                    {{-- Edit --}}
                    <a href="{{ route('admin.alumni_pkl.edit', $alumnus->id) }}" class="action-btn btn-edit" title="Edit Data">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </a>

                    {{-- Toggle Status --}}
                    <form action="{{ route('admin.alumni_pkl.toggle_status', $alumnus->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="action-btn btn-toggle" title="{{ $alumnus->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                            @if($alumnus->is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            @endif
                        </button>
                    </form>

                    {{-- Delete --}}
                    <form action="{{ route('admin.alumni_pkl.destroy', $alumnus->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="action-btn btn-delete" title="Hapus Permanen" 
                            onclick="showDeleteModal(event, '{{ $alumnus->nama_lengkap }}', '{{ $alumnus->universitas }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size: 3rem; margin-bottom: 16px;">🎓</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 8px;">Belum ada Data Alumni</h3>
                <p style="margin-bottom: 24px;">Data alumni PKL yang ditambahkan akan muncul di sini.</p>
                <a href="{{ route('admin.alumni_pkl.create') }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #4f46e5; color: white; border-radius: 10px; font-weight: 600; text-decoration: none;">
                    Tambah Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- MODAL HAPUS --}}
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div style="padding: 24px; text-align: center;">
                <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Hapus Alumni?</h3>
                <p style="color: #64748b; margin-bottom: 24px;">
                    Anda akan menghapus data <strong id="deleteModalNama" style="color: #0f172a;"></strong> dari <span id="deleteModalUniversitas"></span>. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div style="display: flex; gap: 12px;">
                    <button onclick="closeModal()" style="flex: 1; padding: 12px; background: white; border: 1px solid #cbd5e1; border-radius: 8px; font-weight: 600; color: #475569; cursor: pointer;">Batal</button>
                    <button id="confirmDeleteBtn" style="flex: 1; padding: 12px; background: #ef4444; border: none; border-radius: 8px; font-weight: 600; color: white; cursor: pointer;">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto hide alert
        const alertBox = document.getElementById('alertSuccess');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                alertBox.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alertBox.remove(), 500);
            }, 4000);
        }

        // Modal Logic
        function showDeleteModal(event, nama, universitas) {
            event.preventDefault(); 
            document.getElementById('deleteModalNama').textContent = nama;
            document.getElementById('deleteModalUniversitas').textContent = universitas;
            document.getElementById('deleteModal').style.display = 'block';

            // Find parent form
            const button = event.currentTarget; 
            const form = button.closest('form');
            
            document.getElementById('confirmDeleteBtn').onclick = function() {
                if(form) form.submit();
            };
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endsection