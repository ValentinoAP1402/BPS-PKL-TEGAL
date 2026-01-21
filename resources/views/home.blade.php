@extends('layouts.app')

@section('title', 'Pendaftaran PKL BPS - Beranda')

@push('styles')
<style>
    /* --- 1. SMOOTH SCROLL (TAMBAHAN BARU) --- */
    html {
        scroll-behavior: smooth;
    }

    /* --- CUSTOM ANIMATIONS --- */
    @keyframes pulse-soft {
        0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
        50% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
    }
    .step-active { animation: pulse-soft 2s infinite; }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translate3d(0, -20px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
    }
    .animate-logo { animation: fadeInDown 1s ease-out; }

    /* PASTIKAN WARNA IKON PUTIH SAAT COMPLETED */
    .step-completed i { color: #ffffff !important; }

    /* --- HERO SLIDER --- */
    .hero-section { 
        position: relative; 
        min-height: 550px; /* Tinggi di HP */
        display: flex; 
        align-items: center; 
        justify-content: center; 
        overflow: hidden; 
        background: #0f172a; 
    }
    
    @media (min-width: 768px) {
        .hero-section { height: 700px; } /* Tinggi di Laptop */
    }

    .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.65); z-index: 1; }
    .hero-pattern { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px; opacity: 0.1; z-index: 2; }
    
    .hero-slider { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; }
    .hero-slide-item { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; opacity: 0; animation: slideFade 12s infinite linear; }
    
    .slide-1 { background-image: url('{{ asset("image/bps.jpeg") }}'); animation-delay: 0s; }
    .slide-2 { background-image: url('{{ asset("image/hsn.jpg") }}'); animation-delay: 6s; }

    @keyframes slideFade {
        0% { opacity: 0; transform: scale(1.1); }
        10% { opacity: 1; }
        45% { opacity: 1; }
        55% { opacity: 0; transform: scale(1); }
        100% { opacity: 0; }
    }

    /* --- ALUMNI SLIDER --- */
    .slider { height: 360px; margin: auto; overflow: hidden; position: relative; width: 100%; }
    .slide-track { display: flex; width: calc(300px * 10); animation: scroll 40s linear infinite; }
    .slide-card { height: 340px; width: 300px; padding: 15px; flex-shrink: 0; }
    
    @media (max-width: 768px) {
        .slide-track { animation: scroll 30s linear infinite; }
    }
    
    @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-1500px); } }
</style>
@endpush

@section('content')

<section class="hero-section">
    <div class="hero-slider">
        <div class="hero-slide-item slide-1"></div>
        <div class="hero-slide-item slide-2"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 text-center text-white">
        
        @if(isset($pesan_admin) && $pesan_admin != '')
        <div class="flex justify-center mb-6 animate-logo w-full">
            <div class="inline-flex items-center gap-2 md:gap-3 px-3 py-2 md:px-5 md:py-3 rounded-full bg-orange-500/20 border border-orange-400/50 backdrop-blur-md text-orange-100 shadow-lg hover:bg-orange-500/30 transition-all duration-300 cursor-default group max-w-full md:max-w-4xl text-left">
                <span class="flex-shrink-0 flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                <span class="flex-shrink-0 text-[10px] md:text-sm font-semibold tracking-wide uppercase">Info</span>
                <div class="flex-shrink-0 w-px h-3 md:h-4 bg-orange-400/40 mx-1"></div>
                <span class="text-[11px] md:text-sm font-medium whitespace-normal leading-tight md:leading-relaxed group-hover:text-white transition-colors">
                    {{ $pesan_admin }}
                </span>
            </div>
        </div>
        @endif

        <div class="mb-4 md:mb-6 animate-logo" style="animation-delay: 0.1s;">
            <img src="{{ asset('image/bps.png') }}" alt="Logo BPS" class="h-16 md:h-24 mx-auto drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>

        <span class="uppercase tracking-[0.2em] text-blue-400 font-bold text-[10px] md:text-sm mb-2 md:mb-3 block animate-logo" style="animation-delay: 0.2s;">Official Website</span>
        
        <h1 class="text-3xl md:text-6xl font-extrabold leading-tight mb-4 md:mb-6 drop-shadow-lg tracking-tight animate-logo" style="animation-delay: 0.3s;">
            Magang BPS <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300 block md:inline">Kota Tegal</span>
        </h1>
        
        <p class="text-sm md:text-xl text-gray-300 mb-8 md:mb-10 max-w-2xl mx-auto font-light leading-relaxed animate-logo px-2" style="animation-delay: 0.4s;">
            Wujudkan potensi statistik Anda. Bergabunglah dalam program Praktik Kerja Lapangan di lingkungan profesional dan modern.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center animate-logo px-4" style="animation-delay: 0.5s;">
            @auth
                <a href="{{ route('profile') }}" class="px-6 py-3 md:px-8 md:py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-full font-bold shadow-lg shadow-blue-500/40 transition transform hover:-translate-y-1 border border-blue-500 text-sm md:text-base">
                    <i class="fas fa-user-circle mr-2"></i>Dashboard Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 md:px-8 md:py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-full font-bold shadow-lg shadow-blue-500/40 transition transform hover:-translate-y-1 border border-blue-500 text-sm md:text-base">
                    Daftar Sekarang
                </a>
                
                <a href="#alur" class="px-6 py-3 md:px-8 md:py-3.5 bg-white/5 border border-white/20 text-white rounded-full font-bold hover:bg-white hover:text-blue-900 transition backdrop-blur-sm text-sm md:text-base">
                    Pelajari Alur
                </a>
            @endauth
        </div>
    </div>
</section>

<section id="alur" class="py-16 md:py-24 bg-gray-50 relative">
    <div class="container mx-auto px-4 md:px-6">
        <div class="text-center mb-10 md:mb-16 max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-4">Timeline Pendaftaran</h2>
            <p class="text-sm md:text-base text-gray-500">Ikuti langkah mudah berikut untuk memulai perjalanan magang Anda.</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="relative px-2 md:px-4">
                <div class="absolute top-8 md:top-10 left-0 w-full h-1 bg-gray-200 -translate-y-1/2 z-0 rounded-full"></div>
                
                <div class="absolute top-8 md:top-10 left-0 h-1 bg-blue-600 -translate-y-1/2 z-0 rounded-full transition-all duration-1000 ease-out"
                     style="width: 
                        @if(($stepStatus[3] ?? '') == 'completed') 100% 
                        @elseif(($stepStatus[2] ?? '') == 'completed') 100% 
                        @elseif(($stepStatus[1] ?? '') == 'completed') 50% 
                        @else 0% @endif;">
                </div>

                <div class="relative z-10 flex justify-between w-full">
                    
                    <div class="flex flex-col items-center group cursor-default w-1/3">
                        <div class="mb-2 md:mb-4 relative">
                            @if(($stepStatus[1] ?? '') == 'completed')
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center bg-green-500 text-white shadow-xl shadow-green-200 transform scale-100 transition-all duration-300 step-completed">
                                    <i class="fas fa-check text-xl md:text-2xl animate-bounce"></i>
                                </div>
                            @else
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center border-4 text-xl md:text-2xl transition-all duration-300 bg-white shadow-md
                                    {{ ($stepStatus[1] ?? '') == 'active' ? 'border-blue-600 text-blue-600 step-active shadow-blue-200' : 'border-gray-200 text-gray-300' }}">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="text-sm md:text-base font-bold text-gray-800 text-center">1. Buat Akun</h4>
                        <p class="hidden md:block text-xs text-gray-500 mt-1 text-center">Registrasi data diri</p>
                    </div>

                    <div class="flex flex-col items-center group cursor-default w-1/3">
                        <div class="mb-2 md:mb-4 relative">
                            @if(($stepStatus[2] ?? '') == 'completed')
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center bg-green-500 text-white shadow-xl shadow-green-200 transform scale-100 transition-all duration-300 step-completed">
                                    <i class="fas fa-check text-xl md:text-2xl animate-bounce"></i>
                                </div>
                            @else
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center border-4 text-xl md:text-2xl transition-all duration-300 bg-white shadow-md
                                    {{ ($stepStatus[2] ?? '') == 'active' ? 'border-blue-600 text-blue-600 step-active shadow-blue-200' : 'border-gray-200 text-gray-300' }}">
                                    <i class="fas fa-edit"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="text-sm md:text-base font-bold text-gray-800 text-center">2. Isi Formulir</h4>
                        <p class="hidden md:block text-xs text-gray-500 mt-1 text-center">Lengkapi berkas magang</p>
                    </div>

                    <div class="flex flex-col items-center group cursor-default w-1/3">
                        <div class="mb-2 md:mb-4 relative">
                            @if(($stepStatus[3] ?? '') == 'completed')
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center bg-green-500 text-white shadow-xl shadow-green-200 transform scale-100 transition-all duration-300 step-completed">
                                    <i class="fas fa-check text-xl md:text-2xl animate-bounce"></i>
                                </div>
                            @else
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center border-4 text-xl md:text-2xl transition-all duration-300 bg-white shadow-md
                                    {{ ($stepStatus[3] ?? '') == 'active' ? 'border-blue-600 text-blue-600 step-active shadow-blue-200' : 'border-gray-200 text-gray-300' }}">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="text-sm md:text-base font-bold text-gray-800 text-center">3. Pengumuman</h4>
                        <p class="hidden md:block text-xs text-gray-500 mt-1 text-center">Hasil seleksi & surat</p>
                    </div>

                </div>
            </div>

            <div class="mt-10 md:mt-16 max-w-3xl mx-auto">
                @if(($stepStatus[3] ?? '') == 'completed' && isset($pendaftaran) && ($pendaftaran->status == 'approved' || $pendaftaran->status == 'diterima'))
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-green-100 text-center shadow-lg relative overflow-hidden group hover:shadow-xl transition duration-300">
                        <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 text-2xl md:text-3xl group-hover:scale-110 transition duration-300">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Selamat Bergabung!</h3>
                        <p class="text-sm md:text-base text-gray-600 mb-6 md:mb-8 max-w-lg mx-auto">Pengajuan magang Anda telah disetujui. Silakan unduh surat balasan resmi dari BPS di bawah ini.</p>
                        
                        @if($pendaftaran->surat_balasan_pkl)
                            <a href="{{ asset('storage/' . $pendaftaran->surat_balasan_pkl) }}" target="_blank" class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-6 md:py-3 md:px-8 rounded-full hover:bg-green-700 transition shadow-lg hover:shadow-green-200/50 transform hover:-translate-y-1 text-sm md:text-base">
                                <i class="fas fa-download mr-2"></i>Download Surat Balasan
                            </a>
                        @else
                            <div class="inline-flex items-center px-4 py-2 md:px-6 md:py-3 bg-gray-50 rounded-full border border-gray-200 text-gray-500 text-xs md:text-sm">
                                <i class="fas fa-circle-notch fa-spin mr-2"></i>Surat balasan sedang diproses...
                            </div>
                        @endif
                    </div>

                @elseif(($stepStatus[3] ?? '') == 'completed' && isset($pendaftaran) && $pendaftaran->status == 'ditolak')
                     <div class="bg-white rounded-2xl p-6 md:p-8 border border-red-100 text-center shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600 text-2xl md:text-3xl">
                            <i class="fas fa-times"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Mohon Maaf</h3>
                        <p class="text-sm md:text-base text-gray-600">Pengajuan magang Anda belum dapat kami terima saat ini.</p>
                    </div>
                
                @elseif(($stepStatus[3] ?? '') == 'active')
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-blue-100 text-center shadow-lg relative overflow-hidden">
                         <div class="absolute top-0 left-0 w-full h-2 bg-blue-500"></div>
                         <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl md:text-3xl animate-pulse">
                            <i class="far fa-clock"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Menunggu Verifikasi Admin</h3>
                        <p class="text-sm md:text-base text-gray-600 max-w-lg mx-auto">Berkas Anda sudah kami terima dan sedang dalam antrean verifikasi. Mohon cek halaman ini secara berkala.</p>
                    </div>

                @elseif(($stepStatus[2] ?? '') == 'active')
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-blue-100 text-center shadow-lg transform transition hover:scale-[1.01] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-yellow-400"></div>
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 text-yellow-600 text-2xl md:text-3xl">
                            <i class="fas fa-pen-nib"></i>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Lengkapi Pendaftaran Anda</h3>
                        <p class="text-sm md:text-base text-gray-600 mb-6 md:mb-8 max-w-lg mx-auto">Satu langkah lagi! Silakan lengkapi formulir pendaftaran untuk mengajukan permohonan magang.</p>
                        <button onclick="cekProfileDanDaftar()" class="inline-flex items-center bg-blue-600 text-white font-bold py-2 px-6 md:py-3 md:px-8 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-blue-300/50 text-sm md:text-base">
                            Isi Formulir Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                @else
                    <div class="bg-white rounded-2xl p-8 md:p-10 border border-gray-100 text-center shadow-md">
                        <p class="text-gray-500 mb-4 md:mb-6 text-base md:text-lg">Silakan masuk atau buat akun baru untuk memulai proses.</p>
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline text-base md:text-lg">Masuk / Daftar Akun &rarr;</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<section class="py-16 md:py-20 bg-white">
    <div class="container mx-auto px-4 md:px-6 max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 md:mb-10 border-b border-gray-200 pb-4">
            <div class="w-full md:w-auto text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Ketersediaan Kuota</h2>
                <p class="text-sm md:text-base text-gray-500 mt-1 md:mt-2">Cek slot magang yang tersedia setiap bulannya.</p>
            </div>
            <div class="mt-4 md:mt-0 w-full md:w-auto text-center md:text-right">
                <span class="text-xs md:text-sm font-medium text-gray-500 bg-gray-50 px-3 py-1.5 md:px-4 md:py-2 rounded-full border shadow-sm">
                    <i class="fas fa-circle text-green-500 text-[10px] mr-2"></i> Update Real-time
                </span>
            </div>
        </div>

        @if(isset($kuotas) && count($kuotas) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($kuotas as $kuota)
                    @php
                        $terisi = $kuota->pendaftarans ? $kuota->pendaftarans->whereIn('status', ['approved', 'diterima'])->count() : 0;
                        $sisa = $kuota->jumlah_kuota - $terisi;
                        $isFull = $sisa <= 0;
                    @endphp
                    <div class="group bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $isFull ? 'bg-red-500' : 'bg-green-500' }}"></div>
                        
                        <div class="flex justify-between items-start mb-3 md:mb-4">
                            <h4 class="font-bold text-base md:text-lg text-gray-800 group-hover:text-blue-600 transition">{{ $kuota->bulan }}</h4>
                            @if(!$isFull)
                                <i class="fas fa-door-open text-gray-300 group-hover:text-green-500 transition"></i>
                            @else
                                <i class="fas fa-lock text-red-300"></i>
                            @endif
                        </div>
                        
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Sisa Slot</p>
                                <span class="text-2xl md:text-3xl font-bold {{ $isFull ? 'text-red-500' : 'text-gray-800' }}">
                                    {{ $sisa < 0 ? 0 : $sisa }}
                                </span>
                            </div>
                            @if($isFull)
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded border border-red-100">PENUH</span>
                            @else
                                <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">TERSEDIA</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center p-8 md:p-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                <i class="fas fa-calendar-times text-3xl md:text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Data kuota belum tersedia saat ini.</p>
            </div>
        @endif
    </div>
</section>

@if(isset($alumni) && count($alumni) > 0)
<section class="py-16 md:py-24 bg-gray-50 overflow-hidden">
    <div class="container mx-auto px-6 mb-8 md:mb-12 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Alumni Magang</h2>
        <p class="text-sm md:text-base text-gray-500 mt-2">Mereka yang telah berkontribusi dan belajar bersama kami.</p>
    </div>
    
    @php
        $itemCount = count($alumni);
    @endphp

    @if($itemCount <= 4)
        <div class="flex flex-wrap justify-center gap-6 md:gap-8 container mx-auto px-6">
            @foreach($alumni as $a)
            <div class="w-full sm:w-72 group">
                <div class="relative overflow-hidden rounded-2xl shadow-lg bg-white h-72 sm:h-80">
                    <img src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama_lengkap }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500 grayscale group-hover:grayscale-0">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-4 md:p-6 pt-16 md:pt-20">
                        <h4 class="text-white font-bold text-base md:text-lg truncate">{{ $a->nama_lengkap }}</h4>
                        <p class="text-blue-300 text-[10px] md:text-xs font-bold uppercase tracking-wide truncate">{{ $a->universitas }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="slider">
            <div class="slide-track">
                @foreach($alumni as $a)
                <div class="slide-card">
                    <div class="w-full h-full rounded-2xl overflow-hidden shadow-lg relative group bg-white">
                        <img src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama_lengkap }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
                            <h4 class="text-white font-bold text-base md:text-lg leading-tight truncate">{{ $a->nama_lengkap }}</h4>
                            <p class="text-blue-400 text-[10px] md:text-xs font-bold uppercase mt-1 truncate">{{ $a->universitas }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @foreach($alumni as $a)
                <div class="slide-card">
                    <div class="w-full h-full rounded-2xl overflow-hidden shadow-lg relative group bg-white">
                        <img src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama_lengkap }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-4 md:p-6 w-full">
                            <h4 class="text-white font-bold text-base md:text-lg leading-tight truncate">{{ $a->nama_lengkap }}</h4>
                            <p class="text-blue-400 text-[10px] md:text-xs font-bold uppercase mt-1 truncate">{{ $a->universitas }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endif

@endsection

@push('scripts')
<script>
    function cekProfileDanDaftar() {
        const isListLoggedIn = "{{ Auth::check() ? 'yes' : 'no' }}";

        if (isListLoggedIn === 'no') {
            window.location.href = "{{ route('login') }}";
            return;
        }

        const userHp = "{{ Auth::user()->no_telp ?? '' }}";
        const userSekolah = "{{ Auth::user()->asal_sekolah ?? '' }}";
        const userJurusan = "{{ Auth::user()->jurusan ?? '' }}";

        if (userHp === '' || userSekolah === '' || userJurusan === '') {
            Swal.fire({
                title: 'Profil Belum Lengkap',
                text: "Mohon lengkapi data diri (No. HP, Sekolah, Jurusan) sebelum mengisi formulir.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Lengkapi Sekarang',
                cancelButtonText: 'Nanti Saja'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('profile') }}";
                }
            });
        } else {
            window.location.href = "{{ route('pendaftaran.create') }}";
        }
    }
</script>
@endpush