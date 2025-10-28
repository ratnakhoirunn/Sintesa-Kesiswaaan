<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{
    public function dashboard()
    {
        return view('siswa.dashboard');
    }

    public function dataSiswa()
    {
        return view('siswa.datasiswa.index');
    }

    public function dataOrangtua()
    {
        return view('siswa.dataortu.index');
    }

    public function kartuPelajar()
    {
        return view('siswa.kartupelajar.index');
    }

    public function konseling()
    {
        return view('siswa.konseling.index');
    }

    public function dokumenSiswa()
    {
        return view('siswa.dokumensiswa.index');
    }
}
