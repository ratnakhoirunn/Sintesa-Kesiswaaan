<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Konseling;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\Keterlambatan;

class DashboardController extends Controller
{
    /** ===============================
     *  DASHBOARD ADMIN & SISWA
     *  =============================== */
    public function adminDashboard(Request $request)
    {
        /** ===============================
         *  STATISTIK UMUM
         *  =============================== */
        $totalSiswa = Siswa::count();
        $totalAdmin = Guru::where('role', 'admin')->count();
        $totalKonseling = Konseling::count();
        $konselingMenunggu = Konseling::where('status', 'Menunggu')->count();
        $keterlambatanBaru = Keterlambatan::where('status', 'pending')->count();

        /** ===============================
         *  FILTER ANGKATAN
         *  =============================== */
        $filterTahun = $request->get('angkatan'); // contoh: 2025
        $kodeTahun = $filterTahun ? substr($filterTahun, -2) : null;

        /** ===============================
         *  DAFTAR ANGKATAN (ORM MURNI)
         *  =============================== */
        $angkatanList = Siswa::pluck('nis')
            ->map(fn ($nis) => 2000 + (int) substr($nis, 0, 2))
            ->unique()
            ->sort()
            ->values();

        /** ===============================
         *  DATA SISWA (FILTER OPSIONAL)
         *  =============================== */
        $siswaQuery = Siswa::query();

        if ($kodeTahun) {
            $siswaQuery->where('nis', 'like', $kodeTahun . '%');
        }

        $siswa = $siswaQuery->get();

        /** ===============================
         *  DATA CHART (GROUP BY DI PHP)
         *  =============================== */
        $chartData = $siswa
            ->groupBy('jurusan')
            ->map(function ($items, $jurusan) {
                return [
                    'jurusan' => $jurusan,
                    'total'   => $items->count(),
                ];
            })
            ->values();

        /** ===============================
         *  KIRIM KE VIEW
         *  =============================== */
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalAdmin',
            'totalKonseling',
            'konselingMenunggu',
            'keterlambatanBaru',
            'angkatanList',
            'filterTahun',
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
