@extends('layouts.admin')

@section('title', 'Dokumen Siswa')
@section('page_title', 'Dokumen Siswa')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.dokumensiswa.create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Data Siswa
        </a>
    </div>

    <div class="card-body">
        {{-- Search & Filter --}}
        <div class="d-flex align-items-center mb-4 flex-wrap gap-3">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" class="form-control" placeholder="Cari berdasarkan NIS atau Nama...">
                <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
            </div>

            <select class="form-select" style="max-width: 220px;">
                <option value="">Semua Dokumen</option>
                <option value="kartu_pelajar">Kartu Pelajar</option>
                <option value="rapor">Rapor</option>
                <option value="ijazah">Ijazah</option>
            </select>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 120px;">NIS</th>
                        <th>Nama Siswa</th>
                        <th style="width: 160px;">Total Dokumen</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $index => $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nis }}</td>
                        <td class="text-start">{{ $s->nama_lengkap }}</td>
                        <td>{{ $s->dokumen_siswa_count ?? 0 }} / {{ $totalDokumenWajib ?? 5 }}</td>
                        <td>
                            <a href="{{ route('admin.dokumensiswa.show', $s->nis) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted">Belum ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $siswa->links() }}
        </div>
    </div>
</div>
@endsection
