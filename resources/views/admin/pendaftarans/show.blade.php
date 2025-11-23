<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran PKL</title>
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
        
        /* Modern Alert Styles dengan Animasi */
        .alert {
            padding: 18px 24px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-weight: 500;
            font-size: 0.95em;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            animation: slideInAlert 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 2px solid;
            position: relative;
            overflow: hidden;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            animation: progressBar 3s ease-out;
        }
        
        .alert-icon {
            font-size: 1.5em;
            flex-shrink: 0;
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
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
        
        /* Success Alert - Hijau Terang */
        .alert-success { 
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #065f46;
            border-color: #6ee7b7;
        }
        
        .alert-success::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }
        
        .alert-success .alert-icon {
            background: linear-gradient(135deg, #6ee7b7, #10b981);
            color: #ffffff;
        }
        
        /* Error Alert - Merah Terang */
        .alert-error { 
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #991b1b;
            border-color: #fca5a5;
        }
        
        .alert-error::before {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }
        
        .alert-error .alert-icon {
            background: linear-gradient(135deg, #fca5a5, #ef4444);
            color: #ffffff;
        }
        
        /* Warning Alert - Kuning/Orange Terang */
        .alert-warning { 
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            color: #92400e;
            border-color: #fcd34d;
        }
        
        .alert-warning::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        
        .alert-warning .alert-icon {
            background: linear-gradient(135deg, #fcd34d, #f59e0b);
            color: #ffffff;
        }
        
        /* Info Alert - Biru Terang */
        .alert-info { 
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1e40af;
            border-color: #93c5fd;
        }
        
        .alert-info::before {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
        }
        
        .alert-info .alert-icon {
            background: linear-gradient(135deg, #93c5fd, #3b82f6);
            color: #ffffff;
        }
        
        /* Detail Card */
        .detail-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .section-title {
            font-size: 1.3rem;
            color: #1e293b;
            margin-bottom: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .detail-item {
            display: flex;
            padding: 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .detail-item:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateX(4px);
        }
        
        .detail-label {
            font-weight: 600;
            color: #475569;
            min-width: 220px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .detail-value {
            color: #1e293b;
            flex: 1;
            word-break: break-word;
        }
        
        .detail-value strong {
            color: #0f172a;
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85em;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }
        
        .status-pending { 
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .status-pending::before {
            content: '⏱';
        }
        
        .status-approved { 
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .status-approved::before {
            content: '✓';
        }
        
        .status-rejected { 
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .status-rejected::before {
            content: '✕';
        }
        
        .status-completed { 
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        
        /* File Link */
        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }
        
        .file-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }
        
        .file-link::before {
            content: '📄';
        }

        /* Upload Surat Balasan Section */
        .upload-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 2px solid #7dd3fc;
            animation: fadeInUp 0.7s ease-out;
        }

        .upload-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .file-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-input {
            flex: 1;
            padding: 14px 16px;
            border: 2px dashed #93c5fd;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input:hover {
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .file-input-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: block;
        }

        .upload-btn {
            padding: 14px 28px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        .upload-btn::before {
            content: '📤';
        }

        .current-file {
            background: white;
            padding: 16px;
            border-radius: 12px;
            border: 2px solid #93c5fd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .current-file-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .file-icon {
            font-size: 2em;
        }

        .delete-btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9em;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .delete-btn::before {
            content: '🗑';
        }
        
        /* Action Section */
        .action-section {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .actions form {
            display: inline-block;
        }
        
        .actions button {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 0.95em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .actions button::before {
            font-size: 1.1em;
        }
        
        .actions button::after {
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
        
        .actions button:hover::after {
            width: 300px;
            height: 300px;
        }
        
        .approve {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        .approve::before {
            content: '✓';
        }
        
        .reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .reject::before {
            content: '✕';
        }
        
        .delete {
            background: linear-gradient(135deg, #64748b, #475569);
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
        }
        
        .delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }
        
        .delete::before {
            content: '🗑';
        }
        
        .status-message {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            padding: 16px 20px;
            border-radius: 12px;
            color: #1e40af;
            font-weight: 500;
            border: 1px solid #93c5fd;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
        
        .no-data-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.6;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            animation: fadeInModal 0.3s ease-out;
        }

        .modal-content {
            background: #ffffff;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 2px solid;
            animation: scaleInModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-header {
            padding: 24px 32px;
            background: linear-gradient(135deg, var(--modal-header-bg));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.15)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .modal-icon {
            font-size: 3rem;
            margin-bottom: 12px;
            display: block;
            animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .modal-body {
            padding: 32px;
            background: #ffffff;
        }

        .modal-message {
            font-size: 1rem;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }

        .modal-details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            border-left: 4px solid var(--modal-accent);
        }

        .modal-detail-item {
            display: flex;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .modal-detail-label {
            font-weight: 600;
            color: #64748b;
            min-width: 120px;
        }

        .modal-detail-value {
            color: #1e293b;
            flex: 1;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .modal-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .modal-btn::before {
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

        .modal-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .modal-btn-primary {
            background: linear-gradient(135deg, var(--modal-primary-bg));
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .modal-btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .modal-btn-danger {
            background: linear-gradient(135deg, var(--modal-danger-bg));
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Modal Themes */
        .modal-approve .modal-content {
            border-color: #3b82f6;
        }

        .modal-approve {
            --modal-header-bg: #3b82f6, #2563eb;
            --modal-accent: #3b82f6;
            --modal-primary-bg: #3b82f6, #2563eb;
        }

        .modal-reject .modal-content {
            border-color: #ef4444;
        }

        .modal-reject {
            --modal-header-bg: #ef4444, #dc2626;
            --modal-accent: #ef4444;
            --modal-danger-bg: #ef4444, #dc2626;
        }

        .modal-delete .modal-content {
            border-color: #ef4444;
        }

        .modal-delete {
            --modal-header-bg: #ef4444, #dc2626;
            --modal-accent: #ef4444;
            --modal-danger-bg: #ef4444, #dc2626;
        }

        .modal-delete-surat .modal-content {
            border-color: #f59e0b;
        }

        .modal-delete-surat {
            --modal-header-bg: #f59e0b, #d97706;
            --modal-accent: #f59e0b;
            --modal-danger-bg: #f59e0b, #d97706;
        }

        /* Animations */
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

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInModal {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .header-section { padding: 24px; }
            .detail-card { padding: 24px; }
            .action-section { padding: 24px; }
            .upload-section { padding: 24px; }
            h1 { font-size: 1.6rem; flex-direction: column; }
            
            .detail-item {
                flex-direction: column;
                gap: 8px;
            }
            
            .detail-label {
                min-width: auto;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .actions button {
                width: 100%;
                justify-content: center;
            }

            .file-input-wrapper {
                flex-direction: column;
            }

            .current-file {
                flex-direction: column;
                text-align: center;
            }
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.4rem; }
            .detail-card { padding: 20px; }
            .section-title { font-size: 1.1rem; }
            .back-link { padding: 8px 16px; font-size: 0.9em; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">Admin Dashboard</span>
            <a href="{{ route('admin.pendaftarans.index') }}" class="back-link">Kembali</a>
        </div>
    </div>
    
    <div class="container">
        <div class="header-section">
            <h1>📄 Detail Pendaftaran PKL</h1>
            <p class="subtitle">Informasi lengkap pendaftar dan aksi admin</p>
        </div>
        
        {{-- Alert Error dengan Design Modern --}}
        @if(session('error'))
            <div class="alert alert-error">
                <div class="alert-icon">✕</div>
                <div class="alert-content">
                    <div class="alert-title">Terjadi Kesalahan!</div>
                    <div class="alert-message">{{ session('error') }}</div>
                </div>
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <div class="alert-icon">⚠</div>
                <div class="alert-content">
                    <div class="alert-title">Perhatian!</div>
                    <div class="alert-message">{{ session('warning') }}</div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <div class="alert-icon">ℹ</div>
                <div class="alert-content">
                    <div class="alert-title">Informasi</div>
                    <div class="alert-message">{{ session('info') }}</div>
                </div>
            </div>
        @endif
        
        @if($pendaftaran)
            <div class="detail-card">
                <h2 class="section-title"> Informasi Pendaftar</h2>
                
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label"> ID Pendaftaran:</span>
                        <span class="detail-value">{{ $pendaftaran->id }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Nama Lengkap:</span>
                        <span class="detail-value"><strong>{{ $pendaftaran->nama_lengkap }}</strong></span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Asal Universitas/Sekolah:</span>
                        <span class="detail-value">{{ $pendaftaran->asal_sekolah }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Jurusan:</span>
                        <span class="detail-value">{{ $pendaftaran->jurusan }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Email:</span>
                        <span class="detail-value">{{ $pendaftaran->email }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Nomor HP:</span>
                        <span class="detail-value">{{ $pendaftaran->no_hp }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Tanggal Mulai PKL:</span>
                        <span class="detail-value">{{ $pendaftaran->tanggal_mulai_pkl }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Tanggal Selesai PKL:</span>
                        <span class="detail-value">{{ $pendaftaran->tanggal_selesai_pkl }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Status:</span>
                        <span class="detail-value">
                            <span class="status-badge status-{{ $pendaftaran->status }}">
                                {{ ucfirst($pendaftaran->status) }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Surat Keterangan PKL:</span>
                        <span class="detail-value">
                            @if($pendaftaran->surat_keterangan_pkl)
                                <a href="{{ Storage::url($pendaftaran->surat_keterangan_pkl) }}" target="_blank" class="file-link">
                                    Lihat File
                                </a>
                            @else
                                <span style="color: #94a3b8;">Tidak ada file</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Tanggal Daftar:</span>
                        <span class="detail-value">{{ $pendaftaran->created_at->format('d M Y H:i') }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label"> Terakhir Diperbarui:</span>
                        <span class="detail-value">{{ $pendaftaran->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Upload Surat Balasan Section --}}
            <div class="upload-section">
                <h2 class="section-title">📮 Upload Surat Balasan PKL</h2>
                
                @if($pendaftaran->surat_balasan_pkl)
                    <div class="current-file">
                        <div class="current-file-info">
                            <span class="file-icon">📄</span>
                            <div>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">Surat Balasan Tersedia</div>
                                <div style="font-size: 0.85em; color: #64748b;">File sudah diupload</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ Storage::url($pendaftaran->surat_balasan_pkl) }}" target="_blank" class="file-link" style="margin: 0;">
                                Lihat File
                            </a>
                            <form action="{{ route('admin.pendaftarans.deleteSuratBalasan', $pendaftaran->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ PERINGATAN: Hapus Surat Balasan PKL\n\n📌 Pendaftar: {{ $pendaftaran->nama_lengkap }}\n🏫 Sekolah: {{ $pendaftaran->asal_sekolah }}\n\n❌ Aksi ini akan:\n• Menghapus file surat balasan PKL\n• Data pendaftar tetap tersimpan\n• Tidak dapat dibatalkan\n\n💡 Anda dapat upload ulang file baru setelah dihapus.\n\nApakah Anda yakin ingin menghapus surat balasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Hapus</button>
                            </form>
                        </div>
                    </div>
                @else
                    <form action="{{ route('admin.pendaftarans.uploadSuratBalasan', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">  
                        @csrf
                        <div>
                            <label class="file-input-label">📎 Pilih File Surat Balasan (PDF, Max 2MB)</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="surat_balasan" accept=".pdf" required class="file-input">
                                <button type="submit" class="upload-btn">Upload</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            
            <div class="action-section">
                <h2 class="section-title"> Aksi Admin</h2>
                
                @if($pendaftaran->status === 'pending')
                    <div class="actions">
                        <button type="button" class="approve" onclick="showModal('approve', {{ $pendaftaran->id }}, '{{ addslashes($pendaftaran->nama_lengkap) }}', '{{ addslashes($pendaftaran->asal_sekolah) }}', '{{ $pendaftaran->status }}')">Approve</button>
                        <button type="button" class="reject" onclick="showModal('reject', {{ $pendaftaran->id }}, '{{ addslashes($pendaftaran->nama_lengkap) }}', '{{ addslashes($pendaftaran->asal_sekolah) }}', '{{ $pendaftaran->status }}')">Reject</button>
                        <button type="button" class="delete" onclick="showModal('delete', {{ $pendaftaran->id }}, '{{ addslashes($pendaftaran->nama_lengkap) }}', '{{ addslashes($pendaftaran->asal_sekolah) }}', '{{ $pendaftaran->status }}')">Hapus</button>
                    </div>
                    
                @elseif($pendaftaran->status === 'approved')
                    <div class="status-message">
                        ✓ Status: Disetujui. Admin dapat menandai selesai dari tabel utama.
                    </div>
                    <div class="actions">
                        <form action="{{ route('admin.pendaftarans.reject', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Reject Pendaftaran yang Sudah APPROVED\n\n📌 Pendaftar: {{ $pendaftaran->nama_lengkap }}\n🏫 Sekolah: {{ $pendaftaran->asal_sekolah }}\n📊 Status Saat Ini: APPROVED\n\n❌ Aksi ini akan:\n• Mengubah status dari APPROVED ke REJECTED\n• Mengembalikan kuota PKL\n• Membatalkan persetujuan yang sudah diberikan\n• Pendaftar akan menerima notifikasi penolakan\n\n💡 Pastikan Anda memiliki alasan yang jelas untuk membatalkan persetujuan ini.\n\nApakah Anda yakin ingin REJECT pendaftaran ini?')">
                            @csrf
                            <button type="submit" class="reject">Reject</button>
                        </form>
                        <form action="{{ route('admin.pendaftarans.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Hapus Pendaftaran PKL\n\n📌 Pendaftar: {{ $pendaftaran->nama_lengkap }}\n🏫 Sekolah: {{ $pendaftaran->asal_sekolah }}\n📊 Status: {{ ucfirst($pendaftaran->status) }}\n\n❌ Aksi ini akan:\n• Menghapus SEMUA data pendaftaran\n• Menghapus file yang diupload\n• Tidak dapat dibatalkan/dikembalikan\n\nApakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">Hapus</button>
                        </form>
                    </div>
                    
                @elseif($pendaftaran->status === 'rejected')
                    <div class="status-message" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #991b1b; border-color: #fca5a5;">
                        ✕ Status: Ditolak.
                    </div>
                    <div class="actions">
                        <form action="{{ route('admin.pendaftarans.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Hapus Pendaftaran PKL\n\n📌 Pendaftar: {{ $pendaftaran->nama_lengkap }}\n🏫 Sekolah: {{ $pendaftaran->asal_sekolah }}\n📊 Status: {{ ucfirst($pendaftaran->status) }}\n\n❌ Aksi ini akan:\n• Menghapus SEMUA data pendaftaran\n• Menghapus file yang diupload\n• Tidak dapat dibatalkan/dikembalikan\n\nApakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">Hapus</button>
                        </form>
                    </div>
                    
                @elseif($pendaftaran->status === 'completed')
                    <div class="status-message">
                         Status: Selesai PKL.
                    </div>
                    <div class="actions">
                        <form action="{{ route('admin.pendaftarans.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Hapus Pendaftaran PKL\n\n📌 Pendaftar: {{ $pendaftaran->nama_lengkap }}\n🏫 Sekolah: {{ $pendaftaran->asal_sekolah }}\n📊 Status: {{ ucfirst($pendaftaran->status) }}\n\n❌ Aksi ini akan:\n• Menghapus SEMUA data pendaftaran\n• Menghapus file yang diupload\n• Tidak dapat dibatalkan/dikembalikan\n\nApakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">Hapus</button>
                        </form>
                    </div>
                @endif
            </div>
            
        @else
            <div class="detail-card">
                <div class="no-data">
                    <div class="no-data-icon">🔭</div>
                    <div style="font-size: 1.1rem; font-weight: 500;">Data pendaftaran tidak ditemukan</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modals -->
    <!-- Approve Modal -->
    <div id="approveModal" class="modal modal-approve">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">✅</div>
                <h3 class="modal-title">Konfirmasi Persetujuan</h3>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Apakah Anda yakin ingin menyetujui pendaftaran PKL ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="approve-nama"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="approve-sekolah"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Status Saat Ini:</span>
                        <span class="modal-detail-value" id="approve-status"></span>
                    </div>
                </div>
                <div class="modal-message">
                    <strong>Konsekuensi:</strong><br>
                    • Status akan berubah menjadi APPROVED<br>
                    • Kuota PKL akan berkurang<br>
                    • Pendaftar akan menerima notifikasi persetujuan
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModal('approveModal')">Batal</button>
                    <form id="approveForm" action="" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="modal-btn modal-btn-primary">Setujui Pendaftaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal modal-reject">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">⚠️</div>
                <h3 class="modal-title">Konfirmasi Penolakan</h3>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Apakah Anda yakin ingin menolak pendaftaran PKL ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="reject-nama"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="reject-sekolah"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Status Saat Ini:</span>
                        <span class="modal-detail-value" id="reject-status"></span>
                    </div>
                </div>
                <div class="modal-message">
                    <strong>Konsekuensi:</strong><br>
                    • Status akan berubah menjadi REJECTED<br>
                    • Kuota PKL akan dikembalikan<br>
                    • Pendaftar akan menerima notifikasi penolakan
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModal('rejectModal')">Batal</button>
                    <form id="rejectForm" action="" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="modal-btn modal-btn-danger">Tolak Pendaftaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal modal-delete">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">🗑️</div>
                <h3 class="modal-title">Konfirmasi Penghapusan</h3>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Apakah Anda yakin ingin menghapus pendaftaran PKL ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="delete-nama"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="delete-sekolah"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Status:</span>
                        <span class="modal-detail-value" id="delete-status"></span>
                    </div>
                </div>
                <div class="modal-message">
                    <strong>Konsekuensi:</strong><br>
                    • Semua data pendaftaran akan dihapus permanen<br>
                    • File yang diupload akan dihapus<br>
                    • Data tidak dapat dikembalikan
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                    <form id="deleteForm" action="" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ PERINGATAN: Hapus Pendaftaran PKL\n\n📌 Pendaftar: ' + document.getElementById('delete-nama').textContent + '\n🏫 Sekolah: ' + document.getElementById('delete-sekolah').textContent + '\n📊 Status: ' + document.getElementById('delete-status').textContent + '\n\n❌ Aksi ini akan:\n• Menghapus SEMUA data pendaftaran\n• Menghapus file yang diupload\n• Tidak dapat dibatalkan/dikembalikan\n\nApakah Anda yakin ingin menghapus pendaftaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modal-btn modal-btn-danger">Hapus Pendaftaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Surat Modal -->
    <div id="deleteSuratModal" class="modal modal-delete-surat">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">📄</div>
                <h3 class="modal-title">Konfirmasi Hapus Surat Balasan</h3>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Apakah Anda yakin ingin menghapus surat balasan PKL ini?
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="delete-surat-nama"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="delete-surat-sekolah"></span>
                    </div>
                </div>
                <div class="modal-message">
                    <strong>Konsekuensi:</strong><br>
                    • File surat balasan PKL akan dihapus<br>
                    • Data pendaftar tetap tersimpan<br>
                    • Anda dapat upload ulang file baru
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModal('deleteSuratModal')">Batal</button>
                    <form id="deleteSuratForm" action="" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modal-btn modal-btn-danger">Hapus Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(type, id, nama, sekolah, status = '') {
            const modal = document.getElementById(type + 'Modal');
            if (!modal) return;

            // Set modal data
            if (type === 'approve') {
                document.getElementById('approve-nama').textContent = nama;
                document.getElementById('approve-sekolah').textContent = sekolah;
                document.getElementById('approve-status').textContent = status.toUpperCase();
                document.getElementById('approveForm').action = `/admin/pendaftarans/${id}/approve`;
            } else if (type === 'reject') {
                document.getElementById('reject-nama').textContent = nama;
                document.getElementById('reject-sekolah').textContent = sekolah;
                document.getElementById('reject-status').textContent = status.toUpperCase();
                document.getElementById('rejectForm').action = `/admin/pendaftarans/${id}/reject`;
            } else if (type === 'delete') {
                document.getElementById('delete-nama').textContent = nama;
                document.getElementById('delete-sekolah').textContent = sekolah;
                document.getElementById('delete-status').textContent = status.toUpperCase();
                document.getElementById('deleteForm').action = `/admin/pendaftarans/${id}`;
            } else if (type === 'deleteSurat') {
                document.getElementById('delete-surat-nama').textContent = nama;
                document.getElementById('delete-surat-sekolah').textContent = sekolah;
                document.getElementById('deleteSuratForm').action = `/admin/pendaftarans/${id}/delete-surat-balasan`;
            }

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    if (modal.style.display === 'block') {
                        modal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                });
            }
        });
    </script>
</body>
</html>
