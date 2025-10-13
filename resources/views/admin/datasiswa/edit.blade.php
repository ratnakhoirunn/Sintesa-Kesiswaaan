@extends('layouts.admin')

@section('title', 'Edit Data Siswa')
@section('page_title', 'Edit Data Siswa')

@section('content')
<style>
/* ------------------------------
   STYLE HALAMAN EDIT SISWA
--------------------------------*/
.card-siswa {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    margin: 0 auto;
}

.section-title {
    background-color: #1e3a67;
    color: #fff;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 12px 20px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.form-body {
    padding: 25px 40px;
}

.foto-wrapper {
    text-align: center;
    margin-bottom: 25px;
}
.foto-wrapper img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e5e5e5;
}

/* Label dan Input */
label {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}
.form-control {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
textarea.form-control {
    resize: none;
    min-height: 80px;
}

/* Tombol */
.btn-blue {
    display: inline-block;
    background-color: #1e3a67;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    border: none;
    transition: 0.3s;
    margin: 0 6px;
}
.btn-blue:hover {
    background-color: #0056b3;
    color: white;
    text-decoration: none;
}
.btn-gray {
    display: inline-block;
    background-color: #4a4a4a;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    border: none;
    transition: 0.3s;
    margin: 0 6px;
}
.btn-gray:hover {
    background-color: #3a3a3a;
    color: white;
}

/* Grid dua kolom */
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 40px;
    margin-bottom: 20px;
}

/* Scroll agar tidak terlalu panjang */
.scrollable-content {
    max-height: 85vh;
    overflow-y: auto;
    padding-right: 10px;
}
</style>

<div class="scrollable-content">
    <div class="card-siswa">
        <div class="section-title">
            EDIT DATA SISWA: {{ $siswa->nama_lengkap }}
        </div>

        <div class="form-body">
            <form action="{{ route('admin.datasiswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- FOTO SISWA --}}
                <div class="foto-wrapper">
                    <img id="preview-image" 
                         src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/student.png') }}" 
                         alt="Foto Siswa">
                    <br><br>
                    <input type="file" name="foto" class="form-control" onchange="previewImage(event)">
                </div>

                {{-- ===== DATA SISWA ===== --}}
                <div class="form-row">
                    <div>
                        <label>NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}">
                    </div>
                    <div>
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                    </div>
                    <div>
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                    </div>
                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Rombel</label>
                        <input type="text" name="rombel" class="form-control" value="{{ old('rombel', $siswa->rombel) }}">
                    </div>
                    <div>
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $siswa->jurusan) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                    </div>
                    <div>
                        <label>No. WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa', $siswa->no_wa) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div style="grid-column: span 2;">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>
                </div>

                {{-- ===== DATA ORANG TUA ===== --}}
                <div class="section-title" style="margin-top:30px;">DATA ORANG TUA</div>
                <div class="form-body" style="padding:20px 0;">
                    <div class="form-row">
                        <div>
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                        </div>
                        <div>
                            <label>Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                        </div>
                        <div>
                            <label>Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>No. HP Orang Tua</label>
                            <input type="text" name="no_hp_ortu" class="form-control" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}">
                        </div>
                        <div>
                            <label>Alamat Orang Tua</label>
                            <input type="text" name="alamat_ortu" class="form-control" value="{{ old('alamat_ortu', $siswa->alamat_ortu) }}">
                        </div>
                    </div>
                </div>

                {{-- ===== DATA WALI SISWA ===== --}}
                <div class="section-title" style="margin-top:30px;">DATA WALI SISWA (JIKA ADA)</div>
                <div class="form-body" style="padding:20px 0;">
                    <div class="form-row">
                        <div>
                            <label>Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $siswa->nama_wali) }}">
                        </div>
                        <div>
                            <label>Pekerjaan Wali</label>
                            <input type="text" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>No. HP Wali</label>
                            <input type="text" name="no_hp_wali" class="form-control" value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}">
                        </div>
                        <div>
                            <label>Alamat Wali</label>
                            <input type="text" name="alamat_wali" class="form-control" value="{{ old('alamat_wali', $siswa->alamat_wali) }}">
                        </div>
                    </div>
                </div>

                {{-- ===== TOMBOL AKSI ===== --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-blue">💾 Simpan Semua Perubahan</button>
                    <a href="{{ route('admin.datasiswa.index') }}" class="btn btn-gray">⬅ Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview-image').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
