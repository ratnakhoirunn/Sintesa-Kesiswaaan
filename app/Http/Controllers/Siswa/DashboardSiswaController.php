<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{
    // Dashboard siswa
    public function dashboard()
    {
        return view('siswa.dashboard');
    }

    // Data siswa
    public function dataSiswa()
    {
        return view('siswa.data');
    }

    // Data orang tua
    public function dataOrangtua()
    {
        return view('siswa.orangtua');
    }

    // Kartu pelajar
    public function kartuPelajar()
    {
        return view('siswa.kartu');
    }

    // Bimbingan konseling
    public function konseling()
    {
        return view('siswa.konseling');
    }

    // Administrasi siswa
    public function administrasi()
    {
        return view('siswa.administrasi');
    }
}
