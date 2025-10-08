@extends('layouts.admin')
@section('title', 'Detail Siswa')

@section('content')
<h3>Data Lengkap Siswa</h3>
<img src="{{ asset('storage/'.$siswa->foto) }}" width="100"><br>

<p><strong>NIS:</strong> {{ $siswa->nis }}</p>
<p><strong>Nama:</strong> {{ $siswa->nama_lengkap }}</p>
<p><strong>Rombel:</strong> {{ $siswa->rombel }}</p>
<p><strong>Jurusan:</strong> {{ $siswa->jurusan }}</p>
<p><strong>Tempat, Tanggal Lahir:</strong> {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</p>
<p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
<p><strong>Agama:</strong> {{ $siswa->agama }}</p>
<p><strong>Nama Orang Tua:</strong> {{ $siswa->nama_ortu }}</p>
<p><strong>Alamat:</strong> {{ $siswa->alamat }}</p>

<a href="{{ route('admin.siswa.kartu', $siswa->id) }}" class="btn btn-primary">Cetak Kartu Pelajar</a>
@endsection
