@extends('layouts.admin')
@section('title', 'Detail Dokumen Siswa')
@section('page_title', 'Detail Dokumen Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ $siswa->nama }} - {{ $siswa->nis }}</h5>
    </div>
    <div class="card-body">
        <h6>Dokumen Terpenuhi: {{ $dokumen->count() }} dari {{ count($wajib) }}</h6>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Dokumen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wajib as $jenis)
                @php
                    $file = $dokumen->firstWhere('jenis_dokumen', $jenis);
                @endphp
                <tr>
                    <td>{{ $jenis }}</td>
                    <td>
                        @if ($file)
                            <span class="text-success">Diunggah</span>
                        @else
                            <span class="text-danger">Belum Diunggah</span>
                        @endif
                    </td>
                    <td>
                        @if ($file)
                            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-success btn-sm">Lihat File</a>
                        @else
                            <span class="btn btn-danger btn-sm disabled">Belum Ada</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.dokumensiswa.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
