@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')

@section('content')
<div class="filter-container" style="margin-bottom:20px;">

    <!-- Baris filter -->
    <div class="filter-bar" 
         style="display:flex; gap:15px; margin-bottom:15px; align-items:center; flex-wrap:wrap;">
        
        <div style="display:flex; flex-direction:column;">
            <label for="kelas" style="font-size:14px; margin-bottom:5px;">Pilih Kelas</label>
            <select id="kelas" style="padding:8px; border-radius:8px; min-width:80px;">
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>

        <div style="display:flex; flex-direction:column;">
            <label for="jurusan" style="font-size:14px; margin-bottom:5px;">Pilih Jurusan</label>
            <select id="jurusan" style="padding:8px; border-radius:8px; min-width:200px;">
                <option>Rekayasa Perangkat Lunak</option>
                <option>Desain Komunikasi Visual</option>
                <option>Teknik Jaringan Komputer</option>
            </select>
        </div>

        <div style="display:flex; flex-direction:column;">
            <label for="search" style="font-size:14px; margin-bottom:5px;">Cari</label>
            <input type="text" id="search" placeholder="Ketik untuk mencari..." 
                   style="padding:8px; border-radius:8px; min-width:200px;">
        </div>
    </div>

    <!-- Baris tombol -->
    <div style="display:flex; gap:15px; margin-bottom: 20px;">
        <a href="{{ route('admin.siswa.create') }}" 
   style="background:#1abc9c; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer; display:flex; align-items:center; gap:6px; text-decoration: none;">
    <i class="fas fa-plus"></i> Tambah Data Siswa
            </a>

   <a href="{{ route('admin.upload.siswa') }}" style="background:#3498db; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer; display:flex; align-items:center; gap:6px; text-decoration: none;">
    <i class="fas fa-file-upload"></i> Unggah Data Siswa
</a>
    </div>
</div>

<table style="width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden;">
    <thead style="background:#2c3e50; color:white;">
        <tr>
            <th style="padding:10px;">No</th>
            <th style="padding:10px;">NIS</th>
            <th style="padding:10px;">Nama Lengkap</th>
            <th style="padding:10px;">ROMBEL</th>
            <th style="padding:10px;">Jurusan</th>
            <th style="padding:10px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @for($i=1; $i<=10; $i++)
        <tr style="border-bottom:1px solid #ddd;">
            <td style="padding:10px; text-align:center;">{{ $i }}</td>
            <td style="padding:10px;">2510175{{ $i }}</td>
            <td style="padding:10px;">Adinata Royyan Alfarobby</td>
            <td style="padding:10px;">X DKV 1</td>
            <td style="padding:10px;">Desain Komunikasi Visual</td>
            <td style="padding:10px; display:flex; gap:10px; align-items:center;">
                <a href="#" style="color:blue;"><i class="fas fa-eye"></i> Lihat</a>
                <a href="#" style="color:orange;"><i class="fas fa-edit"></i></a>
                <a href="#" style="color:red;"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection
