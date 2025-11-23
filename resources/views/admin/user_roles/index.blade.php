<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Role Pengguna - Super Admin</title>
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

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: 700;
            font-size: 1.5em;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.1);
        }

        .back-link:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateX(-4px);
        }

        .container {
            max-width: 1300px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 32px 40px;
            margin-bottom: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            font-size: 2.2rem;
            color: #2d3748;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .alert {
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 600;
            font-size: 1em;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.4s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-success::before { content: '✓'; }
        .alert-error::before { content: '✕'; }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95em;
        }

        th, td {
            padding: 16px 14px;
            text-align: left;
            vertical-align: middle;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        th {
            color: #fff;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.01);
        }

        .role-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85em;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .role-user {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(9, 132, 227, 0.4);
        }

        .role-admin {
            background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 184, 148, 0.4);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-start;
        }

        .action-buttons form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 12px;
        }

        .action-buttons form select {
            min-width: 100px;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.85em;
            background: #fff;
        }

        .action-buttons form select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        .btn-update {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-delete {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #ff7675 0%, #d63031 100%);
            color: #fff;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(214, 48, 49, 0.4);
        }

        select {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.9em;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Modal Konfirmasi */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 32px;
            border-radius: 16px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            color: #2d3748;
        }

        .modal-body {
            margin-bottom: 24px;
            color: #4a5568;
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-cancel {
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            background: #fff;
            color: #4a5568;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #f7fafc;
        }

        .btn-confirm {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, #ff7675 0%, #d63031 100%);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(214, 48, 49, 0.4);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
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

        .table-container {
            animation: fadeIn 0.6s ease-out;
        }

        @media (max-width: 1024px) {
            .container { padding: 0 16px; }
            .header-section { padding: 24px 28px; }
            .table-container { padding: 20px; overflow-x: scroll; }
            table { min-width: 1000px; }
        }

        @media (max-width: 768px) {
            h1 { font-size: 1.8rem; }
            .navbar { padding: 16px 20px; }
            .header-section { padding: 20px 24px; }
            th, td { padding: 12px 10px; font-size: 0.85em; }
            .action-buttons { flex-direction: column; }
        }

        @media (max-width: 480px) {
            .logo { font-size: 1.2em; }
            h1 { font-size: 1.5rem; }
            .table-container { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <span class="logo">✦ Super Admin Dashboard</span>
            <a href="{{ route('admin.dashboard') }}" class="back-link">← Kembali</a>
        </div>
    </div>

    <div class="container">
        <div class="header-section">
            <h1>👥 Kelola Role Pengguna</h1>
            <p>Kelola peran pengguna dalam sistem</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Role Saat Ini</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allUsers as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item['name'] }}</strong></td>
                            <td>{{ $item['email'] }}</td>
                            <td>
                                <span class="role-badge role-{{ $item['type'] }}">
                                    {{ ucfirst($item['type']) }}
                                </span>
                            </td>
                            <td>
                                <span class="role-badge role-{{ $item['role'] }}">
                                    {{ ucfirst($item['role']) }}
                                </span>
                            </td>

                            <td>
                                @if($item['type'] === 'admin')
                                    @if($item['status'] === 'pending')
                                        <span class="role-badge" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: #fff;">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif($item['status'] === 'approved')
                                        <span class="role-badge" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: #fff;">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="role-badge" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: #fff;">
                                            Ditolak
                                        </span>
                                    @endif
                                @else
                                    <span class="role-badge" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: #fff;">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($item['type'] === 'user')
                                        <form action="{{ route('admin.user_roles.update_user', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" required>
                                                <option value="user" {{ $item['role'] === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="admin" {{ $item['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="btn-update">Update Role</button>
                                        </form>
                                        <button type="button" class="btn-delete" onclick="confirmDelete('{{ $item['id'] }}', '{{ $item['name'] }}', 'user')">Hapus</button>
                                    @else
                                        <form action="{{ route('admin.user_roles.update_admin', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" required>
                                                <option value="admin" {{ $item['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="super_admin" {{ $item['role'] === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                            </select>
                                            <button type="submit" class="btn-update">Update Role</button>
                                        </form>
                                        @if($item['model']->status === 'pending')
                                            <form action="{{ route('admin.user_roles.approve_admin', $item['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-update" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.user_roles.reject_admin', $item['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-delete" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">Tolak</button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn-delete" onclick="confirmDelete('{{ $item['id'] }}', '{{ $item['name'] }}', 'admin')">Hapus</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon">👥</div>
                                    <div class="empty-state-text">Belum ada pengguna atau admin terdaftar</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">⚠️ Konfirmasi Hapus</div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengguna <strong id="userName"></strong>?
                <br><br>
                <span style="color: #dc3545; font-weight: 600;">Tindakan ini tidak dapat dibatalkan!</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name, type) {
            document.getElementById('userName').textContent = name;
            if (type === 'user') {
                document.getElementById('deleteForm').action = `/admin/user-roles/user/${id}`;
            } else {
                document.getElementById('deleteForm').action = `/admin/user-roles/admin/${id}`;
            }
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Tutup modal ketika klik di luar modal
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Auto hide alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    </script>
</body>
</html>
