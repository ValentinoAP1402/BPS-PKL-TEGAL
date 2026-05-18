<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminPortalAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1️⃣ Super Admin (guard admin)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // 2️⃣ User biasa yang rolenya admin
        if (Auth::check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Kalau belum login
        return redirect()->route('admin.login');
    }
}