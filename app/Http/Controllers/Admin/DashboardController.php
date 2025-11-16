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
    public function adminDashboard(Request $request)
    {
        // Ambil data statistik untuk dashboard admin
        $totalSiswa = Siswa::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKonseling = Konseling::count();

 // Ambil filter angkatan dari query string (?angkatan=2025)
    $filterTahun = $request->get('angkatan');

    // Ambil daftar angkatan unik dari 2 digit depan NIS dan ubah jadi format tahun penuh
    $angkatanList = Siswa::selectRaw('LEFT(nis, 2) as kode')
        ->distinct()
        ->get()
        ->map(function ($item) {
            return 2000 + (int)$item->kode; // contoh: 25 => 2025
        })
        ->sort()
        ->values();

    // Hitung statistik umum
    $totalSiswa = Siswa::count();
    $totalAdmin = User::where('role', 'admin')->count();
    $konselingMenunggu = Konseling::where('status', 'Menunggu')->count();


    // === Data untuk Chart: Jumlah siswa per jurusan ===
    $query = Siswa::select('jurusan', DB::raw('COUNT(*) as total'));

    // Jika filter angkatan dipilih, ubah tahun jadi dua digit dan filter
    if ($filterTahun) {
        $kodeTahun = substr($filterTahun, -2); // contoh: 2025 -> 25
        $query->whereRaw('LEFT(nis, 2) = ?', [$kodeTahun]);
    }

    $chartData = $query
        ->groupBy('jurusan')
        ->orderBy('jurusan')
        ->get();

    // Kirim data ke view dashboard
    return view('admin.dashboard', compact(
        'totalSiswa',
        'totalAdmin',
        'totalKonseling',
        'chartData',
        'angkatanList',
        'filterTahun',
        'konselingMenunggu',
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
