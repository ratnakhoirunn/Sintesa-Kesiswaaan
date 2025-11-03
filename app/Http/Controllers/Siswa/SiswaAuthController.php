<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAuthController extends Controller
{
    // 🔹 Halaman login siswa
    public function showLoginForm()
    {
        return view('siswa.login');
    }

    // 🔹 Proses login siswa
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        // Gunakan guard 'web' karena password siswa disimpan di tabel users/roles
        if (Auth::guard('web')->attempt([
            'username' => $request->nis,  // ganti sesuai kolom username di tabel roles/users
            'password' => $request->password,
        ])) {
            $user = Auth::guard('web')->user();

            // Pastikan role-nya siswa
            if ($user->role === 'siswa') {
                $request->session()->regenerate();
                return redirect()->route('siswa.dashboard');
            } else {
                Auth::guard('web')->logout();
                return back()->withErrors(['nis' => 'Akun ini bukan akun siswa.']);
            }
        }

        return back()->withErrors(['nis' => 'NIS atau password salah.']);
    }

    // 🔹 Logout siswa
    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // logout dari guard web, bukan siswa
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('siswa.login');
    }
}
