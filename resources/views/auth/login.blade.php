@extends('layouts.app')

@section('title', 'Login & Register - PKL BPS')

@push('styles')
<style>
    /* --- Layout Adjustments --- */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 120px);
        padding: 40px 20px;
        position: relative;
        z-index: 10;
        overflow: hidden;
    }

    /* --- Orb Background Animation --- */
    .orb {
        position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.15; z-index: 0;
        animation: floatOrb 15s ease-in-out infinite;
        pointer-events: none;
    }
    .orb-1 { width: 500px; height: 500px; background: #3b82f6; top: -100px; left: -100px; }
    .orb-2 { width: 400px; height: 400px; background: #2563eb; bottom: -50px; right: -50px; animation-delay: 5s; }
    
    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(30px, 50px); }
    }

    /* --- Main Card Container --- */
    .container-custom {
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.08), 
                    0 10px 10px rgba(0,0,0,0.06);
        position: relative;
        overflow: hidden;
        width: 850px;
        max-width: 100%;
        min-height: 580px; /* Sedikit lebih tinggi untuk muat tombol Google */
        display: flex;
    }

    /* --- Form Styling --- */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 40px;
        width: 50%;
    }

    form {
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 30px;
        height: 100%;
        width: 100%;
        text-align: center;
    }

    h1 {
        font-weight: 800;
        margin-bottom: 20px;
        color: #1e293b;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* --- Divider --- */
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        width: 100%;
        margin: 20px 0 15px 0;
    }
    .divider::before, .divider::after {
        content: ''; flex: 1; border-bottom: 1px solid #e2e8f0;
    }
    .divider span {
        padding: 0 10px; font-size: 12px; color: #94a3b8; font-weight: 500;
    }

    /* --- INPUT BOX BARU --- */
    .in-field {
        position: relative;
        width: 100%;
        margin: 8px 0;
    }
    .in-field input {
        background-color: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 12px 15px 12px 45px;
        width: 100%;
        outline: none;
        font-size: 14px;
        color: #334155;
        transition: 0.3s;
        font-weight: 500;
    }
    .in-field i {
        position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; transition: 0.3s; font-size: 16px;
    }
    .in-field input:focus {
        background-color: #ffffff; border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .in-field input:focus ~ i { color: #3b82f6; }

    .toggle-password {
        position: absolute; right: 15px; left: auto !important; cursor: pointer; color: #94a3b8;
    }
    .toggle-password:hover { color: #3b82f6; }

    /* --- Buttons --- */
    button.btn-primary {
        border-radius: 50px; border: none; background-color: #3b82f6; color: #ffffff;
        font-size: 14px; font-weight: 700; padding: 12px 45px; letter-spacing: 1px;
        text-transform: uppercase; transition: transform 80ms ease-in, box-shadow 0.3s;
        cursor: pointer; margin-top: 15px; width: 100%;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    button.btn-primary:active { transform: scale(0.95); }
    button.btn-primary:hover { background-color: #2563eb; box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5); }

    /* Tombol Google di Bawah */
    .btn-google {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 10px; border-radius: 50px;
        border: 1px solid #e2e8f0; background: white;
        color: #475569; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: 0.3s; text-decoration: none;
    }
    .btn-google:hover {
        background-color: #f8fafc; border-color: #cbd5e1;
        transform: translateY(-2px);
    }
    .btn-google i { font-size: 16px; }

    button.ghost {
        background-color: transparent; border-color: #ffffff; color: #ffffff;
        border: 2px solid white; border-radius: 50px; padding: 10px 40px;
        font-weight: 600; text-transform: uppercase; margin-top: 20px;
        cursor: pointer; transition: 0.3s;
    }
    button.ghost:hover { background-color: rgba(255,255,255,0.2); }

    .forgot-link {
        color: #64748b; font-size: 13px; text-decoration: none;
        margin: 10px 0; display: block; align-self: flex-end;
    }
    .forgot-link:hover { color: #3b82f6; text-decoration: underline; }

    /* --- Animation Panels --- */
    .sign-in-container { left: 0; width: 50%; z-index: 2; }
    .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

    .container-custom.right-panel-active .sign-in-container { transform: translateX(100%); opacity: 0; z-index: 1; }
    .container-custom.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s; }

    @keyframes show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }

    /* --- Overlay (Dengan Gambar BPS) --- */
    .overlay-container {
        position: absolute; top: 0; left: 50%; width: 50%; height: 100%;
        overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100;
    }
    .container-custom.right-panel-active .overlay-container { transform: translateX(-100%); }

    .overlay {
        /* FOTO BPS DI SINI */
        background: linear-gradient(rgba(37, 99, 235, 0.85), rgba(59, 130, 246, 0.85)), 
                    url('{{ asset("image/bps.jpeg") }}'); 
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%;
        transform: translateX(0); transition: transform 0.6s ease-in-out;
    }
    .container-custom.right-panel-active .overlay { transform: translateX(50%); }

    .overlay-panel {
        position: absolute; display: flex; align-items: center; justify-content: center;
        flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%;
        transform: translateX(0); transition: transform 0.6s ease-in-out;
    }
    .overlay-left { transform: translateX(-20%); }
    .container-custom.right-panel-active .overlay-left { transform: translateX(0); }
    .overlay-right { right: 0; transform: translateX(0); }
    .container-custom.right-panel-active .overlay-right { transform: translateX(20%); }

    .overlay-panel h1 { color: white; margin-bottom: 0; }
    .overlay-panel p { margin: 20px 0 30px 0; font-size: 14px; font-weight: 300; line-height: 1.6; opacity: 0.95; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

    /* --- Mobile Responsive --- */
    .mobile-switch { display: none; margin-top: 15px; font-size: 14px; }
    .mobile-switch a { color: #3b82f6; font-weight: bold; cursor: pointer; text-decoration: none; }

    @media (max-width: 768px) {
        .container-custom { flex-direction: column; width: 100%; min-height: 650px; box-shadow: none; background: transparent; }
        .orb { opacity: 0.2; }
        .form-container { width: 100%; position: relative; height: auto; padding: 30px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: none; transform: none; opacity: 1; top: 0; }
        .sign-in-container, .sign-up-container { width: 100%; left: 0; z-index: 10; }
        .sign-up-container { display: none; }
        .container-custom.right-panel-active .sign-in-container { display: none; }
        .container-custom.right-panel-active .sign-up-container { display: flex; transform: none; animation: none; }
        .overlay-container { display: none; }
        .mobile-switch { display: block; }
        h1 { font-size: 24px; }
    }
</style>
@endpush

@section('content')

<div class="login-wrapper">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="container-custom" id="container">
        
        <div class="form-container sign-up-container">
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <h1>Buat Akun Baru</h1>
                <p class="text-xs text-gray-500 mb-4">Silakan isi data diri Anda untuk mendaftar.</p>
                
                <div class="in-field">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="Nama Lengkap" required />
                </div>
                
                <div class="in-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required />
                </div>
                
                <div class="in-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="reg-pass" placeholder="Password" required />
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reg-pass', this)"></i>
                </div>

                <div class="in-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password_confirmation" id="reg-conf-pass" placeholder="Konfirmasi Password" required />
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reg-conf-pass', this)"></i>
                </div>

                <button type="submit" class="btn-primary">Daftar Sekarang</button>
                
                <div class="mobile-switch">
                    Sudah punya akun? <a id="mobile-to-login">Masuk di sini</a>
                </div>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <h1>Selamat Datang</h1>
                
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative w-full mb-3 text-xs text-left">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative w-full mb-3 text-xs text-left">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="in-field">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="username" placeholder="Email / Username" required />
                </div>
                
                <div class="in-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="login-pass" placeholder="Password" required />
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePass('login-pass', this)"></i>
                </div>

                <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                
                <button type="submit" class="btn-primary">Masuk</button>

                <div class="divider">
                    <span>atau masuk dengan</span>
                </div>

                <a href="{{ route('auth.google') }}" class="btn-google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="width: 18px; height: 18px;">
                    Google Account
                </a>

                <div class="mobile-switch">
                    Belum punya akun? <a id="mobile-to-register">Daftar di sini</a>
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Selamat Datang Kembali!</h1>
                    <p>Login untuk melanjutkan proses pendaftaran magang Anda di BPS Kota Tegal.</p>
                    <button class="ghost" id="signIn">Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Halo, Calon Magang!</h1>
                    <p>Daftarkan diri Anda sekarang dan mulailah pengalaman kerja nyata bersama Badan Pusat Statistik.</p>
                    <button class="ghost" id="signUp">Daftar</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    
    const mobileToRegister = document.getElementById('mobile-to-register');
    const mobileToLogin = document.getElementById('mobile-to-login');

    if (signUpButton && signInButton) {
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    }

    if(mobileToRegister) {
        mobileToRegister.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });
    }
    if(mobileToLogin) {
        mobileToLogin.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    }

    function togglePass(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush