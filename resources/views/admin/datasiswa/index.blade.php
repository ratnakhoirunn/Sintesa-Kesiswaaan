@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')

@section('content')
@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

<div class="filter-container" style="margin-bottom:20px;">
    <div style="display:flex; gap:15px; margin-bottom: 20px; align-items: center;">
        <a href="{{ route('admin.datasiswa.create') }}" 
           style="background:#1abc9c; color:white; border:none; padding:10px 15px; border-radius:8px; text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Data Siswa
        </a>
        
        <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
            @csrf
            <label for="file" 
                style="background:#3498db; color:white; border:none; padding:10px 15px; border-radius:8px; cursor:pointer;">
                <i class="fas fa-file-excel"></i> Import Excel
            </label>
            <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" 
                style="display:none;" onchange="this.form.submit();">
        </form>
    </div>
</div>

<table style="width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden;">
    <thead style="background:#2c3e50; color:white;">
        <tr>
            <th style="padding:10px;">No</th>
            <th style="padding:10px;">NIS</th>
            <th style="padding:10px;">Nama Lengkap</th>
            <th style="padding:10px;">Rombel</th>
            <th style="padding:10px;">Kompetensi Keahlian</th>
            <th style="padding:10px;">Aksi</th>
        </tr>
    </thead>
   <tbody>
        @forelse($siswas as $i => $siswa)
        <tr style="border-bottom:1px solid #ddd;">
            <td style="padding:10px; text-align:center;">{{ $i + $siswas->firstItem() }}</td>
            <td style="padding:10px;">{{ $siswa->nis }}</td>
            <td style="padding:10px;">{{ $siswa->nama_lengkap }}</td>
            <td style="padding:10px;">{{ $siswa->rombel }}</td>
            <td style="padding:10px;">{{ $siswa->jurusan }}</td>
            <td style="padding:10px; display:flex; gap:10px; align-items:center;">
                <a href="{{ route('admin.datasiswa.show', $siswa->nis) }}" style="color:blue;"><i class="fas fa-eye"></i> Lihat</a>
                <a href="{{ route('admin.datasiswa.edit', $siswa->nis) }}" style="color:orange;"><i class="fas fa-edit"></i> Edit</a>
                <form action="{{ route('admin.datasiswa.destroy', $siswa->nis) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border:none; background:none; color:red; cursor:pointer;"><i class="fas fa-trash"></i> Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; padding:10px;">Belum ada data siswa.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination tanpa "Showing..." --}}
<div style="margin-top:20px; display:flex; justify-content:center;">
    <style>
        /* --- Hilangkan teks "Showing 1 to 10 of ..." sepenuhnya --- */
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }

        /* --- Gaya pagination rapi dan simetris --- */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
        }

        /* Ukuran ikon panah */
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            vertical-align: middle;
        }

        /* Tombol pagination */
        .pagination a, 
        .pagination span {
            padding: 6px 12px;
            border-radius: 6px;
            background: #f8f9fa;
            color: #4B0082;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: #4B0082;
            color: #fff;
        }

        /* Tombol aktif */
        .pagination .active span {
            background: #4B0082;
            color: white;
        }
    </style>

    {{-- Gunakan pagination sederhana tanpa teks "Showing..." --}}
    {{ $siswas->appends(request()->query())->links('pagination::simple-tailwind') }}
</div>

@endsection
