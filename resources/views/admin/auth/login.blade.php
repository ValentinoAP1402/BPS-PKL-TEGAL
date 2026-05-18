{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Masuk</title>
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
            overflow-y: auto;
        }

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

        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .header-logo {
            text-align: center;
            padding: 28px 20px 10px;
        }
        .header-logo img {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
        }
        .header-logo h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 800;
        }
        .header-logo p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .forms-wrapper {
            padding: 18px 30px 30px;
        }

        .input-group { margin-bottom: 16px; }

        .input-label {
            display: block;
            margin-bottom: 6px;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 600;
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

        /* ✅ supaya teks/password tidak masuk ke area tombol mata */
        .input-has-toggle {
            padding-right: 52px !important;
        }

        .error-msg {
            color: #ef4444;
            font-size: 0.82rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            line-height: 1.2;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.1s, box-shadow 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .btn-submit:active { transform: translateY(1px); }

        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.3;
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

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2px 0 16px;
            font-size: 0.88rem;
        }
        .remember-me {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }
        .checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Toggle Password Button */
        .toggle-pass-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-pass-btn:hover { color: #4f46e5; }
        .toggle-pass-btn svg { width: 18px; height: 18px; display: block; }

        @media (max-width: 420px) {
            .forms-wrapper { padding: 16px 18px 22px; }
        }
        /* =========================
        HIDE BROWSER DEFAULT EYE ICON
        (Chrome/Edge/IE)
        ========================= */

        /* Edge/IE legacy */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        /* Chromium (Chrome/Edge) autofill credentials button */
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
        }

        /* Kadang muncul juga dekorasi bawaan */
        input[type="password"]::-webkit-textfield-decoration-container {
            visibility: hidden;
        }
    </style>
</head>
<body>

    <div class="bg-shape" style="top: -100px; left: -100px; width: 500px; height: 500px; background: #6366f1;"></div>
    <div class="bg-shape" style="bottom: -100px; right: -100px; width: 400px; height: 400px; background: #ec4899; animation-delay: -5s;"></div>

    <div class="auth-container">

        <div class="header-logo">
            <img src="{{ asset('image/bps.png') }}" alt="Logo BPS">
            <h2>Admin Login</h2>
            <p>Masuk untuk mengelola data PKL</p>
        </div>

        <div class="forms-wrapper">

            @if(session('success'))
                <div class="alert alert-success">
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <div>Periksa kembali input Anda. Ada data yang belum sesuai.</div>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" autocomplete="off">
                @csrf

                <div class="input-group">
                    <label class="input-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="input-field @error('username') error @enderror"
                        placeholder="Masukkan username"
                        required
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="none"
                        spellcheck="false"
                        value=""
                    >
                    @error('username')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label">Password</label>
                    <div style="position: relative;">
                        <input
                            type="password"
                            id="login-pass"
                            name="password"
                            class="input-field input-has-toggle"
                            placeholder="Masukkan password"
                            required
                            autocomplete="new-password"
                            autocorrect="off"
                            autocapitalize="none"
                            spellcheck="false"
                        >

                        {{-- ✅ hanya 1 icon SVG (tidak mungkin dobel) --}}
                        <button
                            type="button"
                            class="toggle-pass-btn"
                            id="togglePassBtn"
                            aria-label="Tampilkan/Sembunyikan Password"
                        >
                            <svg id="toggleIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <!-- default: eye (ikon yang kanan bisa kamu anggap ini) -->
                                <path id="iconPath1" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
                                <circle id="iconCircle" cx="12" cy="12" r="3"></circle>
                                <!-- garis coret (hidden by default) -->
                                <path id="iconSlash" d="M3 3l18 18" style="display:none;"></path>
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" class="checkbox">
                        Ingat Saya
                    </label>
                </div>

                <button type="submit" class="btn-submit">Masuk Sekarang</button>
            </form>

        </div>
    </div>

    <script>
        (function () {
            const input = document.getElementById('login-pass');
            const btn = document.getElementById('togglePassBtn');

            const slash = document.getElementById('iconSlash');

            btn.addEventListener('click', function () {
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                // kalau sedang ditampilkan (type=text) -> tampilkan coretan (eye-off)
                // kalau disembunyikan (type=password) -> sembunyikan coretan (eye)
                slash.style.display = isHidden ? 'block' : 'none';
            });
        })();
    </script>
</body>
</html>