@extends('layouts.admin')

@section('title', 'Kartu Pelajar Siswa')
@section('page_title', 'Kartu Pelajar — Wali Kelas')

@section('content')

<style>
.kartu-wrap { padding: 18px; }
.card-table { background:#f5f7fa; border-radius:8px; padding:18px; margin-top:18px; }
.table-header {
    padding:12px; border-radius:6px;
    display:flex; justify-content:space-between; align-items:center;
    box-shadow:0 2px 6px rgba(0,0,0,0.04);
}
.table-list { width:100%; border-collapse:collapse; margin-top:12px; }
.table-list th, .table-list td { padding:10px 12px; text-align:left; }
.table-list th {
    font-weight:700; font-size:0.95rem; color:#fff; background:#2c3e50;
}
.table-list tr td { border-bottom:1px solid rgba(0,0,0,0.05); }
.btn-cetak {
    background:#1e3a67; color:#fff; padding:6px 10px; border-radius:20px;
    text-decoration:none; font-size:0.85rem;
}

/* Hilangkan showing text pagination */
nav[role="navigation"] > div:first-child { display:none !important; }

/* Pagination prev next only */
nav[role="navigation"] {
    display:flex; justify-content:center; align-items:center; gap:8px; margin-top:15px;
}
.pagination .page-item:not(.disabled):not(.active) { display:none !important; }
.pagination .page-item.active { display:none !important; }

.pagination .page-item .page-link {
    padding:8px 18px; border-radius:30px; background:#17375d; color:white; font-weight:600; border:none;
}
.pagination .page-item .page-link:hover { background:#0069d9; color:white; }
nav[role="navigation"] svg { width:16px!important; height:16px!important; }
</style>

@php
    // rombel wali kelas masuk dari user login
    $rombelSaya = auth()->user()->rombel;
@endphp

<div class="kartu-wrap">

    {{-- INFORMASI ROMBEL WALI --}}
    <div style="background:#1e3a67; padding:18px; border-radius:8px; color:#fff;">
        <div style="font-size:1.1rem; font-weight:600;">
            Rombel yang Anda ampu : {{ $rombel }}
        </div>

        {{-- FORM SEARCH (Tanpa dropdown kelas karena otomatis filter) --}}
        <form action="{{ route('wali.kartupelajar.index') }}" method="GET" style="margin-top:12px; display:flex; gap:8px;">
            <input name="q" type="text" placeholder="Cari nama / NIS..." 
                   value="{{ request('q') }}"
                   style="flex:1; padding:10px 12px; border-radius:6px; border:none; outline:none;">

            <button type="submit" style="background:#fff; color:#1e3a67; padding:8px 12px; border-radius:6px; border:none;">
                Cari
            </button>
        </form>
    </div>

    <div class="card-table">
        <div class="table-header">
            <div style="font-weight:700;">Daftar Siswa — {{ $rombel }}</div>
            <div style="font-size:0.9rem; color:#666;">Total: {{ $siswas->total() }}</div>
        </div>

        <table class="table-list">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $i => $siswa)
                <tr>
                    <td>{{ $i + $siswas->firstItem() }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td>{{ $siswa->jurusan }}</td>
                    <td>
                        <a href="{{ route('wali.kartupelajar.preview', $siswa->nis) }}" class="btn-cetak">
                            Lihat Kartu
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:12px; display:flex; justify-content:center;">
            {{ $siswas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection
