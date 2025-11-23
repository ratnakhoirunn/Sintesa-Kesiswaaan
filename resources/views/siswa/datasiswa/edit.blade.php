@extends('layouts.siswa')
@section('title', 'Edit Biodata')
@section('page_title', 'Edit Biodata Siswa')

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

    label {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    input, select, textarea {
        width: 100%;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background: #f9f9f9;
        font-size: 0.95rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 40px;
        margin-bottom: 20px;
    }

    .btn-blue {
        background-color: #1e3a67;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        text-decoration: none;
        margin-right: 10px;
    }

    .btn-blue:hover { background-color: #0056b3; }

    .btn-gray {
        background-color: #4a4a4a;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
    }

    .btn-gray:hover { background-color: #3a3a3a; }

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
    }

    .detail-box .body {
        padding: 20px;
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

        <div class="form-body">

            <form action="{{ route('siswa.profil.update', $siswa->nis) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- FOTO --}}
                <div style="text-align:center; margin-bottom:25px;">
                    <img src="{{ $siswa->foto ? asset('uploads/foto_siswa/' . $siswa->foto) : asset('images/icon pelajar.jpeg') }}"
                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                    <br><br>
                    <input type="file" name="foto" accept="image/*">
                </div>

                {{-- DATA UTAMA --}}
                <div class="form-row">
                    <div>
                        <label>NIS</label>
                        <input type="text" value="{{ $siswa->nis }}" readonly>
                    </div>
                    <div>
                        <label>NISN</label>
                        <input type="number" name="nisn" value="{{ $siswa->nisn }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $siswa->nama_lengkap }}">
                    </div>
                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="Laki-laki" {{ $siswa->jenis_kelamin=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $siswa->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $siswa->email }}">
                    </div>
                    <div>
                        <label>No WhatsApp</label>
                        <input type="text" name="no_whatsapp" value="{{ $siswa->no_whatsapp }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Rombel</label>
                        <input type="text" name="rombel" value="{{ $siswa->rombel }}">
                    </div>
                    <div>
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" value="{{ $siswa->jurusan }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}">
                    </div>
                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}">
                    </div>
                </div>

                <div class="form-row">
                    <div>
                        <label>Agama</label>
                        <input type="text" name="agama" value="{{ $siswa->agama }}">
                    </div>
                    <div>
                        <label>Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" value="{{ $siswa->nama_ortu }}">
                    </div>
                </div>

                <div class="form-row">
                    <div style="grid-column: span 2;">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="3">{{ $siswa->alamat }}</textarea>
                    </div>
                </div>

                {{-- DETAIL SISWA --}}
                <div class="detail-container">

                    {{-- BOX 1 --}}
                    <div class="detail-box">
                        <div class="header">BIODATA DETAIL</div>
                        <div class="body">
                            @php $d = $siswa->detailSiswa; @endphp

                            <div class="form-group"><label>Cita-cita</label>
                                <input type="text" name="cita_cita" value="{{ $d->cita_cita }}">
                            </div>

                            <div class="form-group"><label>Hobi</label>
                                <input type="text" name="hobi" value="{{ $d->hobi }}">
                            </div>

                            <div class="form-group"><label>Berat Badan</label>
                                <input type="number" name="berat_badan" value="{{ $d->berat_badan }}">
                            </div>

                            <div class="form-group"><label>Tinggi Badan</label>
                                <input type="number" name="tinggi_badan" value="{{ $d->tinggi_badan }}">
                            </div>

                            <div class="form-group"><label>Anak ke-</label>
                                <input type="number" name="anak_ke" value="{{ $d->anak_ke }}">
                            </div>

                            <div class="form-group"><label>Jumlah Saudara</label>
                                <input type="number" name="jumlah_saudara" value="{{ $d->jumlah_saudara }}">
                            </div>

                            <div class="form-group"><label>Tinggal Dengan</label>
                                <input type="text" name="tinggal_dengan" value="{{ $d->tinggal_dengan }}">
                            </div>

                            <div class="form-group"><label>Jarak Rumah</label>
                                <input type="text" name="jarak_rumah" value="{{ $d->jarak_rumah }}">
                            </div>

                            <div class="form-group"><label>Waktu Tempuh</label>
                                <input type="text" name="waktu_tempuh" value="{{ $d->waktu_tempuh }}">
                            </div>

                            <div class="form-group"><label>Transportasi</label>
                                <input type="text" name="transportasi" value="{{ $d->transportasi }}">
                            </div>
                        </div>
                    </div>

                    {{-- BOX 2 --}}
                    <div class="detail-box">
                        <div class="header">ALAMAT DETAIL</div>
                        <div class="body">
                            <div class="form-group"><label>Nama Jalan</label>
                                <input type="text" name="nama_jalan" value="{{ $d->nama_jalan }}">
                            </div>

                            <div class="form-group"><label>RT</label>
                                <input type="text" name="rt" value="{{ $d->rt }}">
                            </div>

                            <div class="form-group"><label>RW</label>
                                <input type="text" name="rw" value="{{ $d->rw }}">
                            </div>

                            <div class="form-group"><label>Dusun</label>
                                <input type="text" name="dusun" value="{{ $d->dusun }}">
                            </div>

                            <div class="form-group"><label>Desa</label>
                                <input type="text" name="desa" value="{{ $d->desa }}">
                            </div>

                            <div class="form-group"><label>Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ $d->kode_pos }}">
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <button type="submit" class="btn-blue">Simpan Perubahan</button>
                <a href="{{ route('siswa.profil.show', $siswa->nis) }}" class="btn-gray">Batal</a>

            </form>

        </div>
    </div>
</div>

@endsection
