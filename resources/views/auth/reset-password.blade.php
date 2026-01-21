@extends('layouts.app')

@section('title', 'Reset Password - PKL BPS')

@push('styles')
<style>
    /* --- Layout Adjustments --- */
    .reset-wrapper {
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
        width: 450px;
        max-width: 100%;
        min-height: 450px;
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
        width: 100%;
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
        margin-bottom: 10px;
        color: #1e293b;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 24px;
    }

    p {
        margin-bottom: 30px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
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

    .back-link {
        color: #64748b; font-size: 13px; text-decoration: none;
        margin: 15px 0; display: block;
    }
    .back-link:hover { color: #3b82f6; text-decoration: underline; }

    /* --- Mobile Responsive --- */
    @media (max-width: 768px) {
        .container-custom { width: 100%; min-height: 400px; box-shadow: none; background: transparent; }
        .orb { opacity: 0.2; }
        .form-container { padding: 30px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        h1 { font-size: 20px; }
    }
</style>
@endpush

@section('content')
<div class="reset-wrapper">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="container-custom">
        <div class="form-container">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <h1>Reset Password</h1>
                <p>Masukkan password baru Anda.</p>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative w-full mb-3 text-xs text-left">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative w-full mb-3 text-xs text-left">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="in-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="reset-pass" placeholder="Password Baru" required />
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reset-pass', this)"></i>
                </div>

                <div class="in-field">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password_confirmation" id="reset-conf-pass" placeholder="Konfirmasi Password Baru" required />
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePass('reset-conf-pass', this)"></i>
                </div>

                <button type="submit" class="btn-primary">Reset Password</button>

                <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
