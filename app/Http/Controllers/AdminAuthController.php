<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        /*
        |--------------------------------------------------------------------------
        | 1️⃣ Coba login sebagai Super Admin (guard admin)
        |--------------------------------------------------------------------------
        */
        if (Auth::guard('admin')->attempt($request->only('username', 'password'), $remember)) {

            /** @var \App\Models\Admin $admin */
            $admin = Auth::guard('admin')->user();

            // ✅ anti session fixation
            $request->session()->regenerate();

            // cek approval (khusus akun admin/super admin lama)
            if (method_exists($admin, 'isApproved') && !$admin->isApproved()) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'username' => 'Akun Anda masih menunggu persetujuan Super Admin.'
                ]);
            }

            return redirect()->route('admin.dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Coba login sebagai User biasa (guard web)
        |--------------------------------------------------------------------------
        */
        $user = User::where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // ❗ Pastikan rolenya admin
            if ($user->role === 'admin') {

                Auth::login($user, $remember);
                $request->session()->regenerate();

                return redirect()->route('admin.dashboard');
            }

            return back()->withErrors([
                'username' => 'Akun ini bukan admin.'
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.'
        ])->onlyInput('username');
    }

    /**
     * Register admin publik dimatikan.
     */
    public function showRegisterForm()
    {
        abort(404);
    }

    public function register(Request $request)
    {
        abort(404);
    }

    public function logout(Request $request)
    {
        // 🔥 Logout super admin (guard admin)
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        // 🔥 Logout admin dari user biasa (guard web)
        if (Auth::check()) {
            Auth::logout();
        }

        // 🔥 Bersihkan session total
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}