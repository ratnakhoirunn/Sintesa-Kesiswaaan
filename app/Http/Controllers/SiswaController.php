<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function create()
    {
        return view('admin.datasiswa.tambah');
    }

    public function store(Request $request)
{
    // 1. Validasi Data
    $request->validate([
        'nama' => 'required|string|max:255', // Ini adalah nama field di form
        'nis' => 'required|string|unique:siswas,NIS|max:255',
        'nisn' => 'required|string|unique:siswas,NISN|max:255',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'agama' => 'nullable|string|max:255',
        'kelas' => 'required|string|max:255',
        'alamat_siswa' => 'nullable|string',
        'nomor_wa' => 'nullable|string|max:20',
        'nama_orang_tua' => 'nullable|string|max:255',
    ]);

    // 2. Simpan Data ke Database
    Siswa::create([
        'nama_lengkap' => $request->nama, // Perbaikan: Ambil data dari $request->nama
        'NIS' => $request->nis,
        'NISN' => $request->nisn,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'agama' => $request->agama,
        'kelas' => $request->kelas,
        'alamat_siswa' => $request->alamat_siswa,
        'nomor_wa' => $request->nomor_wa,
        'nama_orang_tua' => $request->nama_orang_tua,
    ]);

    return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
}
}