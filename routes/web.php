<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HistoryPendaftarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KuotaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Public / User Routes
|--------------------------------------------------------------------------
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Informasi PKL - Redirect ke home
Route::get('/informasi', function () {
    return redirect()->route('home');
});

// Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// User Auth
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', [UserAuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [UserAuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [UserAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [UserAuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Profile (User)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Pendaftaran (User Area)
Route::middleware('auth')->group(function () {
    Route::get('/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Surat balasan user (preview/download)
    Route::get('/surat-balasan/preview', [PendaftaranController::class, 'previewSuratBalasan'])
        ->name('pendaftaran.surat_balasan.preview');

    Route::get('/surat-balasan/download', [PendaftaranController::class, 'downloadSuratBalasan'])
        ->name('pendaftaran.surat_balasan.download');

    // Surat mitra
    Route::get('/surat-mitra-signed', [PendaftaranController::class, 'suratMitraSigned'])->name('pendaftaran.surat_mitra_signed');
    Route::get('/surat-mitra/preview/{id}', [PendaftaranController::class, 'previewSuratMitra'])->name('surat.mitra.preview');
    Route::get('/surat-mitra/download/{id}', [PendaftaranController::class, 'downloadSuratMitra'])->name('surat.mitra.download');

    // Quota
    Route::get('/check-quota', [PendaftaranController::class, 'checkQuota'])->name('check.quota');
});

// API quota
Route::get('/api/check-quota', [PendaftaranController::class, 'checkQuota'])->name('api.check-quota');


/*
|--------------------------------------------------------------------------
| Admin Auth Routes (1 pintu login: /admin/login)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.post');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| ✅ admin.portal = boleh masuk jika:
| - Super Admin: Auth::guard('admin')->check()
| - Admin dari User: Auth::check() && auth()->user()->role === 'admin'
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['admin.portal'])->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Alert message
    Route::get('/alert-message', [AdminController::class, 'alertMessage'])->name('alert_message');
    Route::post('/alert-message/update', [AdminController::class, 'updateAlertMessage'])->name('alert_message.update');

    // Pendaftarans
    Route::get('/pendaftarans', [AdminController::class, 'listPendaftarans'])->name('pendaftarans.index');

    // Surat PKL pelamar
    Route::get('/pendaftarans/{id}/surat-pkl/preview', [AdminController::class, 'previewSuratPkl'])
        ->name('pendaftarans.surat_pkl.preview');
    Route::get('/pendaftarans/{id}/surat-pkl/download', [AdminController::class, 'downloadSuratPkl'])
        ->name('pendaftarans.surat_pkl.download');

    // Surat Balasan
    Route::get('/pendaftarans/{id}/surat-balasan/preview', [AdminController::class, 'previewSuratBalasan'])
        ->name('pendaftarans.surat_balasan.preview');
    Route::get('/pendaftarans/{id}/surat-balasan/download', [AdminController::class, 'downloadSuratBalasan'])
        ->name('pendaftarans.surat_balasan.download');

    // Replace surat balasan
    Route::post('/pendaftarans/{id}/surat-balasan/replace', [AdminController::class, 'replaceSuratBalasan'])
        ->name('pendaftarans.surat_balasan.replace');

    // Surat tanda tangan
    Route::get('/pendaftarans/{id}/download-surat-tanda-tangan', [AdminController::class, 'downloadSuratTandaTangan'])
        ->name('pendaftarans.download-surat-tanda-tangan');

    // Upload/Hapus surat balasan
    Route::post('/pendaftarans/{id}/upload-surat-balasan', [AdminController::class, 'uploadSuratBalasan'])
        ->name('pendaftarans.uploadSuratBalasan');
    Route::delete('/pendaftarans/{id}/delete-surat-balasan', [AdminController::class, 'deleteSuratBalasan'])
        ->name('pendaftarans.deleteSuratBalasan');

    // Approve / Reject / Complete / Delete pendaftaran
    Route::post('/pendaftarans/{id}/approve', [AdminController::class, 'approvePendaftaran'])
        ->name('pendaftarans.approve');
    Route::post('/pendaftarans/{id}/reject', [AdminController::class, 'rejectPendaftaran'])
        ->name('pendaftarans.reject');
    Route::post('/pendaftarans/{pendaftaran}/complete', [AdminController::class, 'completePendaftaran'])
        ->name('pendaftarans.complete');
    Route::delete('/pendaftarans/{pendaftaran}', [AdminController::class, 'destroyPendaftaran'])
        ->name('pendaftarans.destroy');

    // Kuota
    Route::resource('kuotas', KuotaController::class);

    /*
    |--------------------------------------------------------------------------
    | History Pendaftar
    |--------------------------------------------------------------------------
    | Admin & Super Admin boleh lihat + export
    */
    Route::get('/history-pendaftar', [HistoryPendaftarController::class, 'index'])
        ->name('history_pendaftar.index');

    Route::get('/history-pendaftar/export-excel', [HistoryPendaftarController::class, 'exportExcel'])
        ->name('history_pendaftar.export_excel');

    Route::get('/history-pendaftar/export-pdf', [HistoryPendaftarController::class, 'exportPdf'])
        ->name('history_pendaftar.export_pdf');

    /*
    |--------------------------------------------------------------------------
    | Super Admin Only
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth.admin.super')->group(function () {

        // ✅ Delete history permanen hanya super admin
        Route::delete('/history-pendaftar/{id}', [HistoryPendaftarController::class, 'destroy'])
            ->name('history_pendaftar.destroy');

        // Role Pengguna
        Route::get('/user-roles', [SuperAdminController::class, 'manageUsers'])->name('user_roles.index');

        Route::put('/user-roles/user/{userId}', [SuperAdminController::class, 'updateUserRole'])->name('user_roles.update_user');
        Route::put('/user-roles/admin/{adminId}', [SuperAdminController::class, 'updateAdminRole'])->name('user_roles.update_admin');

        Route::post('/user-roles/admin/{adminId}/approve', [SuperAdminController::class, 'approveAdmin'])->name('user_roles.approve_admin');
        Route::post('/user-roles/admin/{adminId}/reject', [SuperAdminController::class, 'rejectAdmin'])->name('user_roles.reject_admin');

        Route::delete('/user-roles/user/{userId}', [SuperAdminController::class, 'deleteUser'])->name('user_roles.delete_user');
        Route::delete('/user-roles/admin/{adminId}', [SuperAdminController::class, 'deleteAdmin'])->name('user_roles.delete_admin');

        Route::post('/user-roles', [SuperAdminController::class, 'createUser'])->name('user_roles.store');
    });
});