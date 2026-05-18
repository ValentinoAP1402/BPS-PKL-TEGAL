<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Super admin dari guard admin (tabel admins)
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            if ($admin && method_exists($admin, 'isSuperAdmin') && $admin->isSuperAdmin()) {
                return $next($request);
            }
        }

        // ✅ Super admin dari web user (tabel users)
        $user = Auth::user();
        if ($user && $user->role === 'super_admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized. Super Admin access required.');
    }
}