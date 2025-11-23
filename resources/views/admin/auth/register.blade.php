<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
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
            overflow: hidden;
        }

        /* Untuk resolusi 1300x780 dan lebih kecil, aktifkan scroll */
        @media (max-height: 780px) {
            body {
                overflow-y: auto;
                overflow-x: hidden;
                align-items: flex-start;
                padding: 30px 20px;
            }
        }

        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .register-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25), 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.6s ease-out;
        }

        /* Untuk resolusi 1300x780, kurangi padding dan spacing */
        @media (max-height: 780px) {
            .register-container {
                padding: 30px 35px;
                margin: 0 auto;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 2rem;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            animation: bounce 2s ease-in-out infinite;
        }

        @media (max-height: 780px) {
            .header-icon {
                width: 55px;
                height: 55px;
                font-size: 1.7rem;
                margin: 0 auto 16px;
            }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        h1 {
            color: #1a202c;
            text-align: center;
            margin-bottom: 8px;
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-height: 780px) {
            h1 {
                font-size: 1.8rem;
                margin-bottom: 6px;
            }
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 36px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        @media (max-height: 780px) {
            .subtitle {
                margin-bottom: 24px;
                font-size: 0.88rem;
            }
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        @media (max-height: 780px) {
            .form-group {
                margin-bottom: 16px;
            }
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #334155;
            font-weight: 600;
            font-size: 0.92rem;
        }

        @media (max-height: 780px) {
            label {
                margin-bottom: 7px;
                font-size: 0.88rem;
            }
        }

        .input-wrapper {
            position: relative;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #1e293b;
        }

        @media (max-height: 780px) {
            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 11px 14px;
                font-size: 0.95rem;
            }
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
            transform: translateY(-1px);
        }

        input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        input.error:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.3rem;
            transition: transform 0.2s ease;
            user-select: none;
        }

        .toggle-password:hover {
            transform: translateY(-50%) scale(1.1);
        }

        .error-text {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-5px);
            animation: slideIn 0.3s ease forwards;
        }

        @media (max-height: 780px) {
            .error-text {
                font-size: 0.8rem;
                margin-top: 4px;
            }
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .password-strength {
            margin-top: 8px;
            font-size: 0.85rem;
        }

        @media (max-height: 780px) {
            .password-strength {
                margin-top: 6px;
                font-size: 0.8rem;
            }
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e2e8f0;
            margin-top: 6px;
            overflow: hidden;
        }

        @media (max-height: 780px) {
            .strength-bar {
                margin-top: 4px;
                height: 3px;
            }
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak .strength-fill {
            width: 33%;
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .strength-medium .strength-fill {
            width: 66%;
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .strength-strong .strength-fill {
            width: 100%;
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .strength-text {
            font-size: 0.8rem;
            margin-top: 4px;
            font-weight: 600;
        }

        @media (max-height: 780px) {
            .strength-text {
                font-size: 0.75rem;
                margin-top: 3px;
            }
        }

        .strength-weak .strength-text {
            color: #ef4444;
        }

        .strength-medium .strength-text {
            color: #f59e0b;
        }

        .strength-strong .strength-text {
            color: #10b981;
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            margin-bottom: 16px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            letter-spacing: 0.5px;
        }

        @media (max-height: 780px) {
            .btn {
                padding: 13px;
                font-size: 1rem;
                margin-top: 6px;
                margin-bottom: 12px;
            }
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border: 1px solid #fca5a5;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
            animation: shake 0.5s ease;
        }

        @media (max-height: 780px) {
            .error-message {
                padding: 11px 13px;
                margin-bottom: 16px;
                font-size: 0.85rem;
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .success-message {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border: 1px solid #6ee7b7;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
        }

        @media (max-height: 780px) {
            .success-message {
                padding: 11px 13px;
                margin-bottom: 16px;
                font-size: 0.85rem;
            }
        }

        .links {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-height: 780px) {
            .links {
                margin-top: 20px;
                padding-top: 18px;
            }
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        @media (max-height: 780px) {
            .links a {
                font-size: 0.88rem;
            }
        }

        .links a:hover {
            color: #5a67d8;
            transform: translateX(2px);
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 36px 28px;
                margin: 20px;
            }

            h1 {
                font-size: 1.9rem;
            }

            .header-icon {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register Admin</h1>
        <p class="subtitle">Buat akun admin baru untuk mengakses dashboard</p>

        <div class="error-message" style="display: none;" id="error-container">
            <!-- Error messages will be displayed here -->
        </div>

        <form method="POST" action="#" id="register-form">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Pilih username unik">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="alamat@email.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter">
                    <span class="toggle-password" id="toggle-password">👁️</span>
                </div>
                <div id="password-error" class="error-text" style="display: none;">
                    ⚠️ Password minimal harus 8 karakter!
                </div>
                <div id="password-strength" class="password-strength" style="display: none;">
                    <div class="strength-bar">
                        <div class="strength-fill"></div>
                    </div>
                    <div class="strength-text"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                    <span class="toggle-password" id="toggle-password-confirmation">👁️</span>
                </div>
                <div id="password-match-error" class="error-text" style="display: none;">
                    ⚠️ Password tidak cocok!
                </div>
            </div>

            <button type="submit" class="btn">DAFTAR SEKARANG</button>
        </form>

        <div class="links">
            <a href="{{ route('admin.login') }}">← Sudah punya akun? Masuk di sini</a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthIndicator = document.getElementById('password-strength');
        const strengthBar = strengthIndicator.querySelector('.strength-fill');
        const strengthText = strengthIndicator.querySelector('.strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const errorDiv = document.getElementById('password-error');

            if (password.length === 0) {
                strengthIndicator.style.display = 'none';
                errorDiv.style.display = 'none';
                this.classList.remove('error');
                return;
            }

            strengthIndicator.style.display = 'block';
            
            // Check password strength
            let strength = 'weak';
            if (password.length >= 8) {
                if (password.length >= 12 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    strength = 'strong';
                } else if (password.length >= 10 || (/[A-Z]/.test(password) && /[0-9]/.test(password))) {
                    strength = 'medium';
                }
            }

            // Update UI
            strengthIndicator.className = 'password-strength strength-' + strength;
            
            if (strength === 'weak') {
                strengthText.textContent = 'Password Lemah';
            } else if (strength === 'medium') {
                strengthText.textContent = 'Password Sedang';
            } else {
                strengthText.textContent = 'Password Kuat';
            }

            // Show/hide error
            if (password.length < 8) {
                errorDiv.style.display = 'flex';
                this.classList.add('error');
            } else {
                errorDiv.style.display = 'none';
                this.classList.remove('error');
            }
        });

        // Password confirmation match
        const passwordConfirmation = document.getElementById('password_confirmation');
        const matchError = document.getElementById('password-match-error');

        passwordConfirmation.addEventListener('input', function() {
            if (this.value.length === 0) {
                matchError.style.display = 'none';
                this.classList.remove('error');
                return;
            }

            if (this.value !== passwordInput.value) {
                matchError.style.display = 'flex';
                this.classList.add('error');
            } else {
                matchError.style.display = 'none';
                this.classList.remove('error');
            }
        });

        // Form validation
        const registerForm = document.getElementById('register-form');
        registerForm.addEventListener('submit', function(e) {
            const passwordValue = passwordInput.value;
            const confirmValue = passwordConfirmation.value;
            
            let hasError = false;

            // Check password length
            if (passwordValue.length < 8) {
                e.preventDefault();
                document.getElementById('password-error').style.display = 'flex';
                passwordInput.classList.add('error');
                passwordInput.focus();
                hasError = true;
            }

            // Check password match
            if (passwordValue !== confirmValue) {
                e.preventDefault();
                matchError.style.display = 'flex';
                passwordConfirmation.classList.add('error');
                if (!hasError) {
                    passwordConfirmation.focus();
                }
                hasError = true;
            }

            if (hasError) {
                return false;
            }
        });

        // Add input animation
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                if (this.parentElement.classList.contains('input-wrapper')) {
                    this.parentElement.style.transform = 'scale(1.01)';
                }
            });
            input.addEventListener('blur', function() {
                if (this.parentElement.classList.contains('input-wrapper')) {
                    this.parentElement.style.transform = 'scale(1)';
                }
            });
        });
    </script>
</body>
</html>