<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
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
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* Animated Background Shapes */
        .bg-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float-shapes 20s ease-in-out infinite;
            z-index: 0;
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
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: #764ba2;
            bottom: 10%;
            right: 5%;
            animation-delay: 7s;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            padding: 50px;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        h1 {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 40px;
            font-weight: 800;
            font-size: 2.5rem;
            position: relative;
        }

        h1:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        /* Avatar Section */
        .avatar-section {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeIn 0.8s ease;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .avatar-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #667eea, #764ba2) border-box;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .avatar-img:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.5);
        }

        .avatar-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            border: 4px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .edit-avatar-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
        }

        .edit-avatar-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
        }

        /* Profile Info Grid */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease 0.2s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            border-color: rgba(102, 126, 234, 0.3);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .info-label .icon {
            font-size: 1.2rem;
        }

        .info-value {
            color: #6b7280;
            font-size: 1rem;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        /* Section Header */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 40px 0 25px 0;
            padding-bottom: 15px;
            border-bottom: 3px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(90deg, #667eea, #764ba2) border-box;
            border-image: linear-gradient(90deg, #667eea, #764ba2) 1;
        }

        .section-header h2 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .section-header .icon {
            font-size: 1.8rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Edit Avatar Section */
        .edit-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 30px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .edit-section h2 {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .file-input-wrapper {
            position: relative;
            margin-bottom: 15px;
        }

        input[type="file"] {
            width: 100%;
            padding: 14px;
            border: 2px dashed rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            background: white;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            border-color: rgba(102, 126, 234, 0.6);
            background: rgba(102, 126, 234, 0.02);
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }

        .btn-save {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.5);
        }

        .btn-cancel {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            border: 2px solid rgba(107, 114, 128, 0.2);
        }

        .btn-cancel:hover {
            background: rgba(107, 114, 128, 0.2);
            transform: translateY(-2px);
        }

        .btn-logout {
            width: 100%;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
            margin-top: 30px;
        }

        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(239, 68, 68, 0.5);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 50px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            transform: translateX(-5px);
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .alert-success:before {
            content: '✓';
            font-size: 1.5rem;
            color: #10b981;
        }

        /* Responsive untuk Laptop 1366x768 */
        @media (max-width: 1400px) {
            body {
                padding: 30px 20px;
            }

            .container {
                max-width: 850px;
                padding: 40px;
            }

            h1 {
                font-size: 2.2rem;
                margin-bottom: 35px;
            }

            .avatar-section {
                margin-bottom: 40px;
            }

            .avatar-img {
                width: 130px;
                height: 130px;
            }

            .avatar-badge {
                width: 35px;
                height: 35px;
                font-size: 1.1rem;
            }

            .profile-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 18px;
                margin-bottom: 35px;
            }

            .info-card {
                padding: 18px;
            }

            .info-label {
                font-size: 0.85rem;
            }

            .info-value {
                font-size: 0.95rem;
                padding: 9px 11px;
            }

            .section-header {
                margin: 35px 0 20px 0;
                padding-bottom: 12px;
            }

            .section-header h2 {
                font-size: 1.4rem;
            }

            .section-header .icon {
                font-size: 1.6rem;
            }

            .edit-section {
                padding: 30px;
            }

            .btn {
                padding: 12px 26px;
                font-size: 0.95rem;
            }

            .empty-state {
                padding: 50px 20px;
            }

            .empty-state .icon {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 1024px) {
            .container {
                max-width: 750px;
                padding: 35px;
            }

            h1 {
                font-size: 2rem;
            }

            .profile-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        /* Tablet Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .container {
                padding: 35px 25px;
                border-radius: 20px;
            }

            h1 {
                font-size: 1.9rem;
            }

            .avatar-img {
                width: 120px;
                height: 120px;
            }

            .avatar-badge {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .section-header h2 {
                font-size: 1.3rem;
            }

            .section-header .icon {
                font-size: 1.5rem;
            }

            .button-group {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .bg-shape {
                display: none;
            }

            .edit-section {
                padding: 28px 22px;
            }

            .empty-state {
                padding: 45px 20px;
            }

            .empty-state .icon {
                font-size: 3rem;
            }
        }

        /* Mobile Small */
        @media (max-width: 480px) {
            body {
                padding: 15px 10px;
            }

            .container {
                padding: 30px 20px;
                border-radius: 16px;
            }

            h1 {
                font-size: 1.65rem;
                margin-bottom: 30px;
            }

            h1:after {
                width: 60px;
                height: 3px;
                margin-top: 12px;
            }

            .avatar-section {
                margin-bottom: 35px;
            }

            .avatar-img {
                width: 100px;
                height: 100px;
                border: 4px solid transparent;
            }

            .avatar-badge {
                width: 28px;
                height: 28px;
                font-size: 0.9rem;
                border: 3px solid white;
            }

            .edit-avatar-btn {
                padding: 10px 22px;
                font-size: 0.9rem;
            }

            .info-card {
                padding: 16px;
            }

            .info-label {
                font-size: 0.8rem;
            }

            .info-label .icon {
                font-size: 1.1rem;
            }

            .info-value {
                font-size: 0.9rem;
                padding: 8px 10px;
            }

            .section-header {
                margin: 30px 0 18px 0;
                padding-bottom: 10px;
            }

            .section-header h2 {
                font-size: 1.15rem;
            }

            .section-header .icon {
                font-size: 1.3rem;
            }

            .status-badge {
                padding: 7px 16px;
                font-size: 0.8rem;
            }

            .edit-section {
                padding: 25px 18px;
                border-radius: 16px;
            }

            .edit-section h2 {
                font-size: 1.25rem;
                margin-bottom: 20px;
            }

            input[type="file"] {
                padding: 12px;
                font-size: 0.85rem;
            }

            small {
                font-size: 0.8rem;
            }

            .btn {
                padding: 12px 24px;
                font-size: 0.9rem;
            }

            .btn-logout {
                margin-top: 25px;
            }

            .back-link {
                margin-top: 25px;
            }

            .back-link a {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .alert {
                padding: 14px 16px;
                font-size: 0.9rem;
            }

            .alert:before {
                font-size: 1.3rem;
            }

            .empty-state {
                padding: 40px 15px;
            }

            .empty-state .icon {
                font-size: 2.5rem;
            }

            .empty-state p {
                font-size: 0.95rem;
            }
        }

        /* Mobile Extra Small */
        @media (max-width: 360px) {
            .container {
                padding: 25px 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .avatar-img {
                width: 90px;
                height: 90px;
            }

            .profile-grid {
                gap: 12px;
            }

            .info-card {
                padding: 14px;
            }
        }

        /* Small text */
        small {
            color: #9ca3af;
            font-size: 0.85rem;
            display: block;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container">
        <h1> Profil Pengguna</h1>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif

        <!-- Avatar Section -->
        <div class="avatar-section">
            <div class="avatar-wrapper">
                @if($user->avatar)
                    @if(strpos($user->avatar, 'http') === 0)
                        <img id="avatar-preview" class="avatar-img" src="{{ $user->avatar }}" alt="Avatar">
                    @else
                        <img id="avatar-preview" class="avatar-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                    @endif
                @else
                    <img id="avatar-preview" class="avatar-img" src="https://via.placeholder.com/150?text=No+Avatar" alt="No Avatar">
                @endif
                <div class="avatar-badge">✓</div>
            </div>
            <div>
                <button type="button" id="edit-avatar-btn" class="edit-avatar-btn">
                    📸 Ubah Foto Profil
                </button>
            </div>
        </div>

        <!-- Profile Content -->
        <div id="profile-content">
            <!-- Basic Info -->
            <div class="profile-grid">
                <div class="info-card">
                    <div class="info-label">
                        Nama
                    </div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>

                <div class="info-card">
                    <div class="info-label">
                        Email
                    </div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>

                <div class="info-card">
                    <div class="info-label">
                        Bergabung Sejak
                    </div>
                    <div class="info-value">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <!-- PKL Registration Section -->
            <div class="section-header">
                <h2>Informasi Pendaftaran PKL</h2>
            </div>

            @php
                $pendaftaran = \App\Models\Pendaftaran::where('email', $user->email)->first();
            @endphp

            @if($pendaftaran)
                <div class="profile-grid">
                    <div class="info-card" style="grid-column: 1 / -1;">
                        <div class="info-label">
                            Status Pendaftaran
                        </div>
                        <div style="margin-top: 10px;">
                            @if($pendaftaran->status == 'approved')
                                <span class="status-badge status-approved">✓ Disetujui</span>
                            @elseif($pendaftaran->status == 'rejected')
                                <span class="status-badge status-rejected">✗ Ditolak</span>
                            @else
                                <span class="status-badge status-pending">⏳ Menunggu</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            Nama Lengkap
                        </div>
                        <div class="info-value">{{ $pendaftaran->nama_lengkap }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            Asal Universitas/Sekolah
                        </div>
                        <div class="info-value">{{ $pendaftaran->asal_sekolah }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            Jurusan
                        </div>
                        <div class="info-value">{{ $pendaftaran->jurusan }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            Tanggal Mulai PKL
                        </div>
                        <div class="info-value">{{ $pendaftaran->tanggal_mulai_pkl }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            Tanggal Selesai PKL
                        </div>
                        <div class="info-value">{{ $pendaftaran->tanggal_selesai_pkl }}</div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <p style="font-size: 1.1rem; font-weight: 500;">Belum ada pendaftaran PKL</p>
                    <p style="margin-top: 10px;">Silakan daftar untuk memulai PKL Anda</p>
                </div>
            @endif
        </div>

        <!-- Edit Avatar Section (Hidden by default) -->
        <div id="edit-avatar-section" style="display: none;">
            <div class="edit-section">
                <h2> Ubah Foto Profil</h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="file-input-wrapper">
                        <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)" required>
                        <small>Maksimal 2MB, format: JPG, PNG, GIF</small>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-save">
                             Simpan Perubahan
                        </button>
                        <button type="button" id="cancel-edit-btn" class="btn btn-cancel">
                            ✕ Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-logout">
                 Logout
            </button>
        </form>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('home') }}">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('edit-avatar-btn').addEventListener('click', function() {
            document.getElementById('profile-content').style.display = 'none';
            document.getElementById('edit-avatar-section').style.display = 'block';
            
            // Smooth scroll to edit section
            document.getElementById('edit-avatar-section').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        });

        document.getElementById('cancel-edit-btn').addEventListener('click', function() {
            document.getElementById('edit-avatar-section').style.display = 'none';
            document.getElementById('profile-content').style.display = 'block';
            
            // Reset form
            document.getElementById('avatar').value = '';
            
            // Reset preview to original avatar
            @if($user->avatar)
                @if(strpos($user->avatar, 'http') === 0)
                    document.getElementById('avatar-preview').src = '{{ $user->avatar }}';
                @else
                    document.getElementById('avatar-preview').src = '{{ asset('storage/' . $user->avatar) }}';
                @endif
            @else
                document.getElementById('avatar-preview').src = 'https://via.placeholder.com/150?text=No+Avatar';
            @endif

            // Smooth scroll back to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Add hover effects to info cards
        const infoCards = document.querySelectorAll('.info-card');
        infoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>