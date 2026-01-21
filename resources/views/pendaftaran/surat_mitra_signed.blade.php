@extends('layouts.app')

@section('title', 'Surat Balasan PKL')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">

        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 rounded-full mb-4 shadow-sm">
                <i class="fa-solid fa-file-signature text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Surat Balasan PKL</h1>
            <p class="text-gray-500 mt-2">Unduh atau lihat surat balasan yang telah ditandatangani secara digital.</p>
        </div>

        @if($pendaftaran->surat_balasan_pkl)
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="p-8 text-center border-b border-gray-100">
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 max-w-lg mx-auto mb-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Surat Balasan PKL</h3>
                            <p class="text-sm text-gray-500 mb-4">File: Surat Balasan PKL</p>

                            <div class="flex justify-center items-center gap-2 text-green-600 bg-green-50 px-3 py-1 rounded-full text-xs font-semibold w-fit mx-auto">
                                <i class="fa-solid fa-circle-check"></i> Ditandatangani Secara Elektronik
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-gray-600">
                                Yth. <strong>{{ $pendaftaran->nama_lengkap }}</strong>,
                            </p>
                            <p class="text-gray-500 text-sm leading-relaxed max-w-2xl mx-auto">
                                Terima kasih atas kontribusi Anda. Surat balasan ini diterbitkan sebagai konfirmasi penerimaan PKL Anda di BPS Kota Tegal. Silakan unduh dokumen melalui tombol di bawah ini.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-6 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ asset('storage/' . $pendaftaran->surat_balasan_pkl) }}" target="_blank" class="flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 hover:border-blue-300 hover:text-blue-600 transition shadow-sm group">
                            <i class="fa-regular fa-eye group-hover:scale-110 transition-transform"></i>
                            Lihat Dokumen
                        </a>

                        <a href="{{ asset('storage/' . $pendaftaran->surat_balasan_pkl) }}" download="Surat_Balasan_PKL_{{ $pendaftaran->nama_lengkap }}.pdf" class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 transition transform">
                            <i class="fa-solid fa-download animate-bounce"></i>
                            Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full mb-4">
                    <i class="fa-solid fa-clock text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Dokumen</h3>
                <p class="text-gray-500">Surat keterangan Anda sedang diproses oleh admin. Silakan cek kembali nanti.</p>
            </div>
        @endif
    </div>
</div>
@endsection
