<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            background: linear-gradient(135deg, #fef3f4 0%, #fff7ed 50%, #f0f9ff 100%);
            font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: #1e293b;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(96, 165, 250, 0.03) 0%, transparent 50%);
            animation: backgroundShift 20s ease infinite;
            pointer-events: none;
        }

        @keyframes backgroundShift {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        
        /* Navbar */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e8ecf1;
            padding: 20px 48px;
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.4rem;
            color: #2563eb;
            letter-spacing: -0.02em;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4); }
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .logout-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
        }
        
        /* Container */
        .container { 
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 48px;
        }
        
        /* Welcome Section */
        .welcome-section {
            background: #ffffff;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        .welcome-content {
            position: relative;
            z-index: 1;
        }
        
        h1 { 
            color: #1e293b;
            font-size: 2rem;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        
        .subtitle {
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
            font-weight: 400;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: #ffffff;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .stat-card:nth-child(1) { animation-delay: 0.3s; }
        .stat-card:nth-child(2) { animation-delay: 0.4s; }
        .stat-card:nth-child(3) { animation-delay: 0.5s; }
        .stat-card:nth-child(4) { animation-delay: 0.6s; }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            border-color: #dbeafe;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover::after {
            left: 100%;
        }
        
        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: #eff6ff;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
            background: #dbeafe;
        }

        .stat-content {
            position: relative;
            z-index: 1;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1e293b;
            letter-spacing: -0.02em;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }
        
        /* Actions Section */
        .actions-section {
            background: #ffffff;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            padding: 32px;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.7s both;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .actions { 
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .action-card {
            background: #ffffff;
            border: 2px solid #e8ecf1;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #1e293b;
            display: block;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .action-card:hover::before {
            left: 100%;
        }
        
        .action-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            transition: width 0.3s ease;
        }
        
        .action-card:hover {
            transform: translateY(-4px);
            border-color: #dbeafe;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .action-card:hover::after {
            width: 100%;
        }

        .action-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .action-icon {
            width: 48px;
            height: 48px;
            background: #eff6ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            transform: scale(1.1);
            background: #dbeafe;
        }
        
        .action-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e293b;
            letter-spacing: -0.01em;
        }
        
        .action-desc {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.5;
        }

        .action-arrow {
            position: absolute;
            top: 24px;
            right: 24px;
            font-size: 1.3rem;
            color: #3b82f6;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .action-card:hover .action-arrow {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 32px;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
            animation: fadeIn 1s ease 1s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Super Admin Badge */
        .super-admin-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #000;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { box-shadow: 0 0 10px rgba(251, 191, 36, 0.5); }
            50% { box-shadow: 0 0 20px rgba(251, 191, 36, 0.8); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .actions { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .container { padding: 24px 20px; }
            .navbar { padding: 16px 20px; }
            h1 { font-size: 1.6rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .welcome-section, .actions-section { padding: 24px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span>Admin Dashboard</span>
            </div>
            <div class="navbar-actions">
                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <span style="position: relative; z-index: 1;">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-section">
            <div class="welcome-content">
                <h1> Selamat datang, {{ Auth::guard('admin')->user()->username }}!</h1>
                <p class="subtitle">Kelola dan pantau pendaftaran PKL dengan mudah melalui dashboard ini. Semua data dan informasi tersedia dalam satu tempat untuk membantu Anda membuat keputusan yang tepat.</p>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $total_pendaftar }}</div>
                    <div class="stat-label">Total Pendaftar</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $kuota_bulan_ini }}</div>
                    <div class="stat-label">Kuota Bulan Ini</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $total_kuota_tersedia }}</div>
                    <div class="stat-label">Total Kuota Tersedia</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $surat_mitra }}</div>
                    <div class="stat-label">Surat Tanda Tangan</div>
                </div>
            </div>
        </div>
        
        <div class="actions-section">
            <h2 class="section-title"> Menu Utama</h2>
            <div class="actions">
                <a href="{{ route('admin.pendaftarans.index') }}" class="action-card">
                    <span class="action-arrow">→</span>
                    <div class="action-header">
                         <div class="action-icon">
                            <img src="{{ asset('image/people.png') }}" alt="Icon PKL" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <div class="action-title">Data Pendaftar</div>
                    <p class="action-desc">Kelola semua data pendaftar PKL</p>
                </a>

                <a href="{{ route('admin.kuotas.index') }}" class="action-card">
                    <span class="action-arrow">→</span>
                    <div class="action-header">
                        <div class="action-icon">
                            <img src="{{ asset('image/date.png') }}" alt="Icon PKL" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <div class="action-title">Kuota Bulanan</div>
                    <p class="action-desc">Kelola kuota bulanan untuk pendaftaran PKL</p>
                </a>

                <a href="{{ route('admin.surat_mitra') }}" class="action-card">
                    <span class="action-arrow">→</span>
                    <div class="action-header">
                        <div class="action-icon">
                            <img src="{{ asset('image/letter.png') }}" alt="Icon PKL" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <div class="action-title">Surat Tanda Tangan</div>
                    <p class="action-desc">Kelola surat tanda tangan anak PKL</p>
                </a>

                <a href="{{ route('admin.alumni_pkl.index') }}" class="action-card">
                    <span class="action-arrow">→</span>
                    <div class="action-header">
                        <div class="action-icon">
                            <img src="{{ asset('image/photo.png') }}" alt="Icon PKL" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <div class="action-title">Foto-foto anak yang telah PKL</div>
                    <p class="action-desc">Kelola foto-foto yang sudah pernah PKL di BPS</p>
                </a>

                @if(Auth::guard('admin')->user()->isSuperAdmin())
                <a href="{{ route('admin.user_roles.index') }}" class="action-card">
                    <span class="action-arrow">→</span>
                    <span class="super-admin-badge" style="position: absolute; top: 20px; right: 20px;">Super Admin</span>
                    <div class="action-header">
                        <div class="action-icon">
                            <img src="{{ asset('image/user.png') }}" alt="Icon PKL" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <div class="action-title">Kelola Role Pengguna</div>
                    <p class="action-desc">Kelola peran dan akses pengguna dalam sistem dengan kontrol penuh</p>
                </a>
                @endif
            </div>
        </div>
        
        <p class="footer-note">💡 Dashboard ini dirancang khusus untuk mengelola kebutuhan PKL</p>
    </div>
</body>
</html>