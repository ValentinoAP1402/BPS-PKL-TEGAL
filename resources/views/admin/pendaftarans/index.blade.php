<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftar PKL Admin</title>
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
        
        .filter-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: #2563eb;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 12px;
            border: 1px solid #dbeafe;
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
        
        /* Table Container */
        .table-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e8ecf1;
        }
        
        .table-wrapper {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }
        
        th, td {
            padding: 18px 16px;
            text-align: left;
            vertical-align: middle;
        }
        
        thead {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        
        th {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
            border-bottom: 2px solid #1d4ed8;
        }
        
        tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }
        
        tbody tr:hover {
            background: #f8fafc;
        }
        
        tbody tr:last-child {
            border-bottom: none;
        }
        
        tbody td {
            color: #475569;
        }
        
        tbody td strong {
            color: #1e293b;
            font-weight: 600;
        }
        
        /* Status Badges */
        .status-pending, .status-approved, .status-rejected, .status-completed {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }
        
        .status-pending { 
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .status-pending::before {
            content: '⏱';
        }
        
        .status-approved { 
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .status-approved::before {
            content: '✓';
        }
        
        .status-rejected { 
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .status-rejected::before {
            content: '✕';
        }
        
        .status-completed { 
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .action-buttons a, .action-buttons button {
            padding: 8px 14px;
            border-radius: 8px;
            border: none;
            font-size: 0.85em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-detail {
            background: #3b82f6;
            color: #fff;
        }
        
        .btn-detail:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .btn-detail::before {
            content: '👁';
        }
        
        .btn-complete {
            background: #10b981;
            color: #fff;
        }
        
        .btn-complete:hover {
            background: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-complete::before {
            content: '✓';
        }
        
        .btn-delete {
            background: #ef4444;
            color: #fff;
        }
        
        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-delete::before {
            content: '🗑';
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.6;
        }
        
        .empty-state-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: #64748b;
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
        .modal-complete .modal-content {
            border-color: #10b981;
        }

        .modal-complete {
            --modal-header-bg: #10b981, #059669;
            --modal-accent: #10b981;
            --modal-primary-bg: #10b981, #059669;
        }

        .modal-delete .modal-content {
            border-color: #ef4444;
        }

        .modal-delete {
            --modal-header-bg: #ef4444, #dc2626;
            --modal-accent: #ef4444;
            --modal-danger-bg: #ef4444, #dc2626;
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

        .table-container {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Scrollbar Styling */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .container { padding: 0 16px; }
            .header-section { padding: 24px; }
            table { min-width: 1000px; }
        }
        
        @media (max-width: 768px) {
            h1 { font-size: 1.6rem; }
            .navbar { padding: 16px 20px; }
            .header-section { padding: 20px; }
            th, td { padding: 14px 12px; font-size: 0.85em; }
            .action-buttons { flex-direction: column; gap: 6px; }
            .action-buttons a, .action-buttons button { width: 100%; justify-content: center; }
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.4rem; }
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
            <h1>📋 Daftar Pendaftar PKL</h1>
            @if(request('filter') === 'surat_mitra')
                <span class="filter-info">
                    📄 Menampilkan pendaftar yang sudah upload surat mitra
                </span>
            @endif
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
        
        <div class="table-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Universitas/Sekolah</th>
                            <th>Jurusan</th>
                            <th>Email</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $index => $pendaftaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $pendaftaran->nama_lengkap }}</strong></td>
                                <td>{{ $pendaftaran->asal_sekolah }}</td>
                                <td>{{ $pendaftaran->jurusan }}</td>
                                <td>{{ $pendaftaran->email }}</td>
                                <td>{{ $pendaftaran->tanggal_mulai_pkl }}</td>
                                <td>{{ $pendaftaran->tanggal_selesai_pkl }}</td>
                                <td>
                                    <span class="status-{{ $pendaftaran->status }}">
                                        {{ ucfirst($pendaftaran->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.pendaftarans.show', $pendaftaran->id) }}" class="btn-detail">Detail</a>
                                        
                                        @if($pendaftaran->status == 'approved')
                                        <form action="{{ route('admin.pendaftarans.complete', $pendaftaran->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-complete" onclick="showCompleteModal(event, '{{ $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ $pendaftaran->id }}')">Selesai</button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.pendaftarans.destroy', $pendaftaran->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="showDeleteModal(event, '{{ $pendaftaran->nama_lengkap }}', '{{ $pendaftaran->asal_sekolah }}', '{{ ucfirst($pendaftaran->status) }}', '{{ $pendaftaran->id }}')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🔭</div>
                                        <div class="empty-state-text">Belum ada pendaftar PKL</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div id="completeModal" class="modal modal-complete">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">✅</div>
                <h2 class="modal-title">Tandai Selesai PKL</h2>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Apakah Anda yakin ingin menandai pendaftaran PKL ini sebagai SELESAI?
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="completeName"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="completeSchool"></span>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="modal-btn modal-btn-secondary" onclick="closeModal('completeModal')">Batal</button>
                    <button class="modal-btn modal-btn-primary" id="confirmCompleteBtn">Ya, Tandai Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="modal modal-delete">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">⚠️</div>
                <h2 class="modal-title">Hapus Pendaftaran PKL</h2>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    <strong>PERINGATAN:</strong> Aksi ini akan menghapus semua data pendaftaran secara permanen dan tidak dapat dibatalkan.
                </div>
                <div class="modal-details">
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Pendaftar:</span>
                        <span class="modal-detail-value" id="deleteName"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Sekolah:</span>
                        <span class="modal-detail-value" id="deleteSchool"></span>
                    </div>
                    <div class="modal-detail-item">
                        <span class="modal-detail-label">Status:</span>
                        <span class="modal-detail-value" id="deleteStatus"></span>
                    </div>
                </div>
                <div class="modal-message" style="color: #dc2626; font-weight: 600;">
                    • Menghapus semua data pendaftaran<br>
                    • Menghapus file yang diupload<br>
                    • Tidak dapat dibatalkan
                </div>
                <div class="modal-actions">
                    <button class="modal-btn modal-btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
                    <button class="modal-btn modal-btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto hide alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);

        // Modal functions
        function showCompleteModal(event, name, school, id) {
            event.preventDefault();
            document.getElementById('completeName').textContent = name;
            document.getElementById('completeSchool').textContent = school;
            document.getElementById('completeModal').style.display = 'block';

            // Set up confirm button
            document.getElementById('confirmCompleteBtn').onclick = function() {
                const form = event.target.closest('form');
                form.submit();
            };
        }

        function showDeleteModal(event, name, school, status, id) {
            event.preventDefault();
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteSchool').textContent = school;
            document.getElementById('deleteStatus').textContent = status;
            document.getElementById('deleteModal').style.display = 'block';

            // Set up confirm button
            document.getElementById('confirmDeleteBtn').onclick = function() {
                const form = event.target.closest('form');
                form.submit();
            };
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
