<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Surat Tanda Tangan Mitra</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header Card */
        .header-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .back-link {
            margin-bottom: 25px;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #f0f3ff 0%, #e8ecff 100%);
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .back-link a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .back-link a::before {
            content: '←';
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .back-link a:hover::before {
            transform: translateX(-3px);
        }

        h1 {
            color: #2d3748;
            font-size: 2em;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Success Alert - Modern Notification */
        .alert {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 20px 25px;
            border-radius: 16px;
            font-weight: 600;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 320px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: slideInRight 0.5s ease-out, pulse 2s ease-in-out infinite;
            backdrop-filter: blur(10px);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        @keyframes slideOutRight {
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-size: 16px;
            margin-bottom: 3px;
        }

        .alert-message {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 500;
        }

        .alert-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
            padding: 5px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Upload Form Card */
        .upload-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
        }

        .file-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        input[type="file"] {
            display: none;
        }

        .file-input-label {
            flex: 1;
            padding: 20px;
            border: 3px dashed #cbd5e0;
            border-radius: 16px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .file-input-label:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #f0f3ff 0%, #e8ecff 100%);
            transform: translateY(-2px);
        }

        .file-input-label.has-file {
            border-color: #10b981;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-style: solid;
        }

        .file-upload-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .file-upload-text {
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
        }

        .file-upload-text strong {
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }

        .file-name-display {
            margin-top: 10px;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            font-size: 13px;
            color: #2d3748;
            display: none;
        }

        .file-name-display.show {
            display: block;
        }

        .note {
            font-size: 13px;
            color: #718096;
            margin-top: 8px;
            font-weight: 500;
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error::before {
            content: '⚠';
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* Table Card */
        .table-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .table-card h2 {
            color: #2d3748;
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #4a5568;
            font-size: 14px;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, #f0f3ff 0%, #e8ecff 100%);
            transform: scale(1.01);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .btn-view {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .no-surat {
            text-align: center;
            padding: 60px 30px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 16px;
            color: #718096;
            font-weight: 500;
            border: 2px dashed #cbd5e0;
        }

        .no-surat-icon {
            font-size: 60px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header-card, .upload-card, .table-card {
                padding: 25px;
            }

            h1 {
                font-size: 1.5em;
            }

            .alert {
                right: 15px;
                left: 15px;
                min-width: auto;
            }

            .table-wrapper {
                font-size: 12px;
            }

            th, td {
                padding: 12px 10px;
                font-size: 12px;
            }

            .btn-view {
                padding: 8px 14px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-card">
            <div class="back-link">
                <a href="{{ route('home') }}">Kembali ke Beranda</a>
            </div>
            <h1> Upload Surat Tanda Tangan</h1>
            <p class="subtitle">Kelola dokumen yang memerlukan tanda tangan mitra dengan mudah</p>
        </div>

        {{-- Modern Alert Notification --}}
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                <div class="alert-icon">✓</div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
                <button class="alert-close" onclick="closeAlert('success-alert')">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error" id="error-alert">
                <div class="alert-icon">⚠</div>
                <div class="alert-content">
                    <div class="alert-title">Terjadi Kesalahan</div>
                    <div class="alert-message">{{ session('error') }}</div>
                </div>
                <button class="alert-close" onclick="closeAlert('error-alert')">×</button>
            </div>
        @endif

        {{-- Upload Form --}}
        <div class="upload-card">
            <form action="{{ route('upload.surat.tanda.tangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="surat_tanda_tangan">
                         Pilih File Surat
                    </label>
                    <div class="file-input-wrapper">
                        <label for="surat_tanda_tangan" class="file-input-label" id="fileLabel">
                            <div class="file-upload-icon">📤</div>
                            <div class="file-upload-text">
                                <strong>Klik untuk memilih file</strong>
                                atau drag & drop file di sini
                            </div>
                            <div class="file-name-display" id="fileName"></div>
                        </label>
                        <input type="file" id="surat_tanda_tangan" name="surat_tanda_tangan" accept=".pdf" required>
                    </div>
                    <p class="note"> Format: PDF | Ukuran maksimal: 2MB</p>
                    @error('surat_tanda_tangan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-submit">
                     Upload Surat Sekarang
                </button>
            </form>
        </div>

        {{-- Table of Uploaded Surat --}}
        @if($suratUploads->count() > 0)
            <div class="table-card">
                <h2>📋 Daftar Surat yang Telah Diupload</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratUploads as $index => $surat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $surat->file_name }}</td>
                                    <td>{{ strtoupper($surat->file_type) }}</td>
                                    <td>{{ $surat->file_size }} KB</td>
                                    <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="btn-view">
                                             Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="table-card">
                <div class="no-surat">
                    <div class="no-surat-icon">📭</div>
                    <p>Belum ada surat yang diupload.<br>Silakan upload surat pertama Anda di atas.</p>
                </div>
            </div>
        @endif
    </div>

    <script>
        // File input handler with visual feedback
        const fileInput = document.getElementById('surat_tanda_tangan');
        const fileLabel = document.getElementById('fileLabel');
        const fileNameDisplay = document.getElementById('fileName');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileLabel.classList.add('has-file');
                fileNameDisplay.textContent = `📄 ${file.name}`;
                fileNameDisplay.classList.add('show');
            }
        });

        // Drag and drop functionality
        fileLabel.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileLabel.style.borderColor = '#667eea';
            fileLabel.style.background = 'linear-gradient(135deg, #f0f3ff 0%, #e8ecff 100%)';
        });

        fileLabel.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileLabel.style.borderColor = '#cbd5e0';
            fileLabel.style.background = 'linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%)';
        });

        fileLabel.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        });

        // Auto-dismiss alerts
        function closeAlert(id) {
            const alert = document.getElementById(id);
            if (alert) {
                alert.style.animation = 'slideOutRight 0.5s ease-out forwards';
                setTimeout(() => alert.remove(), 500);
            }
        }

        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.animation = 'slideOutRight 0.5s ease-out forwards';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>