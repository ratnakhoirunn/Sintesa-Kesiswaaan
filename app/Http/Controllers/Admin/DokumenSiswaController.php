<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Siswa;
use App\Models\DokumenSiswa;

class DokumenSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data siswa beserta jumlah dokumennya
        $siswa = Siswa::withCount('dokumen')->paginate(10);

        // Total dokumen wajib yang harus diupload siswa
        $totalDokumenWajib = 5;

        // kirim ke view
        return view('admin.dokumensiswa.index', compact('siswa', 'totalDokumenWajib'));
    }

 public function show($nis)
{
    $siswa = Siswa::findOrFail($nis);
    $dokumen = DokumenSiswa::where('siswa_nis', $nis)->get();

    $wajib = [
        'Scan Akta Kelahiran',
        'Scan Kartu Keluarga',
        'Scan KTP Orang Tua',
        'Scan Ijazah',
        'Pas Foto 3x4'
    ];

    return view('admin.dokumensiswa.show', compact('siswa', 'dokumen', 'wajib'));
}



    public function create()
    {
        // kalau belum pakai database, bisa manual dulu
        $rombel = [
            'X DKV 1',
            'X DKV 2',
            'X SIJA 1',
            'X SIJA 2',
            'X TITL 1',
            'X TITL 2',
        ];
        return view('admin.dokumensiswa.create', compact('rombel'));
    }
}
