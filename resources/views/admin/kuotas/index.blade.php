<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kuota PKL</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        h1 {
            font-size: 2rem;
            color: #1e293b;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .btn {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.95em;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        
        .btn-add {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }
        
        .btn-add:hover {
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        
        .btn-add::before {
            content: '➕';
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .btn-edit:hover {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }
        
        .btn-edit::before {
            content: '✏️';
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .btn-delete:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        
        .btn-delete::before {
            content: '🗑️';
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
            animation: progressBar 3s ease-out;
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
            animation: fadeIn 0.4s ease-out;
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
            background: linear-gradient(135deg, #fef3c7, #fde68a);
        }
        
        .stat-item:nth-child(2)::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        
        .stat-item:nth-child(3) {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
        }
        
        .stat-item:nth-child(3)::before {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }
        
        .stat-item:nth-child(4) {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        }
        
        .stat-item:nth-child(4)::before {
            background: linear-gradient(90deg, #10b981, #059669);
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
            color: #d97706;
        }
        
        .stat-item:nth-child(3) .stat-value {
            color: #dc2626;
        }
        
        .stat-item:nth-child(4) .stat-value {
            color: #059669;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
        }
        
        /* Table Container */
        .table-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e8ecf1;
            animation: fadeIn 0.6s ease-out;
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
            font-size: 0.9em;
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
        
        tbody td:first-child {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.05em;
        }
        
        .kuota-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9em;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .kuota-badge:hover {
            transform: scale(1.05);
        }
        
        .badge-total {
            background: linear-gradient(135deg, #dbeafe, #93c5fd);
            color: #1e40af;
            border: 1px solid #60a5fa;
        }
        
        .badge-used {
            background: linear-gradient(135deg, #fee2e2, #fca5a5);
            color: #991b1b;
            border: 1px solid #f87171;
        }
        
        .badge-available {
            background: linear-gradient(135deg, #d1fae5, #6ee7b7);
            color: #065f46;
            border: 1px solid #34d399;
        }
        
        .aksi {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tanggal-digunakan {
            font-size: 0.85em;
            color: #1e293b;
            line-height: 1.4;
        }

        .tanggal-badge {
            display: inline-block;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0c4a6e;
            padding: 4px 8px;
            border-radius: 6px;
            margin: 2px 0;
            font-weight: 600;
            border: 1px solid #7dd3fc;
        }

        .no-tanggal {
            color: #64748b;
            font-style: italic;
            font-size: 0.85em;
        }
        
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
            .container { padding: 0 16px; }
            .navbar { padding: 16px 20px; }
            .header-section { 
                padding: 24px;
                flex-direction: column;
                align-items: flex-start;
            }
            h1 { font-size: 1.6rem; }
            .btn-group { width: 100%; }
            .btn { width: 100%; justify-content: center; }
            table { min-width: 800px; }
            .stats-card { 
                padding: 24px;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            .stat-value { font-size: 2rem; }
            .stat-item { padding: 16px; }
        }
        
        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.4rem; }
            th, td { padding: 14px 12px; font-size: 0.9em; }
            .aksi { flex-direction: column; }
            .btn-edit, .btn-delete { width: 100%; justify-content: center; }
            .stats-card { 
                grid-template-columns: 1fr;
                padding: 20px;
            }
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
            <h1> Kelola Kuota PKL</h1>
            <div class="btn-group">
                <a href="{{ route('admin.kuotas.create') }}" class="btn btn-add">
                    Tambah Kuota
                </a>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert-success" id="successAlert">{{ session('success') }}</div>
        @endif
        
        <div class="stats-card">
            <div class="stat-item">
                <div class="stat-value">{{ count($kuotas) }}</div>
                <div class="stat-label">Total Periode</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $kuotas->sum('jumlah_kuota') }}</div>
                <div class="stat-label">Total Kuota</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $kuotas->sum('jumlah_kuota') - $kuotas->sum('available_slots') }}</div>
                <div class="stat-label">Total Digunakan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $kuotas->sum('available_slots') }}</div>
                <div class="stat-label">Total Tersedia</div>
            </div>
        </div>
        
        <div class="table-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>📅 Bulan</th>
                            <th>🎯 Jumlah Kuota</th>
                            <th>📊 Digunakan</th>
                            <th>✅ Tersedia</th>
                            <th>📅 Tanggal PKL</th>
                            <th>⚡ Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuotas as $kuota)
                            <tr>
                                <td>{{ $kuota->bulan }}</td>
                                <td>
                                    <span class="kuota-badge badge-total">{{ $kuota->jumlah_kuota }}</span>
                                </td>
                                <td>
                                    <span class="kuota-badge badge-used">{{ $kuota->jumlah_kuota - $kuota->available_slots }}</span>
                                </td>
                                <td>
                                    <span class="kuota-badge badge-available">{{ $kuota->available_slots }}</span>
                                </td>
                                <td>
                                    @if($kuota->pendaftarans->count() > 0)
                                        <div class="tanggal-digunakan">
                                            <strong>Tanggal yang sudah diambil:</strong><br>
                                            @foreach($kuota->pendaftarans as $pendaftaran)
                                                <span class="tanggal-badge">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_mulai_pkl)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($pendaftaran->tanggal_selesai_pkl)->format('d/m/Y') }}</span><br>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="no-tanggal">Belum ada tanggal yang diambil</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="aksi">
                                        <a href="{{ route('admin.kuotas.edit', $kuota->id) }}" class="btn btn-edit">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.kuotas.destroy', $kuota->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kuota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📭</div>
                                        <div class="empty-state-text">Belum ada kuota PKL yang ditambahkan</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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