@extends('layouts.siswa')

@section('title', 'Dokumen Siswa | SINTESA')
@section('page_title', 'Dokumen Siswa')

<style>
/* 🎨 Gaya CSS untuk Tampilan yang Sangat Rapi dan Rapat */

/* --- Umum --- */
body {
    background-color: #f7f9fc;
}

/* ====== CARD STYLE ====== */
.card {
    border-radius: 12px !important;
    overflow: hidden;
    border: 1px solid #e0e7ff;
}

.card-header {
    font-size: 1rem;
    letter-spacing: 0.3px;
    padding: 15px 20px;
    border-bottom: none !important;
}

.card-header.bg-primary {
    background-color: #007bff !important;
    color: white !important;
    font-weight: 700;
}

.card-body {
    background-color: white;
    /* Perbaikan: Tambahkan padding atas agar konten tidak menempel ke header */
    padding: 5px 0 0 0; 
}

/* ====== TABLE STYLE (Inti Perapian & Kerapatan) ====== */
table.table {
    width: 100%;
    margin-bottom: 0;
}

/* Menggunakan Flexbox untuk Kesejajaran Vertikal Penuh dan BARIS YANG RENGGANG CUKUP */
table.table tr {
    transition: background-color 0.2s ease-in-out;
    display: flex;
    align-items: center;
    height: 50px; /* Tinggi baris ideal */
    border-bottom: 1px solid #f0f0f0;
    padding: 0 10px;
}
/* Perbaikan: Atur padding atas/bawah yang lebih aman untuk baris pertama */
table.table tr:first-child {
    padding-top: 5px; 
    padding-bottom: 5px;
}

table.table tr:hover {
    background-color: #f5f9ff;
    transform: none;
}

table.table tr:last-child {
    border-bottom: none;
}

table.table td {
    padding: 6px 8px !important;
    vertical-align: middle;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
}

/* 🎯 Penyesuaian Lebar Kolom untuk Mengurangi Jarak Horizontal */
/* Icon */
.table td:nth-child(1) {
    width: 50px;
    justify-content: center;
}

/* Jenis Dokumen (Fleksibel, Tetap Beri Sedikit Batasan Lebar Maksimal) */
.table td:nth-child(2) {
    width: 35%; 
    padding-left: 0 !important;
    font-weight: 500;
    color: #333;
}

/* Status (Lebar Tetap) */
.table td:nth-child(3) {
    width: 160px; 
    justify-content: center;
}

/* Tombol Aksi (Lebar Tetap) */
.table td:nth-child(4) {
    flex-grow: 1; 
    min-width: 250px; 
    justify-content: flex-end;
    padding-right: 15px !important;
}

/* ====== ICONS ====== */
.doc-icon {
    color: #007bff;
    background: #e9f2ff;
    padding: 7px 9px;
    border-radius: 8px;
    font-size: 1rem;
}


/* ====== STATUS STYLE (Badge) ====== */
.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-success {
    background-color: #e6fff0;
    color: #1a7a40 !important;
}

.status-danger {
    background-color: #ffe8e8;
    color: #c0392b !important;
}

.status-badge i {
    font-size: 0.8rem;
    margin-left: 4px;
}

/* ====== ACTION BUTTONS (Tombol Aksi yang Rapi dan Seragam) ====== */
.action-buttons {
    display: flex;
    gap: 6px; 
}

/* Style umum untuk tombol dan label upload */
.action-buttons a,
.action-buttons label {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    height: 32px; 
    transition: all 0.2s ease;
    cursor: pointer;
    white-space: nowrap;
}

.action-buttons a:hover,
.action-buttons label:hover {
    opacity: 0.9;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Tombol Lihat (Primary/Blue) */
.btn-view {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: white !important;
}

/* Tombol Ganti File (Success/Green) */
.btn-ganti {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: white !important;
}

/* Tombol Upload File (Danger/Red) */
.btn-upload {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: white !important;
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

/* ====== DETAIL CARD (Accordion Style) ====== */
.detail-card-header {
    background-color: #2c7ef6 !important;
    color: white;
    font-weight: 600;
    border-radius: 12px 12px 0 0 !important;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
}

.detail-card-header:hover {
    background-color: #0056b3 !important;
}

.detail-card-body {
    padding: 20px !important;
    border-top: 1px solid #e0e0e0;
}

.text-muted {
    font-size: 0.9rem;
}
</style>

@section('content')
<div class="container mt-4">

    {{-- 📑 Bagian Dokumen Terpenuhi --}}
    <div class="card shadow-sm">
        {{-- Header Dokumen --}}
        <div class="card-header bg-primary text-white">
            Dokumen Terpenuhi :
            {{ $dokumens->whereNotNull('file_path')->count() }} dari {{ $dokumens->count() }}
        </div>

        {{-- Body Dokumen (Tabel) --}}
        <div class="card-body">
            <table class="table mb-0">
                <tbody>
                    @foreach($dokumens as $dokumen)
                    <tr>
                        {{-- Icon dokumen --}}
                        <td class="ps-4">
                            <i class="fas fa-file-alt doc-icon"></i>
                        </td>

                        {{-- Jenis dokumen --}}
                        <td>{{ $dokumen->jenis_dokumen }}</td>

                        {{-- Status --}}
                        <td>
                            @if($dokumen->file_path)
                                <span class="status-badge status-success">
                                    Diunggah <i class="fas fa-check-circle"></i>
                                </span>
                            @else
                                <span class="status-badge status-danger">
                                    Belum Diunggah <i class="fas fa-times-circle"></i>
                                </span>
                            @endif
                        </td>

                        {{-- Tombol Aksi (Sudah Rapi dan Sejajar) --}}
                        <td>
                            <div class="action-buttons">

                                {{-- Tombol Lihat (Hanya Muncul jika sudah diunggah) --}}
                                @if($dokumen->file_path)
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}"
                                        target="_blank"
                                        class="btn-view">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                @endif

                                {{-- Form Upload/Ganti --}}
                                <form action="{{ route('siswa.dokumensiswa.upload', $dokumen->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Input file tersembunyi --}}
                                    <input type="file" name="file"
                                           id="fileInput{{ $dokumen->id }}"
                                           onchange="this.form.submit()">

                                    {{-- Label sebagai tombol (Upload/Ganti) --}}
                                    @if($dokumen->file_path)
                                        <label for="fileInput{{ $dokumen->id }}" class="btn-ganti">
                                            <i class="fas fa-edit me-1"></i> Ganti File
                                        </label>
                                    @else
                                        <label for="fileInput{{ $dokumen->id }}" class="btn-upload">
                                            <i class="fas fa-upload me-1"></i> Upload File
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

    {{-- 📋 Bagian Detail Data Administrasi (Dropdown/Accordion) --}}
    <div class="card mt-4 shadow-sm border-0">
        {{-- Header Detail --}}
        <div class="detail-card-header" data-bs-toggle="collapse" data-bs-target="#detailData" aria-expanded="true" aria-controls="detailData">
            <span>Detail Data Administrasi Siswa</span>
            <i class="fas fa-chevron-down"></i>
        </div>

        {{-- Body Detail --}}
        <div class="collapse show" id="detailData">
            <div class="detail-card-body">
                <p class="text-muted mb-0">Data administrasi siswa akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>

</div>
@endsection