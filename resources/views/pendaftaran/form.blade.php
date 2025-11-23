<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PKL</title>
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
            animation-delay: 0s;
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
            max-width: 700px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            padding: 50px 40px;
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

        /* Back Link */
        .back-link {
            text-align: center;
            margin-bottom: 30px;
        }

        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .back-link a:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateX(-5px);
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
            font-size: 2.2rem;
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

        /* Form Groups */
        .form-group {
            margin-bottom: 28px;
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.15s; }
        .form-group:nth-child(3) { animation-delay: 0.2s; }
        .form-group:nth-child(4) { animation-delay: 0.25s; }
        .form-group:nth-child(5) { animation-delay: 0.3s; }
        .form-group:nth-child(6) { animation-delay: 0.35s; }
        .form-group:nth-child(7) { animation-delay: 0.4s; }
        .form-group:nth-child(8) { animation-delay: 0.45s; }

        /* Labels */
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #374151;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        label .icon {
            font-size: 1.2rem;
        }

        /* Input Fields */
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            background: #f9fafb;
            transition: all 0.3s ease;
            color: #374151;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        input[readonly] {
            background: #f3f4f6;
            cursor: not-allowed;
            color: #6b7280;
        }

        /* File Input Custom Style */
        input[type="file"] {
            padding: 12px 18px;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        input[type="file"]::file-selector-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Note Text */
        .note {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 400;
            margin-left: 4px;
        }

        /* Error Messages */
        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: shake 0.4s ease;
        }

        .error:before {
            content: '⚠';
            font-size: 1rem;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Submit Button */
        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px 0;
            border-radius: 12px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            margin-top: 20px;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }

        button[type="submit"]:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        button[type="submit"]:hover:before {
            left: 0;
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        button[type="submit"]:active {
            transform: translateY(-1px);
        }

        /* Floating Labels Effect */
        .form-group {
            position: relative;
        }

        .floating-icon {
            position: absolute;
            right: 18px;
            top: 50px;
            color: #9ca3af;
            font-size: 1.2rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        input:focus ~ .floating-icon {
            color: #667eea;
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .container {
                padding: 35px 25px;
                border-radius: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .form-group {
                margin-bottom: 24px;
            }

            input[type="text"],
            input[type="email"],
            input[type="date"],
            input[type="file"] {
                padding: 12px 16px;
                font-size: 0.95rem;
            }

            button[type="submit"] {
                padding: 14px 0;
                font-size: 1rem;
            }

            .bg-shape {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .back-link a {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        /* Success Animation */
        @keyframes success {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Alert Modal Styles */
        .alert-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .alert-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .alert-content {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.8) translateY(-20px);
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .alert-modal.show .alert-content {
            transform: scale(1) translateY(0);
        }

        .alert-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .alert-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .alert-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .alert-message {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 25px;
            text-align: center;
        }

        .alert-errors {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .alert-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-errors li {
            color: #dc2626;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .alert-errors li:before {
            content: '❌';
            flex-shrink: 0;
            margin-top: -2px;
        }

        .alert-close {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .alert-close:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .alert-close:hover:before {
            left: 0;
        }

        .alert-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .alert-close:active {
            transform: translateY(0);
        }

        /* Shake animation for invalid fields */
        @keyframes fieldShake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .field-error {
            animation: fieldShake 0.5s ease;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
        }

        /* Grid Layout for Date Fields */
        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .date-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="container">
        <div class="back-link">
            <a href="{{ route('home') }}">
                ← Kembali ke Beranda
            </a>
        </div>

        <h1> Formulir Pendaftaran PKL</h1>

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            
            <div class="form-group">
                <label for="nama_lengkap">
                    Nama Lengkap
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap Anda" required>
                @error('nama_lengkap')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="asal_sekolah">
                    Asal Sekolah/Universitas
                </label>
                <input type="text" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Contoh: Universitas Indonesia" required>
                @error('asal_sekolah')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jurusan">
                    Jurusan
                </label>
                <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: Statistika" required>
                @error('jurusan')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            @if(Auth::check())
                <div class="form-group">
                    <label for="email">
                        Email (dari akun Google)
                    </label>
                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
                </div>
            @else
                <div class="form-group">
                    <label for="email">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="no_hp">
                    Nomor HP
                </label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                @error('no_hp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="date-grid">
                <div class="form-group">
                    <label for="tanggal_mulai_pkl">
                        Tanggal Mulai PKL
                    </label>
                    <input type="date" id="tanggal_mulai_pkl" name="tanggal_mulai_pkl" value="{{ old('tanggal_mulai_pkl') }}" required onchange="checkQuotaAvailability()" lang="id">
                    @error('tanggal_mulai_pkl')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div id="quota-info" class="quota-info" style="display: none; margin-top: 8px; padding: 8px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; font-size: 0.9rem;"></div>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai_pkl">
                        Tanggal Selesai PKL
                    </label>
                    <input type="date" id="tanggal_selesai_pkl" name="tanggal_selesai_pkl" value="{{ old('tanggal_selesai_pkl') }}" required lang="id">
                    @error('tanggal_selesai_pkl')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="surat_keterangan_pkl">
                    Upload Surat Keterangan PKL
                    <span class="note">(PDF, Max 2MB)</span>
                </label>
                <input type="file" id="surat_keterangan_pkl" name="surat_keterangan_pkl" accept=".pdf" required>
                @error('surat_keterangan_pkl')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">
                 Daftar PKL Sekarang
            </button>
        </form>
    </div>

    <!-- Alert Modal -->
    <div id="validationAlert" class="alert-modal">
        <div class="alert-content">
            <div class="alert-header">
                <span class="alert-icon">⚠️</span>
                <h2 class="alert-title">Form Belum Lengkap!</h2>
            </div>
            <p class="alert-message">Mohon lengkapi semua field yang wajib diisi sebelum mengirim formulir.</p>
            <div class="alert-errors">
                <ul id="errorList"></ul>
            </div>
            <button class="alert-close" onclick="closeAlert()">Tutup & Perbaiki</button>
        </div>
    </div>

    <script>
        // Add floating animation on input focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Form validation feedback
        const form = document.querySelector('form');

        // Prevent browser's default validation on all inputs
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default validation first

            // Check for empty required fields
            const requiredFields = form.querySelectorAll('input[required]');
            const emptyFields = [];
            let hasErrors = false;
            let firstEmptyField = null;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    emptyFields.push(getFieldLabel(field));
                    field.classList.add('field-error');
                    hasErrors = true;
                    if (!firstEmptyField) {
                        firstEmptyField = field;
                    }
                } else {
                    field.classList.remove('field-error');
                }
            });

            if (hasErrors) {
                showAlert(emptyFields);
                // Smooth scroll to first empty field with delay for better UX
                setTimeout(() => {
                    firstEmptyField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                    setTimeout(() => firstEmptyField.focus(), 300);
                }, 500);
                return false;
            }

            // If no errors, submit the form
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '⏳ Memproses...';
            submitBtn.style.background = 'linear-gradient(135deg, #9ca3af 0%, #6b7280 100%)';

            // Submit the form programmatically
            this.submit();
        });

        // Function to get field label
        function getFieldLabel(field) {
            const label = form.querySelector(`label[for="${field.id}"]`);
            if (label) {
                return label.textContent.replace(/[^\w\s]/g, '').trim();
            }
            return field.name;
        }

        // Function to show alert modal
        function showAlert(errors) {
            const alertModal = document.getElementById('validationAlert');
            const errorList = document.getElementById('errorList');

            // Clear previous errors
            errorList.innerHTML = '';

            // Add new errors
            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });

            // Show modal
            alertModal.classList.add('show');
        }

        // Function to close alert modal
        function closeAlert() {
            const alertModal = document.getElementById('validationAlert');
            alertModal.classList.remove('show');

            // Remove field error classes
            document.querySelectorAll('.field-error').forEach(field => {
                field.classList.remove('field-error');
            });
        }

        // File input preview
        const fileInput = document.getElementById('surat_keterangan_pkl');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                console.log(`File selected: ${fileName} (${fileSize} MB)`);
            }
        });

        // Check quota availability
        async function checkQuotaAvailability() {
            const startDateInput = document.getElementById('tanggal_mulai_pkl');
            const quotaInfo = document.getElementById('quota-info');

            if (!startDateInput.value) {
                quotaInfo.style.display = 'none';
                return;
            }

            try {
                const response = await fetch(`/api/check-quota?date=${startDateInput.value}`);
                const data = await response.json();

                if (data.available) {
                    quotaInfo.innerHTML = `✅ Kuota tersedia: ${data.available_slots} slot`;
                    quotaInfo.style.background = 'rgba(16, 185, 129, 0.1)';
                    quotaInfo.style.color = '#065f46';
                } else {
                    quotaInfo.innerHTML = `❌ Kuota penuh untuk periode ini`;
                    quotaInfo.style.background = 'rgba(239, 68, 68, 0.1)';
                    quotaInfo.style.color = '#991b1b';
                }
                quotaInfo.style.display = 'block';
            } catch (error) {
                console.error('Error checking quota:', error);
                quotaInfo.style.display = 'none';
            }
        }
    </script>
</body>
</html>