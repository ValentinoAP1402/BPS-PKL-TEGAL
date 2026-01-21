<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Pendaftaran PKL BPS Kota Tegal')</title>

    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Konfigurasi Font Utama */
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Poppins', sans-serif; }

        /* Scrollbar Halus */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

        /* Navbar Blur Effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .glass-nav.scrolled {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            background: rgba(255, 255, 255, 0.98);
        }

        /* Loading Overlay */
        #loader-wrapper {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #ffffff; z-index: 9999;
            display: flex; justify-content: center; align-items: center;
            transition: opacity 0.5s ease-out, visibility 0.5s;
        }
        .loader {
            width: 48px; height: 48px;
            border: 5px solid #3b82f6;
            border-bottom-color: transparent;
            border-radius: 50%;
            animation: rotation 1s linear infinite;
        }
        @keyframes rotation { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* WhatsApp Float */
        .wa-float {
            position: fixed; bottom: 30px; right: 30px; z-index: 100;
            background-color: #25D366; color: white;
            width: 60px; height: 60px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .wa-float:hover { transform: scale(1.1); background-color: #128C7E; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-100 selection:text-blue-700 relative">

    <div id="loader-wrapper">
        <div class="loader"></div>
    </div>

    <nav id="navbar" class="glass-nav fixed w-full top-0 z-50 h-20 flex items-center transition-all duration-300">
        <div class="w-full max-w-[1920px] mx-auto px-6 md:px-10 lg:px-16 flex items-center justify-between">
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                <img src="{{ asset('image/bps.png') }}" alt="Logo BPS" class="h-10 w-auto transition transform group-hover:scale-110 duration-300">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition">BPS KOTA TEGAL</span>
                    <span class="text-[10px] text-gray-500 font-medium tracking-widest uppercase">Badan Pusat Statistik</span>
                </div>
            </a>

            <div class="flex items-center gap-8">
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition relative group py-2">
                        Beranda
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>  
                </div>

                <div class="hidden md:block h-6 w-px bg-gray-200"></div>

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        @php
                            $pendaftaran = App\Models\Pendaftaran::where('email', Auth::user()->email)->first();
                        @endphp
                        <div class="relative group">
                            <button class="flex items-center gap-3 focus:outline-none pl-2 py-1">
                                <div class="text-right hidden lg:block leading-tight">
                                    <p class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 capitalize font-medium">{{ Auth::user()->role ?? 'Peserta' }}</p>
                                </div>
                                @if(Auth::user()->avatar)
                                    @if(str_starts_with(Auth::user()->avatar, 'http'))
                                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-blue-100 ring-2 ring-transparent group-hover:ring-blue-100 transition">
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-blue-100 ring-2 ring-transparent group-hover:ring-blue-100 transition">
                                    @endif
                                @else
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-blue-500 transition"></i>
                            </button>

                            <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                                <div class="py-2">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                        <i class="fa-regular fa-user mr-2 text-gray-400"></i> Profil Saya
                                    </a>
                                    @if($pendaftaran && $pendaftaran->surat_balasan_pkl)
                                        <a href="{{ route('pendaftaran.surat_mitra_signed') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-file-pdf mr-2 text-gray-400"></i> Surat Balasan
                                        </a>
                                    @endif
                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                        <i class="fa-solid fa-chart-pie mr-2 text-gray-400"></i> Dashboard Admin
                                    </a>
                                    @endif
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition px-4 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none p-2 ml-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu-dropdown" class="hidden absolute top-20 left-0 w-full bg-white border-t border-gray-100 shadow-lg md:hidden z-40">
            <div class="flex flex-col p-4 space-y-3">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Beranda</a>
                @guest
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 text-blue-600 border border-blue-200 rounded-lg font-semibold hover:bg-blue-50 mb-2">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Daftar Akun</a>
                @else
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <div class="px-4 flex items-center gap-3 mb-4">
                            @if(Auth::user()->avatar)
                                @if(str_starts_with(Auth::user()->avatar, 'http'))
                                    <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                                @endif
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg">Profil Saya</a>
                        @if($pendaftaran && $pendaftaran->surat_balasan_pkl)
                            <a href="{{ route('pendaftaran.surat_mitra_signed') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg">
                                <i class="fa-solid fa-file-pdf mr-2"></i> Surat Balasan
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">Keluar</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <div class="h-20"></div>

    <main class="min-h-[80vh]">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Badan Pusat Statistik Kota Tegal. All rights reserved.
            </p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="https://www.instagram.com/bpskotategal?igsh=MTdmbGF0NTY2dmJodw==" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.facebook.com/share/1AKetxxQQX/" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://youtube.com/@bpskotategal?si=yDqqPVPh4Bf4NVS6" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.tiktok.com/@bpskotategal?_r=1&_t=ZS-92MCTOzLzuS" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-brands fa-tiktok"></i></a>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6285179703376" target="_blank" class="wa-float group" title="Hubungi via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script>
        // 1. Loader Logic
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader-wrapper');
            setTimeout(() => {
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
            }, 300); 
        });

        // 2. Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // 3. Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu-dropdown');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Tutup menu jika klik di luar
        document.addEventListener('click', (e) => {
            if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>

    @if(session('success_registration'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                html: `
                    <div style="text-align: left; line-height: 1.6;">
                        <p style="margin-bottom: 10px;">Terima kasih, berkas pendaftaran Anda telah berhasil kami terima.</p>
                        <p style="margin-bottom: 10px;">Saat ini, tim <b>Admin BPS Kota Tegal</b> sedang melakukan verifikasi dokumen.</p>
                        <p>Mohon kesediaan Anda untuk menunggu notifikasi selanjutnya yang akan kami sampaikan melalui <b>WhatsApp</b> atau <b>Email</b> yang terdaftar.</p>
                        <p>Berkas pendaftaran Anda akan terhapus secara otomatis jika selama 3 hari tidak diverifikasi.</p>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Baik, Saya Mengerti',
                confirmButtonColor: '#3b82f6',
                allowOutsideClick: false,
                width: '600px',
                padding: '2em'
            });
        });
    </script>
    @endif
    
    @stack('scripts')
</body>
</html>