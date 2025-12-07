<?php

namespace App\Http\Controllers\Walikelas;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;


class WaliPrestasiController extends Controller
{
    // Semua prestasi siswa dalam kelas wali
     public function index()
    {
        $wali = auth()->user();
        $rombel = $wali->walikelas; // pastikan kolomnya benar

        $prestasi = Prestasi::whereHas('siswa', function ($q) use ($rombel) {
            $q->where('rombel', $rombel); // sesuaikan kolom kelas
        })
        ->orderBy('tanggal_prestasi', 'desc')
        ->get();

        return view('walikelas.prestasi.index', compact('prestasi'));
    }

    // Prestasi per siswa
    public function show($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $prestasi = Prestasi::where('nis', $nis)
            ->orderBy('tanggal_prestasi', 'desc')
            ->get();

        return view('walikelas.prestasi.show', compact('siswa', 'prestasi'));
    }

}
   
