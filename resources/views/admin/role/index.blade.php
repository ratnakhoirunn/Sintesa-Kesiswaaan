@extends('layouts.admin')

@section('title', 'Manajemen Role')
@section('page_title', 'Manajemen Role')

@section('content')

{{-- Load FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    * { font-family: 'Poppins', sans-serif; }

    /* ===========================
       1. FILTER TAB MENU STYLE
       =========================== */
    .tab-container {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        overflow-x: auto; /* Scroll samping di HP */
        padding-bottom: 5px;
        -webkit-overflow-scrolling: touch;
    }

    .tab-menu {
        padding: 10px 20px;
        border-radius: 8px;
        background: #e0e7ff; /* Biru muda */
        color: #123B6B;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .tab-menu:hover {
        background: #c7d2fe;
        color: #0a2240;
    }

    /* State Aktif (Tab yang dipilih) */
    .tab-menu.active {
        background: #123B6B; /* Biru Utama */
        color: white;
        box-shadow: 0 4px 6px rgba(18, 59, 107, 0.2);
    }

    /* ===========================
       2. CONTAINER & TOOLBAR
       =========================== */
    .table-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Search Box */
    .search-form { flex: 1; min-width: 250px; }
    .search-wrapper { position: relative; width: 100%; }
    
    .search-box {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 10px 10px 10px 40px;
        width: 100%;
        font-size: 14px;
        box-sizing: border-box;
    }
    .search-wrapper i {
        position: absolute; top: 50%; left: 12px;
        transform: translateY(-50%); color: #9ca3af;
    }

    /* Tombol Tambah */
    .btn-add {
        background: #123B6B; /* Hijau */
        color: white;
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        transition: 0.2s;
    }
    .btn-add:hover { background: #218838; color: white; }

    /* ===========================
       3. TABLE STYLE (ORIGINAL COLOR)
       =========================== */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px; /* Lebar minimal agar rapi */
    }

    /* HEADER WARNA GELAP (ORIGINAL) */
    thead {
        background: #2c3e50; /* Warna Asli */
        color: white;
        border-bottom: 2px solid #1a252f;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    th { font-weight: 600; }
    
    tbody tr:hover { background-color: #f1f1f1; }

    /* Role Badge */
    .role-badge {
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        min-width: 80px;
        text-align: center;
        color: white; /* Teks Putih */
    }

    /* Action Buttons */
    .btn-action {
        border: none; background: none; cursor: pointer;
        font-size: 16px; margin: 0 4px; transition: 0.2s;
    }
    .btn-edit { color: #f39c12; }
    .btn-edit:hover { opacity: 0.8; }
    .btn-delete { color: #dc3545; }
    .btn-delete:hover { opacity: 0.8; }

    /* ===========================
       MOBILE RESPONSIVE
       =========================== */
    @media (max-width: 768px) {
        .top-bar { flex-direction: column; align-items: stretch; }
        .search-form { width: 100%; }
        .btn-add { justify-content: center; }
        .tab-menu { flex: 0 0 auto; } 
    }
</style>

{{-- TAB MENU (FILTER ROLE) --}}
<div class="tab-container">
    <a href="{{ route('admin.role.index', ['role' => 'admin']) }}" 
       class="tab-menu {{ request('role') == 'admin' ? 'active' : '' }}">
       Admin
    </a>

    <a href="{{ route('admin.role.index', ['role' => 'guru_bk']) }}" 
       class="tab-menu {{ request('role') == 'guru_bk' ? 'active' : '' }}">
       Guru BK
    </a>

    <a href="{{ route('admin.role.index', ['role' => 'guru']) }}" 
       class="tab-menu {{ request('role') == 'guru' ? 'active' : '' }}">
       Guru
    </a>

    <a href="{{ route('admin.role.index', ['role' => 'kesiswaan']) }}" 
       class="tab-menu {{ request('role') == 'kesiswaan' ? 'active' : '' }}">
       Kesiswaan
    </a>

    <a href="{{ route('admin.role.index', ['role' => 'Siswa']) }}" 
       class="tab-menu {{ request('role') == 'Siswa' ? 'active' : '' }}">
       Siswa
    </a>
</div>

<div class="table-container">
    
    {{-- TOOLBAR (SEARCH & ADD) --}}
    <div class="top-bar">
        {{-- Search Form --}}
        <form method="GET" action="{{ route('admin.role.index') }}" class="search-form">
            {{-- PENTING: Hidden Input agar filter role tidak hilang saat search --}}
            <input type="hidden" name="role" value="{{ request('role', 'admin') }}">

            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="search-box" placeholder="Cari Nama, NIS, atau Email...">
            </div>
        </form>

        <a href="{{ route('admin.role.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th>Nama Pengguna</th>
                    <th>NIS / NIP</th>
                    <th>Email</th>
                    <th style="text-align: center;">Role</th>

                    {{-- Kolom Wali Kelas jika filter Guru --}}
                    @if(request('role') == 'guru')
                        <th>Wali Kelas</th>
                    @endif

                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        
                        <td>
                            <strong>{{ $role->nama_lengkap ?? $role->nama ?? '-' }}</strong>
                        </td>

                        <td>{{ $role->nis ?? $role->nip ?? '-' }}</td>

                        <td>{{ $role->email ?? '-' }}</td>

                        <td style="text-align: center;">
                            @php
                                $bgColor = '#6c757d'; // Default Grey
                                if ($role->role == 'admin') $bgColor = '#0d6efd'; // Biru
                                elseif ($role->role == 'guru_bk') $bgColor = '#ffc107'; // Kuning/Gold
                                elseif ($role->role == 'kesiswaan') $bgColor = '#6610f2'; // Ungu
                                elseif ($role->role == 'guru') $bgColor = '#28a745'; // Hijau
                                elseif ($role->role == 'Siswa') $bgColor = '#17a2b8'; // Cyan
                            @endphp
                            
                            <span class="role-badge" style="background-color: {{ $bgColor }};">
                                {{ $role->role == 'guru' ? 'Guru' : ucfirst($role->role) }}
                            </span>
                        </td>
                        
                        @if(request('role') == 'guru')
                            <td>{{ $role->walikelas ?? '-' }}</td>
                        @endif

                        <td style="text-align: center;">
                            <a href="{{ route('admin.role.edit', $role->nip ?? $role->nis) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.role.destroy', $role->nip ?? $role->nis) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin hapus user ini? Data tidak bisa dikembalikan.')" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ request('role') == 'guru' ? 7 : 6 }}" style="text-align:center; padding: 30px; color:#777;">
                            <i class="far fa-folder-open" style="font-size: 32px; margin-bottom: 10px; display:block;"></i>
                            <br>Belum ada data user ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection