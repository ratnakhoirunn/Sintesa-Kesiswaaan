@extends('layouts.admin')

@section('title', 'Tambah Role')
@section('page_title', 'Tambah Role')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .form-wrapper {
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin: 20px auto;
        max-width: 950px;
    }

    .form-header {
        background: #0a3d62;
        color: white;
        font-weight: 600;
        padding: 14px 25px;
        font-size: 17px;
        letter-spacing: 0.5px;
    }

    .form-body {
        padding: 35px 50px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 10px 12px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13,110,253,0.2);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
    }

    .col-half {
        flex: 1 1 calc(50% - 25px);
        display: flex;
        flex-direction: column;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-submit {
        background: #0a3d62;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 25px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #082f4d;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 25px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #5a6268;
    }

    @media (max-width: 768px) {
        .col-half {
            flex: 1 1 100%;
        }
        .form-body {
            padding: 25px;
        }
    }
</style>

<div class="form-wrapper shadow-sm">
    <div class="form-header">TAMBAH ROLE PENGGUNA</div>
    <div class="form-body">
        <form action="{{ route('admin.role.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-half">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="nama_pengguna" class="form-control" placeholder="Masukkan nama pengguna" required>
                </div>

                <div class="col-half">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                </div>

                <div class="col-half">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email pengguna" required>
                </div>

                <div class="col-half">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Guru">Guru</option>
                    </select>
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-submit">💾 Simpan</button>
                <a href="{{ route('admin.role.index') }}" class="btn-back">⬅ Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
