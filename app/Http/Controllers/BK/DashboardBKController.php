<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\Konseling;

class DashboardBKController extends Controller
{
    public function index()
    {
        return view('bk.dashboard', [
            'konselingMenunggu' => Konseling::where('status', 'Menunggu')->count(),
            'konselingProses'   => Konseling::where('status', 'Diproses')->count(),
            'konselingSelesai'  => Konseling::where('status', 'Selesai')->count(),
        ]);
    }
}
