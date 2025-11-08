@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')

<style>
    body {
        background-color: #f5f7fa;
    }

    /* ====== Header Biru Sambutan ====== */
    .welcome-card {
        background-color: #17375d;
        color: #fff;
        border-radius: 10px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .welcome-card h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .welcome-card p {
        margin-top: 6px;
        font-size: 14px;
        opacity: 0.9;
    }

    /* ====== Grid Kartu ====== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
    }

    /* ====== Card Style dengan header biru ====== */
    .card-box {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .card-box:hover {
        transform: translateY(-3px);
    }

    .card-header {
        background-color: #17375d;
        color: white;
        font-weight: 600;
        font-size: 15px;
        padding: 10px 15px;
        text-align: left;
    }

    .card-content {
        padding: 15px;
        text-align: center;
        background: #fff;
    }

    /* ====== Barcode ====== */
    .barcode-box {
        background: #f1f4ff;
        border-radius: 8px;
        padding: 12px 5px;
        margin-top: 8px;
    }

    /* ====== Progress Bar ====== */
    .progress-bar {
        background: #e9ecef;
        border-radius: 8px;
        height: 10px;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress {
        background: #007bff;
        height: 10px;
        width: 90%;
        border-radius: 8px;
    }

    /* ====== Status Aktif ====== */
    .status-circle {
        background: #e6f5e9;
        color: #28a745;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        margin: 10px auto;
    }

    /* ====== Tombol Cetak Kartu ====== */
    .btn-cetak {
        background-color: #17375d;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .btn-cetak:hover {
        background-color: #0f2740;
    }

    /* ====== Jadwal Konseling ====== */
    .jadwal-box {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .jadwal-header {
        background: #17375d;
        color: white;
        font-weight: 600;
        padding: 12px 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
    }

    table th {
        background: #f7f9fc;
        color: #17375d;
        font-weight: 600;
    }
</style>

<div class="welcome-card">
    <h2>Selamat Datang, {{ $siswa->nama_lengkap }}</h2>
    <p>{{ $siswa->jurusan }}</p>
</div>

<div class="dashboard-grid">
    {{-- Barcode --}}
    <div class="card-box">
        <div class="card-header">Barcode</div>
        <div class="card-content">
            <div class="barcode-box">
                {!! DNS1D::getBarcodeHTML(Auth::guard('siswa')->user()->nis, 'C128', 2, 40) !!}
            </div>
            <p style="margin-top:8px; font-weight:bold;">{{ Auth::guard('siswa')->user()->nis }}</p>
        </div>
    </div>

    {{-- Status Kelengkapan Data --}}
    <div class="card-box">
        <div class="card-header">Status Kelengkapan Data</div>
        <div class="card-content">
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <p style="font-weight:600; color:#007bff;">90%</p>
        </div>
    </div>

    {{-- Cetak Kartu Pelajar --}}
    <div class="card-box">
        <div class="card-header">Cetak Kartu Pelajar</div>
        <div class="card-content">
            <button class="btn-cetak" onclick="window.location.href='{{ route('siswa.kartupelajar.index') }}'">
                🖨 Cetak Kartu
            </button>
        </div>
    </div>

    {{-- Status Aktif --}}
    <div class="card-box">
        <div class="card-header">Status di Semester - Ganjil T.A. 2025/2026</div>
        <div class="card-content">
            <div class="status-circle">
                <i class="fa fa-check"></i>
            </div>
            <p style="font-weight:600; color:#28a745;">Aktif</p>
        </div>
    </div>
</div>

{{-- Jadwal Konseling --}}
<div class="jadwal-box">
    <div class="jadwal-header">Jadwal Konseling Anda</div>
    <div style="padding:15px;">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Konselor</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>10 Mei 2024</td><td>10:00</td><td>Siti Aminah</td></tr>
                <tr><td>10 Mei 2024</td><td>14:00</td><td>Budi Santoso</td></tr>
                <tr><td>11 Mei 2024</td><td>10:00</td><td>Joko Susilo</td></tr>
                <tr><td>11 Mei 2024</td><td>13:00</td><td>Ani Wijaya</td></tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
