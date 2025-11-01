<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAuthController extends Controller
{
    // 🔹 Tampilkan halaman login siswa
    public function showLoginForm()
    {
        return view('siswa.login'); // pastikan view-nya ada di resources/views/siswa/login.blade.php
    }

    // 🔹 Proses login siswa
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('siswa')->attempt([
            'nis' => $request->nis,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors(['nis' => 'NIS atau password salah.']);
    }

    // 🔹 Logout siswa
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('siswa.login');
    }
}
