@extends('admin.layouts.app')

@section('title', 'Edit Data Alumni')

{{-- NAVBAR BRANDING --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 40px; height: 40px; background: #fffbeb; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #d97706;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </div>
        <div>
            <div style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Kelola Alumni</div>
            <div style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Edit Data</div>
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
        /* Custom CSS untuk halaman Edit */
        .edit-container {
            max-width: 700px;
            margin: 20px auto;
        }

        .edit-card {
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
            border-color: #f59e0b; /* Amber focus color */
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        /* Foto Lama Section */
        .current-photo-box {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        
        .current-avatar {
            width: 56px; height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Upload Area */
        .upload-area {
            position: relative;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            background: #f8fafc;
            transition: all 0.2s;
            cursor: pointer;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #f59e0b;
            background: #fffbf0;
        }

        .upload-icon { font-size: 2rem; color: #94a3b8; margin-bottom: 8px; display: block; }
        .upload-text { font-size: 0.9rem; font-weight: 600; color: #475569; }
        .upload-hint { font-size: 0.8rem; color: #94a3b8; }

        .btn-save {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.1s;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
            display: flex; justify-content: center; align-items: center; gap: 8px;
        }
        
        .btn-save:hover { background: #b45309; transform: translateY(-1px); }
        .btn-save:active { transform: translateY(0); }

        .error-msg { color: #ef4444; font-size: 0.85rem; margin-top: 6px; display: block; }
    </style>

    <div class="edit-container">
        <div class="edit-card">
            <div class="card-header">
                <h2>Formulir Perubahan Data</h2>
                <p>Silakan perbarui informasi alumni di bawah ini.</p>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.alumni_pkl.update', $alumni->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" 
                               class="form-input"
                               value="{{ old('nama_lengkap', $alumni->nama_lengkap) }}" 
                               required
                               placeholder="Masukkan nama lengkap alumni">
                        @error('nama_lengkap')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Universitas --}}
                    <div class="form-group">
                        <label for="universitas" class="form-label">Asal Sekolah / Universitas</label>
                        <input type="text" id="universitas" name="universitas" 
                               class="form-input"
                               value="{{ old('universitas', $alumni->universitas) }}" 
                               required
                               placeholder="Contoh: Universitas Indonesia">
                        @error('universitas')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Foto Section --}}
                    <div class="form-group">
                        <label class="form-label">Foto Alumni</label>

                        {{-- Tampilan Foto Lama --}}
                        @if($alumni->foto)
                            <div class="current-photo-box">
                                <img src="{{ asset('storage/' . $alumni->foto) }}" alt="Current" class="current-avatar">
                                <div>
                                    <div style="font-size: 0.9rem; font-weight: 600; color: #92400e;">Foto Saat Ini</div>
                                    <div style="font-size: 0.8rem; color: #b45309;">Tersimpan di database</div>
                                </div>
                            </div>
                        @endif

                        {{-- Input Upload Baru --}}
                        <div class="upload-area" id="dropArea">
                            <input type="file" id="foto" name="foto" accept="image/*"
                                   style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
                            
                            <div id="uploadContent">
                                <span class="upload-icon">📷</span>
                                <div class="upload-text">Klik atau seret foto baru ke sini</div>
                                <div class="upload-hint">Biarkan kosong jika tidak ingin mengubah foto</div>
                            </div>

                            {{-- Preview Image --}}
                            <div id="imagePreview" style="display: none; justify-content: center; margin-top: 10px;">
                                <img src="" alt="Preview" style="max-height: 150px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                        @error('foto')
                            <span class="error-msg">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-save">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script JavaScript --}}
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
                    uploadContent.style.display = 'none'; // Hide default text
                    
                    // Style active state
                    uploadArea.style.borderColor = '#d97706';
                    uploadArea.style.background = '#fffbeb';
                }
                reader.readAsDataURL(files[0]);
            }
        }
    </script>
@endsection