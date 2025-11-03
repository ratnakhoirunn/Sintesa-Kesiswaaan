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
    <div class="topbar-filter">
        <form method="GET" action="{{ route('admin.datasiswa.index') }}" class="filter-form">
            <div class="filter-container">
                <!-- Pilih Rombel -->
                <div class="filter-group">
                    <label for="rombel">Pilih Rombel</label>
                    <select name="rombel" id="rombel" class="filter-select">
                        <option value="">Semua</option>
                        <option value="X DKV 1" {{ request('rombel') == 'X DKV 1' ? 'selected' : '' }}>X DKV 1</option>
                        <option value="X DKV 2" {{ request('rombel') == 'X DKV 2' ? 'selected' : '' }}>X DKV 2</option>
                        <option value="X DPIB 1" {{ request('rombel') == 'X DPIB 1' ? 'selected' : '' }}>X DPIB 1</option>
                        <option value="X DPIB 2" {{ request('rombel') == 'X DPIB 2' ? 'selected' : '' }}>X DPIB 2</option>
                        <option value="X DPIB 3" {{ request('rombel') == 'X DPIB 3' ? 'selected' : '' }}>X DPIB 3</option>
                        <option value="X GEOMATIKA" {{ request('rombel') == 'X GEOMATIKA' ? 'selected' : '' }}>X GEOMATIKA</option>
                        <option value="X KGS" {{ request('rombel') == 'X KGS' ? 'selected' : '' }}>X KGS</option>
                        <option value="X MEKATRONIKA" {{ request('rombel') == 'X MEKATRONIKA' ? 'selected' : '' }}>X MEKATRONIKA</option>
                        <option value="X SIJA 1" {{ request('rombel') == 'X SIJA 1' ? 'selected' : '' }}>X SIJA 1</option>
                        <option value="X SIJA 2" {{ request('rombel') == 'X SIJA 2' ? 'selected' : '' }}>X SIJA 2</option>
                        <option value="X TAV" {{ request('rombel') == 'X TAV' ? 'selected' : '' }}>X TAV</option>
                        <option value="X TITL 1" {{ request('rombel') == 'X TITL 1' ? 'selected' : '' }}>X TITL 1</option>
                        <option value="X TITL 2" {{ request('rombel') == 'X TITL 2' ? 'selected' : '' }}>X TITL 2</option>
                        <option value="X TITL 3" {{ request('rombel') == 'X TITL 3' ? 'selected' : '' }}>X TITL 3</option>
                        <option value="X TITL 4" {{ request('rombel') == 'X TITL 4' ? 'selected' : '' }}>X TITL 4</option>
                        <option value="X TKR 1" {{ request('rombel') == 'X TKR 1' ? 'selected' : '' }}>X TKR 1</option>
                        <option value="X TKR 2" {{ request('rombel') == 'X TKR 2' ? 'selected' : '' }}>X TKR 2</option>
                        <option value="X TKR 3" {{ request('rombel') == 'X TKR 3' ? 'selected' : '' }}>X TKR 3</option>
                        <option value="X TKR 4" {{ request('rombel') == 'X TKR 4' ? 'selected' : '' }}>X TKR 4</option>
                        <option value="X TP 1" {{ request('rombel') == 'X TP 1' ? 'selected' : '' }}>X TP 1</option>
                        <option value="X TP 2" {{ request('rombel') == 'X TP 2' ? 'selected' : '' }}>X TP 2</option>
                        <option value="X TP 3" {{ request('rombel') == 'X TP 3' ? 'selected' : '' }}>X TP 3</option>
                        <option value="X TP 4" {{ request('rombel') == 'X TP 4' ? 'selected' : '' }}>X TP 4</option>
                    </select>
                </div>

                <!-- Pilih Jurusan -->
                <div class="filter-group">
                    <label for="jurusan">Pilih Jurusan</label>
                    <select name="jurusan" id="jurusan" class="filter-select">
                        <option value="">Semua</option>
                        <option value="Desain Komunikasi Visual" {{ request('jurusan') == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                        <option value="Desain Pemodelan dan Informasi Bangunan" {{ request('jurusan') == 'Desain Pemodelan dan Informasi Bangunan' ? 'selected' : '' }}>Desain Pemodelan dan Informasi Bangunan</option>
                        <option value="Teknik Geospasial" {{ request('jurusan') == 'Teknik Geospasial' ? 'selected' : '' }}>Teknik Geospasial</option>
                        <option value="Konstruksi Gedung dan Sanitasi" {{ request('jurusan') == 'Konstruksi Gedung dan Sanitasi' ? 'selected' : '' }}>Konstruksi Gedung dan Sanitasi</option>
                        <option value="Teknik Mekatronika" {{ request('jurusan') == 'Teknik Mekatronika' ? 'selected' : '' }}>Teknik Mekatronika</option>
                        <option value="Sistem Informasi Jaringan dan Aplikasi ( Pengembangan Perangkat Lunak dan Gim )" {{ request('jurusan') == 'Sistem Informasi Jaringan dan Aplikasi ( Pengembangan Perangkat Lunak dan Gim )' ? 'selected' : '' }}>Sistem Informasi Jaringan dan Aplikasi ( Pengembangan Perangkat Lunak dan Gim )</option>
                        <option value="Teknik Audio Video" {{ request('jurusan') == 'Teknik Audio Video' ? 'selected' : '' }}>Teknik Audio Video</option>
                        <option value="Teknik Instalasi Tenaga Listrik" {{ request('jurusan') == 'Teknik Instalasi Tenaga Listrik' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik</option>
                        <option value="Teknik Kendaraan Ringan" {{ request('jurusan') == 'Teknik Kendaraan Ringan' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                        <option value="Teknik Pemesinan" {{ request('jurusan') == 'Teknik Pemesinan' ? 'selected' : '' }}>Teknik Pemesinan</option>
                    </select>
                </div>

                <!-- Pencarian -->
                <div class="filter-group">
                    <label for="search">Cari</label>
                    <div class="search-box">
                        <input type="text" name="search" id="search" placeholder="Ketik untuk mencari..." value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tombol kanan -->
        <div class="button-group">
            <a href="{{ route('admin.datasiswa.create') }}" class="btn-tambah">
                <i class="fas fa-plus"></i> Tambah Data Siswa
            </a>

            <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
                @csrf
                <label for="file" class="btn-import">
                    <i class="fas fa-file-excel"></i> Import Excel
                </label>
                <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" style="display:none;" onchange="this.form.submit();">
            </form>
        </div>
    </div>

    @if ($rombel)
     <div style="margin-top: 6px; text-align: right; color: #121212ff;">
        <strong>Jumlah siswa di {{ $rombel }}:</strong> {{ $jumlah }}
    </div>
@else
     <div style="margin-top: 6px; text-align: right; color: #121212ff;">
        <strong>Total semua siswa:</strong> {{ $jumlah }}
    </div>
@endif

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

    <style>
    /* Wrapper utama: filter + tombol sejajar */
    .topbar-filter {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 25px;
    }

    /* Kontainer kiri (filter) */
    .filter-container {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #222;
    }

    /* Input dan Select */
    .filter-select,
    .search-box input {
        background: #f8f9fa;
        border: none;
        border-radius: 12px;
        padding: 10px 15px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        font-size: 14px;
        width: 200px;
        transition: all 0.2s ease;
    }

    .filter-select:focus,
    .search-box input:focus {
        outline: none;
        box-shadow: 0 3px 8px rgba(0, 150, 255, 0.3);
    }

    /* Kotak pencarian */
    .search-box {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    .search-box input {
        border: none;
        flex: 1;
        background: transparent;
        padding: 10px 15px;
    }

    .search-box button {
        background: transparent;
        border: none;
        color: #333;
        padding: 10px 12px;
        cursor: pointer;
        border-radius: 0 12px 12px 0;
    }

    .search-box button:hover {
        color: #007bff;
    }

    /* Tombol kanan */
    .button-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Tombol tambah */
    .btn-tambah {
        background: #1abc9c;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }

    .btn-tambah:hover {
        background: #16a085;
    }

    /* Tombol import */
    .btn-import {
        background: #3498db;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }

    .btn-import:hover {
        background: #2980b9;
    }
    </style>

    <script>
    document.getElementById('rombel').addEventListener('change', function() {
        this.form.submit();
    });
    document.getElementById('jurusan').addEventListener('change', function() {
        this.form.submit();
    });
    </script>

@endsection
