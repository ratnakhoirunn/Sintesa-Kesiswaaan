@extends('layouts.admin')

@section('title', 'Konseling')
@section('page_title', 'Riwayat Konseling Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header" style="background-color:#123B6B; color:white;">
        <h5 class="mb-0">Riwayat Konseling Siswa</h5>
    </div>

    <div class="card-body">
        <a href="{{ route('admin.konseling.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Konseling</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konselings as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_siswa }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->jenis_konseling }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td class="text-center">{{ $item->tanggal }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.konseling.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.konseling.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data konseling</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
