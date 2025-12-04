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

    /* === FILTER === */
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
        color: white;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* === AKSI === */
    .lihat { color: #007bff; font-weight: 600; margin-right: 8px; }
    .edit { color: #ff9800; font-weight: 600; margin-right: 8px; }
    .hapus { color: #e74c3c; font-weight: 600; }

    .lihat:hover { color: #0056b3; }
    .edit:hover { color: #e07b00; }
    .hapus:hover { color: #c0392b; }

    .lihat i, .edit i { margin-right: 3px; }

    /* === TOMBOL KONFIRMASI === */
    .btn-approve {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        margin: 2px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: .2s;
    }

    .btn-approve:hover {
        background: #218838;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        margin: 2px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: .2s;
    }

    .btn-reject:hover {
        background: #c82333;
    }

    .konfirmasi-wrapper {
    display: flex;
    gap: 8px; 
    justify-content: center;
    align-items: center;
}

.btn-approve, .btn-reject {
    padding: 6px 14px;
    border-radius: 6px;
    border: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
}

.btn-approve {
    background: #28a745;
    color: white;
}

.btn-approve:hover {
    background: #218838;
}

.btn-reject {
    background: #dc3545;
    color: white;
}

.btn-reject:hover {
    background: #c82333;
}
.filter-form {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: ; /* FONT SAMA */
}

.filter-icon {
    font-size: 20px;
    color: #123B6B;
}

.filter-input {
    font-family: 'Poppins', sans-serif; /* FONT NYA SAMA */
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}

.filter-btn {
    font-family: 'Poppins', sans-serif; /* FONT SAMA */
    padding: 7px 12px;
    border: none;
    background: #123B6B;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: 0.2s;
}

.filter-btn:hover {
    background: #0d2d52;
}


</style>

{{-- Header --}}
<div class="header-keterlambatan">
    <h4>Manajemen Konseling Siswa</h4>
    <div class="tanggal-jam" id="tanggal-jam"></div>
</div>

{{-- Filter --}}
<div class="filter-wrapper">
    <form method="GET" action="{{ route('admin.keterlambatan.index') }}" class="filter-form">
    <i class="bi bi-calendar-date filter-icon"></i>
    <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="filter-input">
    <button type="submit" class="filter-btn">Tampilkan</button>
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
            <th>Kelas</th>
            <th>Nama Ortu</th>
            <th>Topik</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
            <th>Konfirmasi</th> 
        </tr>
    </thead>

    <tbody>
        @forelse($konselings as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align:left;">{{ $item->nama_siswa }}</td>
                <td>{{ $item->kelas }}</td>
                <td>{{ $item->nama_ortu }}</td>
                <td style="text-align:left;">{{ $item->topik }}</td>
                <td>{{ $item->tanggal }}</td>

                <td>
                    @if ($item->status == 'Menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif ($item->status == 'Disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td>
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

                {{-- Konfirmasi --}}
                <td>
    @if ($item->status == 'Menunggu')
        <div class="konfirmasi-wrapper">
            <form action="{{ route('admin.konseling.proses', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Disetujui">
                <button type="submit" class="btn-approve">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </form>

            <form action="{{ route('admin.konseling.proses', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Ditolak">
                <button type="submit" class="btn-reject">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </form>
        </div>
    @else
        <span style="color:#555; font-weight:600;">-</span>
    @endif
</td>

            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Belum ada data konseling</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

@endsection
