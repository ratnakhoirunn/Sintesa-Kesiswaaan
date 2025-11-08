<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // ✅ benar

use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{
    public function dashboard()
{    
    $siswa = Auth::guard('siswa')->user();
    return view('siswa.dashboard', compact('siswa'));
}

     public function dataSiswa()
    {
        // Ambil data siswa dari guard siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Kirim ke view
        return view('siswa.datasiswa.index', compact('siswa'));
    }

    public function dataOrangtua()
    {
       // Ambil data siswa dari guard siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Kirim ke view
        return view('siswa.dataortu.index', compact('siswa'));
    }

    public function kartuPelajar()
    {
        // Ambil data siswa dari guard siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Kirim ke view
        return view('siswa.kartupelajar.preview', compact('siswa'));
    }

    public function frame($nis)
{
    $siswa = Auth::guard('siswa')->user();

    // Pastikan hanya bisa melihat kartunya sendiri
    if ($siswa->nis !== $nis) {
        abort(403, 'Tidak diizinkan melihat kartu siswa lain.');
    }

    return view('siswa.kartupelajar.frame', compact('siswa'));
}


    public function konseling()
    {
        return view('siswa.konseling.index');
    }

    public function keterlambatan()
    {
        return view('siswa.keterlambatan.index');
    }

    public function dokumenSiswa()
    {
       // Ambil data siswa dari guard siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Kirim ke view
        return view('siswa.dokumensiswa.index', compact('siswa'));
    }
}
