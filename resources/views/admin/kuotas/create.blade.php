@extends('admin.layouts.app')

@section('title', 'Tambah Kuota Baru')

{{-- BRANDING NAVBAR --}}
@section('navbar-branding')
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 38px; height: 38px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
            {{-- Icon Plus --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </div>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em;">Tambah Kuota</span>
            <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Buka Slot Pendaftaran Baru</span>
        </div>
    </div>
@endsection

{{-- ACTIONS NAVBAR --}}
@section('navbar-actions')
    <a href="{{ route('admin.kuotas.index') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: white; color: #64748b; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: 1px solid #e2e8f0; transition: all 0.2s;">
        <span>✕</span> Batal
    </a>
@endsection

@section('content')
    <style>
        /* Card Style */
        .create-card { 
            background: white; 
            border-radius: 16px; 
            border: 1px solid #e2e8f0; 
            max-width: 550px; 
            margin: 20px auto; 
            padding: 32px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
            animation: fadeInUp 0.4s ease-out; 
        }

        .form-header { text-align: center; margin-bottom: 32px; }
        .form-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .form-desc { font-size: 0.9rem; color: #64748b; }

        /* Form Elements */
        .form-group { margin-bottom: 24px; }
        
        .form-label { 
            display: block; font-size: 0.9rem; font-weight: 600; color: #334155; 
            margin-bottom: 8px; 
        }
        
        .input-wrapper { position: relative; }
        
        .modern-input { 
            width: 100%; padding: 12px 16px; padding-left: 42px; /* Space for icon */
            border: 1px solid #cbd5e1; border-radius: 10px; 
            font-size: 0.95rem; color: #1e293b; outline: none; transition: 0.2s; 
        }
        
        .modern-input:focus { 
            border-color: #3b82f6; /* Blue focus */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); 
        }

        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }

        .modern-input:focus + .input-icon { color: #3b82f6; }

        /* Helper & Error */
        .helper-text { font-size: 0.8rem; color: #64748b; margin-top: 6px; display: flex; align-items: center; gap: 4px; }
        .error-msg { color: #ef4444; font-size: 0.85rem; margin-top: 6px; display: flex; align-items: center; gap: 4px; }

        /* Submit Button */
        .btn-submit { 
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); 
            color: white; width: 100%; padding: 14px; border: none; 
            border-radius: 10px; font-weight: 600; font-size: 1rem; 
            cursor: pointer; transition: 0.2s; display: flex; 
            align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 10px -1px rgba(59, 130, 246, 0.4); }

        /* Info Alert inside form */
        .info-alert {
            background: #eff6ff; border: 1px solid #dbeafe; border-radius: 8px;
            padding: 12px; margin-bottom: 24px; font-size: 0.85rem; color: #1e40af;
            display: flex; gap: 8px; align-items: flex-start;
        }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <div class="create-card">
        <div class="form-header">
            <h1 class="form-title">Formulir Kuota Baru</h1>
            <p class="form-desc">Silakan lengkapi data di bawah untuk membuka periode PKL baru.</p>
        </div>

        <div class="info-alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <span>
                Pastikan penulisan <strong>Nama Bulan</strong> sesuai format (Contoh: Januari 2025) agar mudah dicari.
            </span>
        </div>

        <form action="{{ route('admin.kuotas.store') }}" method="POST">
            @csrf
            
            {{-- Input Bulan --}}
            <div class="form-group">
                <label for="bulan" class="form-label">Nama Bulan & Tahun</label>
                <div class="input-wrapper">
                    <input 
                        type="text" 
                        id="bulan" 
                        name="bulan" 
                        class="modern-input"
                        value="{{ old('bulan') }}" 
                        placeholder="Contoh: Januari 2025" 
                        required
                    >
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                </div>
                @error('bulan')
                    <span class="error-msg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        {{ $message }}
                    </span>
                @else
                    <div class="helper-text">Format disarankan: [Nama Bulan] [Tahun]</div>
                @enderror
            </div>

            {{-- Input Jumlah Kuota --}}
            <div class="form-group">
                <label for="jumlah_kuota" class="form-label">Total Kapasitas (Slot)</label>
                <div class="input-wrapper">
                    <input 
                        type="number" 
                        id="jumlah_kuota" 
                        name="jumlah_kuota" 
                        class="modern-input"
                        value="{{ old('jumlah_kuota') }}" 
                        min="1" 
                        placeholder="Contoh: 50" 
                        required
                    >
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
                @error('jumlah_kuota')
                    <span class="error-msg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Simpan Kuota Baru
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </form>
    </div>
@endsection