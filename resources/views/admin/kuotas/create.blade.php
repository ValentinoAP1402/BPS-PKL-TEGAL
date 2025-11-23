<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kuota PKL Baru</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
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
        
        /* Header Section */
        .header-section {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
        }
        
        h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 8px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-top: 8px;
        }
        
        /* Form Container */
        .form-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-left: 4px solid #3b82f6;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 32px;
            display: flex;
            align-items: start;
            gap: 12px;
            animation: slideIn 0.5s ease-out;
            border: 1px solid #93c5fd;
        }
        
        .info-box-icon {
            font-size: 1.5em;
            flex-shrink: 0;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .info-box-content {
            flex: 1;
        }
        
        .info-box-title {
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 6px;
            font-size: 0.95rem;
        }
        
        .info-box-text {
            color: #1e40af;
            font-size: 0.9rem;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        /* Form Group */
        .form-group {
            margin-bottom: 28px;
        }
        
        label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #1e293b;
            font-family: inherit;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: #ffffff;
            transform: translateY(-1px);
        }
        
        input[type="text"]::placeholder,
        input[type="number"]::placeholder {
            color: #94a3b8;
        }
        
        .input-hint {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .input-hint::before {
            content: 'ℹ';
            color: #3b82f6;
            font-size: 1.1em;
        }
        
        /* Error Messages */
        .error {
            color: #dc2626;
            font-size: 0.9em;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: slideIn 0.3s ease-out;
            background: #fef2f2;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #fca5a5;
        }
        
        .error::before {
            content: '⚠';
            font-size: 1.1em;
            color: #ef4444;
        }
        
        input.has-error {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        input.has-error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }
        
        /* Button Group */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            flex-wrap: wrap;
        }
        
        button,
        .btn-cancel {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        button::before,
        .btn-cancel::before {
            font-size: 1.1em;
        }
        
        button::after,
        .btn-cancel::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        button:hover::after,
        .btn-cancel:hover::after {
            width: 300px;
            height: 300px;
        }
        
        button[type="submit"] {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            flex: 1;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        button[type="submit"]::before {
            content: '✓';
        }
        
        .btn-cancel {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            flex: 1;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
        }
        
        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }
        
        .btn-cancel::before {
            content: '✕';
        }
        
        /* Success Alert (for after submit) */
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
            animation: progressBar 3s ease-out;
        }
        
        .alert-icon {
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
        
        .alert-content {
            flex: 1;
        }
        
        .alert-title {
            font-weight: 700;
            font-size: 1.05em;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .alert-message {
            opacity: 0.9;
            line-height: 1.5;
        }
        
        /* Input Icons */
        .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2em;
            opacity: 0.5;
            pointer-events: none;
        }
        
        input:focus ~ .input-icon {
            opacity: 0.8;
            color: #3b82f6;
        }
        
        /* Animations */
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
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .navbar { padding: 16px 20px; }
            .header-section { padding: 24px; }
            .form-container { padding: 28px 24px; }
            h1 { 
                font-size: 1.6rem;
                flex-direction: column;
            }
            .button-group { flex-direction: column; }
            button, .btn-cancel { width: 100%; }
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.4rem; }
            .form-container { padding: 24px 20px; }
            .back-link { padding: 8px 16px; font-size: 0.9em; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">Admin Dashboard</span>
            <a href="{{ route('admin.kuotas.index') }}" class="back-link">Kembali</a>
        </div>
    </div>
    
    <div class="container">
        <div class="header-section">
            <h1>➕ Tambah Kuota PKL Baru</h1>
            <p class="subtitle">Atur kuota pendaftaran untuk periode tertentu</p>
        </div>
        
        {{-- Alert Success jika ada --}}
        @if(session('success'))
            <div class="alert-success">
                <div class="alert-icon">✓</div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
            </div>
        @endif
        
        <div class="form-container">
            <div class="info-box">
                <div class="info-box-icon">💡</div>
                <div class="info-box-content">
                    <div class="info-box-title">Panduan Pengisian</div>
                    <div class="info-box-text">
                        Masukkan nama bulan dan tahun (contoh: Januari 2024) serta jumlah kuota yang tersedia untuk periode tersebut.
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.kuotas.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="bulan">
                        📅 Bulan dan Tahun
                    </label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="bulan" 
                            name="bulan" 
                            value="{{ old('bulan') }}" 
                            placeholder="Contoh: Januari 2024"
                            class="@error('bulan') has-error @enderror"
                            required
                        >
                        <span class="input-hint">Format: [Nama Bulan] [Tahun]</span>
                    </div>
                    @error('bulan') 
                        <div class="error">{{ $message }}</div> 
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="jumlah_kuota">
                        🎯 Jumlah Kuota
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="number"
                            id="jumlah_kuota"
                            name="jumlah_kuota"
                            value="{{ old('jumlah_kuota') }}"
                            placeholder="Masukkan jumlah kuota"
                            min="1"
                            class="@error('jumlah_kuota') has-error @enderror"
                            required
                        >
                        <span class="input-hint">Minimal 1, maksimal tidak terbatas</span>
                    </div>
                    @error('jumlah_kuota') 
                        <div class="error">{{ $message }}</div> 
                    @enderror
                </div>
                
                <div class="button-group">
                    <button type="submit">
                        Simpan Kuota
                    </button>
                    <a href="{{ route('admin.kuotas.index') }}" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>