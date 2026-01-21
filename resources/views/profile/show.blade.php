@extends('layouts.app')

@section('title', 'Dashboard Peserta - BPS PKL')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    
                    <div class="text-center mb-6">
                        <div class="relative w-28 h-28 mx-auto mb-4 group">
                            @if(Auth::user()->avatar)
                                @if(str_starts_with(Auth::user()->avatar, 'http'))
                                    <img src="{{ Auth::user()->avatar }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                                @endif
                            @else
                                <div class="w-full h-full bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-4xl font-bold border-4 border-white shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <button onclick="openEditModal()" class="absolute bottom-1 right-1 bg-blue-600 text-white p-2 rounded-full shadow-lg hover:bg-blue-700 transition text-xs" title="Ganti Foto">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500 text-sm break-all">{{ Auth::user()->email }}</p>
                    </div>

                    <hr class="border-gray-100 my-4">

                    <div class="space-y-4 text-sm text-gray-700">
                        <div class="flex items-start">
                            <i class="fa-solid fa-phone text-blue-500 mt-1 w-6"></i>
                            <div class="flex-1">
                                <p class="text-gray-400 text-xs">No. Telepon</p>
                                <p class="font-medium">{{ Auth::user()->no_telp ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fa-solid fa-graduation-cap text-blue-500 mt-1 w-6"></i>
                            <div class="flex-1">
                                <p class="text-gray-400 text-xs">Asal Sekolah/Kampus</p>
                                <p class="font-medium">{{ Auth::user()->asal_sekolah ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fa-solid fa-book text-blue-500 mt-1 w-6"></i>
                            <div class="flex-1">
                                <p class="text-gray-400 text-xs">Jurusan</p>
                                <p class="font-medium">{{ Auth::user()->jurusan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6">

                    <div class="space-y-3">
                        <button onclick="openEditModal()" class="block w-full py-2.5 px-4 bg-white border border-blue-200 text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition">
                            <i class="fa-solid fa-user-pen mr-2"></i> Edit Profil
                        </button>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full py-2.5 px-4 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium transition">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                
                @if($pendaftaran)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 text-lg">Status Magang</h3>
                            
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide
                                @if($pendaftaran->status == 'diterima') bg-green-100 text-green-700
                                @elseif($pendaftaran->status == 'ditolak') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ $pendaftaran->status }}
                            </span>
                        </div>
                        
                        <div class="p-6">
                            @if($pendaftaran->status == 'pending')
                                <div class="flex items-start p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                                    <i class="fa-solid fa-clock text-yellow-500 text-xl mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-bold text-yellow-800">Menunggu Verifikasi</h4>
                                        <p class="text-sm text-yellow-700 mt-1">Berkas pendaftaran Anda sedang direview oleh admin. Silakan cek berkala.</p>
                                    </div>
                                </div>
                            @elseif($pendaftaran->status == 'diterima')
                                <div class="flex items-start p-4 bg-green-50 rounded-lg border-l-4 border-green-500 mb-6">
                                    <i class="fa-solid fa-check-circle text-green-500 text-xl mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-bold text-green-800">Selamat! Anda Diterima</h4>
                                        <p class="text-sm text-green-700 mt-1">Silakan unduh surat balasan di bawah ini.</p>
                                    </div>
                                </div>
                                <a href="{{ route('pendaftaran.surat_mitra_signed') }}" target="_blank" class="flex items-center p-4 border border-blue-200 bg-blue-50 rounded-xl hover:bg-blue-100 transition group cursor-pointer">
                                    <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 mr-4 group-hover:scale-110 transition">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Download Surat Balasan</h4>
                                        <p class="text-xs text-gray-500">Format PDF</p>
                                    </div>
                                </a>
                            @elseif($pendaftaran->status == 'ditolak')
                                <div class="flex items-start p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                                    <i class="fa-solid fa-circle-xmark text-red-500 text-xl mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-bold text-red-800">Mohon Maaf</h4>
                                        <p class="text-sm text-red-700 mt-1">Pendaftaran Anda belum dapat diterima.</p>
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Mulai Magang</p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->tgl_mulai)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-500 mb-1">Selesai Magang</p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pendaftaran->tgl_selesai)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-lg p-10 text-center text-white relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-x-10 -translate-y-10"></div>
                        <div class="absolute bottom-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full translate-x-10 translate-y-10"></div>

                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                                📝
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Yuk, Daftar Magang!</h3>
                            <p class="opacity-90 max-w-md mx-auto mb-8">Data profil Anda sudah lengkap? Segera ajukan permohonan magang untuk memulai pengalaman baru di BPS.</p>
                            
                            <a href="{{ route('pendaftaran.create') }}" class="inline-block px-8 py-3 bg-white text-blue-700 rounded-full font-bold shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1">
                                Isi Formulir Pendaftaran
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="editProfileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Edit Profil Saya</h3>
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                                    <input type="file" name="avatar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp/HP</label>
                                    <input type="tel" name="no_telp" value="{{ Auth::user()->no_telp }}" maxlength="13" pattern="[0-9]*" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Contoh: 08123456789">
                                    @error('no_telp')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Asal Sekolah / Kampus</label>
                                    <input type="text" name="asal_sekolah" value="{{ Auth::user()->asal_sekolah }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Nama instansi pendidikan">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                                    <input type="text" name="jurusan" value="{{ Auth::user()->jurusan }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Jurusan saat ini">
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse -mx-6 -mb-6 mt-6">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Perubahan
                                </button>
                                <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script Sederhana untuk Modal
    function openEditModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>
@endsection