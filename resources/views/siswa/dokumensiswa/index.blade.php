@extends('layouts.siswa')

@section('title', 'Dokumen Siswa | SINTESA')
@section('page_title', 'Dokumen Siswa')

<style>
    /* ====== CARD STYLE ====== */
    .card {
        border-radius: 15px !important;
        overflow: hidden;
    }

    .card-header {
        font-size: 1rem;
        letter-spacing: 0.3px;
        padding: 12px 18px;
    }

    .card-body {
        background-color: #fafafa;
    }

    /* ====== TABLE STYLE ====== */
    table.table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    table.table tr {
        transition: all 0.2s ease-in-out;
    }

    table.table tr:hover {
        background-color: #f1f7ff;
        transform: scale(1.005);
    }

    table.table td {
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    /* Atur lebar kolom agar tidak terlalu renggang */
    table.table td:nth-child(2) {
        width: 35%;
    }

    table.table td:nth-child(3) {
        width: 25%;
        text-align: center;
    }

    table.table td:nth-child(4) {
        width: 20%;
        text-align: right;
    }

    /* ====== ICONS ====== */
    .fa-file-alt {
        color: #007bff;
        background: #e9f2ff;
        padding: 10px;
        border-radius: 10px;
    }

    /* ====== STATUS STYLE ====== */
    .text-success.fw-semibold,
    .text-danger.fw-semibold {
        padding: 6px 12px;
        border-radius: 12px;
        display: inline-block;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .text-success.fw-semibold {
        background-color: #e7f9ef;
        color: #0f8b3e !important;
    }

    .text-danger.fw-semibold {
        background-color: #fde7e7;
        color: #c72c2c !important;
    }

    /* ====== BUTTON STYLE ====== */
    .btn-sm {
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.3px;
        padding: 6px 14px;
        font-size: 0.85rem;
    }

    .btn-success.btn-sm {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-danger.btn-sm {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }

    /* ====== HILANGKAN INPUT FILE BAWAAN ====== */
    input[type="file"] {
        position: absolute;
        left: -9999px;
        opacity: 0;
        visibility: hidden;
        width: 0;
        height: 0;
    }

    /* ====== DETAIL CARD ====== */
    .card.mt-4 .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #007bff;
        color: white;
        font-weight: 600;
        border-bottom: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .card.mt-4 .card-header:hover {
        background-color: #0069d9;
    }

    .card.mt-4 .card-body {
        background-color: white;
        border-top: 1px solid #e0e0e0;
    }

    .text-muted {
        font-size: 0.9rem;
    }

    /* Container tombol */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
}

/* Style umum tombol */
.action-buttons a,
.action-buttons label {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    text-decoration: none !important; /* hilangkan garis bawah */
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    height: 34px; /* bikin semua tinggi sama */
}

/* Tombol lihat */
.btn-view {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: white !important;
}

/* Tombol ganti */
.btn-ganti {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: white !important;
}

/* Tombol upload */
.btn-upload {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: white !important;
}

</style>

@section('content')
<div class="container mt-4">

    {{-- Bagian Dokumen Terpenuhi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Dokumen Terpenuhi :
            {{ $dokumens->whereNotNull('file_path')->count() }} dari {{ $dokumens->count() }}
        </div>

        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <tbody>
                    @foreach($dokumens as $dokumen)
                    <tr>
                        {{-- Icon dokumen --}}
                        <td class="ps-3" style="width: 45px;">
                            <i class="fas fa-file-alt text-primary fs-5"></i>
                        </td>

                        {{-- Jenis dokumen --}}
                        <td>{{ $dokumen->jenis_dokumen }}</td>

                        {{-- Status --}}
                        <td style="width: 180px;">
                            @if($dokumen->file_path)
                                <span class="text-success fw-semibold">
                                    Diunggah <i class="fas fa-check-circle ms-1"></i>
                                </span>
                            @else
                                <span class="text-danger fw-semibold">
                                    Belum Diunggah <i class="fas fa-times-circle ms-1"></i>
                                </span>
                            @endif
                        </td>

                       <td class="text-end pe-3" style="width: 250px;">
    <div class="action-buttons">

        {{-- Tombol Lihat --}}
        @if($dokumen->file_path)
            <a href="{{ asset('storage/' . $dokumen->file_path) }}"
               target="_blank"
               class="btn-view">
               Lihat
            </a>
        @endif

        {{-- Upload/Ganti --}}
        <form action="{{ route('siswa.dokumensiswa.upload', $dokumen->id) }}"
              method="POST" enctype="multipart/form-data" class="d-inline">
            @csrf

            <input type="file" name="file"
                   id="fileInput{{ $dokumen->id }}"
                   class="d-none"
                   onchange="this.form.submit()">

            @if($dokumen->file_path)
                <label for="fileInput{{ $dokumen->id }}" class="btn-ganti">
                    Ganti File
                </label>
            @else
                <label for="fileInput{{ $dokumen->id }}" class="btn-upload">
                    Upload File
                </label>
            @endif
        </form>

    </div>
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bagian Detail Data Administrasi --}}
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
            <span>Detail Data Administrasi Siswa</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="card-body">
            {{-- Isi detail data siswa bisa ditambahkan di sini --}}
            <p class="text-muted mb-0">Data administrasi siswa akan ditampilkan di sini.</p>
        </div>
    </div>

</div>
@endsection