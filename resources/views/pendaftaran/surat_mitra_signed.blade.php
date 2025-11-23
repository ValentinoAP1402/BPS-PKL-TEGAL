<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Yang Telah Ditandatangani</title>
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: 
                radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 30%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
            animation: floatParticles 20s ease-in-out infinite;
        }

        @keyframes floatParticles {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header Card */
        .header-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899, #6366f1);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .header-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            color: #2d3748;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: #718096;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(99, 102, 241, 0.5);
        }

        .btn-home::before {
            content: '←';
            font-size: 20px;
        }

        /* Surat Balasan Section - Highlight Special */
        .surat-balasan-section {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(251, 191, 36, 0.3);
            border: 3px solid #fbbf24;
            position: relative;
            overflow: hidden;
        }

        .surat-balasan-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b, #fbbf24);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        .surat-balasan-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .surat-balasan-icon {
            font-size: 70px;
            margin-bottom: 15px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .surat-balasan-title {
            font-size: 2em;
            font-weight: 700;
            color: #78350f;
            margin-bottom: 10px;
        }

        .surat-balasan-desc {
            color: #92400e;
            font-size: 15px;
            font-weight: 500;
        }

        .surat-balasan-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .surat-balasan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .balasan-icon {
            font-size: 60px;
            flex-shrink: 0;
        }

        .balasan-content {
            flex: 1;
        }

        .balasan-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .balasan-filename {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .balasan-meta {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 500;
        }

        .balasan-actions {
            display: flex;
            gap: 12px;
            flex-shrink: 0;
        }

        .btn-balasan {
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-view-balasan {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-view-balasan:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-download-balasan {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-download-balasan:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        /* No Balasan Message */
        .no-balasan-message {
            background: white;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            color: #64748b;
        }

        .no-balasan-icon {
            font-size: 60px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-balasan-text {
            font-size: 16px;
            font-weight: 600;
            color: #475569;
        }

        /* Divider */
        .section-divider {
            text-align: center;
            margin: 40px 0;
            position: relative;
        }

        .section-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .section-divider-text {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 700;
            color: white;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        /* No Signed Message */
        .no-signed-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .no-signed-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #fbbf24, #f59e0b);
        }

        .no-signed-icon {
            font-size: 100px;
            margin-bottom: 25px;
            opacity: 0.7;
            animation: swing 3s ease-in-out infinite;
        }

        @keyframes swing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
        }

        .no-signed-message {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #78350f;
            padding: 25px 35px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 16px;
            border: 2px solid #fbbf24;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.2);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .no-signed-message::before {
            content: '⚠️';
            font-size: 24px;
            margin-right: 10px;
        }

        /* Surat Cards Container */
        .surat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .surat-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .surat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .surat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .surat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 15px;
        }

        .surat-info {
            flex: 1;
        }

        .surat-name {
            font-weight: 700;
            color: #2d3748;
            font-size: 16px;
            margin-bottom: 8px;
            line-height: 1.4;
            word-break: break-word;
        }

        .surat-date {
            color: #718096;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .surat-date::before {
            content: '📅';
            font-size: 14px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            white-space: nowrap;
        }

        .status-signed {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
        }

        .status-signed::before {
            content: '✓';
            font-size: 16px;
            font-weight: bold;
        }

        .surat-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 20px 0;
        }

        .surat-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 150px;
            padding: 14px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-download {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        /* Stats Card */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .stats-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 25px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 14px;
            border: 2px solid #7dd3fc;
        }

        .stats-icon {
            font-size: 32px;
        }

        .stats-content {
            text-align: left;
        }

        .stats-number {
            font-size: 28px;
            font-weight: 700;
            color: #0284c7;
            line-height: 1;
        }

        .stats-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            margin-top: 4px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header-card {
                padding: 35px 25px;
            }

            h1 {
                font-size: 1.8em;
            }

            .header-icon {
                font-size: 60px;
            }

            .surat-grid {
                grid-template-columns: 1fr;
            }

            .surat-card {
                padding: 25px;
            }

            .surat-actions {
                flex-direction: column;
            }

            .btn-action {
                min-width: 100%;
            }

            .stats-card {
                flex-direction: column;
                padding: 20px;
            }

            .stats-item {
                width: 100%;
                justify-content: center;
            }

            .no-signed-card {
                padding: 40px 25px;
            }

            .no-signed-icon {
                font-size: 70px;
            }

            .surat-balasan-section {
                padding: 30px 20px;
            }

            .surat-balasan-card {
                flex-direction: column;
                text-align: center;
            }

            .balasan-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-balasan {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .surat-header {
                flex-direction: column;
            }

            .status-badge {
                align-self: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-card">
            <div class="header-icon">✉️</div>
            <h1>Surat Yang Telah Ditandatangani</h1>
            <p class="subtitle">Kelola dan unduh dokumen yang telah ditandatangani oleh admin BPS</p>
            <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>
        </div>

        {{-- Surat Balasan PKL Section - Always show this first --}}
        <div class="surat-balasan-section">
            <div class="surat-balasan-header">
                <div class="surat-balasan-icon">📮</div>
                <h2 class="surat-balasan-title">Surat Balasan PKL</h2>
                <p class="surat-balasan-desc">Surat balasan resmi dari BPS untuk pendaftaran PKL Anda</p>
            </div>

            @if($pendaftaran->surat_balasan_pkl)
                <div class="surat-balasan-card">
                    <div class="balasan-icon">📄</div>
                    <div class="balasan-content">
                        <div class="balasan-label">Dokumen Resmi</div>
                        <div class="balasan-filename">Surat Balasan PKL - {{ $pendaftaran->nama_lengkap }}</div>
                        <div class="balasan-meta">Diupload oleh Admin BPS</div>
                    </div>
                    <div class="balasan-actions">
                        <a href="{{ Storage::url($pendaftaran->surat_balasan_pkl) }}" target="_blank" class="btn-balasan btn-view-balasan">
                             Lihat
                        </a>
                        <a href="{{ Storage::url($pendaftaran->surat_balasan_pkl) }}" download class="btn-balasan btn-download-balasan">
                             Download
                        </a>
                    </div>
                </div>
            @else
                <div class="no-balasan-message">
                    <div class="no-balasan-icon">⏳</div>
                    <div class="no-balasan-text">Surat balasan sedang dalam proses pembuatan</div>
                    <p class="subtitle" style="margin-top: 10px;">Silakan tunggu, admin akan mengupload surat balasan segera</p>
                </div>
            @endif
        </div>

        {{-- Section Divider --}}
        @if($suratUploads->whereNotNull('surat_mitra_signed')->count() > 0)
            <div class="section-divider">
                <span class="section-divider-text">Surat Mitra Lainnya</span>
            </div>

            {{-- Stats Card --}}
            <div class="stats-card">
                <div class="stats-item">
                    <div class="stats-icon">📄</div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $suratUploads->whereNotNull('surat_mitra_signed')->count() }}</div>
                        <div class="stats-label">Surat Ditandatangani</div>
                    </div>
                </div>
            </div>

            {{-- Surat Grid --}}
            <div class="surat-grid">
                @foreach($suratUploads as $surat)
                    @if($surat->surat_mitra_signed)
                        <div class="surat-card">
                            <div class="surat-header">
                                <div class="surat-info">
                                    <div class="surat-name">{{ $surat->file_name }}</div>
                                    <div class="surat-date">{{ $surat->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <div class="status-badge status-signed">
                                    Signed
                                </div>
                            </div>

                            <div class="surat-divider"></div>

                            <div class="surat-actions">
                                <a href="{{ Storage::url($surat->surat_mitra_signed) }}" target="_blank" class="btn-action btn-view">
                                     Lihat
                                </a>
                                <a href="{{ Storage::url($surat->surat_mitra_signed) }}" download class="btn-action btn-download">
                                     Download
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Add smooth entrance animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.surat-card, .surat-balasan-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        });
    </script>
</body>
</html>