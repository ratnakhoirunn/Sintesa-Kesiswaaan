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
                <option>Desain Komunikasi Visual</option>
                <option>Desain Pemodelan dan Informasi Bangunan</option>
                <option>Teknik Geospasial</option>
                <option>Konstruksi Gedung dan Sanitasi</option>
                <option>Teknik Mekatronika</option>
                <option>Sistem Informasi Jaringan dan Aplikasi ( Pengembangan Perangkat Lunak dan Gim )</option>
                <option>Teknik Audio Video</option>
                <option>Teknik Instalasi Tenaga Listrik</option>
                <option>Teknik Teknik Kendaraan Ringan</option>
                <option>Teknik Pemesinan</option>
            </select>
        </div>

        <div style="display:flex; flex-direction:column;">
            <label for="search" style="font-size:14px; margin-bottom:5px;">Cari</label>
            <input type="text" id="search" placeholder="Ketik untuk mencari..." 
                   style="padding:8px; border-radius:8px; min-width:200px;">
        </div>
    </div>

    <!-- Baris tombol -->
    <div class="action-bar">
        <button style="background:#769CCB; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer; display:flex; align-items:center; gap:6px;">
            <i class="fas fa-plus"></i> Tambah Data Siswa
        </button>
    </div>

</div>

<table style="width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; font-size:14px;">
    <thead style="background:#2c3e50; color:white; text-align:center;">
        <tr>
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">NIS</th>
            <th style="padding:12px;">Nama Lengkap</th>
            <th style="padding:12px;">ROMBEL</th>
            <th style="padding:12px;">Jurusan</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @for($i=1; $i<=10; $i++)
        <tr style="border-bottom:1px solid #ddd; text-align:center; transition: background 0.2s;"
            onmouseover="this.style.background='#f5f5f5';" 
            onmouseout="this.style.background='white';">
            
            <td style="padding:10px;">{{ $i }}</td>
            <td style="padding:10px;">2510175{{ $i }}</td>
            <td style="padding:10px;">Adinata Royyan Alfarobby</td>
            <td style="padding:10px;">X DKV 1</td>
            <td style="padding:10px;">Desain Komunikasi Visual</td>
            <td style="padding:10px; display:flex; justify-content:center; gap:8px;">
                <a href="{{ route('admin.datasiswa.read', $i) }}" 
                    style="color:blue; text-decoration:none;" title="Lihat">
                        <i class="fas fa-eye"></i>
                </a>

                <a href="#" style="color:orange; text-decoration:none;" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" style="color:red; text-decoration:none;" title="Hapus">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection
