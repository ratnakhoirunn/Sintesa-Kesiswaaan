<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Konseling;
use Illuminate\Support\Facades\DB;
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

        // === Data untuk Chart: Jumlah siswa per jurusan ===
        // Ubah 'jurusan' jika nama kolom di tabel siswa kamu berbeda
        $chartData = Siswa::select('jurusan', DB::raw('COUNT(*) as total'))
            ->groupBy('jurusan')
            ->orderBy('jurusan')
            ->get();

        // Kirim semua data ke view dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalAdmin',
            'totalKonseling',
            'chartData'
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
        $search = $request->input('search');

        $siswas = Siswa::when($search, function ($query, $search) {
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
        })
        ->orderBy('nama_lengkap')
        ->paginate(10);

        return view('admin.kartupelajar.index', compact('siswas', 'search'));
    }

    public function kartuPelajar()
    {
        $siswas = Siswa::all();
        return view('admin.kartupelajar.index', compact('siswas'));
    }

    /** ===============================
     *  MANAJEMEN KONSELING
     *  =============================== */
    public function konseling()
    {
        return view('admin.konseling.index');
    }

    /** ===============================
     *  MANAJEMEN MANAJEMEN ROLE
     *  =============================== */
    public function role()
    {
        return view('admin.role.index'); 
    }
}
