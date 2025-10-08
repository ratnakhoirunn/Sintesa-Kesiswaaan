@extends('layouts.admin')

@section('content')
<style>
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

    .upload-btn {
        background-color: #1e3a67;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 5px;
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .upload-btn:hover {
        background-color: #2a4c7e;
    }

    label {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 0.95rem;
        width: 100%;
    }

    .btn-primary {
        background-color: #1e3a67;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #2a4c7e;
    }

    .btn-secondary {
        background-color: #f0f2f5;
        color: #555;
        border: 1px solid #ddd;
        padding: 10px 25px;
        border-radius: 5px;
    }

    .btn-secondary:hover {
        background-color: #e0e2e5;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 40px;
        margin-bottom: 20px;
    }

    .content-wrapper {
        padding: 20px 30px;
        width: 100%;
        box-sizing: border-box;
    }

    /* bagian tambahan dua kolom */
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

    .detail-box .body .form-group {
        margin-bottom: 15px;
    }

    .scrollable-content {
        max-height: 80vh;
        overflow-y: auto;
        padding-right: 10px;
    }
</style>

<div class="scrollable-content">
    <div class="card-siswa">
        <div class="section-title">BIODATA SISWA</div>

        <div class="form-body">
            <form action="{{ route('admin.datasiswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- FOTO SISWA -->
                <div class="foto-wrapper">
                    <img id="preview-image" src="{{ asset('images/student.png') }}" alt="Foto Siswa">
                    <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                    <br>
                    <button type="button" class="upload-btn" onclick="document.getElementById('foto').click()">Upload Foto</button>
                </div>

                <!-- FORM INPUT UTAMA -->
                <div class="form-row">
                    <div>
                        <label>Nomer Induk Siswa</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div>
                        <label>Nomer Induk Siswa Nasional</label>
                        <input type="text" name="nisn" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div>
                        <label>No. WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Rombel</label>
                        <input type="text" name="rombel" class="form-control" required>
                    </div>
                    <div>
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>
                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control">
                    </div>
                    <div>
                        <label>Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div style="grid-column: span 2;">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <!-- FORM BIODATA DETAIL & ALAMAT -->
                <div class="detail-container">

                    <!-- Biodata Detail -->
                    <div class="detail-box">
                        <div class="header">BIODATA DETAIL SISWA</div>
                        <div class="body">
                            <div class="form-group"><label>Cita-cita</label><input type="text" name="cita_cita" class="form-control"></div>
                            <div class="form-group"><label>Hobi</label><input type="text" name="hobi" class="form-control"></div>
                            <div class="form-group"><label>Berat Badan</label><input type="text" name="berat_badan" class="form-control"></div>
                            <div class="form-group"><label>Tinggi Badan</label><input type="text" name="tinggi_badan" class="form-control"></div>
                            <div class="form-group"><label>Anak ke-</label><input type="number" name="anak_ke" class="form-control"></div>
                            <div class="form-group"><label>Jumlah Saudara Kandung</label><input type="number" name="jumlah_saudara" class="form-control"></div>
                            <div class="form-group"><label>Tinggal dengan</label><input type="text" name="tinggal_dengan" class="form-control"></div>
                            <div class="form-group"><label>Jarak Rumah</label><input type="text" name="jarak_rumah" class="form-control"></div>
                            <div class="form-group"><label>Waktu Tempuh</label><input type="text" name="waktu_tempuh" class="form-control"></div>
                            <div class="form-group"><label>Transportasi</label><input type="text" name="transportasi" class="form-control"></div>
                        </div>
                    </div>

                    <!-- Data Alamat -->
                    <div class="detail-box">
                        <div class="header">DATA ALAMAT SISWA</div>
                        <div class="body">
                            <div class="form-group"><label>Nama Jalan</label><input type="text" name="nama_jalan" class="form-control"></div>
                            <div class="form-group"><label>RT</label><input type="text" name="rt" class="form-control"></div>
                            <div class="form-group"><label>RW</label><input type="text" name="rw" class="form-control"></div>
                            <div class="form-group"><label>Dusun</label><input type="text" name="dusun" class="form-control"></div>
                            <div class="form-group"><label>Desa/Kelurahan</label><input type="text" name="desa" class="form-control"></div>
                            <div class="form-group"><label>Kode Pos</label><input type="text" name="kode_pos" class="form-control"></div>
                        </div>
                    </div>
                </div>

                <!-- DATA ORANG TUA -->
<div class="detail-container">

    <!-- Biodata Ayah -->
    <div class="detail-box">
        <div class="header">BIODATA AYAH</div>
        <div class="body">
            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_ayah" class="form-control" placeholder="Masukkan nama ayah..."></div>
            <div class="form-group"><label>NIK</label><input type="text" name="nik_ayah" class="form-control"></div>
            <div class="form-group"><label>Tahun Lahir</label><input type="number" name="tahun_lahir_ayah" class="form-control"></div>
            <div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_ayah" class="form-control"></div>
            <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan_ayah" class="form-control"></div>
            <div class="form-group"><label>Penghasilan</label><input type="text" name="penghasilan_ayah" class="form-control" placeholder="< 500.000"></div>
            <div class="form-group"><label>Status Ayah</label><input type="text" name="status_ayah" class="form-control" placeholder="Hidup / Meninggal"></div>
            <div class="form-group"><label>No Telepon</label><input type="text" name="no_telp_ayah" class="form-control"></div>
        </div>
    </div>

    <!-- Biodata Ibu -->
    <div class="detail-box">
        <div class="header">BIODATA IBU</div>
        <div class="body">
            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_ibu" class="form-control" placeholder="Masukkan nama ibu..."></div>
            <div class="form-group"><label>NIK</label><input type="text" name="nik_ibu" class="form-control"></div>
            <div class="form-group"><label>Tahun Lahir</label><input type="number" name="tahun_lahir_ibu" class="form-control"></div>
            <div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_ibu" class="form-control"></div>
            <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan_ibu" class="form-control"></div>
            <div class="form-group"><label>Penghasilan</label><input type="text" name="penghasilan_ibu" class="form-control" placeholder="< 500.000"></div>
            <div class="form-group"><label>Status Ibu</label><input type="text" name="status_ibu" class="form-control" placeholder="Hidup / Meninggal"></div>
            <div class="form-group"><label>No Telepon</label><input type="text" name="no_telp_ibu" class="form-control"></div>
        </div>
    </div>

</div>

<!-- DATA WALI -->
<div class="detail-container">
    <div class="detail-box" style="flex: 1;">
        <div class="header">BIODATA WALI</div>
        <div class="body">
            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_wali" class="form-control" placeholder="Masukkan nama wali..."></div>
            <div class="form-group"><label>NIK</label><input type="text" name="nik_wali" class="form-control"></div>
            <div class="form-group"><label>Tahun Lahir</label><input type="number" name="tahun_lahir_wali" class="form-control"></div>
            <div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_wali" class="form-control"></div>
            <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan_wali" class="form-control"></div>
            <div class="form-group"><label>Penghasilan</label><input type="text" name="penghasilan_wali" class="form-control" placeholder="< 500.000"></div>
            <div class="form-group"><label>Status Wali</label><input type="text" name="status_wali" class="form-control" placeholder="Hidup / Meninggal"></div>
            <div class="form-group"><label>No Telepon</label><input type="text" name="no_telp_wali" class="form-control"></div>
        </div>
    </div>
</div>
<div class="mt-4"> <button type="submit" class="btn btn-primary">Simpan Data</button> 
    <button type="button" class="btn btn-secondary">Batal</button>
</div>
            </form>
        </div>
    </div>
</div>

<script>
    // preview foto sebelum upload
    document.getElementById('foto').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview-image').src = reader.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endsection
