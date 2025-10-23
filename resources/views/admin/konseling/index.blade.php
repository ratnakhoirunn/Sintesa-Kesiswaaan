@extends('layouts.admin')

@section('title', 'Konseling')
@section('page_title', 'Riwayat Konseling Siswa')

@section('content')
<style>
    .card-konseling {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        max-width: 100%;
        margin: 0 auto;
    }

    .card-header-konseling {
        background-color: #1e3a67;
        color: white;
        font-weight: 600;
        font-size: 16px;
        padding: 12px 20px;
    }

    .btn-tambah {
        background-color: #1e3a67;
        color: #fff;
        font-size: 14px;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        transition: all 0.3s ease;
    }

    .btn-tambah:hover {
        background-color: #162c50;
        transform: scale(1.03);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #2c3e50;
        color: white;
        text-align: center;
    }

    th, td {
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e0;
    }

    tbody tr:hover {
        background-color: #f9fafc;
    }

    .aksi a {
        margin-right: 10px;
        text-decoration: none;
        font-weight: 500;
    }

    .aksi a.lihat {
        color: #007bff;
    }

    .aksi a.edit {
        color: #ff9800;
    }

    .aksi a.hapus {
        color: #e74c3c;
    }

    .aksi a:hover {
        text-decoration: underline;
    }

    .no-data {
        color: #888;
        text-align: center;
        font-style: italic;
    }
</style>

<div class="card-konseling">
        <a href="{{ route('admin.konseling.create') }}" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>

    <div class="p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Konseling</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konselings as $index => $item)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->jenis_konseling }}</td>
                    <td>{{ $item->deskripsi }}</td>
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
