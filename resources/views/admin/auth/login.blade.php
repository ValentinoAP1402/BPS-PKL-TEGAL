<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
            overflow: auto;
        }

        /* Animated Background Shapes */
        .bg-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: float-shapes 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes float-shapes {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(80px, -80px) scale(1.1); }
            66% { transform: translate(-80px, 80px) scale(0.9); }
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: #667eea;
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 350px;
            height: 350px;
            background: #764ba2;
            bottom: -100px;
            right: -100px;
            animation-delay: 7s;
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px 45px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
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


        @keyframes fadeIn {
            to { opacity: 1; }
        }



        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Header */
        h1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: 800;
            animation: fadeIn 0.8s ease 0.5s forwards;
            opacity: 0;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 35px;
            font-size: 0.95rem;
            line-height: 1.5;
            animation: fadeIn 0.8s ease 0.6s forwards;
            opacity: 0;
        }

        /* Form Styles */
        form {
            animation: fadeIn 0.8s ease 0.7s forwards;
            opacity: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        input.error:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        /* Toggle Password Button */
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.3rem;
            transition: all 0.3s ease;
            user-select: none;
        }

        .toggle-password:hover {
            transform: translateY(-50%) scale(1.1);
        }

        /* Error text inline */
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
            animation: slideInError 0.3s ease forwards;
        }

        @keyframes slideInError {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Messages */
        .error-message,
        .success-message {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            animation: slideInMessage 0.4s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideInMessage {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .error-message {
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            color: #c53030;
            border: 2px solid #fc8181;
        }

        .error-message::before {
            content: '⚠️';
            font-size: 1.2rem;
        }

        .success-message {
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            color: #276749;
            border: 2px solid #68d391;
        }

        .success-message::before {
            content: '✓';
            font-size: 1.2rem;
        }

        /* Submit Button */
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
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn::before {
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

        .btn:hover::before {
            left: 0;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Links */
        .links {
            text-align: center;
            margin-top: 28px;
            animation: fadeIn 0.8s ease 0.9s forwards;
            opacity: 0;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .links a:hover {
            color: #5a67d8;
            transform: translateY(-2px);
        }

        /* Heart Decorations */
        .heart {
            position: absolute;
            font-size: 1.2rem;
            opacity: 0.2;
            animation: heartFloat 3s ease-in-out infinite;
        }

        @keyframes heartFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-15px) scale(1.1); }
        }

        .heart-1 { top: 30px; left: 35px; animation-delay: 0s; }
        .heart-2 { top: 70px; right: 40px; animation-delay: 1s; }
        .heart-3 { bottom: 90px; left: 45px; animation-delay: 2s; }
        .heart-4 { bottom: 50px; right: 35px; animation-delay: 1.5s; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                padding: 40px 35px;
                max-width: 420px;
            }

            h1 {
                font-size: 1.85rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
            }

            .login-container {
                padding: 35px 28px;
                border-radius: 25px;
            }

            h1 {
                font-size: 1.7rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            input[type="text"],
            input[type="password"] {
                padding: 12px 16px;
                font-size: 0.95rem;
            }

            .btn {
                padding: 14px;
                font-size: 1rem;
            }

            .heart {
                display: none;
            }
        }

        @media (max-width: 375px) {
            .login-container {
                padding: 30px 24px;
            }
        }

        /* Responsive for larger screens like 1300px width */
        @media (min-width: 1300px) {
            .login-container {
                max-width: 500px;
                padding: 60px 50px;
            }

            h1 {
                font-size: 2.2rem;
                margin-bottom: 15px;
            }

            .subtitle {
                font-size: 1rem;
                margin-bottom: 40px;
            }

            input[type="text"],
            input[type="password"] {
                padding: 16px 20px;
                font-size: 1.05rem;
            }

            .btn {
                padding: 18px;
                font-size: 1.1rem;
            }

            .bg-shape.shape-1 {
                width: 500px;
                height: 500px;
            }

            .bg-shape.shape-2 {
                width: 450px;
                height: 450px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <div class="login-container">
        <!-- Login Content -->
        <h1>Admin Login</h1>
        <p class="subtitle">Masuk ke dashboard admin untuk mengelola sistem PKL</p>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" id="login-form">
            @csrf

            <div class="form-group">
                <label for="username">👤 Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">🔒 Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                    <span class="toggle-password" id="toggle-password">👁️</span>
                </div>
                <div id="password-error" class="error-text" style="display: none;">
                    ⚠️ Password minimal harus 8 karakter!
                </div>
            </div>

            <button type="submit" class="btn"> Masuk ke Dashboard</button>
        </form>

        <div class="links">
            <a href="{{ route('admin.register') }}"> Belum punya akun? Daftar di sini</a>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const leftEye = document.getElementById('left-eye');
        const rightEye = document.getElementById('right-eye');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });


        passwordInput.addEventListener('blur', function() {
            if (this.value.length === 0) {
                leftEye.classList.remove('closed');
                rightEye.classList.remove('closed');
            }
        });

        passwordInput.addEventListener('input', function() {
            const errorDiv = document.getElementById('password-error');
            
            if (this.value.length > 0) {
                leftEye.classList.add('closed');
                rightEye.classList.add('closed');
            } else {
                leftEye.classList.remove('closed');
                rightEye.classList.remove('closed');
            }

            // Show/hide error inline
            if (this.value.length > 0 && this.value.length < 8) {
                errorDiv.style.display = 'flex';
                this.classList.add('error');
            } else {
                errorDiv.style.display = 'none';
                this.classList.remove('error');
            }
        });


        // Form validation for password length
        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', function(e) {
            const passwordValue = passwordInput.value;
            const errorDiv = document.getElementById('password-error');
            
            if (passwordValue.length < 8) {
                e.preventDefault();
                
                // Show error
                errorDiv.style.display = 'flex';
                passwordInput.classList.add('error');
                passwordInput.focus();
            }
        });

        // Add ripple effect on button click
        const button = document.querySelector('.btn');
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.width = ripple.style.height = '100px';
            ripple.style.left = e.clientX - this.offsetLeft - 50 + 'px';
            ripple.style.top = e.clientY - this.offsetTop - 50 + 'px';
            ripple.style.animation = 'ripple 0.6s ease-out';
            ripple.style.pointerEvents = 'none';

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                from {
                    transform: scale(0);
                    opacity: 1;
                }
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>