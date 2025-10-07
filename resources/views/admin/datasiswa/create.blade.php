@extends('layouts.admin')
@section('title', 'Tambah Data Siswa')

@section('content')
<h2>Tambah Data Siswa</h2>

<form action="{{ route('siswa.store') }}" method="POST" style="max-width:600px;">
    @csrf
    <div style="margin-bottom:10px;">
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Rombel</label>
        <input type="text" name="rombel" class="form-control" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Jurusan</label>
        <input type="text" name="jurusan" class="form-control" required>
    </div>

    <button type="submit" style="background:#1abc9c; color:white; padding:10px 20px; border:none; border-radius:8px;">Simpan</button>
    <a href="{{ route('siswa.index') }}" style="margin-left:10px;">Kembali</a>
</form>
@endsection
