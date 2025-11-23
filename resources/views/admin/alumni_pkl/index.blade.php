<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Alumni PKL - Admin Dashboard</title>
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

        .navbar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
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
            max-width: 1400px;
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
            animation: fadeIn 0.4s ease-out;
        }

        h1 {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .add-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95em;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .add-btn::before {
            content: '➕';
        }

        /* Modern Alert */
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
            animation: progressBar 5s ease-out;
        }

        .alert-success::after {
            content: '✓';
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

        /* Alumni Grid */
        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .alumni-card {
            background: #ffffff;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .alumni-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alumni-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .alumni-card:hover .alumni-image {
            transform: scale(1.05);
        }

        .alumni-content {
            padding: 24px;
        }

        .alumni-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .alumni-university {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .alumni-status {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 16px;
        }

        .status-active {
            background: linear-gradient(135deg, #d1fae5, #6ee7b7);
            color: #065f46;
            border: 1px solid #34d399;
        }

        .status-inactive {
            background: linear-gradient(135deg, #fee2e2, #fca5a5);
            color: #991b1b;
            border: 1px solid #f87171;
        }

        .alumni-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex: 1;
            text-align: center;
        }

        .edit-btn {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
        }

        .edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .edit-btn::before {
            content: '✏️';
        }

        .toggle-btn {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 2px 6px rgba(107, 114, 128, 0.3);
        }

        .toggle-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .delete-btn::before {
            content: '🗑️';
        }

        /* Empty State */
        .empty-state {
            background: #ffffff;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            padding: 64px 32px;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 24px;
            opacity: 0.6;
        }

        .empty-title {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .empty-text {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 32px;
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 500;
            animation: fadeIn 1s ease;
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

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .navbar {
                padding: 16px 20px;
            }

            .navbar-actions {
                flex-direction: column;
                gap: 8px;
            }

            .header-section {
                padding: 24px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .alumni-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .alumni-actions {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 1.2em;
            }

            h1 {
                font-size: 1.4rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">Admin Dashboard</span>
            <div class="navbar-actions">
                <a href="{{ route('admin.dashboard') }}" class="back-link">Kembali</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="header-section">
            <h1> Kelola Alumni PKL</h1>
            <p class="subtitle">Kelola data alumni PKL yang akan ditampilkan di halaman utama website. Alumni yang aktif akan muncul di galeri homepage dengan animasi menarik.</p>
            <a href="{{ route('admin.alumni_pkl.create') }}" class="add-btn">Tambah Alumni Baru</a>
        </div>

        @if(session('success'))
        <div class="alert-success" id="successAlert">{{ session('success') }}</div>
        @endif

        @if($alumni->count() > 0)
            <div class="alumni-grid">
                @foreach($alumni as $item)
                <div class="alumni-card">
                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama_lengkap }}" class="alumni-image">
                    <div class="alumni-content">
                        <div class="alumni-name">{{ $item->nama_lengkap }}</div>
                        <div class="alumni-university">{{ $item->universitas }}</div>
                        <div class="alumni-status {{ $item->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $item->is_active ? '✅ Aktif' : '❌ Tidak Aktif' }}
                        </div>
                        <div class="alumni-actions">
                            <a href="{{ route('admin.alumni_pkl.edit', $item->id) }}" class="action-btn edit-btn">Edit</a>
                            <form method="POST" action="{{ route('admin.alumni_pkl.toggle_status', $item->id) }}" style="display: inline; flex: 1;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="action-btn toggle-btn" style="width: 100%;">
                                    {{ $item->is_active ? '🚫 Nonaktifkan' : '✅ Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.alumni_pkl.destroy', $item->id) }}" style="display: inline; flex: 1;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alumni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" style="width: 100%;">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🔭</div>
                <div class="empty-title">Belum ada data alumni PKL</div>
                <div class="empty-text">Tambahkan alumni PKL pertama untuk ditampilkan di homepage website dengan galeri yang menarik dan animasi.</div>
            </div>
        @endif

        <p class="footer-note">💡 Alumni yang aktif akan ditampilkan di homepage dengan animasi dan desain yang menarik</p>
    </div>

    <script>
        // Auto hide alert after 5 seconds
        const alert = document.getElementById('successAlert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(-100px)';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html>