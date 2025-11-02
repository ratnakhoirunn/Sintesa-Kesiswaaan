@extends('layouts.admin')

@section('title', 'Konseling')
@section('page_title', 'Riwayat Konseling Siswa')

@section('content')
<style>
    /* === HEADER === */
    .header-keterlambatan {
        background-color: #123B6B;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        border-radius: 8px 8px 0 0;
    }

    .header-keterlambatan h4 {
        margin: 0;
        font-weight: 600;
    }

    .tanggal-jam {
        font-size: 14px;
        text-align: right;
    }

    /* === FILTER + TOMBOL TAMBAH === */
    .filter-wrapper {
        background: #f8f9fa;
        padding: 15px 25px;
        border: 1px solid #ddd;
        border-top: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-form input[type="date"] {
        border: 1px solid #ccc;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 14px;
    }

    .filter-form button {
        background-color: #123B6B;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .filter-form button:hover {
        background-color: #0f2e52;
    }

    /* Tombol Tambah di kanan */
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
        color: #ffff;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .btn-cetak {
        background: none;
        border: none;
        color: #123B6B;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-cetak i {
        color: #123B6B;
    }

    .text-muted {
        font-style: italic;
        color: #999;
    }
</style>


{{-- Header --}}
    <div class="header-keterlambatan">
        <h4>Manajemen Konseling Siswa</h4>
        <div class="tanggal-jam" id="tanggal-jam">
            {{-- Tanggal & jam oleh JavaScript --}}
        </div>
    </div>

    {{-- Filter Tanggal + Tombol Tambah Data di kanan --}}
    <div class="filter-wrapper">
        <form method="GET" action="{{ route('admin.keterlambatan.index') }}" class="filter-form">
            <i class="bi bi-calendar-date" style="font-size: 20px; color:#123B6B;"></i>
            <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}">
            <button type="submit">Tampilkan</button>
        </form>

        <a href="{{ route('admin.konseling.create') }}" class="btn-tambah">
            + Tambah Data Konseling
        </a>
    </div>

    <div class="p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Rombel</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konselings as $index => $item)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->rombel }}</td>
                    <td>{{ $item->catatan }}</td>
                    <td style="text-align:center;">{{ $item->tanggal }}</td>
                    <td class="aksi" style="text-align:center;">
                        <a href="{{ route('admin.konseling.show', $item->id) }}" class="lihat">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="{{ route('admin.konseling.edit', $item->id) }}" class="edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.konseling.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hapus" style="background:none;border:none;cursor:pointer;"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="no-data">Belum ada data konseling</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
