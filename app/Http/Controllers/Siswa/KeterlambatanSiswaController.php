<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeterlambatanSiswaController extends Controller
{
    public function index()
{
    $siswa = Auth::guard('siswa')->user();

    // Hitung total keterlambatan dan poin pelanggaran
    $jumlah = Keterlambatan::where('nis', $siswa->nis)->count();
    $poin = $jumlah * 5; // bisa kamu ubah sesuai aturan sekolah

    // Ambil data keterlambatan milik siswa
    $riwayat = Keterlambatan::where('nis', $siswa->nis)
        ->orderBy('tanggal', 'desc')
        ->get();

    // Kirim semua ke view
    return view('siswa.keterlambatan.index', compact('siswa', 'jumlah', 'poin', 'riwayat'));
}



    public function ajukan(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $siswa = Auth::guard('siswa')->user();

        // Buat pengajuan baru
        Keterlambatan::create([
            'nis' => $siswa->nis,
            'nama_siswa' => $siswa->nama_lengkap,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'jam_datang' => Carbon::now()->format('H:i:s'),
            'menit_terlambat' => rand(5, 30), // misal dummy data menit
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan SIT berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function cetakSIT($id)
{
    $data = Keterlambatan::where('id', $id)->where('status', 'diterima')->firstOrFail();

    return view('siswa.keterlambatan.cetak_sit', compact('data'));
}

}
