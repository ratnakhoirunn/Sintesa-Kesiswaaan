@extends('layouts.admin')

@section('content')
<style>
    .form-card {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
        color: #555;
    }
    .form-control, .form-select {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 0.95rem;
    }
    .btn-primary {
        background-color: #1e3a67;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #2a4c7e;
    }
    .btn-secondary {
        background-color: #f0f2f5;
        color: #555;
        border: 1px solid #ddd;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background-color: #e0e2e5;
    }
    .form-section-title {
        color: #1e3a67;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .form-section-divider {
        border-top: 1px solid #eee;
        margin: 20px 0;
    }
</style>

<div class="container-fluid">
    <h2 class="mb-4">Tambah Data Siswa Baru</h2>
    
    <div class="form-card">
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h4 class="form-section-title">Data Pribadi</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" class="form-control" id="nis" name="nis" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="agama" class="form-label">Agama</label>
                    <input type="text" class="form-control" id="agama" name="agama">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                </div>
            </div>
            
            <hr class="form-section-divider">
            <h4 class="form-section-title">Data Alamat & Kontak</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat_siswa" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat_siswa" name="alamat_siswa" rows="3"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nomor_wa" class="form-label">Nomor WhatsApp</label>
                    <input type="text" class="form-control" id="nomor_wa" name="nomor_wa">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_orang_tua" class="form-label">Nama Orang Tua</label>
                    <input type="text" class="form-control" id="nama_orang_tua" name="nama_orang_tua">
                </div>
            </div>
            
            <hr class="form-section-divider">
            <h4 class="form-section-title">Data Tambahan</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="hobi" class="form-label">Hobi</label>
                    <input type="text" class="form-control" id="hobi" name="hobi">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cita_cita" class="form-label">Cita-cita</label>
                    <input type="text" class="form-control" id="cita_cita" name="cita_cita">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <button type="button" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection