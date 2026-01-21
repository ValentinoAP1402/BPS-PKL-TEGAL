@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('navbar-actions')
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            Logout
        </button>
    </form>
@endsection

@section('content')
    {{-- 1. WELCOME SECTION --}}
    <div class="welcome-section">
        <div class="welcome-content">
            <h1>Halo, {{ Auth::guard('admin')->user()->username }}! 👋</h1>
            <p class="subtitle">
                Selamat datang kembali di panel administrasi. Berikut adalah ringkasan aktivitas dan menu pengelolaan PKL hari ini.
            </p>
        </div>
    </div>
    
    {{-- 2. STATS OVERVIEW --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-value">{{ $total_pendaftar }}</div>
                <div class="stat-label">Total Siswa Terdaftar</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-value">{{ $kuota_bulan_ini }}</div>
                <div class="stat-label">Sisa Kuota Bulan Ini</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-value">{{ $total_kuota_tersedia }}</div>
                <div class="stat-label">Total Kapasitas Global</div>
            </div>
        </div>
    </div>
    
    {{-- 3. MAIN MENU ACTIONS --}}
    <div class="actions-section">
        <h2 class="section-title">Akses Cepat</h2>
        
        <div class="actions">
            {{-- Menu: Data Pendaftar --}}
            <a href="{{ route('admin.pendaftarans.index') }}" class="action-card">
                <div class="action-header">
                    <div class="action-icon">
                        <img src="{{ asset('image/people.png') }}" alt="Pendaftar">
                    </div>
                    <span class="action-arrow">→</span>
                </div>
                <div class="action-body">
                    <div class="action-title">Data Pendaftar</div>
                    <p class="action-desc">Verifikasi dan kelola data siswa PKL.</p>
                </div>
            </a>

            {{-- Menu: Kuota Bulanan --}}
            <a href="{{ route('admin.kuotas.index') }}" class="action-card">
                <div class="action-header">
                    <div class="action-icon">
                        <img src="{{ asset('image/date.png') }}" alt="Kuota">
                    </div>
                    <span class="action-arrow">→</span>
                </div>
                <div class="action-body">
                    <div class="action-title">Atur Kuota</div>
                    <p class="action-desc">Manajemen ketersediaan kuota per bulan.</p>
                </div>
            </a>

            {{-- Menu: Galeri Alumni --}}
            <a href="{{ route('admin.alumni_pkl.index') }}" class="action-card">
                <div class="action-header">
                    <div class="action-icon">
                        <img src="{{ asset('image/photo.png') }}" alt="Galeri">
                    </div>
                    <span class="action-arrow">→</span>
                </div>
                <div class="action-body">
                    <div class="action-title">Dokumentasi</div>
                    <p class="action-desc">Foto kegiatan anak yang telah selesai PKL.</p>
                </div>
            </a>

            {{-- Menu: Pesan Peringatan --}}
            <a href="{{ route('admin.alert_message') }}" class="action-card">
                <div class="action-header">
                    <div class="action-icon warning-icon">⚠️</div>
                    <span class="action-arrow">→</span>
                </div>
                <div class="action-body">
                    <div class="action-title">Info & Peringatan</div>
                    <p class="action-desc">Update pengumuman di halaman depan.</p>
                </div>
            </a>

            {{-- Menu: Super Admin Only --}}
            @if(Auth::guard('admin')->user()->isSuperAdmin())
            <a href="{{ route('admin.user_roles.index') }}" class="action-card super-admin-card">
                <div class="badge-super">Super Admin</div>
                <div class="action-header">
                    <div class="action-icon">
                        <img src="{{ asset('image/user.png') }}" alt="User Role">
                    </div>
                    <span class="action-arrow">→</span>
                </div>
                <div class="action-body">
                    <div class="action-title">Role Pengguna</div>
                    <p class="action-desc">Kelola akses admin dan user.</p>
                </div>
            </a>
            @endif
        </div>
    </div>

    {{-- 4. FOOTER NOTE --}}
    <div class="dashboard-footer">
        <p>💡 Sistem Informasi Manajemen PKL &copy; {{ date('Y') }}</p>
    </div>

    {{-- LOCAL STYLES (Optional Refinements) --}}
    <style>
        /* Scoped styles untuk merapikan layout spesifik dashboard */
        .actions-section {
            padding: 32px;
            margin-bottom: 40px;
        }
        
        .action-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .action-icon img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .warning-icon {
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px; 
            height: 42px;
        }

        /* Styling khusus badge Super Admin agar rapi */
        .super-admin-card {
            border-color: #fbbf24;
            background: linear-gradient(to bottom right, #fffbeb, #ffffff);
        }
        
        .badge-super {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #fbbf24;
            color: #78350f;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(251, 191, 36, 0.2);
        }

        .dashboard-footer {
            text-align: center;
            margin-top: 40px;
            color: #94a3b8;
            font-size: 0.85rem;
            padding-bottom: 20px;
        }
        
        .subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-top: 8px;
            max-width: 600px;
        }
    </style>
@endsection