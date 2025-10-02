<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Konseling;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Mengambil data dari database
        $totalSiswa = Siswa::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKonseling = Konseling::count();

        // Mengirim data ke tampilan (view)
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalAdmin',
            'totalKonseling'
        ));
    }

    public function siswaDashboard()
    {
        // Logika untuk dashboard siswa
        return view('siswa.dashboard');
    }

    // 📌 Menu Data Siswa
    public function dataSiswa()
    {
        return view('admin.datasiswa.index');
    }

    // 📌 Menu Kartu Pelajar
    public function kartuPelajar()
    {
        return view('admin.kartupelajar.index');
    }

    // 📌 Menu Bimbingan Konseling
    public function konseling()
    {
        return view('admin.konseling.index');
    }

    public function keterlambatan()
    {
        return view('admin.keterlambatan.index');
    }

    // 📌 Menu Dokumen Siswa
    public function dokumenSiswa()
    {
        return view('admin.dokumensiswa.index');
    }

    // 📌 Menu Manajemen Role
    public function role()
    {
        return view('admin.role.index');
    }
}
