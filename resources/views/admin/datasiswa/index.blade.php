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

<div class="filter-container" style="margin-bottom:20px;">
    <div style="display:flex; gap:15px; margin-bottom: 20px; align-items: center;">
        <a href="{{ route('admin.datasiswa.create') }}" 
           style="background:#1abc9c; color:white; border:none; padding:10px 15px; border-radius:8px; text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Data Siswa
        </a>
        
        <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
            @csrf
            <label for="file" 
                style="background:#3498db; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer;">
                <i class="fas fa-file-excel"></i> Import Excel
            </label>
            <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" 
                style="display:none;" onchange="this.form.submit();">
        </form>
    </div>
</div>

<style>
    /* =======================
       TABEL DATA SISWA
    ======================= */
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        table-layout: fixed; /* penting agar kolom sejajar */
    }

    thead {
        background: #2c3e50;
        color: white;
    }

    th, td {
        padding: 6px 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        vertical-align: middle;
        word-wrap: break-word;
    }

    th:nth-child(1) { width: 5%; text-align: center; }
    th:nth-child(2) { width: 15%; }
    th:nth-child(3) { width: 25%; }
    th:nth-child(4) { width: 15%; }
    th:nth-child(5) { width: 25%; }
    th:nth-child(6) { width: 15%; text-align: center; }

    tbody tr:hover {
        background: #f8f9fa;
    }

    /* Aksi sejajar */
    .aksi-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-wrap: nowrap;
    }

    .aksi-container a, 
    .aksi-container button {
        font-size: 14px;
        text-decoration: none;
        border: none;
        background: none;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .aksi-container a i,
    .aksi-container button i {
        margin-right: 4px;
    }

    .aksi-container a:hover,
    .aksi-container button:hover {
        opacity: 0.8;
    }

    /* Tombol warna aksi */
    .aksi-lihat { color: #007bff; }
    .aksi-edit { color: #ff9800; }
    .aksi-hapus { color: #e74c3c; }
</style>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Rombel</th>
            <th>Kompetensi Keahlian</th>
            <th>Aksi</th>
        </tr>
    </thead>
   <tbody>
        @forelse($siswas as $i => $siswa)
        <tr>
            <td style="text-align:center;">{{ $i + $siswas->firstItem() }}</td>
            <td>{{ $siswa->nis }}</td>
            <td>{{ $siswa->nama_lengkap }}</td>
            <td>{{ $siswa->rombel }}</td>
            <td>{{ $siswa->jurusan }}</td>
            <td>
                <div class="aksi-container">
                    <a href="{{ route('admin.datasiswa.show', $siswa->nis) }}" class="aksi-lihat">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="{{ route('admin.datasiswa.edit', $siswa->nis) }}" class="aksi-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.datasiswa.destroy', $siswa->nis) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="aksi-hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; padding:10px;">Belum ada data siswa.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination tanpa "Showing..." --}}
<div style="margin-top:20px; display:flex; justify-content:center;">
    <style>
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
        }
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            vertical-align: middle;
        }
        .pagination a, 
        .pagination span {
            padding: 6px 12px;
            border-radius: 6px;
            background: #f8f9fa;
            color: #4B0082;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .pagination a:hover {
            background: #4B0082;
            color: #fff;
        }
        .pagination .active span {
            background: #4B0082;
            color: white;
        }
    </style>

    {{ $siswas->appends(request()->query())->links('pagination::simple-tailwind') }}
</div>
@endsection
