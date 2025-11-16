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
    color: #2c3e50;
    transition: .2s;
}
.tab-menu.active {
    background: #4B0082;
    color: white;
}
.tab-content { display: none; }
.tab-content.active { display: block; }
</style>

<div class="tab-container">
    <div class="tab-menu active" data-target="#tab-siswa">Password Siswa</div>
    <div class="tab-menu" data-target="#tab-guru">Password Guru</div>
    <div class="tab-menu" data-target="#tab-admin">Password Admin</div>
</div>


{{-- ================================
      TAB 1 — PASSWORD SISWA
================================ --}}
<div id="tab-siswa" class="tab-content active">

    <div class="topbar-filter">
        <form method="GET" action="{{ route('admin.password.index') }}">
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
                    <a href="{{ route('admin.password.edit', ['type' => 'siswa', 'id' => $s->nis]) }}"
                        class="aksi-edit" style="color:#ff9800;">
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
      TAB 2 — PASSWORD GURU
================================ --}}
<div id="tab-guru" class="tab-content">

    <div class="topbar-filter">
        <form method="GET" action="{{ route('admin.password.index') }}">
            <div class="filter-container">
                <div class="filter-group">
                    <label>Cari Guru</label>
                    <div class="search-box">
                        <input type="text" name="search_guru" placeholder="Cari NIP / Nama..."
                            value="{{ request('search_guru') }}">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($gurus as $i => $g)
            <tr>
                <td style="text-align:center">{{ $i + $gurus->firstItem() }}</td>
                <td>{{ $g->nip }}</td>
                <td>{{ $g->nama }}</td>
                <td>{{ ucfirst($g->role) }}</td>
                <td style="text-align:center;">
                    <a href="{{ route('admin.password.edit', ['type' => 'guru', 'id' => $g->nip]) }}"
                        class="aksi-edit" style="color:#ff9800;">
                        <i class="fas fa-key"></i> Ubah Password
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $gurus->appends(request()->query())->links('pagination::simple-tailwind') }}
    </div>

</div>



{{-- ================================
      TAB 3 — PASSWORD ADMIN SENDIRI
================================ --}}
<div id="tab-admin" class="tab-content">

    <h3>Ubah Password Admin</h3>

    <form method="POST" action="{{ route('admin.password.updateSelf') }}">
        @csrf

        <div style="margin-bottom:15px;">
            <label>Password Lama</label>
            <input type="password" name="current_password" required
                style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <div style="margin-bottom:15px;">
            <label>Password Baru</label>
            <input type="password" name="new_password" required
                style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
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
<style>
/* ================================
   TABLE STYLE (Sama seperti Data Siswa)
================================ */
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
    text-align: left;
    vertical-align: middle;
    word-wrap: break-word;
}

th:nth-child(1) { width: 5%; text-align: center; }
th:nth-child(2) { width: 15%; }
th:nth-child(3) { width: 25%; }
th:nth-child(4) { width: 18%; }
th:nth-child(5) { width: 30%; }
th:nth-child(6) { width: 14%; text-align: center; }

tbody tr:hover { background: #f8f9fa; }

td:last-child a {
    white-space: nowrap;
}

/* ================================
   SEARCH BOX
================================ */
.topbar-filter {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 20px;
}

.filter-container {
    display: flex;
    gap: 20px;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
}

.search-box {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    padding: 8px;
    border-radius: 12px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    width: 260px;
}

.search-box input {
    border: none;
    background: transparent;
    outline: none;
    flex: 1;
}

.search-box button {
    background: transparent;
    border: none;
    cursor: pointer;
    color: #333;
}

/* ================================
   AKSI BUTTON
================================ */
.aksi-edit {
    color: #ff9800;
    font-weight: 600;
    text-decoration: none;
}

.aksi-edit:hover {
    opacity: 0.7;
}
/* ================================
   TAB STYLE (WARNA BIRU)
================================ */
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

.tab-menu:hover {
    background: #1e3a8a;
    color: white;
}

.tab-menu.active {
    background: #1e3a8a;
    color: white;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* ================================
   PASSWORD INPUTS (Admin Tab)
================================ */
#tab-admin input[type="password"] {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-top: 5px;
}

#tab-admin button {
    background: #1e3a8a;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
}

#tab-admin button:hover {
    opacity: .85;
}
</style>



{{-- ================================
      SCRIPT UNTUK TAB
================================ --}}
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
