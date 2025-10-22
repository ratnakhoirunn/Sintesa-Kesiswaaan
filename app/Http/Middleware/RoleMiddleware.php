<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Kalau belum login → arahkan ke halaman login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Kalau role user tidak cocok → tolak akses
        if (Auth::user()->role !== $role) {
            return redirect('/login')->withErrors([
                'akses' => 'Akses ditolak, kamu tidak memiliki izin untuk halaman ini.'
            ]);
        }

        // Lanjutkan request
        return $next($request);
    }
}
