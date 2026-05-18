@extends('layouts.app')

@section('title', 'Form Pendaftaran Magang')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Formulir Pendaftaran</h1>
            <p class="text-gray-500 mt-2">Silakan lengkapi data di bawah ini untuk mengajukan permohonan magang.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="pendaftaran-form" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-500 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-500 cursor-not-allowed" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" required placeholder="0812..." class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" value="{{ old('no_hp', Auth::user()->no_telp) }}">
                    </div>
                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700 mb-2">Asal Sekolah / Kampus <span class="text-red-500">*</span></label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" required placeholder="Contoh: Universitas Dian Nuswantoro" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" value="{{ old('asal_sekolah', Auth::user()->asal_sekolah) }}">
                    </div>
                </div>

                <hr class="border-gray-100 my-2">

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Periode Magang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="tanggal_mulai_pkl" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai_pkl" id="tanggal_mulai_pkl" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label for="tanggal_selesai_pkl" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai_pkl" id="tanggal_selesai_pkl" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="button" id="check-quota" class="px-6 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 transition focus:outline-none flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i> Cek Ketersediaan Kuota
                        </button>
                        <span class="text-xs text-gray-400">Wajib cek kuota sebelum lanjut.</span>
                    </div>
                    <div id="availability-status" class="mt-4"></div>
                </div>

                <hr class="border-gray-100 my-2">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Surat Pengantar / Proposal <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex items-center gap-4 mt-2 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label for="surat_keterangan_pkl" class="cursor-pointer bg-white text-gray-700 font-medium py-2 px-4 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition">
                            <i class="fa-solid fa-upload mr-2 text-blue-500"></i> Choose File
                            <input id="surat_keterangan_pkl" name="surat_keterangan_pkl" type="file" class="sr-only" accept=".pdf">
                        </label>
                        
                        <div class="flex-1 truncate">
                            <span id="filename-display" class="text-gray-500 text-sm italic">Belum ada file yang dipilih...</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 ml-1">Format PDF, Maksimal 2MB</p>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-xl transition transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Kirim Pendaftaran
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('pendaftaran-form');
        const checkBtn = document.getElementById('check-quota');
        const startDateInput = document.getElementById('tanggal_mulai_pkl');
        const statusDiv = document.getElementById('availability-status');
        const submitBtn = document.getElementById('submit-btn');
        const fileInput = document.getElementById('surat_keterangan_pkl');
        const fileNameDisplay = document.getElementById('filename-display');

        // 1. Tampilkan Nama File
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('text-gray-500', 'italic');
                fileNameDisplay.classList.add('text-gray-800', 'font-medium');
            } else {
                fileNameDisplay.textContent = "Belum ada file yang dipilih...";
                fileNameDisplay.classList.add('text-gray-500', 'italic');
                fileNameDisplay.classList.remove('text-gray-800', 'font-medium');
            }
        });

        // 2. Validasi Submit Manual (Pengganti 'required' browser)
        form.addEventListener('submit', function(e) {
            // Cek apakah file kosong
            if (fileInput.files.length === 0) {
                e.preventDefault(); // Batalkan pengiriman form
                
                // Tampilkan Alert Warning
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Belum Diupload',
                        text: 'Mohon upload Surat Pengantar / Proposal terlebih dahulu sebelum mengirim pendaftaran.',
                        confirmButtonColor: '#3b82f6'
                    });
                } else {
                    alert('Mohon upload Surat Pengantar / Proposal terlebih dahulu!');
                }
            }
        });

        // 3. Logic Cek Kuota
        checkBtn.addEventListener('click', function() {
            const startDate = startDateInput.value;
            
            if (!startDate) {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Pilih Tanggal', text: 'Silakan pilih tanggal mulai magang terlebih dahulu.' });
                } else {
                    alert('Silakan pilih tanggal mulai magang terlebih dahulu');
                }
                return;
            }

            statusDiv.innerHTML = '<div class="text-blue-600 animate-pulse flex items-center gap-2"><i class="fa-solid fa-spinner fa-spin"></i> Sedang mengecek ketersediaan...</div>';
            checkBtn.disabled = true; 
            
            const checkUrl = "{{ route('check.quota') }}"; 
            
            fetch(`${checkUrl}?date=${startDate}`)
                .then(response => response.json())
                .then(data => {
                    checkBtn.disabled = false;
                    
                    if (data.available) {
                        statusDiv.innerHTML = `
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg flex items-start">
                                <i class="fa-solid fa-circle-check text-green-500 mt-1 mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-green-800">Kuota Tersedia!</h4>
                                    <p class="text-sm text-green-700">${data.message}</p>
                                </div>
                            </div>
                        `;
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        statusDiv.innerHTML = `
                            <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-start">
                                <i class="fa-solid fa-circle-xmark text-red-500 mt-1 mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-red-800">Kuota Penuh / Tidak Tersedia</h4>
                                    <p class="text-sm text-red-700">${data.message || 'Mohon pilih bulan lain.'}</p>
                                </div>
                            </div>
                        `;
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkBtn.disabled = false;
                    statusDiv.innerHTML = '<span class="text-orange-500">Gagal koneksi. Coba lagi nanti.</span>';
                });
        });

        startDateInput.addEventListener('change', () => {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            statusDiv.innerHTML = '';
        });
    });
</script>
@endsection