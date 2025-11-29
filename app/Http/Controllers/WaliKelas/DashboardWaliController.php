<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class DashboardWaliController extends Controller
{
    // DASHBOARD WALI KELAS
    public function dashboard()
    {
        // Ambil wali kelas dari guru yang sedang login
        $rombel = auth('guru')->user()->wali_kelas ?? auth('guru')->user()->walikelas;

        $siswa = Siswa::where('rombel', $rombel)->get();

        return view('walikelas.dashboard', [
            'totalSiswa'      => $siswa->count(),
            'totalLaki'       => $siswa->where('jenis_kelamin', 'Laki-Laki')->count(),
            'totalPerempuan'  => $siswa->where('jenis_kelamin', 'Perempuan')->count(),
            'dokumenBelum'    => $siswa->where('dokumen_lengkap', 0)->count(),
        ]);
    }


    // LIST SISWA WALI KELAS
    public function listSiswa(Request $request)
    {
        $rombel = auth('guru')->user()->wali_kelas ?? auth('guru')->user()->walikelas;

        $query = Siswa::where('rombel', $rombel);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%");
            });
        }

        $siswas = $query->paginate(10);
        $jumlah = $query->count();

        return view('walikelas.datasiswa.siswa', compact('siswas', 'jumlah', 'rombel'));
    }


    // DOKUMEN SISWA WALI KELAS
    public function dokumen(Request $request)
    {
        $guru = auth('guru')->user();

        // gunakan wali_kelas atau walikelas (antisipasi perbedaan kolom)
        $rombel = $guru->wali_kelas ?? $guru->walikelas;

        // semua siswa dalam rombel wali kelas
        $query = Siswa::where('rombel', $rombel)->withCount('dokumenSiswa');

        // filter dokumen
        if ($request->dokumen) {
            $query->whereHas('dokumenSiswa', function ($q) use ($request) {
                $q->where('jenis_dokumen', $request->dokumen);
            });
        }

        // pencarian
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%");
            });
        }

        $siswa = $query->paginate(10);

        // jumlah dokumen wajib (misal 5)
        $totalDokumenWajib = 5;

        return view('walikelas.dokumensiswa.index', compact('siswa', 'totalDokumenWajib'));
    }
}
