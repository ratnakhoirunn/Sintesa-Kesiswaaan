<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\DokumenSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // 🔹 Tampilkan halaman dokumen siswa
    public function index()
    {
        // Ambil data siswa yang login
        $siswa = Siswa::where('nis', Auth::guard('siswa')->user()->nis)->first();

        // Simpan NIS dalam variabel untuk digunakan di bawah
        $nis = $siswa->nis;

        // Ambil semua dokumen berdasarkan NIS
        $dokumens = DokumenSiswa::where('nis', $nis)->get();

        // Kalau dokumen belum ada sama sekali, isi daftar default (biar selalu tampil 5 item)
        if ($dokumens->isEmpty()) {
            $jenisDokumen = [
                'Kartu Keluarga',
                'Akta Kelahiran',
                'KPSPKH',
                'KIP',
                'Pas Foto'
            ];

            foreach ($jenisDokumen as $jenis) {
                DokumenSiswa::create([
                    'nis' => $nis,
                    'jenis_dokumen' => $jenis,
                    'file_path' => null,
                ]);
            }

            $dokumens = DokumenSiswa::where('nis', $nis)->get();
        }

        // Pastikan view-nya sesuai folder
        return view('siswa.dokumensiswa.index', compact('dokumens', 'siswa'));
    }

    // 🔹 Proses upload / ganti file
    public function upload(Request $request, $id)
    {
        $dokumen = DokumenSiswa::findOrFail($id);
        $nis = Auth::guard('siswa')->user()->nis;

        // Cegah akses dokumen siswa lain
        if ($dokumen->nis !== $nis) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Hapus file lama kalau ada
        if ($dokumen->file_path && Storage::exists($dokumen->file_path)) {
            Storage::delete($dokumen->file_path);
        }

        // Simpan file baru
        $filePath = $request->file('file')->storeAs(
            'dokumen_siswa/' . $nis,
            time() . '_' . $request->file('file')->getClientOriginalName(),
            'public'
        );


        // Update path file
        $dokumen->update([
            'file_path' => $path,
        ]);

        return back()->with('success', 'File berhasil diunggah!');
    }
}
