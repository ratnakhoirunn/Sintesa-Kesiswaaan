@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page_title', 'Data Lengkap Siswa')

@section('content')
<div style="background:#fff; padding:20px; border-radius:8px;">

    <!-- Header -->
    <div style="background:#4a7eb0; color:white; padding:10px 15px; border-radius:6px 6px 0 0;">
        <h4 style="margin:0; font-size:16px;">BIODATA SISWA</h4>
    </div>

    <div style="padding:20px; background:#f5f6fa;">

    <!-- Foto di tengah -->
    <div style="text-align:center; margin-bottom:20px;">
        <img src="{{ asset('images/icon pelajar.jpeg') }}" 
             alt="Foto Siswa" 
             style="width:120px; height:120px; border-radius:50%; border:2px solid #ccc;">
        <br><br>
        <button style="background:#4a7eb0; color:white; padding:6px 12px; border:none; border-radius:5px; cursor:pointer;">
            Ubah Foto
        </button>
    </div>

    <!-- Form Biodata -->
    <div style="display:grid; gap:20px;">
        
        <div>
            <label>Nomor Induk Siswa</label>
            <input type="text" value="{{ $siswa->nis ?? '25101757' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>
        
        <div>
            <label>Nomor Induk Siswa Nasional</label>
            <input type="text" value="{{ $siswa->nisn ?? '0088576978' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Nama Lengkap</label>
            <input type="text" value="{{ $siswa->nama_lengkap ?? 'ADINATA ROYYAN ALFAROBBY' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Tempat Lahir</label>
            <input type="text" value="{{ $siswa->tempat_lahir ?? 'Sleman' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <input type="text" value="{{ $siswa->jenis_kelamin ?? 'Laki-laki' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Tanggal Lahir</label>
            <input type="text" value="{{ $siswa->tanggal_lahir ?? '31 Agustus 2009' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>ROMBEL</label>
            <input type="text" value="{{ $siswa->rombel ?? 'X DKV 1' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Kompetensi Keahlian</label>
            <input type="text" value="{{ $siswa->jurusan ?? 'Desain Komunikasi Visual' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Agama</label>
            <input type="text" value="{{ $siswa->agama ?? 'Islam' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>Email Aktif</label>
            <input type="text" value="{{ $siswa->email ?? 'alfarobby1@gmail.com' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>

        <div>
            <label>No HP/WA</label>
            <input type="text" value="{{ $siswa->no_hp ?? '085727114070' }}" 
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:5px;" readonly>
        </div>
    </div>

    <!-- Tombol kembali -->
    <div style="margin-top:20px;">
        <a href="{{ route('admin.datasiswa') }}" 
           style="background:#2c3e50; color:white; padding:8px 15px; border-radius:6px; text-decoration:none;">
            Kembali
        </a>
    </div>
</div>
@endsection
