<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardSiswaController extends Controller
{
    public function dashboard()
    {
        $siswa = Auth::guard('siswa')->user(); // ✅ ambil siswa login
        return view('siswa.dashboard', compact('siswa'));
    }

    public function dataSiswa()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.datasiswa.index', compact('siswa'));
    }

    public function dataOrangtua()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.dataortu.index', compact('siswa'));
    }

    public function kartuPelajar()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.kartupelajar.index', compact('siswa'));
    }

    public function konseling()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.konseling.index', compact('siswa'));
    }

    public function dokumenSiswa()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.dokumensiswa.index', compact('siswa'));
    }

    public function gantiPassword()
    {
        return view('siswa.ganti-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $siswa = Auth::guard('siswa')->user();

        if (!Hash::check($request->password_lama, $siswa->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }

        $siswa->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return back()->with('success', 'Password berhasil diperbarui');
    }
}
