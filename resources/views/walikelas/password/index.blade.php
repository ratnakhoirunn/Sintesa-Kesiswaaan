@extends('layouts.admin')

@section('title', 'Manajemen Password')
@section('page_title', 'Manajemen Password')

@section('content')

{{-- Alert --}}
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

{{-- ================================
      TAB MENU
================================ --}}
<style>
.tab-container {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}

.tab-menu {
    padding: 10px 18px;
    border-radius: 8px;
    background: #ecf0f1;
    cursor: pointer;
    font-weight: 600;
    color: #1e3a8a;
    transition: .2s;
}

.tab-menu.active {
    background: #1e3a8a;
    color: white;
}

.tab-content { display: none; }
.tab-content.active { display: block; }
</style>

<div class="tab-container">
    <div class="tab-menu active" data-target="#tab-siswa">Password Siswa</div>
    <div class="tab-menu" data-target="#tab-wali">Password Saya</div>
</div>

{{-- ================================
      TAB 1 — PASSWORD SISWA
================================ --}}
<div id="tab-siswa" class="tab-content active">

    <div class="topbar-filter">
        <form method="GET" action="{{ route('wali.password.index') }}">
            <div class="filter-container">
                <div class="filter-group">
                    <label>Cari Siswa</label>
                    <div class="search-box">
                        <input type="text" name="search_siswa" placeholder="Cari NIS / Nama..."
                            value="{{ request('search_siswa') }}">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <table>
        {{-- ============ KOLOM FIX AGAR LURUS ============ --}}
        <colgroup>
            <col style="width: 60px;">   <!-- No -->
            <col style="width: 140px;">  <!-- NIS -->
            <col style="width: 260px;">  <!-- Nama -->
            <col style="width: 140px;">  <!-- Rombel -->
            <col style="width: 180px;">  <!-- Jurusan -->
            <col style="width: 160px;">  <!-- Aksi -->
        </colgroup>

        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Rombel</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($siswas as $i => $s)
            <tr>
                <td style="text-align:center">{{ $i + $siswas->firstItem() }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_lengkap }}</td>
                <td>{{ $s->rombel }}</td>
                <td>{{ $s->jurusan }}</td>
                <td style="text-align:center;">
                    <a href="{{ route('wali.password.edit', $s->nis) }}" class="aksi-edit" style="color:#ff9800;">
                        <i class="fas fa-key"></i> Ubah Password
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $siswas->appends(request()->query())->links('pagination::simple-tailwind') }}
    </div>

</div>

{{-- ================================
      TAB 2 — UBAH PASSWORD WALI
================================ --}}
<div id="tab-wali" class="tab-content">

    <h3>Ubah Password Saya</h3>

    <form method="POST" action="{{ route('wali.password.updateSelf') }}">
        @csrf

        <div style="margin-bottom:15px;">
            <label>Password Lama</label>
            <input type="password" name="current_password" required
                style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <div style="margin-bottom:15px%;">
            <label>Password Baru</label>
            <input type="password" name="new_password" required
                style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc%;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" required
                style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <button style="background:#1e3a8a; color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer;">
            Simpan Perubahan
        </button>

    </form>

</div>

{{-- ================================
      STYLING TABLE
================================ --}}
<style>
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    table-layout: fixed;
}

thead {
    background: #2c3e50;
    color: white;
}

th, td {
    padding: 8px 10px;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

tbody tr:hover { background: #f8f9fa; }

.search-box {
    display: flex;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 12px;
    width: 260px;
}

/* Perataan kolom */
td:nth-child(1), th:nth-child(1),
td:nth-child(6), th:nth-child(6) { text-align: center; }
td:nth-child(2), th:nth-child(2),
td:nth-child(3), th:nth-child(3),
td:nth-child(4), th:nth-child(4),
td:nth-child(5), th:nth-child(5) { text-align: left; }

.aksi-edit { font-weight: 600; }
</style>

<script>
document.querySelectorAll('.tab-menu').forEach(tab => {
    tab.addEventListener('click', function() {

        document.querySelectorAll('.tab-menu').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        document.querySelector(this.dataset.target).classList.add('active');
    });
});
</script>

@endsection
