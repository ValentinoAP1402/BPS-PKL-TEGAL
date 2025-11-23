<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran PKL BPS - Beranda</title>
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
        }

        /* Navbar Modern dengan Glassmorphism */
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
            outline: none;
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
            outline: none;
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

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .nav-link:focus {
            outline: none;
        }

        /* Hero Section dengan Gradient Overlay */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 50%, rgba(37, 99, 235, 0.8) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
        }

        /* Animated Gradient Text */
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

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Modern Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-primary:hover:before {
            left: 0;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }

        /* Feature Cards dengan Glassmorphism */
        .feature-card {
            background: rgba(102, 126, 234, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 40px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .feature-card:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
            z-index: -1;
            border-radius: 24px;
        }

        .feature-card:hover:before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            background: rgba(102, 126, 234, 0.35);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .feature-icon {
            font-size: 64px;
            margin-bottom: 20px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.2) rotate(5deg);
        }

        /* Kuota Cards dengan Glassmorphism */
        .kuota-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 80px 0;
            margin: -80px 20px 40px 20px;
            position: relative;
            z-index: 10;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .kuota-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }

        .kuota-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-left: 4px solid #667eea;
            border-radius: 20px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .kuota-card:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .kuota-card:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            z-index: -1;
            border-radius: 20px;
        }

        .kuota-card:hover:before {
            opacity: 1;
        }

        .kuota-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.25) 0%, rgba(118, 75, 162, 0.25) 100%);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .kuota-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kuota-card-title:before {
            content: '📅';
            font-size: 1.2rem;
        }

        .kuota-card-info {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .kuota-card-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-top: 8px;
        }

        .kuota-status {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 12px;
        }

        .kuota-status.full {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .kuota-status.limited {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .kuota-status.available {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        /* Animated Background Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float-shapes 20s ease-in-out infinite;
        }

        @keyframes float-shapes {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(100px, -100px) scale(1.1); }
            66% { transform: translate(-100px, 100px) scale(0.9); }
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: #667eea;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: #764ba2;
            bottom: 10%;
            right: 5%;
            animation-delay: 7s;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: #2563eb;
            top: 50%;
            right: 20%;
            animation-delay: 14s;
        }

        /* Section Styling */
        .content-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 80px 0;
            margin: 40px 20px 40px 20px;
            position: relative;
            z-index: 10;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        /* Footer Modern */
        footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            position: relative;
            overflow: hidden;
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

        /* Slider Styles */
        #bpsCarousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        #bpsCarousel .slides {
            display: flex;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #bpsCarousel .slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        #bpsCarousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Posisi khusus untuk slide pertama - fokus ke atas */
        #bpsCarousel .slide:first-child img {
            object-position: center top;
        }

        /* Slide lainnya tetap center */
        #bpsCarousel .slide:not(:first-child) img {
            object-position: center center;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 30;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-btn.prev { left: 20px; }
        .carousel-btn.next { right: 20px; }

        .carousel-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 30;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            background: white;
            transform: scale(1.3);
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
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        .delay-200 { animation-delay: 0.2s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-800 { animation-delay: 0.8s; }

        /* Mobile Navigation Toggle */
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

        /* Responsive untuk Laptop 1366x768 */
        @media (max-width: 1400px) {
            .hero-content h1 {
                font-size: 3.5rem;
            }

            .hero-content p {
                font-size: 1.15rem;
            }

            .content-section {
                padding: 60px 0;
                margin: -60px 20px 40px 20px;
            }

            .feature-card {
                padding: 35px;
            }

            .feature-icon {
                font-size: 56px;
            }
        }

        @media (max-width: 1024px) {
            .nav-link {
                padding: 6px 12px;
                font-size: 14px;
            }

            .hero-section {
                min-height: 85vh;
            }

            .hero-content h1 {
                font-size: 3rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .feature-card {
                padding: 30px;
            }

            .feature-icon {
                font-size: 52px;
            }
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
                max-height: 500px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .nav-link {
                width: 100%;
                text-align: center;
                padding: 12px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
            }

            .hero-section {
                min-height: 90vh;
                padding-top: 64px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                line-height: 1.2;
            }

            .hero-content p {
                font-size: 1rem;
                padding: 0 10px;
            }

            .btn-primary, .btn-secondary {
                padding: 12px 24px;
                font-size: 14px;
                width: 100%;
                max-width: 300px;
            }
            
            .content-section {
                margin: -40px 10px 20px 10px;
                padding: 40px 20px;
                border-radius: 20px;
            }

            .feature-card {
                padding: 30px 20px;
            }

            .feature-icon {
                font-size: 48px;
            }

            .carousel-btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .carousel-btn.prev { left: 10px; }
            .carousel-btn.next { right: 10px; }

            .carousel-indicators {
                bottom: 20px;
            }

            .bg-shape {
                display: none;
            }

            footer .grid {
                gap: 40px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding-top: 56px;
            }

            nav {
                padding: 10px 0;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 0.9rem;
            }

            .content-section {
                padding: 30px 15px;
            }

            .feature-card {
                padding: 25px 15px;
            }

            .feature-card h3 {
                font-size: 1.25rem;
            }

            .carousel-btn {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }

            footer {
                padding: 40px 0;
            }
        }

        /* Utility */
        body {
            padding-top: 64px;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    <nav id="navbar" class="px-4 py-4">
        <div class="container mx-auto flex items-center justify-between px-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-white text-2xl font-bold tracking-wide">
                    <img src="{{ asset('image/bps.png') }}" alt="BPS" class="h-8 w-8 inline mr-2"> BPS PKL
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                ☰
            </button>

            <!-- Navigation Menu -->
            <div class="nav-menu" id="navMenu">
                <a href="{{ route('informasi') }}" class="nav-link">Informasi PKL</a>
                @if(Auth::check() && (!$hasPendaftaran || $pendaftaranStatus !== 'approved'))
                    <a href="{{ route('pendaftaran.create') }}" class="nav-link">Daftar Sekarang</a>
                    <a href="{{ $hasPendaftaran ? route('upload.surat.tanda.tangan') : 'javascript:void(0)' }}" class="nav-link" onclick="{{ !$hasPendaftaran ? "showRegistrationAlert('upload'); return false;" : '' }}">Upload Surat</a>
                    <a href="{{ $hasPendaftaran ? route('pendaftaran.surat_mitra_signed') : 'javascript:void(0)' }}" class="nav-link relative" onclick="{{ !$hasPendaftaran ? "showRegistrationAlert('surat_mitra'); return false;" : '' }}">
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
    <header class="hero-section">
        <!-- Background Shapes -->
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
        <div class="bg-shape shape-3"></div>

        <!-- Image Slider -->
        <div id="bpsCarousel">
            <div class="slides">
                <div class="slide"><img src="{{ asset('images/slide1.jpg') }}" alt="Slide 1" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('image/bps depan.jpg') }}';"></div>
                <div class="slide"><img src="{{ asset('images/slide2.jpg') }}" alt="Slide 2" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('image/hsn.jpg') }}';"></div>
                <div class="slide"><img src="{{ asset('images/slide3.jpg') }}" alt="Slide 3" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('image/bps depan.jpg') }}';"></div>
            </div>
            <button class="carousel-btn prev" aria-label="Previous">‹</button>
            <button class="carousel-btn next" aria-label="Next">›</button>
            <div class="carousel-indicators">
                <button data-index="0" class="active"></button>
                <button data-index="1"></button>
                <button data-index="2"></button>
            </div>
        </div>

        <!-- Gradient Overlay -->
        <div class="hero-gradient-overlay"></div>

        <!-- Hero Content -->
        <div class="hero-content container mx-auto px-6">
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 animate-fade-in-up">
                Selamat Datang di Portal<br>
                <span class="gradient-text">Pendaftaran PKL BPS KOTA TEGAL</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto animate-fade-in-up delay-200 font-light">
                Wujudkan pengalaman belajar terbaik Anda dengan mengikuti Praktik Kerja Lapangan di institusi terkemuka bidang statistik dan data
            </p>
        </div>
    </header>

    <!-- Kuota PKL Section -->
    <section class="kuota-section">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                    Kuota PKL Tersedia
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Cek ketersediaan kuota pendaftaran PKL untuk periode yang Anda inginkan
                </p>
            </div>

            <div class="kuota-grid">
                @forelse($kuotas as $kuota)
                    <div class="kuota-card animate-fade-in-up">
                        <div class="kuota-card-title">
                            {{ $kuota->bulan }}
                        </div>
                        <div class="kuota-card-info">Kuota Tersisa:</div>
                        <div class="kuota-card-number">{{ $kuota->available_slots }}</div>
                        <div class="kuota-card-info">dari {{ $kuota->jumlah_kuota }} total kuota</div>
                        @if($kuota->available_slots == 0)
                            <span class="kuota-status full">Kuota Penuh</span>
                        @elseif($kuota->available_slots <= 5)
                            <span class="kuota-status limited">Kuota Terbatas</span>
                        @else
                            <span class="kuota-status available">Kuota Tersedia</span>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 text-lg">Belum ada kuota PKL yang tersedia saat ini.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

        <!-- Features Section -->
    <section class="content-section">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                    Kenapa Memilih PKL di BPS?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dapatkan pengalaman berharga yang tidak akan Anda temukan di tempat lain
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in-up delay-600">
                <div class="feature-card text-center text-white">
                    <div class="feature-icon float-animation">📊</div>
                    <h3 class="text-2xl font-bold mb-4 text-white drop-shadow-lg">Data & Analisis Nyata</h3>
                    <p class="text-white leading-relaxed drop-shadow-md" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        Terlibat langsung dalam siklus data nasional, dari pengumpulan hingga publikasi menggunakan teknologi terkini
                    </p>
                </div>

                <div class="feature-card text-center text-white" style="animation-delay: 0.8s">
                    <div class="feature-icon float-animation" style="animation-delay: 0.3s">👨‍🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-white drop-shadow-lg">Mentorship Ahli</h3>
                    <p class="text-white leading-relaxed drop-shadow-md" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        Belajar dari para statistikawan, peneliti, dan data scientist profesional yang berdedikasi
                    </p>
                </div>

                <div class="feature-card text-center text-white" style="animation-delay: 1s">
                    <div class="feature-icon float-animation" style="animation-delay: 0.6s">🌍</div>
                    <h3 class="text-2xl font-bold mb-4 text-white drop-shadow-lg">Dampak Nasional</h3>
                    <p class="text-white leading-relaxed drop-shadow-md" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        Berpartisipasi dalam pekerjaan yang berkontribusi pada kebijakan publik dan pembangunan bangsa
                    </p>
                </div>
            </div>
        </div>
    </section>


<!-- Alumni PKL Section -->
   <section class="alumni-section py-20 overflow-hidden" style="background: linear-gradient(180deg, #f5f5f5 0%, #e8e8e8 100%);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent">
                     Alumni PKL BPS Kota Tegal
                </h2>
                <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                    Kenali para alumni yang telah berhasil menyelesaikan program PKL di BPS Kota Tegal
                </p>
            </div>

            @if(count($alumni ?? []) > 0)
            <div class="relative">
                <!-- Alumni Grid Container -->
                <div class="alumni-grid-wrapper py-4" id="alumniSlider">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4" id="alumniTrack">
                        @foreach($alumni ?? [] as $index => $alumnus)
                        <div class="alumni-slide">
                            <div class="alumni-card bg-white rounded-xl overflow-hidden transform hover:scale-110 hover:-translate-y-2 transition-all duration-300 group cursor-pointer shadow-xl border-2 border-gray-300 hover:border-purple-400" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);">
                                <div class="alumni-image-container relative overflow-hidden" style="height: 256px;">
                                    <img src="{{ asset('storage/' . $alumnus->foto) }}" alt="{{ $alumnus->nama_lengkap }}" class="alumni-image w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                                    <!-- Gradient Overlay yang selalu muncul -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>

                                    <!-- Info Alumni - Always Visible -->
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white text-base font-bold mb-1 line-clamp-2 drop-shadow-lg">{{ $alumnus->nama_lengkap }}</h3>
                                        <p class="text-gray-200 text-xs font-semibold line-clamp-1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">{{ $alumnus->universitas }}</p>
                                        
                                        <!-- Badge Alumni -->
                                        <div class="mt-2 inline-flex items-center gap-1.5 bg-gradient-to-r from-purple-500 to-blue-500 px-2.5 py-1 rounded-full text-xs font-semibold text-white shadow-lg">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            Alumni
                                        </div>
                                    </div>

                                    <!-- Hover Glow Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-purple-500/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <div class="no-alumni text-gray-500">
                    <p class="text-lg">Galeri alumni sedang dalam persiapan</p>
                </div>
            </div>
            @endif
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="text-gray-300 py-16 mt-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-4"><img src="{{ asset('image/bps.png') }}" alt="BPS PKL" class="h-8 w-8 inline mr-2"> Pendaftaran PKL BPS</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Portal resmi untuk pendaftaran Praktik Kerja Lapangan. Kami berkomitmen memberikan pengalaman belajar yang berharga.
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
                        <li><a href="{{ route('informasi') }}" class="text-gray-400 hover:text-white transition duration-300 flex items-center">→ Informasi PKL</a></li>
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

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileMenuBtn.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
            });

            // Close menu when clicking on a link
            const navLinks = navMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        mobileMenuBtn.textContent = '☰';
                    }
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                }
            });
        }

        // Carousel
        (function(){
            const carousel = document.getElementById('bpsCarousel');
            const slidesWrap = carousel.querySelector('.slides');
            const slides = Array.from(carousel.querySelectorAll('.slide'));
            const prevBtn = carousel.querySelector('.prev');
            const nextBtn = carousel.querySelector('.next');
            const indicators = Array.from(carousel.querySelectorAll('.carousel-indicators button'));
            let current = 0;
            let timer = null;

            function goTo(index) {
                index = (index + slides.length) % slides.length;
                current = index;
                slidesWrap.style.transform = `translateX(-${100 * index}%)`;
                indicators.forEach((b,i)=> b.classList.toggle('active', i===index));

                // Hide prev/next buttons on slides 2 and 3 (index 1 and 2)
                if (index === 0) {
                    prevBtn.style.display = 'flex';
                    nextBtn.style.display = 'flex';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }
            }

            function next(){ goTo(current + 1); }
            function prev(){ goTo(current - 1); }

            nextBtn.addEventListener('click', ()=> { next(); resetTimer(); });
            prevBtn.addEventListener('click', ()=> { prev(); resetTimer(); });

            indicators.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    goTo(parseInt(e.target.dataset.index, 10));
                    resetTimer();
                });
            });

            function startTimer(){
                if(timer) return;
                timer = setInterval(next, 5000);
            }

            function stopTimer(){
                if(timer){ clearInterval(timer); timer = null; }
            }

            function resetTimer(){
                stopTimer();
                startTimer();
            }

            carousel.addEventListener('mouseenter', stopTimer);
            carousel.addEventListener('mouseleave', startTimer);

            // Touch swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopTimer();
            }, { passive: true });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    next();
                } else if (touchEndX - touchStartX > 50) {
                    prev();
                }
                resetTimer();
            }, { passive: true });

            goTo(0);
            startTimer();
        })();

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <!-- Modern Success Alert -->
    @if(session('success'))
    <div id="successAlert" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg border border-white border-opacity-20 rounded-2xl p-8 max-w-md mx-4 shadow-2xl transform scale-95 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Berhasil!</h3>
                <p class="text-white text-opacity-90 leading-relaxed">{{ session('success') }}</p>
                <button onclick="closeAlert()" class="mt-6 bg-gradient-to-r from-purple-500 to-blue-500 text-white px-6 py-2 rounded-full font-medium hover:from-purple-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    OK
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modern Error Alert -->
    @if(session('error'))
    <div id="errorAlert" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg border border-white border-opacity-20 rounded-2xl p-8 max-w-md mx-4 shadow-2xl transform scale-95 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-red-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Peringatan!</h3>
                <p class="text-white text-opacity-90 leading-relaxed">{{ session('error') }}</p>
                <button onclick="closeErrorAlert()" class="mt-6 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-full font-medium hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    OK
                </button>
            </div>
        </div>
    </div>
    @endif

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

            // Close menu when clicking on a link
            const navLinks = navMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        mobileMenuBtn.textContent = '☰';
                    }
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                }
            });
        }

        // Carousel
        (function(){
            const carousel = document.getElementById('bpsCarousel');
            const slidesWrap = carousel.querySelector('.slides');
            const slides = Array.from(carousel.querySelectorAll('.slide'));
            const prevBtn = carousel.querySelector('.prev');
            const nextBtn = carousel.querySelector('.next');
            const indicators = Array.from(carousel.querySelectorAll('.carousel-indicators button'));
            let current = 0;
            let timer = null;

            function goTo(index) {
                index = (index + slides.length) % slides.length;
                current = index;
                slidesWrap.style.transform = `translateX(-${100 * index}%)`;
                indicators.forEach((b,i)=> b.classList.toggle('active', i===index));

                // Hide prev/next buttons on slides 2 and 3 (index 1 and 2)
                if (index === 0) {
                    prevBtn.style.display = 'flex';
                    nextBtn.style.display = 'flex';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }
            }

            function next(){ goTo(current + 1); }
            function prev(){ goTo(current - 1); }

            nextBtn.addEventListener('click', ()=> { next(); resetTimer(); });
            prevBtn.addEventListener('click', ()=> { prev(); resetTimer(); });

            indicators.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    goTo(parseInt(e.target.dataset.index, 10));
                    resetTimer();
                });
            });

            function startTimer(){
                if(timer) return;
                timer = setInterval(next, 5000);
            }

            function stopTimer(){
                if(timer){ clearInterval(timer); timer = null; }
            }

            function resetTimer(){
                stopTimer();
                startTimer();
            }

            carousel.addEventListener('mouseenter', stopTimer);
            carousel.addEventListener('mouseleave', startTimer);

            // Touch swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopTimer();
            }, { passive: true });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    next();
                } else if (touchEndX - touchStartX > 50) {
                    prev();
                }
                resetTimer();
            }, { passive: true });

            goTo(0);
            startTimer();
        })();

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Success Alert
        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('successAlert');
            setTimeout(() => {
                alert.classList.remove('opacity-0', 'pointer-events-none');
                alert.classList.add('opacity-100', 'pointer-events-auto');
                alert.querySelector('.bg-white').classList.remove('scale-95');
                alert.querySelector('.bg-white').classList.add('scale-100');
            }, 100);

            // Auto close after 5 seconds
            setTimeout(() => {
                closeAlert();
            }, 5000);
        });

        function closeAlert() {
            const alert = document.getElementById('successAlert');
            alert.classList.remove('opacity-100', 'pointer-events-auto');
            alert.classList.add('opacity-0', 'pointer-events-none');
            alert.querySelector('.bg-white').classList.remove('scale-100');
            alert.querySelector('.bg-white').classList.add('scale-95');
        }
        @endif

        // Error Alert
        @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('errorAlert');
            setTimeout(() => {
                alert.classList.remove('opacity-0', 'pointer-events-none');
                alert.classList.add('opacity-100', 'pointer-events-auto');
                alert.querySelector('.bg-white').classList.remove('scale-95');
                alert.querySelector('.bg-white').classList.add('scale-100');
            }, 100);

            // Auto close after 5 seconds
            setTimeout(() => {
                closeErrorAlert();
            }, 5000);
        });

        function closeErrorAlert() {
            const alert = document.getElementById('errorAlert');
            alert.classList.remove('opacity-100', 'pointer-events-auto');
            alert.classList.add('opacity-0', 'pointer-events-none');
            alert.querySelector('.bg-white').classList.remove('scale-100');
            alert.querySelector('.bg-white').classList.add('scale-95');
        }
        @endif

        // Alumni Slider
        (function(){
            const slider = document.getElementById('alumniSlider');
            if (!slider) return;

            const track = document.getElementById('alumniTrack');
            const indicatorsContainer = document.getElementById('alumniIndicators');
            const slides = Array.from(track.children);
            let current = 0;
            let timer = null;

            // Create indicators
            slides.forEach((_, index) => {
                const indicator = document.createElement('button');
                indicator.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-purple-600 scale-125' : 'bg-gray-300 hover:bg-purple-400'}`;
                indicator.addEventListener('click', () => goTo(index));
                indicatorsContainer.appendChild(indicator);
            });

            const indicators = Array.from(indicatorsContainer.children);

            function goTo(index) {
                index = Math.max(0, Math.min(index, slides.length - 1));
                current = index;
                track.style.transform = `translateX(-${index * 100}%)`;

                // Update indicators
                indicators.forEach((ind, i) => {
                    if (i === index) {
                        ind.className = 'w-3 h-3 rounded-full bg-purple-600 scale-125 transition-all duration-300';
                    } else {
                        ind.className = 'w-3 h-3 rounded-full bg-gray-300 hover:bg-purple-400 transition-all duration-300';
                    }
                });

                resetTimer();
            }

            function next() {
                goTo(current + 1);
            }

            function prev() {
                goTo(current - 1);
            }

            function startTimer() {
                if (timer) return;
                timer = setInterval(next, 4000);
            }

            function stopTimer() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            function resetTimer() {
                stopTimer();
                startTimer();
            }

            // Touch support
            let touchStartX = 0;
            let touchEndX = 0;

            slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopTimer();
            }, { passive: true });

            slider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 50) {
                    next();
                } else if (touchEndX - touchStartX > 50) {
                    prev();
                }
                resetTimer();
            }, { passive: true });

            // Pause on hover
            slider.addEventListener('mouseenter', stopTimer);
            slider.addEventListener('mouseleave', startTimer);

            // Initialize
            goTo(0);
            startTimer();
        })();


    </script>
</body>
</html>
