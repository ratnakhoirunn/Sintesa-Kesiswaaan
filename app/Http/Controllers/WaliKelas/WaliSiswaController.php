<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class WaliSiswaController extends Controller
{
    // List siswa kelas wali
    public function index()
    {
        $guru = auth('guru')->user();
        $rombel = $guru->walikelas; // ambil rombel wali kelas

        // Ambil semua siswa di rombel wali
        $siswas = Siswa::where('rombel', $rombel)->paginate(36);

        // Hitung jumlah siswa
        $jumlah = Siswa::where('rombel', $rombel)->count();

        return view('walikelas.datasiswa.siswa', compact('siswas', 'rombel', 'jumlah'));
    }

    // Edit satu siswa
    public function edit($nis)
    {
        $guru = auth('guru')->user();
        $rombel = $guru->walikelas;

        $siswa = Siswa::where('nis', $nis)
                      ->where('rombel', $rombel) // keamanan
                      ->firstOrFail();

        return view('walikelas.datasiswa.edit', compact('siswa'));
    }

    // Update siswa
    public function update(Request $request, $nis)
    {
        $guru = auth('guru')->user();
        $rombel = $guru->walikelas;

        $siswa = Siswa::where('nis', $nis)
                      ->where('rombel', $rombel)
                      ->firstOrFail();

        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('wali.datasiswa')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }
}
