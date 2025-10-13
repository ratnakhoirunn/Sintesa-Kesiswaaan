<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\OrangTua; // Model OrangTua diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // Pastikan library ini sudah diinstal jika digunakan

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama_lengkap', 'asc')->paginate(10);
        return view('admin.datasiswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.datasiswa.create');
    }

    public function store(Request $request)
{
    // Validasi semua kolom siswa
    $validatedSiswa = $request->validate([
        'nis' => 'required|unique:siswas,nis',
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|string',
        'rombel' => 'nullable|string',
        'jurusan' => 'nullable|string',
        'tempat_lahir' => 'nullable|string',
        'tanggal_lahir' => 'nullable|date',
        'agama' => 'nullable|string',
        'nama_ortu' => 'nullable|string',
        'alamat' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload foto jika ada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/foto_siswa'), $fileName);
        $validatedSiswa['foto'] = $fileName;
    }

    // Simpan data siswa
    $siswa = Siswa::create($validatedSiswa);

    // Simpan data orang tua (opsional)
   // Cek dulu apakah tabel orang_tua memang memiliki kolom yang sesuai
if (Schema::hasTable('orang_tua')) {
    $orangTuaData = [
        'siswa_id' => $siswa->id,
    ];

    // Pastikan hanya masukkan kolom yang memang ada
    if (Schema::hasColumn('orang_tua', 'nama_ayah')) {
        $orangTuaData['nama_ayah'] = $request->nama_ayah;
    }

    if (Schema::hasColumn('orang_tua', 'nama_ibu')) {
        $orangTuaData['nama_ibu'] = $request->nama_ibu;
    }

    $siswa->orangTua()->create($orangTuaData);
}


    return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil disimpan.');
}



    public function show($id)
    {
        // PERBAIKAN UTAMA: Baris ini harus ada untuk mendefinisikan $siswa!
        // Menggunakan eager loading 'orangTua' (camelCase yang benar)
        $siswa = Siswa::with('orangTua')->findOrFail($id); 
        
        // Karena $siswa sudah didefinisikan, compact() berfungsi dengan baik
        return view('admin.datasiswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        // Muat relasi 'orangTua' untuk form edit
        $siswa = Siswa::with('orangTua')->findOrFail($id);
        return view('admin.datasiswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Validasi dan update data Siswa...
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis,'.$siswa->id,
            // ... kolom Siswa lainnya
        ]);

        $siswa->update($validated);
        
        // Logika update data Orang Tua (contoh singkat)
        $validatedOrangTuaUpdate = $request->validate([
            'nama_ayah' => 'nullable|string|max:255',
            // ... kolom OrangTua lainnya
        ]);

        if ($siswa->orangTua) {
            $siswa->orangTua->update($validatedOrangTuaUpdate);
        } else {
            // Jika data orang tua belum ada, buat yang baru
            $siswa->orangTua()->create($validatedOrangTuaUpdate);
        }

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Karena ada 'on delete cascade', data orang_tua akan ikut terhapus
        Siswa::destroy($id);
        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

  
}