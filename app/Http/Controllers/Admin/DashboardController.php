<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

// Import Models
use App\Models\guru; // Pastikan nama model sesuai (Guru / guru)
use App\Models\Siswa;
use App\Models\Konseling;
use App\Models\Keterlambatan;
use App\Imports\SiswaImport;

class DashboardController extends Controller
{
    /** ===============================
     * DASHBOARD ADMIN
     * =============================== */
    public function adminDashboard(Request $request)
    {
        // === 1. DATA CARD UTAMA ===
        $totalSiswa     = Siswa::count();
        $totalAdmin     = guru::where('role', 'admin')->count();
        $totalKonseling = Konseling::count();

        // === 2. DOKUMEN SISWA (Progress Bar) ===
        $sudahUpload = 0;
        // Cek tabel dokumen_siswas atau dokumen_siswa (antisipasi nama tabel beda)
        if (Schema::hasTable('dokumen_siswas')) {
            $sudahUpload = DB::table('dokumen_siswas')->distinct('nis')->count('nis');
        } elseif (Schema::hasTable('dokumen_siswa')) {
            $sudahUpload = DB::table('dokumen_siswa')->distinct('nis')->count('nis');
        }

        $belumUpload = max(0, $totalSiswa - $sudahUpload);
        $persenBelum = $totalSiswa > 0 ? number_format(($belumUpload / $totalSiswa) * 100, 1) : 0;

        // === 3. NOTIFIKASI BAWAH (Konseling, Keterlambatan, Prestasi) ===
        $konselingMenunggu = Konseling::whereIn('status', ['Menunggu', 'pending'])->count();
        
        $keterlambatanBaru = 0;
        if (Schema::hasTable('keterlambatans')) {
            $keterlambatanBaru = Keterlambatan::where('status', 'pending')->count();
        }

        $totalPrestasi = 0;
        if (Schema::hasTable('prestasis')) {
            $totalPrestasi = DB::table('prestasis')->count();
        }

        // === 4. CHART 1: SISWA PER JURUSAN (Filter Angkatan) ===
        $filterAngkatan = $request->get('angkatan');
        $querySiswa = Siswa::select('jurusan', DB::raw('COUNT(*) as total'));

        if ($filterAngkatan) {
            // Ambil 2 digit terakhir dari angkatan (misal 2025 -> 25)
            $kodeTahun = substr($filterAngkatan, -2);
            $querySiswa->whereRaw('LEFT(nis, 2) = ?', [$kodeTahun]);
        }
        $chartData = $querySiswa->groupBy('jurusan')->orderBy('jurusan')->get();

        // List Angkatan untuk Dropdown
        $angkatanList = Siswa::selectRaw('LEFT(nis, 2) as kode')
            ->distinct()->get()
            ->map(function ($item) { return 2000 + (int)$item->kode; })
            ->sortDesc()->values();


        // === 5. CHART 2: PIE CHART PRESTASI (Filter Tahun Prestasi) ===
        $chartPrestasi = [
            'Lomba' => 0,
            'Seminar' => 0,
            'Sertifikat' => 0,
            'Lainnya' => 0
        ];
        $tahunPrestasiList = collect([]); // Default kosong

        if (Schema::hasTable('prestasis')) {
            $filterTahunPrestasi = $request->get('tahun_prestasi');
            
            // Query Statistik Jenis Prestasi
            $queryPrestasi = DB::table('prestasis')
                ->select('jenis', DB::raw('count(*) as total'));

            if ($filterTahunPrestasi) {
                // Asumsi kolom tanggal bernama 'tanggal_prestasi' atau 'created_at'
                // Sesuaikan dengan nama kolom di tabel Anda
                $kolomTanggal = Schema::hasColumn('prestasis', 'tanggal_prestasi') ? 'tanggal_prestasi' : 'created_at';
                $queryPrestasi->whereYear($kolomTanggal, $filterTahunPrestasi);
            }
            
            $dataPrestasi = $queryPrestasi->groupBy('jenis')->get();

            foreach ($dataPrestasi as $p) {
                // Normalisasi nama jenis (huruf besar awal)
                $jenis = ucfirst(strtolower($p->jenis));
                
                if (array_key_exists($jenis, $chartPrestasi)) {
                    $chartPrestasi[$jenis] = $p->total;
                } else {
                    $chartPrestasi['Lainnya'] += $p->total;
                }
            }

            // Ambil List Tahun untuk Dropdown
            $kolomTanggal = Schema::hasColumn('prestasis', 'tanggal_prestasi') ? 'tanggal_prestasi' : 'created_at';
            $tahunPrestasiList = DB::table('prestasis')
                ->selectRaw("YEAR($kolomTanggal) as tahun")
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');
        }

        // === RETURN VIEW ===
        return view('admin.dashboard', compact(
            'totalSiswa', 'totalAdmin', 'totalKonseling',
            'sudahUpload', 'belumUpload', 'persenBelum',
            'konselingMenunggu', 'keterlambatanBaru', 'totalPrestasi',
            'chartData', 'angkatanList',
            'chartPrestasi', 'tahunPrestasiList'
        ));
    }

    /** ===============================
     * DASHBOARD SISWA
     * =============================== */
    public function siswaDashboard()
    {
        return view('siswa.dashboard');
    }

    /** ===============================
     * DATA SISWA
     * =============================== */
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
     * MANAJEMEN KARTU PELAJAR
     * =============================== */
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
     * MANAJEMEN LAINNYA
     * =============================== */
    public function konseling()
    {
        return view('admin.konseling.index');
    }

    public function role()
    {
        return view('admin.role.index'); 
    }
}