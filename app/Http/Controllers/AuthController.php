<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Siswa;

class AuthController extends Controller
{
    /**
     * 🔹 Proses login untuk semua role
     */
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $role = $request->role;

        // ===============================
        // Login untuk ADMIN / GURU / BK
        // ===============================
        if (in_array($role, ['admin', 'guru', 'bk'])) {
            $user = User::where('username', $request->username)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);

                // Redirect sesuai role
                if (in_array($user->role, ['admin', 'guru', 'bk'])) {
                    return redirect()->route('admin.dashboard');
                }
            }

            return back()->withErrors(['login_error' => 'Username atau password salah.']);
        }

        // ===============================
        // Login untuk SISWA
        // ===============================
        if ($role === 'siswa') {
            $siswa = Siswa::where('nis', $request->username)->first();
            
            if ($siswa && Hash::check($request->password, $siswa->password)) {
                // login siswa dengan guard siswa
                Auth::guard('siswa')->login($siswa);

                // regenerate session supaya guard siswa dikenali
                $request->session()->regenerate();

                return redirect()->route('siswa.dashboard');
            }

    return back()->withErrors(['login_error' => 'NIS atau password salah.']);
}

        // Jika role tidak dikenali
        return back()->withErrors(['login_error' => 'Role tidak valid.']);
    }

    /**
     * 🔹 Logout untuk semua role
     */
    public function logout(Request $request)
    {
        // Logout untuk siswa
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        // Logout untuk admin/guru/bk
        if (Auth::check()) {
            Auth::logout();
        }

        // Hapus semua session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
