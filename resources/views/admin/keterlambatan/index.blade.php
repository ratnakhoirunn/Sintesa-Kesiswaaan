@extends('layouts.admin')

@section('title', 'Keterlambatan')
@section('page_title', 'Keterlambatan')

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
    .btn-status {
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-pending { background: #f1c40f; color: white; }
    .btn-proses { background: #3498db; color: white; }
    .btn-terima { background: #27ae60; color: white; }
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
</style>

<div class="card shadow-sm">

    {{-- Header --}}
    <div class="header-keterlambatan">
        <h4>Manajemen Keterlambatan Siswa</h4>
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

        <a href="{{ route('admin.keterlambatan.create') }}" class="btn-tambah">
            + Tambah Data Keterlambatan
        </a>
    </div>

    {{-- Tabel Data --}}
    <div class="p-3">
        <p style="font-weight: 600; margin-top:10px;">Daftar pengajuan Surat Izin Terlambat (SIT) siswa</p>

        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No.</th>
                    <th style="width:25%;">Nama</th>
                    <th style="width:15%;">NIS</th>
                    <th style="width:25%;">Kedatangan (terlambat)</th>
                    <th style="width:20%;">Keterangan</th>
                    <th style="width:10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keterlambatans as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->siswa->nis ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->jam_datang)->format('H.i') }} ({{ $item->menit_terlambat }} menit)</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                       <td>
                            <form action="{{ route('admin.keterlambatan.updateStatus', $item->id) }}" method="POST" style="display:flex; gap:4px; justify-content:center;">
                                @csrf
                                @method('PUT')
                                <button name="status" value="pending" class="btn-status btn-pending">Pending</button>
                                <button name="status" value="proses" class="btn-status btn-proses">Proses</button>
                                <button name="status" value="terima" class="btn-status btn-terima">Terima</button>
                            </form>

                            <a href="{{ route('admin.keterlambatan.cetak', $item->id) }}" class="btn-cetak">
                                <i class="bi bi-printer"></i> Cetak
                            </a>
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Tidak ada data keterlambatan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const hari = now.toLocaleDateString('id-ID', { weekday: 'long' });
        const tanggal = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const jam = now.toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('tanggal-jam').innerHTML = `${hari}, ${tanggal}<br>${jam}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
@endsection
