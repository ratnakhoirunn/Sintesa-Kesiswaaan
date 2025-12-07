@extends('layouts.admin')

@section('title', 'Prestasi Siswa')
@section('page_title', 'Prestasi Siswa')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    .header-prestasi {
        background-color: #123B6B;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        border-radius: 8px 8px 0 0;
    }
    .header-prestasi h4 { margin: 0; font-weight: 600; }
    .tanggal-jam { font-size: 14px; text-align: right; }

    .prestasi-filter-wrapper {
        background: #f8f9fa;
        padding: 15px 25px;
        border: 1px solid #ddd;
        border-top: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .prestasi-filter select {
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    thead { background-color: #2c3e50; }
    th, td {
        border: 1px solid #ddd;
        padding: 6px 10px;
        text-align: center;
        font-size: 12px;
    }
    th { color: #fff; font-weight: 600; }
    tr:nth-child(even) { background-color: #f9f9f9; }

    .td-nama { text-align: left !important; padding-left: 10px; }

    .btn-view {
        text-decoration: none;
        color: #123B6B;
        font-size: 18px;
    }
</style>


<div class="card shadow-sm">

    {{-- Header --}}
    <div class="header-prestasi">
        <h4>Prestasi Siswa Kelas yang Diampu</h4>
        <div class="tanggal-jam" id="tanggal-jam"></div>
    </div>

    {{-- Filter --}}
    <div class="prestasi-filter-wrapper">
        <form method="GET" action="{{ route('wali.prestasi.index') }}" 
            class="prestasi-filter" 
            style="display:flex; gap:10px; align-items:center;">

            <i class="fa-solid fa-filter" style="font-size:18px; color:#123B6B;"></i>

            <select name="jenis">
                <option value="">-- Semua Jenis Prestasi --</option>
                <option value="sertifikat" {{ request('jenis') == 'sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                <option value="seminar" {{ request('jenis') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                <option value="lomba" {{ request('jenis') == 'lomba' ? 'selected' : '' }}>Lomba</option>
                <option value="lainnya" {{ request('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>

            <button type="submit">Filter</button>
        </form>
    </div>


    {{-- Tabel --}}
    <div class="p-3">
        <p style="font-weight:600; margin-top:10px;">Daftar Prestasi Siswa</p>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Judul Prestasi</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>File / Link</th>
                    <th>Lihat</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($prestasi as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="td-nama">
                            {{ $p->siswa->nama_lengkap ?? '-' }}
                        </td>

                        <td>{{ $p->siswa->rombel ?? '-' }}</td>

                        <td style="text-align:left;">{{ $p->judul }}</td>

                        <td>{{ ucfirst($p->jenis) }}</td>

                        <td>
                            {{ $p->tanggal_prestasi 
                                ? \Carbon\Carbon::parse($p->tanggal_prestasi)->format('d M Y')
                                : '-' }}
                        </td>

                        <td>
                            @if ($p->file)
                                {{-- File --}}
                                @if (file_exists(public_path('uploads/prestasi/'.$p->file)))
                                    <a href="{{ asset('uploads/prestasi/'.$p->file) }}" target="_blank">
                                        <i class="fa-solid fa-file"></i> File
                                    </a>
                                @elseif (file_exists(storage_path('app/public/prestasi/'.$p->file)))
                                    <a href="{{ asset('storage/prestasi/'.$p->file) }}" target="_blank">
                                        <i class="fa-solid fa-file"></i> File
                                    </a>
                                @endif

                            @elseif ($p->link)
                                {{-- Link --}}
                                <a href="{{ $p->link }}" target="_blank" style="color:#1e3a8a;">
                                    <i class="fa-solid fa-link"></i> Link
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('wali.prestasi.show', $p->siswa->nis) }}" class="btn-view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Belum ada prestasi siswa di kelas ini</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection
