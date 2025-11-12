@extends('layouts.siswa')
@section('title', 'Form Konseling')
@section('page_title', 'Pengajuan Konseling')

@section('content')
<div class="form-konseling-wrapper">

    <div class="header-konseling">
        <h4>📝 Form Pengajuan Konseling</h4>
        <span class="tanggal-jam">{{ now()->format('d M Y, H:i') }}</span>
    </div>

    <div class="form-container">
        <form action="{{ route('siswa.konseling.store') }}" method="POST">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" value="{{ $siswa->nama_lengkap }}" readonly>
                </div>

                <div class="form-group">
                    <label>NIS</label>
                    <input type="text" name="nis" value="{{ $siswa->nis }}" readonly>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" name="kelas" value="{{ $siswa->rombel }}" readonly>
                </div>

                <div class="form-group">
                    <label>Nama Orang Tua</label>
                    <input type="text" name="nama_ortu" value="{{ $siswa->nama_ortu ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>Alamat Orang Tua</label>
                    <input type="text" name="alamat_ortu" value="{{ $siswa->alamat ?? '-' }}" readonly>
                </div>

                <div class="form-group">
                    <label>No Telp Orang Tua</label>
                    <input type="text" name="no_telp_ortu" value="{{ $orangtua->no_telp_ayah ?? '-' }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Alasan Konseling</label>
                <textarea name="alasan" rows="4" placeholder="Tuliskan alasan konseling di sini..."></textarea>
            </div>

            <div class="form-group">
                <label>Topik / Peristiwa</label>
                <input type="text" name="topik" placeholder="Contoh: Konflik dengan teman" required>
            </div>

            <div class="form-group">
                <label>Latar Belakang</label>
                <textarea name="latar_belakang" rows="4" placeholder="Ceritakan latar belakang masalah..." required></textarea>
            </div>

            <div class="form-group">
                <label>Kegiatan Layanan yang Diinginkan</label>
                <textarea name="kegiatan_layanan" rows="4" placeholder="Contoh: Konseling individu, bimbingan kelompok, dll." required></textarea>
            </div>

            <div class="form-buttons">
                <a href="{{ route('siswa.konseling.index') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>

<style>
/* === HEADER === */
.header-konseling {
    background-color: #123B6B;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 25px;
    border-radius: 8px 8px 0 0;
}

.header-konseling h4 {
    margin: 0;
    font-weight: 600;
}

.tanggal-jam {
    font-size: 14px;
    opacity: 0.9;
}

/* === FORM CONTAINER === */
.form-container {
    background: #ffffff;
    padding: 25px;
    border: 1px solid #ddd;
    border-top: none;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* === GRID LAYOUT === */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 20px;
    margin-bottom: 20px;
    row-gap: 25px;
}

/* === FORM GROUP === */
.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 6px;
    color: black;
}

.form-group input,
.form-group textarea {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 10px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #123B6B;
    outline: none;
    box-shadow: 0 0 4px rgba(18,59,107,0.3);
}

/* === BUTTON === */
.form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.btn-primary {
    background-color: #123B6B;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.btn-primary:hover {
    background-color: #0f2e52;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* === ALERT STYLE === */
.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}
</style>
@endsection
