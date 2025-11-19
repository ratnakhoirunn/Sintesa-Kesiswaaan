@extends('layouts.admin')

@section('title', 'Detail Konseling')
@section('page_title', 'Detail Pengajuan Konseling')

@section('content')

<style>
    /* === GLOBAL FONT === */
    .form-container,
    .form-container * {
        font-family: 'Poppins', sans-serif !important;
    }

    .form-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        width: 100%;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #1e3a8a;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #f9fafb;
        font-size: 14px;
        resize: none;
    }

    .form-group input[readonly],
    .form-group textarea[readonly] {
        background: #f1f5f9;
        color: #555;
        cursor: not-allowed;
    }

    .form-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-secondary {
        padding: 10px 18px;
        background: #6b7280;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.2s;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    @media(max-width: 768px){
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">

    <div class="grid-2">
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" value="{{ $konseling->nama_siswa }}" readonly>
        </div>

        <div class="form-group">
            <label>NIS</label>
            <input type="text" value="{{ $konseling->nis }}" readonly>
        </div>

        <div class="form-group">
            <label>Kelas</label>
            <input type="text" value="{{ $konseling->kelas }}" readonly>
        </div>

        <div class="form-group">
            <label>Nama Orang Tua</label>
            <input type="text" value="{{ $konseling->nama_ortu }}" readonly>
        </div>

        <div class="form-group">
            <label>Alamat Orang Tua</label>
            <input type="text" value="{{ $konseling->alamat_ortu }}" readonly>
        </div>

        <div class="form-group">
            <label>No Telp Orang Tua</label>
            <input type="text" value="{{ $konseling->no_telp_ortu }}" readonly>
        </div>
    </div>

    <div class="form-group">
        <label>Alasan Konseling</label>
        <textarea rows="4" readonly>{{ $konseling->alasan }}</textarea>
    </div>

    <div class="form-group">
        <label>Topik / Peristiwa</label>
        <input type="text" value="{{ $konseling->topik }}" readonly>
    </div>

    <div class="form-group">
        <label>Latar Belakang</label>
        <textarea rows="4" readonly>{{ $konseling->latar_belakang }}</textarea>
    </div>

    <div class="form-group">
        <label>Kegiatan Layanan yang Diinginkan</label>
        <textarea rows="4" readonly>{{ $konseling->kegiatan_layanan }}</textarea>
    </div>

    <div class="form-buttons">
        <a href="{{ route('admin.konseling.index') }}" class="btn-secondary">Kembali</a>
    </div>

</div>

@endsection
