<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Konseling; // ✅ pastikan ini ada

class DashboardSiswaController extends Controller
{
    public function dashboard()
    {    
        $siswa = Auth::guard('siswa')->user();

        // ✅ Ambil semua riwayat konseling siswa ini
        $konselings = Konseling::where('nis', $siswa->nis)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('siswa.dashboard', compact('siswa', 'konselings'));
    }

    public function dataSiswa()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.datasiswa.index', compact('siswa'));
    }

    public function dataOrangtua()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.dataortu.index', compact('siswa'));
    }

    public function kartuPelajar()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.kartupelajar.preview', compact('siswa'));
    }

    public function frame($nis)
    {
        $siswa = Auth::guard('siswa')->user();

        // Pastikan hanya bisa melihat kartunya sendiri
        if ($siswa->nis !== $nis) {
            abort(403, 'Tidak diizinkan melihat kartu siswa lain.');
        }

        return view('siswa.kartupelajar.frame', compact('siswa'));
    }

    public function konseling()
    {
        $siswa = Auth::guard('siswa')->user();

        // ✅ tampilkan daftar pengajuan konseling siswa
        $konselings = Konseling::where('nis', $siswa->nis)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('siswa.konseling.index', compact('siswa', 'konselings'));
    }

    public function keterlambatan()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.keterlambatan.index', compact('siswa'));
    }

    public function dokumenSiswa()
    {
        $siswa = Auth::guard('siswa')->user();

        // Kirim ke view
        return view('siswa.dokumen.index', compact('siswa'));
    }
}
