<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Masuk & Daftar</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-y: auto; /* Allow scroll on small screens */
        }

        /* Background Shapes Animation */
        .bg-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float-shapes 20s ease-in-out infinite;
            z-index: 0;
        }
        @keyframes float-shapes {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Container Card */
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            padding: 0; /* Padding handled inside */
            position: relative;
            z-index: 1;
            overflow: hidden;
            transition: height 0.3s ease;
        }

        /* Toggle Tabs (Header) */
        .toggle-container {
            display: flex;
            background: #f1f5f9;
            padding: 6px;
            margin: 20px 20px 10px;
            border-radius: 12px;
            position: relative;
        }

        .toggle-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            color: #64748b;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            border-radius: 8px;
            z-index: 2;
            transition: color 0.3s;
        }

        .toggle-btn.active {
            color: #4f46e5;
        }

        /* Moving Slider for Tabs */
        .slider {
            position: absolute;
            top: 6px;
            left: 6px;
            height: calc(100% - 12px);
            width: calc(50% - 6px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            z-index: 1;
        }

        /* Logo Area */
        .header-logo {
            text-align: center;
            padding-top: 20px;
        }
        .header-logo img {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
        }
        .header-logo h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .header-logo p {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Forms Wrapper */
        .forms-wrapper {
            position: relative;
            overflow: hidden;
            padding: 20px 30px 30px;
        }

        /* Form Styling */
        .auth-form {
            display: none; /* Hidden by default */
            animation: fadeIn 0.4s ease;
        }
        .auth-form.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            margin-bottom: 16px;
        }
        .input-label {
            display: block;
            margin-bottom: 6px;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .input-field {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
            outline: none;
            background: #f8fafc;
        }
        .input-field:focus {
            border-color: #6366f1;
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .input-field.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s, box-shadow 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Alert Box */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Checkbox & Links */
        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            cursor: pointer;
        }
        .checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>
</head>
<body>

    <div class="bg-shape" style="top: -100px; left: -100px; width: 500px; height: 500px; background: #6366f1;"></div>
    <div class="bg-shape" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: #ec4899; animation-delay: -5s;"></div>

    <div class="auth-container">
        
        <div class="header-logo">
            <img src="{{ asset('image/bps.png') }}" alt="Logo BPS">
            <h2 id="headerTitle">Admin Login</h2>
            <p id="headerDesc">Masuk untuk mengelola data PKL</p>
        </div>

        <div class="toggle-container">
            <div class="slider" id="slider"></div>
            <button type="button" class="toggle-btn active" id="tab-login" onclick="switchTab('login')">Masuk</button>
            <button type="button" class="toggle-btn" id="tab-register" onclick="switchTab('register')">Daftar</button>
        </div>

        <div class="forms-wrapper">
            
            {{-- ALERT MESSAGES (General) --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form id="form-login" action="{{ route('admin.login.post') }}" method="POST" class="auth-form active">
                @csrf
                <div class="input-group">
                    <label class="input-label">Username</label>
                    <input type="text" name="username" class="input-field @error('username') error @enderror" placeholder="Admin BPS" required value="{{ old('username') }}">
                    @error('username')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="login-pass" name="password" class="input-field @error('password') error @enderror" placeholder="••••••••" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('login-pass', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                    </div>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" class="checkbox"> Ingat Saya
                    </label>
                </div>

                <button type="submit" class="btn-submit">Masuk Sekarang</button>
            </form>

            <form id="form-register" action="{{ route('admin.register.post') }}" method="POST" class="auth-form">
                @csrf

                {{-- Nama --}}
                <div class="input-group">
                    <label class="input-label">Nama Lengkap</label>
                    <input type="text" name="name" class="input-field @error('name') error @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="input-group">
                    <label class="input-label">Username</label>
                    <input type="text" name="username" class="input-field @error('username') error @enderror" placeholder="adminbps" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="input-group">
                    <label class="input-label">Email Address</label>
                    <input type="email" name="email" class="input-field @error('email') error @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="register-pass" name="password" class="input-field @error('password') error @enderror" placeholder="Minimal 8 karakter" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('register-pass', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                    </div>
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="input-group">
                    <label class="input-label">Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input type="password" id="register-confirm-pass" name="password_confirmation" class="input-field @error('password_confirmation') error @enderror" placeholder="Ulangi password" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePass('register-confirm-pass', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b;"></i>
                    </div>
                    @error('password_confirmation')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Daftar Akun Baru</button>
            </form>

        </div>
    </div>

    <script>
        function switchTab(tab) {
            const slider = document.getElementById('slider');
            const btnLogin = document.getElementById('tab-login');
            const btnRegister = document.getElementById('tab-register');
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');

            const title = document.getElementById('headerTitle');
            const desc = document.getElementById('headerDesc');

            if(tab === 'login') {
                // UI Logic
                slider.style.transform = 'translateX(0)';
                btnLogin.classList.add('active');
                btnRegister.classList.remove('active');

                // Form Logic
                formLogin.classList.add('active');
                formRegister.classList.remove('active');

                // Text
                title.innerText = 'Admin Login';
                desc.innerText = 'Masuk untuk mengelola data PKL';
            } else {
                // UI Logic
                slider.style.transform = 'translateX(100%)'; // Move to right
                btnRegister.classList.add('active');
                btnLogin.classList.remove('active');

                // Form Logic
                formRegister.classList.add('active');
                formLogin.classList.remove('active');

                // Text
                title.innerText = 'Daftar Admin';
                desc.innerText = 'Buat akun baru untuk akses sistem';
            }
        }

        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-switch tab based on Errors (Laravel Validation)
        document.addEventListener("DOMContentLoaded", function() {
            // Jika ada error validasi di field register (seperti nama, admin_code, confirm password),
            // otomatis pindah ke tab Register supaya user tau salahnya dimana.
            @if($errors->has('name') || $errors->has('admin_code') || $errors->has('password_confirmation') || ($errors->has('email') && old('name')))
                switchTab('register');
            @endif
        });
    </script>
</body>
</html>