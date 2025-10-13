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
    /** ===============================
     *  DASHBOARD ADMIN & SISWA
     *  =============================== */
    public function adminDashboard()
    {
        // Ambil data statistik untuk dashboard admin
        $totalSiswa = Siswa::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKonseling = Konseling::count();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalAdmin',
            'totalKonseling'
        ));
    }

    public function siswaDashboard()
    {
        return view('siswa.dashboard');
    }

    /** ===============================
     *  DATA SISWA
     *  =============================== */
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

    /** ===============================
     *  MANAJEMEN KARTU PELAJAR
     *  =============================== */
    public function manajemenKartu(Request $request)
    {
        // Jika nanti mau ditambah fitur search
        $search = $request->input('search');

        $siswas = Siswa::when($search, function ($query, $search) {
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
        })
        ->orderBy('nama_lengkap')
        ->paginate(10); // pakai paginate biar rapi

        return view('admin.kartupelajar.index', compact('siswas', 'search'));
    }

    public function kartuPelajar()
{
    $siswas = Siswa::all();
    return view('admin.kartupelajar.index', compact('siswas'));
}

}
