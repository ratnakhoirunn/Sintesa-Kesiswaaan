<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

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

        // === 3. Simpan ke Tabel Siswa ===
        $siswa = Siswa::create($validatedSiswa);

        // === 4. Simpan ke Tabel Detail Siswa ===
        $detailData = [
            'nis' => $siswa->nis,
            'hobi' => $request->hobi,
            'cita_cita' => $request->cita_cita,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'anak_ke' => $request->anak_ke,
            'jumlah_saudara' => $request->jumlah_saudara,
            'tinggal_dengan' => $request->tinggal_dengan,
            'jarak_rumah' => $request->jarak_rumah,
            'waktu_tempuh' => $request->waktu_tempuh,
            'transportasi' => $request->transportasi,
            'nama_jalan' => $request->nama_jalan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'desa' => $request->desa,
            'kode_pos' => $request->kode_pos,
        ];

        DetailSiswa::create($detailData);

        // === 5. Simpan ke Tabel Orang Tua ===
        $orangTuaData = [
            'nis' => $siswa->nis,
            // Ayah
            'nama_ayah' => $request->nama_ayah,
            'nik_ayah' => $request->nik_ayah,
            'tahun_lahir_ayah' => $request->tahun_lahir_ayah,
            'pendidikan_ayah' => $request->pendidikan_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'penghasilan_ayah' => $request->penghasilan_ayah,
            'status_hidup_ayah' => $request->status_hidup_ayah,
            'no_telp_ayah' => $request->no_telp_ayah,
            // Ibu
            'nama_ibu' => $request->nama_ibu,
            'nik_ibu' => $request->nik_ibu,
            'tahun_lahir_ibu' => $request->tahun_lahir_ibu,
            'pendidikan_ibu' => $request->pendidikan_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'penghasilan_ibu' => $request->penghasilan_ibu,
            'status_hidup_ibu' => $request->status_hidup_ibu,
            'no_telp_ibu' => $request->no_telp_ibu,
            // Wali
            'nama_wali' => $request->nama_wali,
            'nik_wali' => $request->nik_wali,
            'tahun_lahir_wali' => $request->tahun_lahir_wali,
            'pendidikan_wali' => $request->pendidikan_wali,
            'pekerjaan_wali' => $request->pekerjaan_wali,
            'penghasilan_wali' => $request->penghasilan_wali,
            'status_hidup_wali' => $request->status_hidup_wali,
            'no_telp_wali' => $request->no_telp_wali,
        ];

        OrangTua::create($orangTuaData);

        return redirect()->route('admin.datasiswa.index')
            ->with('success', 'Data siswa dan biodata lengkap berhasil disimpan.');
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

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_siswa'), $filename);

            if ($siswa->foto && file_exists(public_path('uploads/foto_siswa/'.$siswa->foto))) {
                unlink(public_path('uploads/foto_siswa/'.$siswa->foto));
            }

            $validatedSiswa['foto'] = $filename;
        }

        // Update siswa utama
        $siswa->update($validatedSiswa);

        // Update detail siswa
        $detailData = $request->only([
            'cita_cita', 'hobi', 'berat_badan', 'tinggi_badan', 'anak_ke',
            'jumlah_saudara', 'tinggal_dengan', 'jarak_rumah', 'waktu_tempuh', 'transportasi',
            'nama_jalan', 'rt', 'rw', 'dusun', 'desa', 'kode_pos'
        ]);

        if ($siswa->detailSiswa) {
            $siswa->detailSiswa->update($detailData);
        } else {
            $siswa->detailSiswa()->create(array_merge($detailData, ['nis' => $siswa->nis]));
        }

        // Update orang tua
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

