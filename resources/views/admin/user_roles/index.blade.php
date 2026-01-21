@extends('admin.layouts.app')

@section('title', 'Kelola Role Pengguna')

{{-- NAVBAR BRANDING: Simpel & Bersih --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        {{-- Icon SVG Modern --}}
        <div style="width: 36px; height: 36px; background: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; line-height: 1.2;">Access Control</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">User & Admin Roles</span>
        </div>
    </div>
@endsection

{{-- NAVBAR ACTIONS --}}
@section('navbar-actions')
    <a href="{{ route('admin.dashboard') }}" 
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: #64748b; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 0.9rem; border: 1px solid #e2e8f0; transition: all 0.2s;"
           onmouseover="this.style.background='#f8fafc'; this.style.color='#334155';"
           onmouseout="this.style.background='white'; this.style.color='#64748b';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>
@endsection

@section('content')
    <style>
        /* Modern Alert Style */
        .alert-modern {
            background: white;
            border-left: 4px solid;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
        }
        .alert-success { border-color: #10b981; }
        .alert-error { border-color: #ef4444; }
        .alert-icon { margin-top: 2px; }

        /* Card Container */
        .card-clean {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        /* Table Styling - Clean & Professional */
        .table-clean { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-clean th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .table-clean td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
            font-size: 0.9rem;
        }
        .table-clean tr:last-child td { border-bottom: none; }
        .table-clean tr:hover td { background: #f8fafc; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 99px;
            font-size: 0.75rem; font-weight: 600;
        }
        /* Role Colors */
        .badge-super { background: #fff7ed; color: #9a3412; border: 1px solid #ffedd5; }
        .badge-admin { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
        .badge-user  { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        
        /* Status Colors */
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .status-active { background: #10b981; }
        .status-pending { background: #f59e0b; }
        .status-rejected { background: #ef4444; }

        /* Form Elements */
        .select-clean {
            padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px;
            font-size: 0.85rem; color: #334155; outline: none; bg: white;
            transition: border 0.2s;
        }
        .select-clean:focus { border-color: #3b82f6; }

        /* Buttons */
        .btn-icon {
            width: 32px; height: 32px; border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            border: none; cursor: pointer; transition: all 0.2s;
            color: white;
        }
        .btn-save { background: #3b82f6; } .btn-save:hover { background: #2563eb; }
        .btn-check { background: #10b981; } .btn-check:hover { background: #059669; }
        .btn-cross { background: #f59e0b; } .btn-cross:hover { background: #d97706; }
        .btn-trash { background: white; border: 1px solid #fee2e2; color: #ef4444; } 
        .btn-trash:hover { background: #fef2f2; border-color: #fecaca; }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(2px); }
        .modal-box { 
            background: white; margin: 10% auto; padding: 32px; width: 400px; 
            border-radius: 16px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            animation: slideUp 0.3s;
        }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .avatar-circle {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.9rem; color: white;
            background: linear-gradient(135deg, #64748b, #475569);
        }
        .avatar-img { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; }
    </style>

    {{-- ALERT MESSAGES (Redesigned) --}}
    @if(session('success'))
        <div class="alert-modern alert-success" id="alert-success">
            <div class="alert-icon" style="color: #10b981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
                <h4 style="font-size: 0.9rem; font-weight: 600; color: #065f46; margin-bottom: 2px;">Berhasil</h4>
                <p style="font-size: 0.85rem; color: #064e3b; margin: 0;">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-modern alert-error" id="alert-error">
            <div class="alert-icon" style="color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div>
                <h4 style="font-size: 0.9rem; font-weight: 600; color: #991b1b; margin-bottom: 2px;">Terjadi Kesalahan</h4>
                <p style="font-size: 0.85rem; color: #7f1d1d; margin: 0;">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <div class="card-clean">
        <div style="overflow-x: auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">User Profile</th>
                        <th width="20%">Role & Status</th>
                        <th width="30%">Access Control</th>
                        <th width="10%" style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allUsers as $index => $user)
                    <tr>
                        <td style="color: #94a3b8; text-align: center;">{{ $index + 1 }}</td>
                        
                        {{-- User Info --}}
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if(!empty($user['avatar']))
                                    <img src="{{ asset('storage/' . $user['avatar']) }}" alt="Av" class="avatar-img">
                                @else
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $user['name'] }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">{{ $user['email'] }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Role & Status --}}
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                                @if($user['role'] == 'super_admin')
                                    <span class="badge badge-super">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        Super Admin
                                    </span>
                                @elseif($user['role'] == 'admin')
                                    <span class="badge badge-admin">Admin</span>
                                @else
                                    <span class="badge badge-user">User</span>
                                @endif

                                @if($user['type'] === 'admin')
                                    <div style="font-size: 0.75rem; color: #64748b; margin-left: 4px;">
                                        @if($user['status'] == 'pending')
                                            <span class="status-dot status-pending"></span>Pending
                                        @elseif($user['status'] == 'approved')
                                            <span class="status-dot status-active"></span>Active
                                        @elseif($user['status'] == 'rejected')
                                            <span class="status-dot status-rejected"></span>Rejected
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Action Logic --}}
                        <td>
                            @if($user['role'] === 'super_admin')
                                <span style="font-size: 0.8rem; color: #cbd5e1; font-style: italic;">Full Access Granted</span>
                            @else
                                {{-- Approval Buttons --}}
                                @if($user['type'] === 'admin' && $user['status'] === 'pending')
                                    <div style="display: flex; gap: 6px;">
                                        <form action="{{ route('admin.user_roles.approve_admin', $user['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-icon btn-check" title="Approve">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.user_roles.reject_admin', $user['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-icon btn-cross" title="Reject">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    {{-- Role Update Form --}}
                                    <form action="{{ $user['type'] === 'admin' ? route('admin.user_roles.update_admin', $user['id']) : route('admin.user_roles.update_user', $user['id']) }}" method="POST" style="display: flex; gap: 8px; align-items: center;">
                                        @csrf
                                        @method('PUT')
                                        
                                        <select name="role" class="select-clean">
                                            <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        
                                        <button type="submit" class="btn-icon btn-save" title="Save Role">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>

                        {{-- Delete Button --}}
                        <td style="text-align: center;">
                            @if($user['role'] !== 'super_admin')
                                <form action="{{ $user['type'] === 'admin' ? route('admin.user_roles.delete_admin', $user['id']) : route('admin.user_roles.delete_user', $user['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-icon btn-trash" onclick="showDeleteModal(event, '{{ $user['name'] }}', '{{ $user['email'] }}', '{{ $user['role'] }}')" title="Delete User">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <div style="width: 50px; height: 50px; background: #fef2f2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
            </div>
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Delete User?</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">
                Are you sure you want to delete <strong id="deleteName"></strong>? <br>
                <span style="font-size: 0.8rem;">This action cannot be undone.</span>
            </p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <button onclick="closeModal('deleteModal')" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #64748b; font-weight: 600; cursor: pointer;">Cancel</button>
                <button id="confirmDeleteBtn" style="padding: 10px 20px; border-radius: 8px; border: none; background: #ef4444; color: white; font-weight: 600; cursor: pointer;">Yes, Delete</button>
            </div>
            <div id="hiddenData" style="display:none;"></div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        // Auto-dismiss alert
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-modern');
            alerts.forEach(alert => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        function showDeleteModal(event, name, email, role) {
            event.preventDefault();
            document.getElementById('deleteName').innerText = name;
            
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'block';

            const form = event.target.closest('form');
            document.getElementById('confirmDeleteBtn').onclick = function() {
                form.submit();
            };
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
@endsection