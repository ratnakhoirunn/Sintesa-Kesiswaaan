<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Method untuk menampilkan halaman login umum (siswa, guru)
    public function showLoginForm()
    {
        return view('login');
    }

    // Method untuk memproses login siswa/user
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Beritahu Laravel untuk login menggunakan kolom 'username'
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Cek peran (role) pengguna dan arahkan ke dashboard yang sesuai
            $userRole = Auth::user()->role;
            if ($userRole === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($userRole === 'siswa') {
                return redirect()->intended('/siswa/dashboard');
            } elseif ($userRole === 'bk') {
                return redirect()->intended('/bk/dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Method untuk memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}