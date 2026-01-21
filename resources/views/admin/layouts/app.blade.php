<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        /* --- GLOBAL STYLES --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.04) 0%, transparent 50%),
                        radial-gradient(circle at 40% 20%, rgba(96, 165, 250, 0.03) 0%, transparent 50%);
            animation: backgroundShift 20s ease infinite; pointer-events: none; z-index: -1;
        }
        @keyframes backgroundShift {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }

        /* --- NAVBAR --- */
        .navbar {
            background: #ffffff; border-bottom: 1px solid #e8ecf1; padding: 20px 48px;
            position: sticky; top: 0; z-index: 1000;
            animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }
        @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .navbar-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1.4rem; color: #2563eb; letter-spacing: -0.02em; }
        .logo-icon {
            width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        /* --- CONTAINER & SECTIONS --- */
        .container { max-width: 1400px; margin: 0 auto; padding: 32px 48px; }
        .section-title { font-size: 1.8rem; color: #1e293b; margin-bottom: 24px; font-weight: 700; display: flex; align-items: center; gap: 12px; }
        .section-icon {
            width: 48px; height: 48px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }
        
        /* --- UTILITIES (Buttons, Alerts, Forms) --- */
        .btn, .logout-btn {
            color: white; border: none; padding: 14px 32px; border-radius: 12px;
            font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;
            position: relative; overflow: hidden;
        }
        .btn { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4); }
        
        .logout-btn { 
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 10px 24px; font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); 
        }
        .logout-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4); }

        .back-btn {
            display: inline-flex; align-items: center; gap: 8px; background: #f3f4f6; color: #374151;
            text-decoration: none; padding: 10px 20px; border-radius: 10px; font-weight: 500; transition: all 0.3s ease;
        }
        .back-btn:hover { background: #e5e7eb; transform: translateX(-2px); }

        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; animation: slideIn 0.5s ease-out; }
        .alert-success { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border: 1px solid #86efac; color: #166534; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

        /* --- DASHBOARD SPECIFIC --- */
        .welcome-section, .stat-card, .actions-section, .form-section, .preview-section {
            background: #ffffff; border: 1px solid #e8ecf1; border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        .welcome-section { padding: 32px; margin-bottom: 24px; position: relative; overflow: hidden; }
        .welcome-section::before {
            content: ''; position: absolute; top: -50%; right: -20%; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float { 0%, 100% { transform: translate(0, 0) rotate(0deg); } 50% { transform: translate(30px, -30px) rotate(120deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(260px, 1fr)); gap: 24px; margin-bottom: 24px; justify-content: center; }
        .stat-card { padding: 24px; position: relative; overflow: hidden; transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-4px); border-color: #dbeafe; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15); }
        .stat-value { font-size: 2rem; font-weight: 700; color: #1e293b; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.85rem; color: #64748b; font-weight: 500; }

        .actions { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .action-card {
            background: #ffffff; border: 2px solid #e8ecf1; border-radius: 12px; padding: 24px;
            transition: all 0.3s ease; text-decoration: none; color: #1e293b; display: block; position: relative; overflow: hidden;
        }
        .action-card:hover { transform: translateY(-4px); border-color: #dbeafe; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15); }
        .action-icon { width: 48px; height: 48px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .action-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; color: #1e293b; }
        .action-desc { font-size: 0.9rem; color: #64748b; line-height: 1.5; }
        .action-arrow { position: absolute; top: 24px; right: 24px; font-size: 1.3rem; color: #3b82f6; opacity: 0; transform: translateX(-10px); transition: all 0.3s ease; }
        .action-card:hover .action-arrow { opacity: 1; transform: translateX(0); }

        /* --- FORM SPECIFIC --- */
        .form-section { padding: 32px; }
        .form-label { display: block; font-size: 1rem; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .form-textarea { width: 100%; min-height: 120px; padding: 16px 20px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; color: #374151; transition: all 0.3s ease; font-family: inherit; }
        .form-textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .preview-section { padding: 24px; margin-top: 24px; }
        .preview-alert { background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 16px; color: #92400e; font-weight: 500; }

        /* Responsive */
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .actions { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .container, .navbar, .form-section { padding: 24px 20px; } .stats-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <div class="logo">
                @hasSection('navbar-branding')
                    @yield('navbar-branding')
                @else
                    <span>Admin Dashboard</span>
                @endif
            </div>
            <div class="navbar-actions">
                @yield('navbar-actions')
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>