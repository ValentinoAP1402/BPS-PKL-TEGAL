<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Bisa lewat guard admin (tabel admins)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // ✅ Bisa lewat web user (tabel users) dengan role admin/super_admin
        $user = Auth::user();
        if ($user && in_array($user->role, ['admin', 'super_admin'])) {
            return $next($request);
        }

        // Untuk request AJAX / API
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->route('admin.login');
    }
}