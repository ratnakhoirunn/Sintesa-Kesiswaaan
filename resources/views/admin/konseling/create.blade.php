@extends('layouts.admin')

@section('title', 'Tambah Konseling')
@section('page_title', 'Tambah Data Konseling')

@section('content')
<style>
    .card-konseling {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 700px;
        margin: 0 auto;
    }

    .card-header {
        background-color: #123B6B;
        color: white;
        font-weight: 600;
        padding: 14px 20px;
    }

    .card-body {
        padding: 25px 30px;
    }

    label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #123B6B;
        box-shadow: 0 0 5px rgba(18,59,107,0.4);
    }

    .btn {
        border-radius: 8px;
        padding: 8px 18px;
        font-weight: 500;
    }

    .btn-success {
        background-color: #123B6B;
        border: none;
    }

    .btn-success:hover {
        background-color: #0e2f59;
    }

    .btn-secondary {
        background-color: #ccc;
        color: #000;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #b3b3b3;
    }
</style>

<div class="card-konseling">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Data Konseling</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.konseling.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="jenis_konseling">Jenis Konseling</label>
                <input type="text" id="jenis_konseling" name="jenis_konseling" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.konseling.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
