@extends('layouts.admin')

@section('title', 'Manajemen Role')
@section('page_title', 'Manajemen Role')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    * {
        font-family: 'Poppins', sans-serif;
    }
    .table-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .top-bar {
        background: #0d3b66;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .filters {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
    .search-wrapper {
        position: relative;
        width: 100%;
    }
    .search-box {
        border: none;
        border-radius: 8px;
        padding: 8px 35px 8px 35px;
        width: 92%;
        font-size: 14px;
    }
    .search-wrapper i {
        position: absolute;
        top: 9px;
        left: 10px;
        color: #888;
        font-size: 14px;
    }
    .filter-role {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 14px;
        color: #555;
    }
    .btn-add {
        background: #fff;
        color: #0d3b66;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        padding: 8px 15px;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-add:hover {
        background: #f1f1f1;
    }

    /* ===== RESPONSIVE FIX ===== */
    @media (max-width: 768px) {
        .top-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .filters {
            width: 100%;
            flex-direction: column;
        }
        .filter-role {
            width: 100%;
        }
        .btn-add {
            width: 100%;
            text-align: center;
        }
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    thead {
        background: #2c3e50;
        border-bottom: 2px solid #eee;
    }
    thead th {
        color: #fff;
        font-weight: 600;
    }
    tbody tr:nth-child(even) {
        background: #fafafa;
    }
    .role-badge {
        color: #fff;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 13px;
        font-weight: 500;
    }
    .btn-action {
        border: none;
        background: none;
        color: #0d6efd;
        cursor: pointer;
        font-size: 16px;
        margin: 0 4px;
    }
    .btn-action:hover {
        color: #0b5ed7;
    }
</style>

<div class="table-container">
    <div class="top-bar">
        <form method="GET" action="{{ route('admin.role.index') }}" class="filters">

            {{-- Search Box --}}
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="search-box" placeholder="Cari User...">
            </div>

            {{-- Filter Role (dengan ikon di LUAR search box) --}}
            <div style="display:flex; align-items:center; gap:6px; color:white;">
                <select name="role" class="filter-role" onchange="this.form.submit()">
                     <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="guru_bk" {{ request('role') == 'guru_bk' ? 'selected' : '' }}>
                        Guru BK
                    </option>

                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>
                        Guru
                    </option>

                    <option value="kesiswaan" {{ request('role') == 'kesiswaan' ? 'selected' : '' }}>
                        Kesiswaan
                    </option>
                     <option value="Siswa" {{ request('role') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
            </div>
        </form>

        <a href="{{ route('admin.role.create') }}" class="btn-add">
            Tambah User
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengguna</th>
                <th>NIP/NIS</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $role->nama_lengkap ?? $role->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $role->nis ?? $role->nip ?? '-' }}
                    </td>

                    <td>{{ $role->email ?? '-' }}</td>
                    <td>
                        <span class="role-badge" style="background:
                            {{ $role->role == 'admin' ? '#0d6efd' :
                               ($role->role == 'guru_bk' ? '#ffc107' :
                               ($role->role == 'kesiswaan' ? '#6610f2' : '#28a745')) }};">
                            {{ $role->role == 'guru' ? 'Guru' : ucfirst($role->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.role.edit', $role->nip ?? $role->nis) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.role.destroy', $role->nip ?? $role->nis) }}" 
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action" onclick="return confirm('Yakin hapus user ini?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#777;">Belum ada data user</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
