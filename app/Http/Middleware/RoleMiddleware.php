<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
   public function handle(Request $request, Closure $next, ...$roles)
{
    // Cek guard siswa dulu
    $guard = Auth::guard('siswa')->check() ? 'siswa' : 'web';

    $user = Auth::guard($guard)->user();

    if (!$user) {
        return redirect('/login');
    }

    // Kalau role tidak sesuai
    if (isset($user->role) && !in_array($user->role, $roles)) {
        return redirect('/login')->withErrors(['akses' => 'Akses ditolak']);
    }

    return $next($request);
}
}