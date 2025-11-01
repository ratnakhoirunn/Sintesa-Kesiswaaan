@extends('layouts.admin')

@section('title', 'Tambah Konseling')
@section('page_title', 'Tambah Data Konseling')

@section('content')
<style>
    .wrap-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .header-box {
        background: #0e325f;
        color: white;
        padding: 18px 25px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-body {
        background: #fff;
        padding: 25px;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }

    label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-control, select, textarea {
        width: 100% !important;
        border: 1px solid #bfbfbf;
        border-radius: 8px;
        padding: 12px;
        font-size: 15px;
        margin-bottom: 14px;
        box-sizing: border-box;
    }


    .form-control:focus {
        border-color: #0e325f;
        box-shadow: 0 0 5px rgba(14,50,95,0.4);
    }

    .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 10px 18px;
    }

   .btn-primary {
        background-color: #123B6B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #0f2e52;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
    }
</style>

<div class="wrap-card">

    {{-- HEADER --}}
    <div class="header-box">
        <span>Tambah Data Konseling</span>
        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}<br>
              {{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
    </div>

    <div class="form-body">
        <form action="{{ route('admin.konseling.store') }}" method="POST">
            @csrf

            {{-- Nama & NIS Siswa --}}
            <label for="siswa_nis">Nama Siswa</label>
            <select id="siswa_nis" name="siswa_nis" class="form-control" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->nis }}">{{ $siswa->nama_lengkap }} ({{ $siswa->nis }})</option>
                @endforeach
            </select>

            {{-- Rombel --}}
            <label for="rombel">Rombel</label>
            <input type="text" id="rombel" name="rombel" class="form-control" required>

            {{-- Catatan --}}
            <label for="catatan">Catatan Konseling</label>
            <textarea id="catatan" name="catatan" class="form-control" rows="3"></textarea>

            {{-- Tanggal --}}
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" required>

            {{-- Tombol --}}
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <a href="{{ route('admin.konseling.index') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>

</div>
@endsection
