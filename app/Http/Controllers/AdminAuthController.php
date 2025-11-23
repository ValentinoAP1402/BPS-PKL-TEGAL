<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

       if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // Check if admin is approved
        if (!$admin->isApproved()) {
            Auth::guard('admin')->logout();
            return back()->withErrors(['username' => 'Akun Anda masih menunggu persetujuan Super Admin.']);
        }

        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Default role for new registrations
            'status' => 'pending', // New admins need approval
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun admin berhasil dibuat dan menunggu persetujuan Super Admin. Silakan login setelah disetujui.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
