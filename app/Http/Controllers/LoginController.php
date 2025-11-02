<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Tampilkan halaman login umum
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Proses login untuk semua role (admin, bk, siswa)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // 🧩 1️⃣ Coba login sebagai admin/bk dari tabel users (guard web)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'bk') {
                return redirect()->intended(route('bk.dashboard'));
            }
        }

        // 🧩 2️⃣ Coba login sebagai siswa dari tabel siswas (guard siswa)
        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('siswa.dashboard'));
        }

        // ❌ Jika semua gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout user dari guard manapun
     */
    public function logout(Request $request)
    {
        // Logout dari semua guard agar bersih
        Auth::guard('web')->logout();
        Auth::guard('siswa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
