<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use Carbon\Carbon;

class DashboardBKController extends Controller
{
    public function index()
    {
        // ==== 1. DATA COUNT STATUS ====
        $konselingMenunggu = Konseling::where('status', 'Menunggu')->count();
        $konselingProses   = Konseling::where('status', 'Diproses')->count();
        $konselingSelesai  = Konseling::where('status', 'Selesai')->count();

        // ==== 2. NOTIFIKASI: DATA BARU HARI INI ====
        $konselingBaru = Konseling::whereDate('created_at', Carbon::today())->count();

        // ==== 3. RECENT ACTIVITY ====
        $recent = Konseling::with('siswa')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        // ==== 4. DATA UNTUK CHART (12 bulan terakhir) ====
        $bulan = [];
        $jumlah = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()->month($i)->translatedFormat('F');

            $jumlah[] = Konseling::whereMonth('created_at', $i)->count();
        }

        return view('bk.dashboard', [
            'konselingMenunggu' => $konselingMenunggu,
            'konselingProses'   => $konselingProses,
            'konselingSelesai'  => $konselingSelesai,

            'konselingBaru'     => $konselingBaru,
            'recent'            => $recent,
            'bulan'             => $bulan,
            'jumlah'            => $jumlah,
        ]);
    }
}
