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
                        <option value="" {{ request('rombel') == '' ? 'selected' : '' }}>Semua</option>

                        <!-- =======================
                            KELAS X
                        ======================= -->
                        <optgroup label="Kelas X">
                            <option value="X DKV 1">X DKV 1</option>
                            <option value="X DKV 2">X DKV 2</option>
                            <option value="X DPIB 1">X DPIB 1</option>
                            <option value="X DPIB 2">X DPIB 2</option>
                            <option value="X DPIB 3">X DPIB 3</option>
                            <option value="X GEOMATIKA">X GEOMATIKA</option>
                            <option value="X KGS">X KGS</option>
                            <option value="X MEKATRONIKA">X MEKATRONIKA</option>
                            <option value="X SIJA 1">X SIJA 1</option>
                            <option value="X SIJA 2">X SIJA 2</option>
                            <option value="X TAV">X TAV</option>
                            <option value="X TITL 1">X TITL 1</option>
                            <option value="X TITL 2">X TITL 2</option>
                            <option value="X TITL 3">X TITL 3</option>
                            <option value="X TITL 4">X TITL 4</option>
                            <option value="X TKR 1">X TKR 1</option>
                            <option value="X TKR 2">X TKR 2</option>
                            <option value="X TKR 3">X TKR 3</option>
                            <option value="X TKR 4">X TKR 4</option>
                            <option value="X TP 1">X TP 1</option>
                            <option value="X TP 2">X TP 2</option>
                            <option value="X TP 3">X TP 3</option>
                            <option value="X TP 4">X TP 4</option>
                        </optgroup>

                        <!-- =======================
                            KELAS XI
                        ======================= -->
                        <optgroup label="Kelas XI">
                            <option value="XI DKV 1">XI DKV 1</option>
                            <option value="XI DKV 2">XI DKV 2</option>
                            <option value="XI DPIB 1">XI DPIB 1</option>
                            <option value="XI DPIB 2">XI DPIB 2</option>
                            <option value="XI DPIB 3">XI DPIB 3</option>
                            <option value="XI GEOMATIKA">XI GEOMATIKA</option>

                            <!-- KGS & SIJA -->
                            <option value="XI KGS">XI KGS</option>
                            <option value="XI SIJA 1">XI SIJA 1</option>
                            <option value="XI SIJA 2">XI SIJA 2</option>

                            <option value="XI MEKATRONIKA">XI MEKATRONIKA</option>
                            <option value="XI TAV">XI TAV</option>
                            <option value="XI TITL 1">XI TITL 1</option>
                            <option value="XI TITL 2">XI TITL 2</option>
                            <option value="XI TITL 3">XI TITL 3</option>
                            <option value="XI TITL 4">XI TITL 4</option>
                            <option value="XI TKR 1">XI TKR 1</option>
                            <option value="XI TKR 2">XI TKR 2</option>
                            <option value="XI TKR 3">XI TKR 3</option>
                            <option value="XI TKR 4">XI TKR 4</option>
                            <option value="XI TP 1">XI TP 1</option>
                            <option value="XI TP 2">XI TP 2</option>
                            <option value="XI TP 3">XI TP 3</option>
                            <option value="XI TP 4">XI TP 4</option>
                        </optgroup>

                        <!-- =======================
                            KELAS XII
                        ======================= -->
                        <optgroup label="Kelas XII">
                            <option value="XII DKV 1">XII DKV 1</option>
                            <option value="XII DKV 2">XII DKV 2</option>
                            <option value="XII DPIB 1">XII DPIB 1</option>
                            <option value="XII DPIB 2">XII DPIB 2</option>
                            <option value="XII DPIB 3">XII DPIB 3</option>
                            <option value="XII GEOMATIKA">XII GEOMATIKA</option>

                            <!-- KGS & SIJA -->
                            <option value="XII KGS">XII KGS</option>
                            <option value="XII SIJA 1">XII SIJA 1</option>
                            <option value="XII SIJA 2">XII SIJA 2</option>

                            <option value="XII MEKATRONIKA">XII MEKATRONIKA</option>
                            <option value="XII TAV">XII TAV</option>
                            <option value="XII TITL 1">XII TITL 1</option>
                            <option value="XII TITL 2">XII TITL 2</option>
                            <option value="XII TITL 3">XII TITL 3</option>
                            <option value="XII TITL 4">XII TITL 4</option>
                            <option value="XII TKR 1">XII TKR 1</option>
                            <option value="XII TKR 2">XII TKR 2</option>
                            <option value="XII TKR 3">XII TKR 3</option>
                            <option value="XII TKR 4">XII TKR 4</option>
                            <option value="XII TP 1">XII TP 1</option>
                            <option value="XII TP 2">XII TP 2</option>
                            <option value="XII TP 3">XII TP 3</option>
                            <option value="XII TP 4">XII TP 4</option>
                        </optgroup>

                        <!-- =======================
                            KELAS XIII (KHUSUS)
                            Hanya SIJA & KGS
                        ======================= -->
                        <optgroup label="Kelas XIII (Khusus)">
                            <option value="XIII KGS">XIII KGS</option>
                            <option value="XIII SIJA 1">XIII SIJA 1</option>
                            <option value="XIII SIJA 2">XIII SIJA 2</option>
                        </optgroup>
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

                <!-- FILTER ANGKATAN -->
                    <div class="filter-group">
                        <label for="angkatan">Angkatan</label>
                        <select name="angkatan" id="angkatan" class="filter-select">
                            <option value="">Semua</option>
                            @foreach($angkatan_list as $a)
                                <option value="{{ $a }}" {{ request('angkatan') == $a ? 'selected' : '' }}>
                                    Angkatan {{ $a }}
                                </option>
                            @endforeach
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
        @if(auth('guru')->user()->role !== 'kesiswaan')
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
        @endif

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

      @if(request('rombel'))
            <form 
                action="{{ route('admin.naikkanRombel', request('rombel')) }}" 
                method="POST"
                onsubmit="return confirm('Yakin ingin menaikkan kelas seluruh siswa di rombel {{ request('rombel') }}?');"
                style="margin-top:10px;"
            >
                @csrf
                @method('PUT')

                <button type="submit" class="btn-tambah" style="background:#8e44ad;">
                    <i class="fas fa-level-up-alt"></i> Naikkan Kelas Rombel Ini
                </button>
            </form>
            @endif

</div>

<script>
document.getElementById('angkatan')?.addEventListener('change', function() {
    this.form.submit();
});

// SET NILAI SELECT ROMBEL AGAR TETAP TERPILIH
document.getElementById('rombel').value = "{{ request('rombel') }}";
</script>



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
    justify-content: flex-start; /* geser kiri */
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;
    overflow: visible; /* cegah elemen menghilang */
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

    /*tombol toggle */
    .aksi-toggle {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: 0.2s;
    }

    .aksi-toggle:hover {
        opacity: .7;
    }

    /* Tombol aksi naik kelas */
    .aksi-naik {
        color: #8e44ad; /* ungu */
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: 0.2s;
    }

    .aksi-naik:hover {
        opacity: 0.7;
}

</style>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Rombel</th>
            <th>Kompetensi Keahlian</th>
            <th style="width: 250px;">Aksi</th>
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

    {{-- Semua user (Admin, BK, Kesiswaan) bisa lihat --}}
    <a href="{{ route('admin.datasiswa.show', $siswa->nis) }}" class="aksi-lihat">
        <i class="fas fa-eye"></i> Lihat
    </a>

    {{-- ===========================================================
        KONDISI ROLE
        Hanya Admin yang boleh Edit, Hapus, dan Toggle Akses
       =========================================================== --}}
    @if(auth()->user()->role == 'admin')

        {{-- Tombol Edit --}}
        <a href="{{ route('admin.datasiswa.edit', $siswa->nis) }}" class="aksi-edit">
            <i class="fas fa-edit"></i> Edit
        </a>

        {{-- Tombol Hapus --}}
        <form action="{{ route('admin.datasiswa.destroy', $siswa->nis) }}" 
            method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="aksi-hapus">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>

        {{-- Toggle Akses Edit Siswa --}}
        <form action="{{ route('admin.datasiswa.toggleAkses', $siswa->nis) }}" method="POST">
            @csrf
            @method('PUT')

            @if($siswa->akses_edit)
                <button type="submit" class="aksi-toggle" style="color:#16a085;">
                    <i class="fas fa-unlock"></i> Aktif
                </button>
            @else
                <button type="submit" class="aksi-toggle" style="color:#e74c3c;">
                    <i class="fas fa-lock"></i> Nonaktif
                </button>
            @endif
        </form>

        {{-- Tombol Naikkan kelas per siswa (hanya muncul saat filter rombel aktif) --}}
        @if(request('rombel'))
        <form action="{{ route('admin.naikkanSiswa', $siswa->nis) }}"
            method="POST"
            onsubmit="return confirm('Naikkan kelas {{ $siswa->nama_lengkap }}?');">
            @csrf
            @method('PUT')
            <button type="submit" class="aksi-naik" title="Naikkan Kelas">
                <i class="fas fa-level-up-alt"></i> Naikkan
            </button>
        </form>
        @endif

    @endif
 
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
