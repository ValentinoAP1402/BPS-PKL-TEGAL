@extends('admin.layouts.app')

@section('title', 'Tambah Alumni PKL')

{{-- NAVBAR BRANDING --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
            {{-- Icon Plus --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </div>
        <div>
            <div style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Kelola Alumni</div>
            <div style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Tambah Baru</div>
        </div>
    </div>
@endsection

{{-- NAVBAR ACTIONS --}}
@section('navbar-actions')
    <a href="{{ route('admin.alumni_pkl.index') }}" 
       style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: #64748b; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem; border: 1px solid #e2e8f0; transition: all 0.2s;">
        <span>Batal</span>
    </a>
@endsection

{{-- CONTENT --}}
@section('content')
    <style>
        /* Custom CSS untuk halaman Create */
        .create-container {
            max-width: 700px;
            margin: 20px auto;
        }

        .create-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header {
            background: #f8fafc;
            padding: 20px 32px;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-header h2 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; }
        .card-header p { font-size: 0.85rem; color: #64748b; margin: 4px 0 0 0; }

        .card-body { padding: 32px; }

        .form-group { margin-bottom: 24px; }
        
        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: #3b82f6; /* Blue focus color */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Upload Area Style */
        .upload-area {
            position: relative;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px 32px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.2s;
            cursor: pointer;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .upload-icon { font-size: 2.5rem; color: #94a3b8; margin-bottom: 12px; display: block; }
        .upload-text { font-size: 0.95rem; font-weight: 600; color: #475569; }
        .upload-hint { font-size: 0.85rem; color: #94a3b8; margin-top: 4px; }

        /* Button Style */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.1s;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
            display: flex; justify-content: center; align-items: center; gap: 8px;
        }
        
        .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }

        .error-msg { color: #ef4444; font-size: 0.85rem; margin-top: 6px; display: block; }
    </style>

    <div class="create-container">
        <div class="create-card">
            <div class="card-header">
                <h2>Input Data Alumni</h2>
                <p>Tambahkan data alumni baru untuk ditampilkan di beranda.</p>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.alumni_pkl.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" 
                               class="form-input"
                               value="{{ old('nama_lengkap') }}" 
                               required
                               placeholder="Contoh: Budi Santoso">
                        @error('nama_lengkap')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Universitas --}}
                    <div class="form-group">
                        <label for="universitas" class="form-label">Asal Sekolah / Universitas</label>
                        <input type="text" id="universitas" name="universitas" 
                               class="form-input"
                               value="{{ old('universitas') }}" 
                               required
                               placeholder="Contoh: Universitas Indonesia">
                        @error('universitas')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Foto Upload --}}
                    <div class="form-group">
                        <label class="form-label">Foto Alumni</label>
                        
                        <div class="upload-area" id="dropArea">
                            <input type="file" id="foto" name="foto" accept="image/*" required
                                   style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
                            
                            <div id="uploadContent">
                                <span class="upload-icon">📷</span>
                                <div class="upload-text">Klik atau seret foto ke sini</div>
                                <div class="upload-hint">Format: JPG, PNG, JPEG (Maks. 2MB)</div>
                            </div>

                            {{-- Preview Image --}}
                            <div id="imagePreview" style="display: none; justify-content: center; margin-top: 10px;">
                                <img src="" alt="Preview" style="max-height: 180px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                        @error('foto')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript untuk Interaksi --}}
    <script>
        const fotoInput = document.getElementById('foto');
        const uploadArea = document.getElementById('dropArea');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = previewContainer.querySelector('img');
        const uploadContent = document.getElementById('uploadContent');

        // Handle Change Event (Click Upload)
        fotoInput.addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });

        // Handle Drag & Drop Visuals
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            }, false);
        });

        // Handle Drop Event
        uploadArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fotoInput.files = files; // Assign files to input
                handleFiles(files);
            }
        });

        function handleFiles(files) {
            if (files && files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'flex';
                    uploadContent.style.display = 'none'; // Sembunyikan teks default
                    
                    // Style active state (Biru)
                    uploadArea.style.borderColor = '#3b82f6';
                    uploadArea.style.background = '#eff6ff';
                }
                reader.readAsDataURL(files[0]);
            }
        }
    </script>
@endsection