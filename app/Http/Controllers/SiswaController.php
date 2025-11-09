<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\OrangTua;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $rombel = $request->input('rombel');
        $jurusan = $request->input('jurusan');
        $search  = $request->input('search');

        // Query awal
        $query = Siswa::query();

        // Filter rombel
        if ($rombel) {
            $query->where('rombel', $rombel);
        }

        // Filter jurusan
        if ($jurusan) {
            $query->where('jurusan', $jurusan);
        }

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Hitung jumlah siswa hasil filter
        $jumlah = $query->count();

        // Ambil data dan pagination
        $siswas = $query->orderBy('rombel')->paginate(10);

        return view('admin.datasiswa.index', compact('siswas', 'rombel', 'jurusan', 'jumlah'));
    }

    public function create()
    {
        return view('admin.datasiswa.create');
    }

    public function store(Request $request)
{
    // === 1. Validasi Data Siswa ===
    $validatedSiswa = $request->validate([
        'nis' => 'required|unique:siswas,nis',
        'nisn' => 'nullable|string|max:20',
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'no_whatsapp' => 'nullable|string|max:20',
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

    // === 2. Upload Foto (Jika Ada) ===
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/foto_siswa'), $fileName);
        $validatedSiswa['foto'] = $fileName;
    }

 // ✅ Tambahkan password default = 'siswa123'
    $validatedSiswa['password'] = bcrypt('siswa123');

    // === 3. Simpan ke Tabel Siswa ===
    $siswa = Siswa::create($validatedSiswa);

    // === 4. Simpan ke Tabel Detail Siswa ===
    $detailData = $request->only([
        'hobi', 'cita_cita', 'berat_badan', 'tinggi_badan', 'anak_ke',
        'jumlah_saudara', 'tinggal_dengan', 'jarak_rumah', 'waktu_tempuh',
        'transportasi', 'nama_jalan', 'rt', 'rw', 'dusun', 'desa', 'kode_pos'
    ]);

    $numericFields = ['berat_badan', 'tinggi_badan', 'anak_ke', 'jumlah_saudara', 'jarak_rumah'];
    foreach ($numericFields as $field) {
        if (isset($detailData[$field]) && $detailData[$field] === '') {
            $detailData[$field] = null;
        }
    }

    $detailData['nis'] = $siswa->nis;
    DetailSiswa::create($detailData);

    // === 5. Simpan ke Tabel Orang Tua ===
    $orangTuaData = $request->only([
        'nama_ayah','nik_ayah','tahun_lahir_ayah','pendidikan_ayah',
        'pekerjaan_ayah','penghasilan_ayah','status_hidup_ayah','no_telp_ayah',
        'nama_ibu','nik_ibu','tahun_lahir_ibu','pendidikan_ibu',
        'pekerjaan_ibu','penghasilan_ibu','status_hidup_ibu','no_telp_ibu',
        'nama_wali','nik_wali','tahun_lahir_wali','pendidikan_wali',
        'pekerjaan_wali','penghasilan_wali','status_hidup_wali','no_telp_wali'
    ]);

    $orangTuaData['nis'] = $siswa->nis;
    OrangTua::create($orangTuaData);

    return redirect()->route('admin.datasiswa.index')
        ->with('success', 'Data siswa dan biodata lengkap berhasil disimpan. Password awal = siswa123.');
}


    public function show($nis)
    {
        $siswa = Siswa::with(['orangTua', 'detailSiswa'])->where('nis', $nis)->firstOrFail();
        return view('admin.datasiswa.show', compact('siswa'));
    }

    public function edit($nis)
    {
        $siswa = Siswa::with(['detailSiswa', 'orangTua'])->where('nis', $nis)->firstOrFail();
        return view('admin.datasiswa.edit', compact('siswa'));
    }

    public function update(Request $request, $nis)
{
    $siswa = Siswa::with(['orangTua', 'detailSiswa'])->where('nis', $nis)->firstOrFail();

    // === VALIDASI DATA SISWA ===
    $validatedSiswa = $request->validate([
        'nis' => 'required|unique:siswas,nis,' . $siswa->nis . ',nis',
        'nisn' => 'nullable|string|max:50',
        'nama_lengkap' => 'required|string|max:255',
        'jenis_kelamin' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'no_whatsapp' => 'nullable|string|max:20',
        'rombel' => 'nullable|string|max:100',
        'jurusan' => 'nullable|string|max:100',
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'agama' => 'nullable|string|max:50',
        'nama_ortu' => 'nullable|string|max:255',
        'alamat' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // === UPLOAD FOTO (Jika ada) ===
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/foto_siswa'), $filename);

        // hapus foto lama
        if ($siswa->foto && file_exists(public_path('uploads/foto_siswa/' . $siswa->foto))) {
            unlink(public_path('uploads/foto_siswa/' . $siswa->foto));
        }

        $validatedSiswa['foto'] = $filename;
    }

    // === UPDATE DATA UTAMA SISWA ===
    $siswa->update($validatedSiswa);

    // === UPDATE DETAIL SISWA ===
    $detailData = $request->only([
        'cita_cita', 'hobi', 'berat_badan', 'tinggi_badan', 'anak_ke',
        'jumlah_saudara', 'tinggal_dengan', 'jarak_rumah', 'waktu_tempuh',
        'transportasi', 'nama_jalan', 'rt', 'rw', 'dusun', 'desa', 'kode_pos'
    ]);

    // 🔍 Ubah field integer kosong menjadi null biar MySQL gak error
    $numericFields = ['berat_badan', 'tinggi_badan', 'anak_ke', 'jumlah_saudara', 'jarak_rumah'];
    foreach ($numericFields as $field) {
        if (isset($detailData[$field]) && $detailData[$field] === '') {
            $detailData[$field] = null;
        }
    }

    if ($siswa->detailSiswa) {
        $siswa->detailSiswa->update($detailData);
    } else {
        $siswa->detailSiswa()->create(array_merge($detailData, ['nis' => $siswa->nis]));
    }

    // === UPDATE DATA ORANG TUA ===
    $ortuData = $request->only([
        'nama_ayah', 'nik_ayah', 'tahun_lahir_ayah', 'pendidikan_ayah',
        'pekerjaan_ayah', 'penghasilan_ayah', 'status_hidup_ayah', 'no_telp_ayah',
        'nama_ibu', 'nik_ibu', 'tahun_lahir_ibu', 'pendidikan_ibu',
        'pekerjaan_ibu', 'penghasilan_ibu', 'status_hidup_ibu', 'no_telp_ibu',
        'nama_wali', 'nik_wali', 'tahun_lahir_wali', 'pendidikan_wali',
        'pekerjaan_wali', 'penghasilan_wali', 'status_hidup_wali', 'no_telp_wali',
    ]);

    if ($siswa->orangTua) {
        $siswa->orangTua->update($ortuData);
    } else {
        $siswa->orangTua()->create(array_merge($ortuData, ['nis' => $siswa->nis]));
    }

    return redirect()->route('admin.datasiswa.index')
        ->with('success', 'Data siswa berhasil diperbarui.');
}


    public function destroy($nis)
    {
        Siswa::where('nis', $nis)->delete();
        return redirect()->route('admin.datasiswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    
}
