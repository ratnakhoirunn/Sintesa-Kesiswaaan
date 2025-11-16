<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\Siswa;

class AuthController extends Controller
{
    /**
     * 🔹 Proses login untuk semua role
     */
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Cek di tabel guru (berdasarkan NIP)
    $guru = Guru::where('nip', $request->username)->first();
    if ($guru && Hash::check($request->password, $guru->password)) {
        Auth::guard('guru')->login($guru);
        $request->session()->regenerate();
        
    
        // Arahkan sesuai role
        switch ($guru->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru_bk':
                return redirect()->route('bk.dashboard');
            case 'kesiswaan':
                return redirect()->route('kesiswaan.dashboard');
            default:
                return redirect()->route('guru.dashboard');
        }
    }

    // Cek di tabel siswa (berdasarkan NIS)
    $siswa = Siswa::where('nis', $request->username)->first();
    if ($siswa && Hash::check($request->password, $siswa->password)) {
        Auth::guard('siswa')->login($siswa);
        $request->session()->regenerate();

        // Cek apakah password default
        if (Hash::check('siswa123', $siswa->password)) {
            session(['default_password' => true]);
        } else {
            session()->forget('default_password');
        }

        return redirect()->route('siswa.dashboard');
    }

    // Kalau gak cocok dua-duanya
    return back()->withErrors(['login_error' => 'NIP/NIS atau password salah.']);
}

    /**
     * 🔹 Logout untuk semua role
     */
    public function logout(Request $request)
    {
        if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
        }

        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
