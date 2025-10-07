<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa; // Pastikan model DetailSiswa diimpor
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport; // Pastikan class import diimpor

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa dengan paginasi (mengatasi BadMethodCallException).
     */
    public function index()
    {
        // PENTING: Menggunakan paginate() untuk menghindari error Collection::links()
        $siswas = Siswa::select('id', 'nisn', 'nama', 'rombel', 'kompetensi_keahlian')
                      ->latest()
                      ->paginate(10); 
                      
        return view('admin.datasiswa.index', compact('siswas'));
    }

    /**
     * Menampilkan formulir untuk menambahkan siswa baru (Manual).
     */
    public function create()
    {
        return view('admin.datasiswa.create');
    }

    /**
     * Menyimpan data siswa baru (Manual).
     */
    public function store(Request $request)
    {
        // Validasi data utama siswa
        $request->validate([
            'nisn' => 'required|unique:siswas',
            'nama' => 'required',
            'rombel' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        // Simpan data ke tabel siswas
        Siswa::create($request->only(['nisn', 'nama', 'rombel', 'kompetensi_keahlian']));
        
        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil ditambahkan secara manual.');
    }

    /**
     * Menampilkan detail siswa (Lihat).
     */
    public function show(Siswa $siswa)
    {
        // Eager loading relasi detail untuk menampilkan data lengkap
        $siswa->load('detail');
        return view('admin.datasiswa.show', compact('siswa'));
    }

    /**
     * Menampilkan formulir untuk mengedit data siswa.
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load('detail');
        return view('admin.datasiswa.edit', compact('siswa'));
    }

    /**
     * Memperbarui data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn' => 'required|unique:siswas,nisn,' . $siswa->id,
            'nama' => 'required',
            'rombel' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        $siswa->update($request->only(['nisn', 'nama', 'rombel', 'kompetensi_keahlian']));

        // Anda mungkin perlu menambahkan logika untuk mengupdate DetailSiswa di sini juga
        // $siswa->detail()->update($request->only([...kolom detail...]));

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy(Siswa $siswa)
    {
        // Relasi onDelete('cascade') di migrasi akan otomatis menghapus DetailSiswa
        $siswa->delete();
        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Memproses impor data siswa dari file Excel/CSV.
     */
    public function import(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ], [
            'file.required' => 'File harus diunggah.',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv.'
        ]);

        try {
            // Proses impor data
            Excel::import(new SiswaImport, $request->file('file'));
        } catch (\Exception $e) {
            // Menangkap error jika pemetaan atau data tidak valid
            return redirect()->route('admin.datasiswa.index')->with('error', 'Gagal mengimpor data. Pastikan format kolom di file Anda sudah benar.');
        }

        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil diimpor!');
    }
}
