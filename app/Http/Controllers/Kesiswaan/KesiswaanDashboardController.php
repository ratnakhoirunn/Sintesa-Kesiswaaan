<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Keterlambatan;
use App\Models\DokumenSiswa;

class KesiswaanDashboardController extends Controller
{
    public function index()
    {
        // === Kard Informasi ===
        $totalSiswa = Siswa::count();
        $totalKeterlambatan = Keterlambatan::count();
        $totalDokumen = DokumenSiswa::count();

        // === Grafik Siswa Per Jurusan ===
        $grafikJurusan = Siswa::select('jurusan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('jurusan')
            ->orderBy('total', 'DESC')
            ->get();

        // === Notifikasi 5 Keterlambatan Terbaru ===
        $keterlambatanTerbaru = Keterlambatan::with('siswa')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('kesiswaan.dashboard', compact(
            'totalSiswa',
            'totalKeterlambatan',
            'totalDokumen',
            'grafikJurusan',
            'keterlambatanTerbaru'
        ));
    }
}
