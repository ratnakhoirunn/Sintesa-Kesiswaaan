@extends('layouts.admin')

@section('title', 'Tambah Prestasi')
@section('page_title', 'Tambah Data Prestasi')

@section('content')
<style>
    .wrap-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .header-box {
        background: #0e325f;
        color: white;
        padding: 18px 25px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-body {
        background: #fff;
        padding: 25px;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }

    label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-control, select, textarea {
        width: 100% !important;
        border: 1px solid #bfbfbf;
        border-radius: 8px;
        padding: 12px;
        font-size: 15px;
        margin-bottom: 14px;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #0e325f;
        box-shadow: 0 0 5px rgba(14,50,95,0.4);
    }

    .btn-primary {
        background-color: #123B6B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
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
    }
</style>

<div class="wrap-card">

    {{-- HEADER --}}
    <div class="header-box">
        <span>Tambah Data Prestasi Siswa</span>
        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}<br>
              {{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
    </div>

    <div class="form-body">
        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- PILIH SISWA (NIS) --}}
            <label for="nis">Nama Siswa</label>
            <select id="nis" name="nis" class="form-control" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->nis }}">{{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</option>
                @endforeach
            </select>

            {{-- Judul Prestasi --}}
            <label for="judul">Judul Prestasi</label>
            <input type="text" id="judul" name="judul" class="form-control" required>

            {{-- Jenis Prestasi --}}
            <label for="jenis">Jenis Prestasi</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="">-- Pilih Jenis Prestasi --</option>
                <option value="Lomba">Lomba</option>
                <option value="Seminar">Seminar</option>
                <option value="Sertifikat">Sertifikat</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            {{-- Deskripsi --}}
            <label for="deskripsi">Deskripsi (Opsional)</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>

            {{-- File Upload --}}
            <label for="file">Upload Bukti (PDF/JPG/JPEG/PNG)</label>
            <input type="file" id="file" name="file" class="form-control"
                   accept=".pdf,.jpg,.jpeg,.png">

            {{-- Link Prestasi --}}
            <label for="link">Link Prestasi (Opsional)</label>
            <input type="url" id="link" name="link" class="form-control">

            {{-- Tanggal Prestasi --}}
            <label for="tanggal_prestasi">Tanggal Prestasi</label>
            <input type="date" id="tanggal_prestasi" name="tanggal_prestasi" class="form-control" required>

            {{-- Tombol --}}
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <a href="{{ route('admin.prestasi.index') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Simpan Data</button>
            </div>

        </form>
    </div>

</div>

@endsection
