<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Konseling;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;


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

    //Fungsi untuk Admin-Menu Data Siswa
    public function dataSiswa()
    {
        return view('admin.datasiswa.index');
    }

    public function showUploadSiswaForm()
    {
        return view('admin.datasiswa.upload_siswa');
    }

    public function importSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diunggah!');
    }

    

}