@extends('layouts.admin')

@section('title', 'Edit Data Siswa')
@section('content')

<style>
    /* Copy dari show.blade + ubahan untuk input */
    .card-siswa {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
    }

    .section-title {
        background-color: #1e3a67;
        color: white;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 1.1rem;
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .form-body {
        padding: 30px 50px;
    }

    .foto-wrapper {
        text-align: center;
        margin-bottom: 30px;
    }

    .foto-wrapper img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e5e5e5;
    }

    label {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
        margin-bottom: 4px;
        display: block;
    }

    input, select, textarea {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 10px;
        font-size: 0.95rem;
        background-color: #f9f9f9;
        transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #1e3a67;
        background-color: #fff;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 40px;
        margin-bottom: 20px;
    }

    .detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 30px;
    }

    .detail-box {
        flex: 1;
        min-width: 350px;
        background-color: #f9fafc;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .detail-box .header {
        background-color: #1e3a67;
        color: white;
        font-weight: 600;
        padding: 10px 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .detail-box .body {
        padding: 20px;
    }

    .btn-blue {
        display: inline-block;
        background-color: #1e3a67;
        color: white;
        padding: 10px 18px;
        border-radius: 5px;
        border: none;
        transition: 0.3s;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-blue:hover {
        background-color: #0056b3;
    }

    .btn-gray {
        display: inline-block;
        background-color: #4a4a4a;
        color: white;
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-gray:hover {
        background-color: #3a3a3a;
    }

    .scrollable-content {
        max-height: 80vh;
        overflow-y: auto;
        padding-right: 10px;
    }
</style>

<div class="scrollable-content">
    <div class="card-siswa">
        <div class="section-title">EDIT BIODATA SISWA: {{ $siswa->nama_lengkap }}</div>

        <form action="{{ route('admin.datasiswa.update', $siswa->nis) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="foto-wrapper">
                    <img id="preview-image" 
                         src="{{ $siswa->foto ? asset('uploads/foto_siswa/'.$siswa->foto) : asset('images/student.png') }}" 
                         alt="Foto Siswa">
                    <br><br>
                    <input type="file" name="foto" accept="image/*" onchange="previewImage(event)">
                </div>

                {{-- Baris utama data siswa --}}
                <div class="form-row">
                    <div>
                        <label>NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}">
                    </div>
                    <div>
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                    </div>
                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}">
                    </div>
                    <div>
                        <label>No. WhatsApp</label>
                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $siswa->no_whatsapp) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Rombel</label>
                        <input type="text" name="rombel" value="{{ old('rombel', $siswa->rombel) }}">
                    </div>
                    <div>
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $siswa->jurusan) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Agama</label>
                        <input type="text" name="agama" value="{{ old('agama', $siswa->agama) }}">
                    </div>
                    <div>
                        <label>Nama Orang Tua (Utama)</label>
                        <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div style="grid-column: span 2;">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                </div>

                {{-- Detail Box --}}
                @php 
                    $detail = $siswa->detailSiswa;
                    $ortu = $siswa->orangTua;
                @endphp

                <div class="detail-container">
                    <div class="detail-box">
                        <div class="header">BIODATA DETAIL SISWA</div>
                        <div class="body">
                            <label>Cita-cita</label><input type="text" name="cita_cita" value="{{ old('cita_cita', $detail->cita_cita ?? '') }}">
                            <label>Hobi</label><input type="text" name="hobi" value="{{ old('hobi', $detail->hobi ?? '') }}">
                            <label>Berat Badan</label><input type="number" name="berat_badan" value="{{ old('berat_badan', $detail->berat_badan ?? '') }}">
                            <label>Tinggi Badan</label><input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $detail->tinggi_badan ?? '') }}">
                            <label>Anak ke-</label><input type="number" name="anak_ke" value="{{ old('anak_ke', $detail->anak_ke ?? '') }}">
                            <label>Jumlah Saudara</label><input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $detail->jumlah_saudara ?? '') }}">
                            <label>Tinggal Dengan</label><input type="text" name="tinggal_dengan" value="{{ old('tinggal_dengan', $detail->tinggal_dengan ?? '') }}">
                            <label>Jarak Rumah</label><input type="text" name="jarak_rumah" value="{{ old('jarak_rumah', $detail->jarak_rumah ?? '') }}">
                            <label>Waktu Tempuh</label><input type="text" name="waktu_tempuh" value="{{ old('waktu_tempuh', $detail->waktu_tempuh ?? '') }}">
                            <label>Transportasi</label><input type="text" name="transportasi" value="{{ old('transportasi', $detail->transportasi ?? '') }}">
                        </div>
                    </div>

                    <div class="detail-box">
                        <div class="header">DATA ALAMAT SISWA</div>
                        <div class="body">
                            <label>Nama Jalan</label><input type="text" name="nama_jalan" value="{{ old('nama_jalan', $detail->nama_jalan ?? '') }}">
                            <label>RT</label><input type="text" name="rt" value="{{ old('rt', $detail->rt ?? '') }}">
                            <label>RW</label><input type="text" name="rw" value="{{ old('rw', $detail->rw ?? '') }}">
                            <label>Dusun</label><input type="text" name="dusun" value="{{ old('dusun', $detail->dusun ?? '') }}">
                            <label>Desa/Kelurahan</label><input type="text" name="desa" value="{{ old('desa', $detail->desa ?? '') }}">
                            <label>Kode Pos</label><input type="text" name="kode_pos" value="{{ old('kode_pos', $detail->kode_pos ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- AYAH, IBU, WALI --}}
                <div class="detail-container">
                    <div class="detail-box">
                        <div class="header">BIODATA AYAH</div>
                        <div class="body">
                            <label>Nama Ayah</label><input type="text" name="nama_ayah" value="{{ old('nama_ayah', $ortu->nama_ayah ?? '') }}">
                            <label>NIK</label><input type="text" name="nik_ayah" value="{{ old('nik_ayah', $ortu->nik_ayah ?? '') }}">
                            <label>Tahun Lahir</label><input type="text" name="tahun_lahir_ayah" value="{{ old('tahun_lahir_ayah', $ortu->tahun_lahir_ayah ?? '') }}">
                            <label>Pendidikan</label><input type="text" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $ortu->pendidikan_ayah ?? '') }}">
                            <label>Pekerjaan</label><input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $ortu->pekerjaan_ayah ?? '') }}">
                            <label>Penghasilan</label><input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah', $ortu->penghasilan_ayah ?? '') }}">
                            <label>Status Hidup</label>
                                <select name="status_hidup_ayah" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Masih Hidup" {{ old('status_hidup_ayah', $ortu->status_hidup_ayah ?? '') == 'Masih Hidup' ? 'selected' : '' }}>Masih Hidup</option>
                                    <option value="Sudah Meninggal" {{ old('status_hidup_ayah', $ortu->status_hidup_ayah ?? '') == 'Sudah Meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                                </select>
                            <label>No. Telepon</label><input type="text" name="no_telp_ayah" value="{{ old('no_telp_ayah', $ortu->no_telp_ayah ?? '') }}">
                        </div>
                    </div>

                    <div class="detail-box">
                        <div class="header">BIODATA IBU</div>
                        <div class="body">
                            <label>Nama Ibu</label><input type="text" name="nama_ibu" value="{{ old('nama_ibu', $ortu->nama_ibu ?? '') }}">
                            <label>NIK</label><input type="text" name="nik_ibu" value="{{ old('nik_ibu', $ortu->nik_ibu ?? '') }}">
                            <label>Tahun Lahir</label><input type="text" name="tahun_lahir_ibu" value="{{ old('tahun_lahir_ibu', $ortu->tahun_lahir_ibu ?? '') }}">
                            <label>Pendidikan</label><input type="text" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $ortu->pendidikan_ibu ?? '') }}">
                            <label>Pekerjaan</label><input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $ortu->pekerjaan_ibu ?? '') }}">
                            <label>Penghasilan</label><input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu', $ortu->penghasilan_ibu ?? '') }}">
                            <label>Status Hidup</label>
                                <select name="status_hidup_ibu" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Masih Hidup" {{ old('status_hidup_ibu', $ortu->status_hidup_ibu ?? '') == 'Masih Hidup' ? 'selected' : '' }}>Masih Hidup</option>
                                    <option value="Sudah Meninggal" {{ old('status_hidup_ibu', $ortu->status_hidup_ibu ?? '') == 'Sudah Meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                                </select>
                            <label>No. Telepon</label><input type="text" name="no_telp_ibu" value="{{ old('no_telp_ibu', $ortu->no_telp_ibu ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="detail-container">
                    <div class="detail-box">
                        <div class="header">BIODATA WALI</div>
                        <div class="body">
                            <label>Nama Wali</label><input type="text" name="nama_wali" value="{{ old('nama_wali', $ortu->nama_wali ?? '') }}">
                            <label>NIK</label><input type="text" name="nik_wali" value="{{ old('nik_wali', $ortu->nik_wali ?? '') }}">
                            <label>Tahun Lahir</label><input type="text" name="tahun_lahir_wali" value="{{ old('tahun_lahir_wali', $ortu->tahun_lahir_wali ?? '') }}">
                            <label>Pendidikan</label><input type="text" name="pendidikan_wali" value="{{ old('pendidikan_wali', $ortu->pendidikan_wali ?? '') }}">
                            <label>Pekerjaan</label><input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali', $ortu->pekerjaan_wali ?? '') }}">
                            <label>Penghasilan</label><input type="text" name="penghasilan_wali" value="{{ old('penghasilan_wali', $ortu->penghasilan_wali ?? '') }}">
                            <label>Status Hidup</label>
                                <select name="status_hidup_wali" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Masih Hidup" {{ old('status_hidup_wali', $ortu->status_hidup_wali ?? '') == 'Masih Hidup' ? 'selected' : '' }}>Masih Hidup</option>
                                    <option value="Sudah Meninggal" {{ old('status_hidup_wali', $ortu->status_hidup_wali ?? '') == 'Sudah Meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                                </select>
                            <label>No. Telepon</label><input type="text" name="no_telp_wali" value="{{ old('no_telp_wali', $ortu->no_telp_wali ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn-blue">Simpan Perubahan</button>
                    <a href="{{ route('admin.datasiswa.index') }}" class="btn-gray">Batal</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const image = document.getElementById('preview-image');
    image.src = URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
