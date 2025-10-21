@extends('layouts.admin')

@section('title', 'Keterlambatan')
@section('page_title', 'Manajemen Keterlambatan Siswa')

@section('content')
<div class="card shadow-sm">
    

    <div class="filter-container" style="margin-bottom:20px;">
    <div style="display:flex; gap:15px; margin-bottom: 20px; align-items: center;">
        <a href="{{ route('admin.keterlambatan.create') }}" 
           style="background:#1abc9c; color:white; border:none; padding:10px 15px; border-radius:8px; text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Data 
        </a>
    </div>
</div>

    <div class="card-body">
        <!-- Filter tanggal -->
        <form method="GET" action="{{ route('admin.keterlambatan.index') }}" class="mb-4 d-flex align-items-center">
            <input type="date" name="tanggal" class="form-control me-2" value="{{ $tanggal ?? '' }}" style="max-width: 250px;">
            <button class="btn btn-primary">
                <i class="bi bi-search"></i> Tampilkan
            </button>
        </form>

        @php
            $keterlambatans = $keterlambatans ?? collect();
        @endphp

        <!-- Tabel Data -->
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:20%">Nama</th>
                    <th style="width:15%">NIS</th>
                    <th style="width:25%">Kedatangan (terlambat)</th>
                    <th style="width:20%">Keterangan</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keterlambatans as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                        <td class="text-center">{{ $item->siswa->nis ?? '-' }}</td>
                        <td class="text-center">{{ $item->jam_datang }} ({{ $item->menit_terlambat }} menit)</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.keterlambatan.cetak', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-printer"></i> Cetak SIT
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data keterlambatan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
