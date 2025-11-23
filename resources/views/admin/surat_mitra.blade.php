<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Surat Tanda Tangan - Admin</title>
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
            margin-bottom: 8px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .subtitle {
            color: #64748b;
            font-size: 1rem;
        }
        
        /* Modern Alert Styles */
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
        }
        
        .alert-message {
            opacity: 0.9;
            line-height: 1.5;
        }
        
        .alert-success { 
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
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
        
        .alert-error { 
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
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
        
        .alert-warning { 
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
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
        
        .alert-info { 
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
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
        
        /* Stats Card */
        .stats-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 12px 12px 0 0;
        }
        
        .stat-item:nth-child(1) {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
        }
        
        .stat-item:nth-child(1)::before {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
        }
        
        .stat-item:nth-child(2) {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        }
        
        .stat-item:nth-child(2)::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }
        
        .stat-item:nth-child(3) {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
        }
        
        .stat-item:nth-child(3)::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        
        .stat-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            margin-top: 8px;
        }
        
        .stat-item:nth-child(1) .stat-value {
            color: #2563eb;
        }
        
        .stat-item:nth-child(2) .stat-value {
            color: #059669;
        }
        
        .stat-item:nth-child(3) .stat-value {
            color: #d97706;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
        }
        
        /* Surat Grid */
        .surat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 24px;
            animation: fadeIn 0.6s ease-out;
        }
        
        .surat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #e8ecf1;
        }
        
        .surat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }
        
        .surat-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .surat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-size: 24px;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .surat-info {
            flex: 1;
            min-width: 0;
        }
        
        .surat-info h3 {
            margin: 0 0 6px;
            color: #1e293b;
            font-size: 1.15em;
            font-weight: 700;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .surat-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.9em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .surat-details {
            margin-bottom: 20px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.9em;
            gap: 12px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .detail-label {
            color: #475569;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: #1e293b;
            font-weight: 500;
            text-align: right;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Status Badges */
        .status-pending { 
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #fcd34d;
            font-weight: 700;
            font-size: 0.8em;
        }
        
        .status-pending::before {
            content: '⏱';
        }
        
        .status-approved { 
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #6ee7b7;
            font-weight: 700;
            font-size: 0.8em;
        }
        
        .status-approved::before {
            content: '✓';
        }
        
        .status-rejected { 
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #fca5a5;
            font-weight: 700;
            font-size: 0.8em;
        }
        
        .status-rejected::before {
            content: '✕';
        }
        
        .status-completed { 
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 1px solid #93c5fd;
            font-weight: 700;
            font-size: 0.8em;
        }
        
        .status-completed::before {
            content: '🎓';
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .action-buttons a,
        .action-buttons button {
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            font-size: 0.85em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            justify-content: center;
            min-width: 140px;
            position: relative;
            overflow: hidden;
        }
        
        .action-buttons a::before,
        .action-buttons button::before {
            font-size: 1.1em;
        }
        
        .btn-detail {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        
        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        
        .btn-detail::before {
            content: '👁';
        }
        
        .btn-download {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
        }
        
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        
        .btn-download::before {
            content: '📥';
        }
        
        .btn-upload {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }
        
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }
        
        .btn-upload::before {
            content: '📤';
        }
        
        .btn-signed {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: #fff;
        }
        
        .btn-signed:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        }
        
        .btn-signed::before {
            content: '✓';
        }
        
        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.6;
        }
        
        .empty-state h3 {
            color: #1e293b;
            font-size: 1.5rem;
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .empty-state p {
            color: #64748b;
            font-size: 1rem;
        }
        
        /* Hidden File Input */
        input[type="file"] {
            display: none;
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
        @media (max-width: 1024px) {
            .surat-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .navbar { padding: 16px 20px; }
            .header-section { padding: 24px; }
            h1 { font-size: 1.6rem; }
            .surat-grid { grid-template-columns: 1fr; }
            .stats-card { 
                padding: 24px;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            .stat-value { font-size: 2rem; }
            .action-buttons { flex-direction: column; }
            .action-buttons a, .action-buttons button {
                width: 100%;
                min-width: auto;
            }
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.4rem; }
            .surat-card { padding: 20px; }
            .surat-icon { width: 45px; height: 45px; font-size: 20px; }
            .back-link { padding: 8px 16px; font-size: 0.9em; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">Admin Dashboard</span>
            <a href="{{ route('admin.dashboard') }}" class="back-link">Kembali</a>
        </div>
    </div>
    
    <div class="container">
        <div class="header-section">
            <h1>📨 Kelola Surat Tanda Tangan</h1>
            <p class="subtitle">Kelola surat tanda tangan PKL</p>
        </div>
        
        {{-- Modern Alerts --}}
        @if(session('success')) 
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
            </div>
        @endif
        
        @if(session('error')) 
            <div class="alert alert-error">
                <div class="alert-icon">✕</div>
                <div class="alert-content">
                    <div class="alert-title">Terjadi Kesalahan!</div>
                    <div class="alert-message">{{ session('error') }}</div>
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
        
        @if(count($pendaftarans) > 0)
            <div class="stats-card">
                <div class="stat-item">
                    <div class="stat-value">{{ $pendaftarans->sum(function($pendaftaran) { return $pendaftaran->suratUploads->count(); }) }}</div>
                    <div class="stat-label">Total Surat Mitra</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $pendaftarans->sum(function($pendaftaran) { return $pendaftaran->suratUploads->where('surat_mitra_signed', '!=', null)->count(); }) }}</div>
                    <div class="stat-label">Sudah Signed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $pendaftarans->sum(function($pendaftaran) { return $pendaftaran->suratUploads->where('surat_mitra_signed', null)->count(); }) }}</div>
                    <div class="stat-label">Belum Signed</div>
                </div>
            </div>
        @endif
        
        <div class="surat-grid">
            @forelse($pendaftarans as $pendaftaran)
                @if($pendaftaran->suratUploads->count() > 0)
                    @foreach($pendaftaran->suratUploads as $surat)
                        <div class="surat-card">
                            <div class="surat-header">
                                <div class="surat-icon">📄</div>
                                <div class="surat-info">
                                    <h3>{{ $pendaftaran->nama_lengkap }}</h3>
                                    <p>{{ $pendaftaran->asal_sekolah }}</p>
                                </div>
                            </div>

                            <div class="surat-details">
                                <div class="detail-row">
                                    <span class="detail-label">📚 Jurusan:</span>
                                    <span class="detail-value">{{ $pendaftaran->jurusan }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">📧 Email:</span>
                                    <span class="detail-value">{{ $pendaftaran->email }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">📅 Periode:</span>
                                    <span class="detail-value">{{ $pendaftaran->tanggal_mulai_pkl }} - {{ $pendaftaran->tanggal_selesai_pkl }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">📊 Status:</span>
                                    <span class="detail-value">
                                        <span class="status-{{ $pendaftaran->status }}">{{ ucfirst($pendaftaran->status) }}</span>
                                    </span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">📄 Nama File:</span>
                                    <span class="detail-value">{{ $surat->file_name }}</span>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="btn-detail">Lihat</a>
                                <a href="{{ Storage::url($surat->file_path) }}" download class="btn-download">Download</a>

                                @if($surat->surat_mitra_signed)
                                    <a href="{{ Storage::url($surat->surat_mitra_signed) }}" target="_blank" class="btn-signed">
                                        Lihat Signed
                                    </a>
                                    <a href="{{ Storage::url($surat->surat_mitra_signed) }}" download class="btn-download">
                                        Download Signed
                                    </a>
                                @else
                                    <form action="{{ route('admin.surat_mitra.upload_signed', $surat->id) }}" method="POST" enctype="multipart/form-data" style="display:inline; flex: 1;">
                                        @csrf
                                        <input type="file" name="surat_mitra_signed" accept=".pdf" required id="file-upload-{{ $pendaftaran->id }}-{{ $surat->id }}" onchange="this.form.submit()">
                                        <button type="button" onclick="document.getElementById('file-upload-{{ $pendaftaran->id }}-{{ $surat->id }}').click()" class="btn-upload">
                                            Upload Signed
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h3>Belum ada surat mitra</h3>
                    <p>Pendaftar yang sudah upload surat tanda tangan mitra akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>