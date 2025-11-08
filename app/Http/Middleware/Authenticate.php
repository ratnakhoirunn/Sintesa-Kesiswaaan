<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect($this->redirectTo($request));
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('siswa/*')) {
                return route('login'); // bisa kamu ubah ke route siswa.login kalau ada halaman login terpisah
            }
            return route('login');
        }
    }
}
