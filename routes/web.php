<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KuotaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserAuthController;


// Route baru untuk beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Informasi PKL - Redirect to home since content is merged
Route::get('/informasi', function () {
    return redirect()->route('home');
});


// Google Auth Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// User Auth Routes
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [UserAuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [UserAuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [UserAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [UserAuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');
});

// Halaman Depan
Route::middleware('auth')->group(function () {
    Route::get('/daftar', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/surat-mitra-signed', [PendaftaranController::class, 'suratMitraSigned'])->name('pendaftaran.surat_mitra_signed');
    Route::get('/surat-mitra/preview/{id}', [PendaftaranController::class, 'previewSuratMitra'])->name('surat.mitra.preview');
    Route::get('/surat-mitra/download/{id}', [PendaftaranController::class, 'downloadSuratMitra'])->name('surat.mitra.download');
    Route::get('/check-quota', [PendaftaranController::class, 'checkQuota'])->name('check.quota');
});

// API Route for quota checking
Route::get('/api/check-quota', [PendaftaranController::class, 'checkQuota'])->name('api.check-quota');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth.admin', 'auth.admin.approved'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/alert-message', [AdminController::class, 'alertMessage'])->name('alert_message');
    Route::post('/alert-message/update', [AdminController::class, 'updateAlertMessage'])->name('alert_message.update');

    Route::get('/pendaftarans', [AdminController::class, 'listPendaftarans'])->name('pendaftarans.index');
    Route::get('/pendaftarans/{id}/download-surat-tanda-tangan', [AdminController::class, 'downloadSuratTandaTangan'])->name('pendaftarans.download-surat-tanda-tangan');
    Route::post('/pendaftarans/{id}/upload-surat-balasan', [AdminController::class, 'uploadSuratBalasan'])->name('pendaftarans.uploadSuratBalasan');
    Route::delete('/pendaftarans/{id}/delete-surat-balasan', [AdminController::class, 'deleteSuratBalasan'])->name('pendaftarans.deleteSuratBalasan');
    Route::post('/pendaftarans/{id}/approve', [AdminController::class, 'approvePendaftaran'])->name('pendaftarans.approve');
    Route::post('/pendaftarans/{id}/reject', [AdminController::class, 'rejectPendaftaran'])->name('pendaftarans.reject');
    Route::post('/pendaftarans/{pendaftaran}/complete', [AdminController::class, 'completePendaftaran'])->name('pendaftarans.complete'); // Rute baru
    Route::delete('/pendaftarans/{pendaftaran}', [AdminController::class, 'destroyPendaftaran'])->name('pendaftarans.destroy'); // Rute baru (menggunakan DELETE method)

    Route::resource('kuotas', KuotaController::class); // Akan kita buat KuotaController

    // Alumni PKL Routes
    Route::get('/alumni-pkl', [AdminController::class, 'alumniPklIndex'])->name('alumni_pkl.index');
    Route::get('/alumni-pkl/create', [AdminController::class, 'alumniPklCreate'])->name('alumni_pkl.create');
    Route::post('/alumni-pkl', [AdminController::class, 'alumniPklStore'])->name('alumni_pkl.store');
    Route::get('/alumni-pkl/{id}/edit', [AdminController::class, 'alumniPklEdit'])->name('alumni_pkl.edit');
    Route::put('/alumni-pkl/{id}', [AdminController::class, 'alumniPklUpdate'])->name('alumni_pkl.update');
    Route::delete('/alumni-pkl/{id}', [AdminController::class, 'alumniPklDestroy'])->name('alumni_pkl.destroy');
    Route::post('/alumni-pkl/{id}/toggle-status', [AdminController::class, 'alumniPklToggleStatus'])->name('alumni_pkl.toggle_status');

    // Super Admin Routes
    Route::middleware('auth.admin.super')->group(function () {
        Route::get('/user-roles', [SuperAdminController::class, 'manageUsers'])
            ->name('user_roles.index');

        Route::put('/user-roles/user/{userId}', [SuperAdminController::class, 'updateUserRole'])
            ->name('user_roles.update_user');

        Route::put('/user-roles/admin/{adminId}', [SuperAdminController::class, 'updateAdminRole'])
            ->name('user_roles.update_admin');

        Route::post('/user-roles/admin/{adminId}/approve', [SuperAdminController::class, 'approveAdmin'])
            ->name('user_roles.approve_admin');

        Route::post('/user-roles/admin/{adminId}/reject', [SuperAdminController::class, 'rejectAdmin'])
            ->name('user_roles.reject_admin');

        Route::delete('/user-roles/user/{userId}', [SuperAdminController::class, 'deleteUser'])
            ->name('user_roles.delete_user');

        Route::delete('/user-roles/admin/{adminId}', [SuperAdminController::class, 'deleteAdmin'])
            ->name('user_roles.delete_admin');

    // Opsional: Route untuk tambah admin baru
    Route::post('/user-roles', [SuperAdminController::class, 'createUser'])
        ->name('user_roles.store');
});
});
