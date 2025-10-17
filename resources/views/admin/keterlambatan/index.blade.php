@extends('layouts.admin')

@section('title', 'Keterlambatan')
@section('page_title', 'Manajemen Keterlambatan Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#123B6B; color:white;">
        <h5 class="mb-0">Manajemen Keterlambatan Siswa</h5>
        <span>{{ now()->format('l, d F Y - H:i') }}</span>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.keterlambatan.index') }}" class="mb-4 d-flex align-items-center">
            <input type="date" name="tanggal" class="form-control me-2" value="{{ $tanggal ?? '' }}">
            <button class="btn btn-primary">Tampilkan</button>
        </form>

        @php
            $keterlambatans = $keterlambatans ?? collect(); // antisipasi undefined
        @endphp

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kedatangan (terlambat)</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keterlambatans as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->siswa->nis ?? '-' }}</td>
                        <td class="text-center">{{ $item->jam_datang }} ({{ $item->menit_terlambat }} menit)</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.keterlambatan.cetak', $item->id) }}" class="btn btn-sm btn-outline-primary">Cetak SIT</a>
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
