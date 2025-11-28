<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;

class DashboardWaliController extends Controller
{
    // Halaman dashboard wali kelas
   public function dashboard()
{
    $rombel = auth('guru')->user()->walikelas;

    $siswa = Siswa::where('rombel', $rombel)->get();

    return view('walikelas.dashboard', [
        'totalSiswa'      => $siswa->count(),
        'totalLaki'       => $siswa->where('jenis_kelamin', 'Laki-Laki')->count(),
        'totalPerempuan'  => $siswa->where('jenis_kelamin', 'Perempuan')->count(),
        'dokumenBelum'    => $siswa->where('dokumen_lengkap', 0)->count(), 
    ]);
}


 public function listSiswa(Request $request)
    {
        $rombel = auth('guru')->user()->walikelas;

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

    // dokumen siswa wali kelas
    public function dokumen()
    {
        $guru = auth('guru')->user();
        $kelas = $guru->wali_kelas;

        $siswa = Siswa::where('rombel', $kelas)->get();

        return view('walikelas.dokumen', compact('kelas', 'siswa'));
    }
}
