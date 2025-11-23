<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminApprovedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\Admin $user */
        $user = auth('admin')->user();

        if (!$user || !$user->isApproved()) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->withErrors(['message' => 'Akun Anda masih menunggu persetujuan Super Admin.']);
        }

        return $next($request);
    }
}
