<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika login pakai guard admin -> tetap wajib approved
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            if (!$admin || !$admin->isApproved()) {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')
                    ->withErrors(['message' => 'Akun Anda masih menunggu persetujuan Super Admin.']);
            }

            return $next($request);
        }

        // Jika login pakai web user -> cukup role admin/super_admin
        $user = Auth::user();
        if ($user && in_array($user->role, ['admin', 'super_admin'])) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}