@extends('admin.layouts.app')

@section('title', 'Kelola Kuota PKL')

@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0f172a; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">Kuota Bulanan</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Monitoring Slot & Jadwal Peserta</span>
        </div>
    </div>
@endsection

@section('navbar-actions')
    <div style="display: flex; gap: 10px;">
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
        </a>
        <a href="{{ route('admin.kuotas.create') }}" 
           style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: #0f172a; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.15); transition: all 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Kuota
        </a>
    </div>
@endsection

@section('content')
    <style>
        /* Card & Table Styles */
        .card-clean { background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.02); overflow: hidden; animation: fadeInUp 0.5s ease-out; }
        .table-clean { width: 100%; border-collapse: collapse; }
        
        .table-clean th { 
            background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 700; 
            text-transform: uppercase; letter-spacing: 0.05em; padding: 16px 24px; 
            border-bottom: 1px solid #e2e8f0; text-align: left; 
        }
        
        .table-clean td { 
            padding: 18px 24px; border-bottom: 1px solid #f1f5f9; 
            vertical-align: middle; color: #334155; font-size: 0.9rem; 
        }
        
        /* Progress Bar */
        .progress-container { width: 100%; min-width: 100px; height: 6px; background: #f1f5f9; border-radius: 99px; overflow: hidden; margin-top: 8px; }
        .progress-fill { height: 100%; border-radius: 99px; transition: width 0.6s ease; }
        
        /* Badges */
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; gap: 4px; }
        .badge-full { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-avail { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-detail { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .badge-detail:hover { background: #dbeafe; }

        /* Buttons */
        .action-btn { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: 0.2s; color: #64748b; background: transparent; }
        .action-btn:hover { background: #f1f5f9; color: #0f172a; }
        .action-btn.delete:hover { background: #fef2f2; color: #ef4444; }

        /* Expandable Row (Detail Peserta) */
        .detail-row { display: none; background: #f8fafc; animation: slideDown 0.3s ease; }
        .detail-row.active { display: table-row; }
        .detail-content { padding: 24px 32px !important; border-bottom: 1px solid #e2e8f0; border-top: 2px solid #e2e8f0; }
        
        /* --- STYLE BARU KHUSUS GRID SISWA (TEXT ONLY) --- */
        .student-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 16px; 
        }
        
        .student-card-simple { 
            background: white; 
            border: 1px solid #e2e8f0; 
            border-radius: 10px; 
            padding: 16px; 
            display: flex; 
            flex-direction: column;
            gap: 12px;
            transition: 0.2s;
        }
        .student-card-simple:hover { 
            border-color: #cbd5e1; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .info-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        .info-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .info-value-secondary {
            font-size: 0.9rem;
            color: #334155;
            font-weight: 500;
        }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(2px); }
        .modal-box { background: white; margin: 10% auto; padding: 32px; width: 400px; border-radius: 16px; text-align: center; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    {{-- ALERT --}}
    @if(session('success'))
        <div id="alert-success" style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card-clean">
        <div style="overflow-x: auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Bulan</th>
                        <th width="25%">Kapasitas</th>
                        <th width="15%">Status</th>
                        <th width="20%">Peserta Approved</th>
                        <th width="15%" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kuotas as $index => $kuota)
                        @php
                            $approvedUsers = $kuota->pendaftarans->where('status', 'approved'); 
                            $terisiTotal = $kuota->pendaftarans->count(); 
                            $sisa = $kuota->jumlah_kuota - $terisiTotal;
                            $persen = $kuota->jumlah_kuota > 0 ? ($terisiTotal / $kuota->jumlah_kuota) * 100 : 0;
                            
                            $color = '#3b82f6';
                            if($persen > 80) $color = '#f59e0b';
                            if($persen >= 100) $color = '#ef4444';
                        @endphp
                    <tr>
                        <td style="text-align: center; color: #94a3b8;">{{ $index + 1 }}</td>
                        
                        {{-- Bulan --}}
                        <td>
                            <div style="font-weight: 600; color: #1e293b; font-size: 0.95rem;">{{ $kuota->bulan }}</div>
                        </td>
                        
                        {{-- Kapasitas & Progress --}}
                        <td>
                            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 4px;">
                                <span style="color: #64748b;">Terisi: <strong>{{ $terisiTotal }}</strong></span>
                                <span style="color: #64748b;">Total: <strong>{{ $kuota->jumlah_kuota }}</strong></span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-fill" style="width: {{ $persen }}%; background: {{ $color }};"></div>
                            </div>
                        </td>
                        
                        {{-- Status Badge --}}
                        <td>
                            @if($sisa <= 0)
                                <span class="badge badge-full">Penuh</span>
                            @else
                                <span class="badge badge-avail">{{ $sisa }} Slot Tersedia</span>
                            @endif
                        </td>
                        
                        {{-- Tombol Lihat Detail Peserta --}}
                        <td>
                            @if($approvedUsers->count() > 0)
                                <button type="button" class="badge badge-detail" onclick="toggleDetail('detail-{{ $kuota->id }}')">
                                    Lihat {{ $approvedUsers->count() }} Peserta
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                            @else
                                <span style="font-size: 0.8rem; color: #94a3b8; font-style: italic;">Belum ada peserta</span>
                            @endif
                        </td>
                        
                        {{-- Aksi --}}
                        <td style="text-align: center;">
                            <a href="{{ route('admin.kuotas.edit', $kuota->id) }}" class="action-btn" title="Edit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.kuotas.destroy', $kuota->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-btn delete" onclick="showDeleteModal(event, '{{ $kuota->bulan }}')" title="Hapus">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- DETAIL ROW (Data Siswa Simple) --}}
                    <tr id="detail-{{ $kuota->id }}" class="detail-row">
                        <td colspan="6" class="detail-content">
                            <h4 style="font-size: 0.9rem; font-weight: 700; color: #64748b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em;">
                                Data Peserta PKL - {{ $kuota->bulan }}
                            </h4>
                            
                            <div class="student-grid">
                            @foreach($approvedUsers as $siswa)
                                <div class="student-card-simple">
                                    {{-- Nama --}}
                                    <div class="info-group">
                                        <span class="info-label">Nama:</span>
                                        <span class="info-value">
                                            {{ $siswa->user->name ?? $siswa->nama_lengkap ?? '-' }}
                                        </span>
                                    </div>

                                    {{-- Asal Sekolah --}}
                                    <div class="info-group">
                                        <span class="info-label">Asal Univ/Sekolah:</span>
                                        {{-- Cek di tabel user juga karena ProfileController menyimpan data di sana --}}
                                        <span class="info-value-secondary">
                                            {{ $siswa->user->asal_sekolah ?? $siswa->asal_sekolah ?? '-' }}
                                        </span>
                                    </div>

                                    {{-- Jurusan --}}
                                    <div class="info-group">
                                        <span class="info-label">Jurusan:</span>
                                        <span class="info-value-secondary">
                                            {{ $siswa->user->jurusan ?? $siswa->jurusan ?? '-' }}
                                        </span>
                                    </div>

                                    {{-- Periode PKL --}}
                                    <div class="info-group">
                                    <span class="info-label">Periode PKL:</span>
                                    <span class="info-value-secondary" style="font-weight: 600; color: #0f172a;">
                                        {{ \Carbon\Carbon::parse($siswa->tanggal_mulai_pkl)->translatedFormat('d M Y') }} 
                                        <span style="color: #94a3b8; margin: 0 4px;">s/d</span> 
                                        {{ \Carbon\Carbon::parse($siswa->tanggal_selesai_pkl)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                </div>
                            @endforeach
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($kuotas->isEmpty())
            <div style="padding: 64px; text-align: center; color: #94a3b8;">
                <p>Belum ada data kuota yang ditambahkan.</p>
            </div>
        @endif
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #ef4444;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
            </div>
            <h3 style="margin-bottom: 8px; font-weight: 700; color: #1e293b;">Hapus Kuota?</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">
                Anda yakin ingin menghapus kuota <strong id="deleteTarget"></strong>? <br>Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button onclick="closeModal()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-weight: 600; color: #64748b; cursor: pointer;">Batal</button>
                <button id="confirmDeleteBtn" style="padding: 10px 20px; border-radius: 8px; border: none; background: #ef4444; font-weight: 600; color: white; cursor: pointer;">Hapus</button>
            </div>
        </div>
    </div>

    <script>
        // Auto Hide Alert
        setTimeout(() => {
            const alert = document.getElementById('alert-success');
            if(alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        // Toggle Accordion Detail
        function toggleDetail(rowId) {
            const row = document.getElementById(rowId);
            if (row.style.display === "table-row") {
                row.style.display = "none";
            } else {
                row.style.display = "table-row";
            }
        }

        // Modal Logic
        function showDeleteModal(event, bulan) {
            event.preventDefault();
            document.getElementById('deleteTarget').innerText = bulan;
            document.getElementById('deleteModal').style.display = 'block';
            
            const form = event.target.closest('form');
            document.getElementById('confirmDeleteBtn').onclick = function() {
                form.submit();
            };
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) closeModal();
        }
    </script>
@endsection