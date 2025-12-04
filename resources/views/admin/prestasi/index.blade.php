@extends('layouts.admin')

@section('title', 'Prestasi Siswa')
@section('page_title', 'Prestasi Siswa')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">


<style>
    /* === HEADER === */
    .header-prestasi {
        background-color: #123B6B;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        border-radius: 8px 8px 0 0;
    }

    .header-prestasi h4 {
        margin: 0;
        font-weight: 600;
    }

    .tanggal-jam {
        font-size: 14px;
        text-align: right;
    }

    /* === FILTER === */
    .prestasi-filter-wrapper {
        background: #f8f9fa;
        padding: 15px 25px;
        border: 1px solid #ddd;
        border-top: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .prestasi-filter input[type="date"] {
        border: 1px solid #ccc;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 14px;
    }

    .prestasi-filter button {
        background-color: #123B6B;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .prestasi-filter button:hover {
        background-color: #0f2e52;
    }

    /* Tombol Tambah */
    .btn-tambah {
        border: 2px solid #123B6B;
        color: #123B6B;
        background-color: #fff;
        padding: 8px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-tambah:hover {
        background-color: #123B6B;
        color: #fff;
    }

    /* === TABLE === */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    thead {
        background-color: #2c3e50;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 6px 10px;
        text-align: center;
        font-size: 12px;
    }

    th {
        color: #fff;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .td-nama {
        text-align: left !important;
        padding-left: 10px;
    }

    /* Aksi */
    .btn-view {
        text-decoration: none;
        color: #123B6B;
        font-size: 18px;
    }

    .btn-delete {
        color: red;
        border: none;
        background: none;
        font-size: 18px;
        cursor: pointer;
    }
</style>

<div class="card shadow-sm">

    {{-- Header --}}
    <div class="header-prestasi">
        <h4>Manajemen Prestasi Siswa</h4>
        <div class="tanggal-jam" id="tanggal-jam"></div>
    </div>

    {{-- Filter Tanggal + Tambah --}}
   <div class="prestasi-filter-wrapper">
    <form method="GET" action="{{ route('admin.prestasi.index') }}" 
          class="prestasi-filter" 
          style="display:flex; gap:10px; align-items:center;">

        <i class="fa-solid fa-filter" style="font-size: 18px; color:#123B6B;"></i>

       <select name="jenis" 
    style="
        padding: 8px 10px; 
        border:1px solid #ccc; 
        border-radius:6px; 
        font-size:14px;
        font-family: 'Poppins', sans-serif;
    ">
    <option value="">-- Semua Jenis Prestasi --</option>
    <option value="sertifikat" {{ request('jenis') == 'sertifikat' ? 'selected' : '' }}>Sertifikat</option>
    <option value="seminar" {{ request('jenis') == 'seminar' ? 'selected' : '' }}>Seminar</option>
    <option value="lomba" {{ request('jenis') == 'lomba' ? 'selected' : '' }}>Lomba</option>
    <option value="lainnya" {{ request('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
</select>


        <button type="submit">Filter</button>
    </form>

    <a href="{{ route('admin.prestasi.create') }}" class="btn-tambah">
        + Tambah Prestasi
    </a>
</div>


    {{-- Tabel --}}
    <div class="p-3">
        <p style="font-weight: 600; margin-top:10px;">Daftar Prestasi Siswa</p>

        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No.</th>
                    <th style="width:20%;">Nama Siswa</th>
                    <th style="width:10%;">Kelas</th>
                    <th style="width:30%;">Judul Prestasi/Kegiatan</th>
                    <th style="width:10%;">Jenis</th>
                    <th style="width:10%;">Tanggal</th>
                    <th style="width:10%;">File / Link</th>
                    <th style="width:10%;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($prestasi as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="td-nama">
                            {{ $p->siswa->nama_lengkap ?? '-' }}
                        </td>

                         <td class="td-kelas">
                            {{ $p->siswa->rombel ?? '-' }}
                        </td>

                       <td style="text-align:left;">{{ $p->judul }}</td>


                        <td>{{ ucfirst($p->jenis) }}</td>

                        <td>
                            {{ $p->tanggal_prestasi ? \Carbon\Carbon::parse($p->tanggal_prestasi)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            @if ($p->file)
                                {{-- Jika ada file, cek sumber foldernya --}}
                                @if (file_exists(public_path('uploads/prestasi/' . $p->file)))
                                    {{-- File versi GURU --}}
                                    <a href="{{ asset('uploads/prestasi/' . $p->file) }}" target="_blank" style="color:#1e3a8a;">
                                        <i class="fa-solid fa-file"></i> Lihat File
                                    </a>
                                @elseif (file_exists(storage_path('app/public/prestasi/' . $p->file)))
                                    {{-- File versi SISWA --}}
                                    <a href="{{ asset('storage/prestasi/'.$p->file) }}" target="_blank" style="color:#1e3a8a;">
                                        <i class="fa-solid fa-file"></i> Lihat File
                                    </a>
                                @endif

                            @elseif ($p->link)
                                {{-- Jika tidak ada file tetapi ada link --}}
                                <a href="{{ $p->link }}" target="_blank" style="color:#1e3a8a;">
                                    <i class="fa-solid fa-link"></i> Link
                                </a>

                            @else
                                {{-- Jika file dan link kosong --}}
                                -
                            @endif
                        </td>

                        <td style="display:flex; justify-content:center; gap:10px;">
                            <a href="{{ route('admin.prestasi.show', $p->id) }}" class="btn-view">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <form method="POST" action="{{ route('admin.prestasi.destroy', $p->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete" onclick="return confirm('Hapus prestasi ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-muted">Belum ada data prestasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
