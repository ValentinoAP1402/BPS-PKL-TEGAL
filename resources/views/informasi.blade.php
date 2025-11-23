<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pendaftaran PKL & Kuota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Modern Navbar */
        nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            transition: all 0.3s ease;
        }

        nav.scrolled {
            background: rgba(172, 116, 245, 0.212);
            backdrop-filter: blur(30px);
        }

        .nav-link {
            color: white;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover:before {
            left: 0;
        }

        /* Hero Section */
        .page-hero {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            padding: 140px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-hero:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .page-hero-content {
            position: relative;
            z-index: 10;
        }

        .gradient-text {
            background: linear-gradient(45deg, #fff, #a5f3fc, #fde68a, #fff);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Info Section Cards */
        .info-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .info-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
        }

        .info-section h2 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-section h2 .icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        /* Custom Ordered List */
        .custom-ol {
            list-style: none;
            counter-reset: item;
            padding: 0;
            margin: 30px 0;
        }

        .custom-ol li {
            counter-increment: item;
            margin-bottom: 20px;
            padding-left: 60px;
            position: relative;
            font-size: 1.05rem;
            line-height: 1.7;
            color: #374151;
        }

        .custom-ol li:before {
            content: counter(item);
            position: absolute;
            left: 0;
            top: -2px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        /* Kuota Cards */
        .kuota-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .kuota-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-left: 4px solid #667eea;
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .kuota-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .kuota-card:hover:before {
            opacity: 1;
        }

        .kuota-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.25);
            border-left-width: 6px;
        }

        .kuota-card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 8px;
        }

        .kuota-card-info {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .kuota-card-number {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            padding: 16px 40px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            display: inline-block;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .btn-link {
            color: #667eea;
            font-weight: 600;
            text-decoration: underline;
            transition: all 0.3s ease;
        }

        .btn-link:hover {
            color: #764ba2;
            text-decoration: none;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert:before {
            font-size: 1.5rem;
        }

        .alert-success:before {
            content: '✓';
            color: #10b981;
        }

        .alert-error:before {
            content: '⚠';
            color: #ef4444;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            position: relative;
            overflow: hidden;
            margin-top: 60px;
        }

        footer:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #2563eb);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .delay-200 { animation-delay: 0.2s; }
        .delay-400 { animation-delay: 0.4s; }

        /* Responsive untuk Laptop 1366x768 */
        @media (max-width: 1400px) {
            .page-hero {
                padding: 120px 0 60px;
            }

            .page-hero h1 {
                font-size: 3.5rem;
            }

            .page-hero p {
                font-size: 1.15rem;
            }

            main {
                padding: 50px 20px;
            }

            .info-section {
                padding: 35px;
                margin-bottom: 25px;
            }

            .info-section h2 {
                font-size: 1.75rem;
            }

            .custom-ol li {
                font-size: 1rem;
                padding-left: 55px;
            }

            .custom-ol li:before {
                width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }

            .kuota-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 18px;
            }

            .kuota-card {
                padding: 20px;
            }

            .kuota-card-title {
                font-size: 1.25rem;
            }

            .kuota-card-number {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 1024px) {
            .page-hero {
                padding: 110px 0 50px;
            }

            .page-hero h1 {
                font-size: 3rem;
            }

            .info-section {
                padding: 30px;
            }

            .kuota-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Mobile Responsive */
        .mobile-menu-btn {
            display: none;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .nav-menu {
                position: fixed;
                top: 64px;
                left: 0;
                right: 0;
                background: rgba(102, 126, 234, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                gap: 12px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .nav-menu.active {
                max-height: 400px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .nav-link {
                width: 100%;
                text-align: center;
                padding: 12px;
                background: rgba(255, 255, 255, 0.1);
            }

            .page-hero {
                padding: 120px 20px 60px;
            }

            .page-hero h1 {
                font-size: 2rem;
            }

            .info-section {
                padding: 30px 20px;
            }

            .info-section h2 {
                font-size: 1.5rem;
                flex-direction: column;
                text-align: center;
            }

            .custom-ol li {
                padding-left: 55px;
                font-size: 0.95rem;
            }

            .custom-ol li:before {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .kuota-grid {
                grid-template-columns: 1fr;
            }
        }

        body {
            padding-top: 64px;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    <nav id="navbar" class="p-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="{{ route('home') }}" class="text-white text-2xl font-bold tracking-wide">
                <img src="{{ asset('image/bps.png') }}" alt="BPS" class="h-8 w-8 inline mr-2"> BPS PKL
            </a>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                ☰
            </button>

            <div class="nav-menu" id="navMenu">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                @if(Auth::check() && (!$pendaftaranStatus || $pendaftaranStatus !== 'approved'))
                    <a href="{{ route('pendaftaran.create') }}" class="nav-link">Daftar Sekarang</a>
                    <a href="{{ $pendaftaranStatus ? route('upload.surat.tanda.tangan') : 'javascript:void(0)' }}" class="nav-link" onclick="{{ !$pendaftaranStatus ? "showRegistrationAlert('upload'); return false;" : '' }}">Upload Surat</a>
                    <a href="{{ $pendaftaranStatus ? route('pendaftaran.surat_mitra_signed') : 'javascript:void(0)' }}" class="nav-link relative" onclick="{{ !$pendaftaranStatus ? "showRegistrationAlert('surat_mitra'); return false;" : '' }}">
                        Surat Balasan
                        @if($suratMitraNotification)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-3 h-3 flex items-center justify-center animate-pulse"></span>
                        @endif
                    </a>
                    <a href="{{ route('profile') }}" class="nav-link flex items-center justify-center">
                        @if(Auth::user()->avatar)
                            @if(strpos(Auth::user()->avatar, 'http') === 0)
                                <img src="{{ Auth::user()->avatar }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                            @else
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                            @endif
                        @else
                            <img src="https://via.placeholder.com/32?text=P" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                        @endif
                    </a>
                @elseif(Auth::check() && $pendaftaranStatus === 'approved')
                    <a href="{{ route('upload.surat.tanda.tangan') }}" class="nav-link">Upload Surat</a>
                    <a href="{{ route('pendaftaran.surat_mitra_signed') }}" class="nav-link relative">
                        Surat Balasan
                        @if($suratMitraNotification)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-3 h-3 flex items-center justify-center animate-pulse"></span>
                        @endif
                    </a>
                    <a href="{{ route('profile') }}" class="nav-link flex items-center justify-center">
                        @if(Auth::user()->avatar)
                            @if(strpos(Auth::user()->avatar, 'http') === 0)
                                <img src="{{ Auth::user()->avatar }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                            @else
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                            @endif
                        @else
                            <img src="https://via.placeholder.com/32?text=P" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white">
                        @endif
                    </a>
                @else
                    <a href="{{ route('auth.google') }}" class="nav-link">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="page-hero">
        <div class="page-hero-content container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 text-white animate-fade-in-up">
                <span class="gradient-text">Informasi Pendaftaran PKL</span>
            </h1>
            <p class="text-xl md:text-2xl text-white opacity-90 max-w-3xl mx-auto animate-fade-in-up delay-200 font-light">
                Langkah-langkah pendaftaran dan kuota PKL yang tersedia di Badan Pusat Statistik
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12 md:py-16">
        <div class="max-w-5xl mx-auto">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success animate-fade-in-up">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error animate-fade-in-up">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif

            <!-- Cara Daftar Section -->
            <div class="info-section animate-fade-in-up delay-200">
                <h2>
                    Cara Daftar PKL
                </h2>
                <p style="color: #6b7280; font-size: 1.05rem; margin-bottom: 20px;">
                    Ikuti langkah-langkah mudah di bawah ini untuk memulai pendaftaran PKL Anda:
                </p>
                
                <ol class="custom-ol">
                    <li>
                        Periksa kuota PKL yang tersedia di bagian bawah halaman ini.
                    </li>
                    <li>
                        Isi formulir pendaftaran melalui tombol
                        @if(Auth::check() && $pendaftaranStatus === 'approved')
                            <a href="javascript:void(0)" onclick="showApprovedAlert()" class="btn-link">Daftar Sekarang</a>.
                        @else
                            <a href="{{ route('pendaftaran.create') }}" class="btn-link">Daftar Sekarang</a>.
                        @endif
                    </li>
                    <li>
                        Upload surat keterangan PKL dari institusi Universitas/Sekolah Anda.
                    </li>
                    <li>
                        Tunggu konfirmasi dari admin BPS melalui email yang terdaftar.
                    </li>
                </ol>

                <div style="text-align: center; margin-top: 40px;">
                    @if(Auth::check() && (!$pendaftaranStatus || $pendaftaranStatus !== 'approved'))
                        <a href="{{ route('pendaftaran.create') }}" class="btn-primary">
                         Lanjut ke Formulir Pendaftaran
                        </a>
                    @elseif(Auth::check() && $pendaftaranStatus === 'approved')
                        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%); border: 2px solid #10b981; border-radius: 12px; padding: 20px; text-align: center; color: #065f46;">
                            <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
                            <strong>Pendaftaran PKL Anda telah disetujui!</strong>
                        </div>
                    @else
                        <a href="{{ route('auth.google') }}" class="btn-primary">
                            🔐 Login untuk Daftar PKL
                        </a>
                    @endif
                </div>
            </div>

            <!-- Kuota Section -->
            <div class="info-section animate-fade-in-up delay-400">
                <h2>
                    Kuota PKL Tersedia
                </h2>
                <p style="color: #6b7280; font-size: 1.05rem; margin-bottom: 20px;">
                    Berikut adalah ketersediaan kuota PKL per bulan. Pastikan untuk mendaftar sebelum kuota penuh!
                </p>
                
                <div class="kuota-grid">
                    @forelse($kuotas as $kuota)
                        <div class="kuota-card">
                            <div class="kuota-card-title">{{ $kuota->bulan }}</div>
                            <div class="kuota-card-info">Kuota Tersisa:</div>
                            <div class="kuota-card-number">{{ $kuota->available_slots }}</div>
                            @if($kuota->available_slots == 0)
                                <div style="font-size: 0.8rem; color: #dc2626; margin-top: 8px; font-weight: 600;">⚠️ Kuota Penuh</div>
                            @elseif($kuota->available_slots <= 5)
                                <div style="font-size: 0.8rem; color: #f59e0b; margin-top: 8px; font-weight: 600;">⚡ Kuota Terbatas</div>
                            @endif
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.1) 0%, rgba(245, 158, 11, 0.1) 100%); border-left: 4px solid #f59e0b; border-radius: 16px; color: #92400e;">
                            <div style="font-size: 3rem; margin-bottom: 12px;">⚠️</div>
                            <strong style="font-size: 1.2rem;">Maaf, saat ini belum ada informasi kuota PKL yang tersedia.</strong>
                            <p style="margin-top: 8px; color: #b45309;">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-gray-300 py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-4"><img src="{{ asset('image/bps.png') }}" alt="BPS PKL" class="h-8 w-8 inline mr-2"> Pendaftaran PKL BPS</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Portal resmi untuk pendaftaran Praktik Kerja Lapangan di Badan Pusat Statistik.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">📞 Hubungi Kami</h3>
                    <p class="text-gray-400 text-sm space-y-2">
                        <strong class="text-white">Alamat:</strong><br>
                        Jl. Nakula No. 36A Tegal 52124<br><br>
                        <strong class="text-white">Email:</strong><br>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=bps3376@bps.co.id" target="_blank" class="text-purple-400 hover:text-purple-300 transition">bps3376@bps.co.id</a><br><br>
                        <strong class="text-white">Telepon:</strong><br>
                        (0283) 351593
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">🔗 Tautan Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-300 flex items-center">→ Beranda</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-500 mb-4">
                    © 2025 Badan Pusat Statistik. Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileMenuBtn.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
            });

            const navLinks = navMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        mobileMenuBtn.textContent = '☰';
                    }
                });
            });

            document.addEventListener('click', (e) => {
                if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                }
            });
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Registration Alert Functions
        function showRegistrationAlert(type) {
            const alert = document.getElementById('registrationAlert');
            const messageElement = document.getElementById('registrationAlertMessage');

            // Customize message based on type
            if (type === 'upload') {
                messageElement.textContent = 'Anda harus mengisi formulir pendaftaran PKL terlebih dahulu sebelum dapat mengupload surat.';
            } else if (type === 'surat_mitra') {
                messageElement.textContent = 'Anda harus mengisi formulir pendaftaran PKL terlebih dahulu sebelum dapat melihat surat mitra.';
            } else {
                messageElement.textContent = 'Anda harus mengisi formulir pendaftaran PKL terlebih dahulu sebelum dapat mengakses fitur ini.';
            }

            setTimeout(() => {
                alert.classList.remove('opacity-0', 'pointer-events-none');
                alert.classList.add('opacity-100', 'pointer-events-auto');
                alert.classList.remove('scale-90');
                alert.classList.add('scale-100');
            }, 100);
        }

        function closeRegistrationAlert() {
            const alert = document.getElementById('registrationAlert');
            alert.classList.remove('opacity-100', 'pointer-events-auto');
            alert.classList.add('opacity-0', 'pointer-events-none');
            alert.classList.remove('scale-100');
            alert.classList.add('scale-90');
        }

        // Approved Alert Function
        function showApprovedAlert() {
            const alert = document.getElementById('approvedAlert');
            setTimeout(() => {
                alert.classList.remove('opacity-0', 'pointer-events-none');
                alert.classList.add('opacity-100', 'pointer-events-auto');
                alert.classList.remove('scale-90');
                alert.classList.add('scale-100');
            }, 100);
        }

        function closeApprovedAlert() {
            const alert = document.getElementById('approvedAlert');
            alert.classList.remove('opacity-100', 'pointer-events-auto');
            alert.classList.add('opacity-0', 'pointer-events-none');
            alert.classList.remove('scale-100');
            alert.classList.add('scale-90');
        }
    </script>

    <!-- Modern Registration Alert -->
    <div id="registrationAlert" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-500">
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-xl border border-white border-opacity-30 rounded-3xl p-10 max-w-lg mx-4 shadow-2xl transform scale-90 transition-all duration-500 relative overflow-hidden">
            <!-- Animated Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 via-blue-500/20 to-pink-500/20 animate-pulse"></div>

            <!-- Floating Particles Effect -->
            <div class="absolute inset-0">
                <div class="absolute top-4 left-4 w-2 h-2 bg-white rounded-full opacity-60 animate-bounce" style="animation-delay: 0s;"></div>
                <div class="absolute top-8 right-6 w-1 h-1 bg-purple-300 rounded-full opacity-40 animate-bounce" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-6 left-8 w-1.5 h-1.5 bg-blue-300 rounded-full opacity-50 animate-bounce" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-4 right-4 w-1 h-1 bg-pink-300 rounded-full opacity-45 animate-bounce" style="animation-delay: 1.5s;"></div>
            </div>

            <div class="text-center relative z-10">
                <!-- Animated Icon -->
                <div class="w-20 h-20 bg-gradient-to-r from-orange-400 via-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl animate-pulse">
                    <svg class="w-10 h-10 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-white mb-4 animate-fade-in-up">Pendaftaran Diperlukan</h3>
                <p id="registrationAlertMessage" class="text-white text-opacity-90 leading-relaxed mb-8 animate-fade-in-up text-lg">
                    Anda harus mengisi formulir pendaftaran PKL terlebih dahulu sebelum dapat mengakses fitur ini.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up">
                    <a href="{{ route('pendaftaran.create') }}" class="bg-gradient-to-r from-purple-500 via-blue-500 to-pink-500 text-white px-8 py-3 rounded-full font-semibold hover:from-purple-600 hover:via-blue-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Daftar Sekarang
                    </a>
                    <button onclick="closeRegistrationAlert()" class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-8 py-3 rounded-full font-semibold hover:bg-opacity-30 transition-all duration-300 transform hover:scale-105 shadow-lg border border-white border-opacity-30">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Approved Alert -->
    <div id="approvedAlert" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-500">
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-xl border border-white border-opacity-30 rounded-3xl p-10 max-w-lg mx-4 shadow-2xl transform scale-90 transition-all duration-500 relative overflow-hidden">
            <!-- Animated Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 via-blue-500/20 to-purple-500/20 animate-pulse"></div>

            <!-- Floating Particles Effect -->
            <div class="absolute inset-0">
                <div class="absolute top-4 left-4 w-2 h-2 bg-white rounded-full opacity-60 animate-bounce" style="animation-delay: 0s;"></div>
                <div class="absolute top-8 right-6 w-1 h-1 bg-green-300 rounded-full opacity-40 animate-bounce" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-6 left-8 w-1.5 h-1.5 bg-blue-300 rounded-full opacity-50 animate-bounce" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-4 right-4 w-1 h-1 bg-purple-300 rounded-full opacity-45 animate-bounce" style="animation-delay: 1.5s;"></div>
            </div>

            <div class="text-center relative z-10">
                <!-- Animated Icon -->
                <div class="w-20 h-20 bg-gradient-to-r from-green-400 via-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl animate-pulse">
                    <svg class="w-10 h-10 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-white mb-4 animate-fade-in-up">Pendaftaran Sudah Disetujui</h3>
                <p class="text-white text-opacity-90 leading-relaxed mb-8 animate-fade-in-up text-lg">
                    Selamat! Pendaftaran PKL Anda telah disetujui. Anda tidak perlu mendaftar lagi.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up">
                    <button onclick="closeApprovedAlert()" class="bg-gradient-to-r from-green-500 via-blue-500 to-purple-500 text-white px-8 py-3 rounded-full font-semibold hover:from-green-600 hover:via-blue-600 hover:to-purple-600 transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
