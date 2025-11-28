@extends('layouts.admin')

@section('title', 'Data Siswa Wali Kelas')
@section('page_title', 'Data Siswa Kelas ' . $rombel)

@section('content')
@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<div class="filter-container" style="margin-bottom:20px;">
    <div class="topbar-filter">
        <form method="GET" action="{{ route('wali.datasiswa') }}" class="filter-form">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="search">Cari Nama / NIS</label>
                    <div class="search-box">
                        <input type="text" name="search" id="search" placeholder="Ketik nama atau NIS..." value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div style="margin-top:6px; text-align:right;">
        <strong>Jumlah siswa di {{ $rombel }}:</strong> {{ $jumlah }}
    </div>
</div>

<style>
.table { 
    width:100%; 
    border-collapse:collapse; 
    background:#fff; 
    border-radius:8px; 
    overflow:hidden; 
}

.table thead { 
    background:#2c3e50; 
    color:#fff; 
}

.table th, 
.table td { 
    padding:10px; 
    border-top:1px solid #eee; 
    font-size:14px; 
    vertical-align: middle;     /* ➜ Biar sejajar vertikal (tidak mencong) */
    text-align: left;           /* ➜ Semua teks rata kiri */
    white-space: nowrap;        /* ➜ Mencegah teks turun baris */
}

/* Kolom nomor tetap rata tengah */
.table th:nth-child(1),
.table td:nth-child(1) {
    text-align:center;
}

.table tbody tr:hover { 
    background:#f8f9fa; 
}

.search-box { 
    display:flex; 
    background:#f8f9fa; 
    border-radius:12px; 
    box-shadow:0 3px 6px rgba(0,0,0,0.06); 
}

.search-box input { 
    border:none; 
    padding:10px 12px; 
    background:transparent; 
    width:260px; 
}

.search-box button { 
    background:transparent; 
    border:none; 
    padding:8px 12px; 
    cursor:pointer; 
}

.btn { 
    padding:6px 10px; 
    border-radius:8px; 
    font-size:13px; 
}

.btn-sm{ 
    padding:4px 8px; 
    font-size:12px; 
}

.btn-view{ 
    background:#17a2b8; 
    color:#fff; 
}
.btn-edit{ 
    background:#f0ad4e; 
    color:#fff; 
}
.btn-delete{ 
    background:#d9534f; 
    color:#fff; 
}

/* Tombol warna aksi */
.aksi-lihat { color: #007bff; }
.aksi-edit { color: #ff9800; }
.aksi-hapus { color: #e74c3c; }

/* tombol toggle */
.aksi-toggle {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}

.aksi-toggle:hover {
    opacity: .7;
}

.aksi-container {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;  /* supaya tidak turun ke bawah */
}


</style>


<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width:5%; text-align:center;">No</th>
                <th style="width:15%;">NIS</th>
                <th style="width:15%;">NISN</th>
                <th>Nama Lengkap</th>
                <th style="width:15%;">Jenis Kelamin</th>
                <th style="width:20%;">Email</th>
                <th style="width:15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $i => $s)
            <tr>
                <td style="text-align:center;">{{ $i + $siswas->firstItem() }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->nama_lengkap }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ $s->email }}</td>
                <td>
                  <div class="aksi-container">

    {{-- Tombol Lihat --}}
    <a href="{{ route('wali.datasiswa.show', $s->nis) }}" class="aksi-lihat">
        <i class="fas fa-eye"></i> Lihat
    </a>

    {{-- Tombol Edit --}}
    <a href="{{ route('wali.datasiswa.edit', $s->nis) }}" class="aksi-edit">
        <i class="fas fa-edit"></i> Edit
    </a>

    {{-- Tombol Hapus --}}
    <form action="{{ route('wali.datasiswa.destroy', $s->nis) }}" method="POST" 
          onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="aksi-hapus" style="background:none; border:none;">
            <i class="fas fa-trash"></i> Hapus
        </button>
    </form>

    {{-- Toggle Akses Edit --}}
    <form action="{{ route('wali.datasiswa.toggle', $s->nis) }}" method="POST">
        @csrf
        @method('PUT')

        @if($s->akses_edit)
            <button type="submit" class="aksi-toggle" style="color:#16a085;">
                <i class="fas fa-unlock"></i> Aktif
            </button>
        @else
            <button type="submit" class="aksi-toggle" style="color:#e74c3c;">
                <i class="fas fa-lock"></i> Nonaktif
            </button>
        @endif
    </form>

</div>


                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:12px;">Tidak ada data siswa pada rombel ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- pagination --}}
<div style="margin-top:18px; display:flex; justify-content:center;">
    {{ $siswas->appends(request()->query())->links('pagination::simple-tailwind') }}
</div>
@endsection
