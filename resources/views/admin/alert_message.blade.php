@extends('admin.layouts.app')

@section('title', 'Konfigurasi Peringatan')

{{-- BRANDING NAVBAR --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #d97706; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            {{-- Icon Alert --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">Pesan Peringatan</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Pengaturan banner informasi home</span>
        </div>
    </div>
@endsection

{{-- ACTIONS NAVBAR --}}
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
        /* Card Style */
        .config-card { 
            background: white; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0; 
            max-width: 600px; 
            margin: 20px auto; 
            padding: 32px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
        }

        .header-section { margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; }
        .card-title { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .card-desc { font-size: 0.85rem; color: #64748b; }

        /* Form Elements */
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 8px; }

        /* Modern Textarea */
        .modern-textarea { 
            width: 100%; padding: 14px; border: 1px solid #cbd5e1; border-radius: 10px; 
            font-size: 0.95rem; color: #1e293b; outline: none; transition: 0.2s; min-height: 120px; font-family: inherit; resize: vertical;
        }
        .modern-textarea:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }

        /* TOGGLE SWITCH STYLE */
        .toggle-wrapper { display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 16px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .toggle-label { font-size: 0.95rem; font-weight: 600; color: #1e293b; }
        .toggle-desc { font-size: 0.8rem; color: #64748b; display: block; margin-top: 2px; }
        
        .switch { position: relative; display: inline-block; width: 48px; height: 26px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        
        input:checked + .slider { background-color: #f59e0b; } /* Amber Color */
        input:checked + .slider:before { transform: translateX(22px); }

        /* Submit Button */
        .btn-save { 
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
            color: white; width: 100%; padding: 14px; border: none; 
            border-radius: 10px; font-weight: 600; font-size: 1rem; 
            cursor: pointer; transition: 0.2s; display: flex; 
            align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 10px -1px rgba(245, 158, 11, 0.4); }

        /* Preview Box */
        .preview-box { margin-top: 30px; border-top: 1px dashed #cbd5e1; padding-top: 24px; }
        .preview-title { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700; margin-bottom: 12px; }
        .alert-preview {
            background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 6px; color: #92400e; font-size: 0.95rem; display: flex; gap: 12px; align-items: flex-start;
        }

        /* Success Message */
        .success-banner { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
    </style>

    <div class="config-card">
        <div class="header-section">
            <h1 class="card-title">Pengaturan Pesan</h1>
            <p class="card-desc">Atur pesan peringatan yang muncul di halaman utama pendaftar.</p>
        </div>

        @if(session('success'))
            <div class="success-banner">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.alert_message.update') }}" method="POST">
            @csrf
            
            {{-- Toggle Switch --}}
            <div class="toggle-wrapper">
                <div>
                    <span class="toggle-label">Status Tampilan</span>
                    <span class="toggle-desc">Aktifkan untuk menampilkan pesan di dashboard user.</span>
                </div>
                <label class="switch">
                    {{-- Hidden input untuk mengirim nilai 0 jika checkbox tidak dicentang --}}
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" 
                        {{ old('is_active', optional($alertMessage)->is_active) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Konten Pesan</label>
                <textarea
                    id="message"
                    name="message"
                    class="modern-textarea"
                    placeholder="Tuliskan pesan peringatan di sini..."
                    required
                >{{ old('message', optional($alertMessage)->message) }}</textarea>
                @error('message')
                    <span style="color: #ef4444; font-size: 0.85rem; display: block; margin-top: 6px;">
                        ⚠️ {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-save">
                Simpan Konfigurasi
            </button>
        </form>

        {{-- Preview Section --}}
        @if($alertMessage && $alertMessage->message)
        <div class="preview-box">
            <div class="preview-title">Pratinjau Tampilan (Live Preview)</div>
            <div class="alert-preview" style="opacity: {{ optional($alertMessage)->is_active ? '1' : '0.5' }}; filter: {{ optional($alertMessage)->is_active ? 'none' : 'grayscale(100%)' }};">
                <svg style="flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <div>
                    <strong style="display: block; margin-bottom: 4px; color: #92400e;">Peringatan</strong>
                    <span style="line-height: 1.5;">{!! nl2br(e($alertMessage->message)) !!}</span>
                    @if(!optional($alertMessage)->is_active)
                        <div style="margin-top: 8px; font-size: 0.75rem; background: #e2e8f0; padding: 2px 8px; border-radius: 4px; display: inline-block; color: #64748b;">(Sedang Nonaktif)</div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection