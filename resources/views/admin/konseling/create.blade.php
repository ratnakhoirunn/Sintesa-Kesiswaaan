@extends('layouts.admin')

@section('title', 'Tambah Konseling')
@section('page_title', 'Tambah Data Konseling')

@section('content')
<div class="card shadow-sm">
    <div class="card-header" style="background-color:#123B6B; color:white;">
        <h5 class="mb-0">Form Tambah Data Konseling</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.konseling.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jenis Konseling</label>
                <input type="text" name="jenis_konseling" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.konseling.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
