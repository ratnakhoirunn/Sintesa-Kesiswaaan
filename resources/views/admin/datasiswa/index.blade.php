@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')

@section('content')
@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

{{-- Kontainer Filter dan Tombol Aksi --}}
<div class="filter-container" style="margin-bottom:20px;">
    {{-- Menggunakan display:flex untuk memastikan tombol sejajar --}}
    <div style="display:flex; gap:15px; margin-bottom: 20px; align-items: center;">
        
        {{-- Tombol Tambah Data Manual --}}
        <a href="{{ route('admin.datasiswa.create') }}" 
           style="background:#1abc9c; color:white; border:none; padding:10px 15px; border-radius:8px; text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Data Siswa
        </a>
        
        {{-- Formulir Import Excel (Menggunakan label untuk memicu input file yang tersembunyi) --}}
        <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
            @csrf
            
            <label for="file" 
                style="background:#3498db; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer;">
                <i class="fas fa-file-excel"></i> Import Excel
            </label>
            
            {{-- Input file yang tersembunyi, akan otomatis submit saat file dipilih --}}
            <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" 
                style="display:none;" onchange="this.form.submit();">
        </form>
    </div>
</div>

{{-- Tabel Data Siswa --}}
<table style="width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden;">
    <thead style="background:#2c3e50; color:white;">
        <tr>
            <th style="padding:10px; text-align:left;">No</th>
            <th style="padding:10px; text-align:left;">NIS</th>
            <th style="padding:10px; text-align:left;">Nama Lengkap</th>
            <th style="padding:10px; text-align:left;">Rombel</th>
            <th style="padding:10px; text-align:left;">Kompetensi Keahlian</th>
            <th style="padding:10px; text-align:left;">Aksi</th>
        </tr>
    </thead>
   <tbody>
        @forelse($siswas as $i => $siswa)
        <tr style="border-bottom:1px solid #ddd;">
            {{-- Nomor urut yang benar untuk paginasi --}}
            <td style="padding:10px; text-align:center;">{{ $i + $siswas->firstItem() }}</td>
            <td style="padding:10px;">{{ $siswa->nis }}</td>
            <td style="padding:10px;">{{ $siswa->nama_lengkap }}</td>
            <td style="padding:10px;">{{ $siswa->rombel }}</td>
            <td style="padding:10px;">{{ $siswa->jurusan }}</td>
            <td style="padding:10px; display:flex; gap:10px; align-items:center;">
                {{-- Tautan Aksi --}}
                <a href="{{ route('admin.datasiswa.show', $siswa->id) }}" style="color:blue;"><i class="fas fa-eye"></i> Lihat</a>
                <a href="{{ route('admin.datasiswa.edit', $siswa->id) }}" style="color:orange;"><i class="fas fa-edit"></i> Edit</a>
                <form action="{{ route('admin.datasiswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border:none; background:none; color:red; cursor:pointer;"><i class="fas fa-trash"></i> Hapus</button>
                </form>

            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; padding:10px;">Belum ada data siswa.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Link Paginasi (Penting agar tidak error BadMethodCallException) --}}
<div style="margin-top:15px; display:flex; justify-content:center;">
    {{ $siswas->links() }}
</div>
@endsection
