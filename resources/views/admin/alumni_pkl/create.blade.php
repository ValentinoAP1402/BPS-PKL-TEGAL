<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alumni PKL - Admin Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #fef3f4 0%, #fff7ed 50%, #f0f9ff 100%);
            font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            padding-bottom: 40px;
            color: #1e293b;
        }

        /* Navbar */
        .navbar { 
            background: #ffffff;
            padding: 20px 32px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #e8ecf1;
        }
        
        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-weight: 700;
            font-size: 1.4em;
            color: #2563eb;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        
        .back-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background: #eff6ff;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-link:hover {
            background: #dbeafe;
            transform: translateX(-4px);
        }
        
        .back-link::before {
            content: '←';
            font-size: 1.2em;
        }
        
        /* Container */
        .container {
            max-width: 1000px;
            margin: 32px auto;
            padding: 0 24px;
        } 

        /* Form Section */
        .form-section {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            animation: fadeIn 0.4s ease-out;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            display: block;
        }

        h1 {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            height: 400px;
        }

        .file-input-label:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .file-input-label.dragover {
            border-color: #10b981;
            background: #ecfdf5;
        }

        .file-icon {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        .file-text {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .file-hint {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        /* Preview Image */
        .image-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            display: none;
        }

        .file-input-label.has-preview .file-icon,
        .file-input-label.has-preview .file-text,
        .file-input-label.has-preview .file-hint {
            display: none;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-radius: 12px;
            border: 1px solid #6ee7b7;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            accent-color: #10b981;
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 0.95rem;
            color: #065f46;
            cursor: pointer;
            font-weight: 500;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-primary::before {
            content: '💾';
        }

        .btn-secondary {
            background: #ffffff;
            color: #6b7280;
            border: 2px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .btn-secondary::before {
            content: '←';
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .error-message::before {
            content: '⚠️';
        }

        /* Success Alert */
        .alert-success {
            padding: 18px 24px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
            border-radius: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            border: 2px solid #6ee7b7;
            animation: slideInAlert 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        .alert-success::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: linear-gradient(180deg, #10b981, #059669);
            animation: progressBar 5s ease-out;
        }

        .alert-success::after {
            content: '✓';
            font-size: 1.5em;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6ee7b7, #10b981);
            color: #ffffff;
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 32px;
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 500;
            animation: fadeIn 1s ease;
        }

        /* Animations */
        @keyframes slideInAlert {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes progressBar {
            from {
                transform: scaleY(1);
            }
            to {
                transform: scaleY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .navbar {
                padding: 16px 20px;
            }

            .form-section {
                padding: 32px 24px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 1.2em;
            }

            h1 {
                font-size: 1.4rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .form-section {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">Admin Dashboard</span>
            <a href="{{ route('admin.alumni_pkl.index') }}" class="back-btn">Kembali</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
        <div class="alert-success" id="successAlert">{{ session('success') }}</div>
        @endif

        <div class="form-section">
            <div class="form-header">
                <h1>Tambah Alumni PKL</h1>
                <p class="subtitle">Tambahkan data alumni PKL baru yang akan ditampilkan di homepage website dengan galeri yang menarik.</p>
            </div>

            <form method="POST" action="{{ route('admin.alumni_pkl.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" required
                           placeholder="Masukkan nama lengkap alumni" value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="universitas" class="form-label">Universitas *</label>
                    <input type="text" id="universitas" name="universitas" class="form-input" required
                           placeholder="Masukkan nama universitas" value="{{ old('universitas') }}">
                    @error('universitas')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto" class="form-label">Foto Alumni *</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="foto" name="foto" class="file-input" accept="image/*" required>
                        <label for="foto" class="file-input-label">
                            <img id="imagePreview" class="image-preview" alt="Preview">
                            <img src="{{ asset('image/camera.png') }}" class="file-icon" alt="Camera Icon">
                            <div class="file-text">Klik untuk memilih foto</div>
                            <div class="file-hint">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        </label>
                    </div>
                    @error('foto')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="is_active" name="is_active" class="checkbox-input" checked>
                        <label for="is_active" class="checkbox-label">✅ Tampilkan di homepage</label>
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ route('admin.alumni_pkl.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Alumni</button>
                </div>
            </form>
        </div>

        <p class="footer-note">💡 Pastikan foto yang diupload berkualitas baik untuk tampilan yang menarik di homepage</p>
    </div>

    <script>
        // Auto hide alert after 5 seconds
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(-100px)';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
        }

        // Image preview functionality
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const label = document.querySelector('.file-input-label');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    label.classList.add('has-preview');
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                label.classList.remove('has-preview');
            }
        });

        // Drag and drop functionality
        const fileInput = document.getElementById('foto');
        const fileLabel = document.querySelector('.file-input-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileLabel.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileLabel.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileLabel.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileLabel.classList.add('dragover');
        }

        function unhighlight(e) {
            fileLabel.classList.remove('dragover');
        }

        fileLabel.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                // Trigger change event
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        }
    </script>
</body>
</html>