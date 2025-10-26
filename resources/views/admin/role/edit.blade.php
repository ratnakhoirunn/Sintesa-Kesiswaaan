@extends('layouts.admin')

@section('title', 'Edit Role')
@section('page_title', 'Edit Role')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    * {
        font-family: 'Poppins', sans-serif;
    }
    .form-container {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        max-width: 600px;
        margin: 0 auto;
    }
    label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }
    input[type="text"],
    input[type="email"],
    select {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px 10px;
        margin-bottom: 15px;
    }
    .btn-primary {
        background: #0d6efd;
        border: none;
        color: white;
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: 500;
        transition: 0.2s;
    }
    .btn-primary:hover {
        background: #0b5ed7;
    }
    .btn-back {
        text-decoration: none;
        color: #0d6efd;
        font-weight: 500;
        margin-left: 10px;
    }
</style>

<div class="form-container">

    <form action="{{ route('admin.role.update', $role->nis) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ $role->nama_lengkap }}" readonly>

        <label>NIS</label>
        <input type="text" name="nis" value="{{ $role->nis }}" readonly>

        <label>Email</label>
        <input type="email" name="email" value="{{ $role->email }}" readonly>

        <label>Role</label>
        <select name="role" required>
            <option value="siswa" {{ $role->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="guru" {{ $role->role == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="bk" {{ $role->role == 'bk' ? 'selected' : '' }}>BK</option>
            <option value="admin" {{ $role->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <div class="text-center mt-3">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.role.index') }}" class="btn-back">Batal</a>
        </div>
    </form>
</div>
@endsection
