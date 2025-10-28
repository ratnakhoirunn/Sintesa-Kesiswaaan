@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')

<style>
    .dashboard-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .dashboard-card {
        background: #ffffff;
        border: 2px solid #17375d;
        border-radius: 10px;
        padding: 20px;
        flex: 1;
        min-width: 250px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .dashboard-card h4 {
        margin-top: 0;
        color: #17375d;
        font-weight: 600;
        border-bottom: 2px solid #17375d;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .progress-bar {
        background: #e9ecef;
        border-radius: 10px;
        height: 10px;
        overflow: hidden;
    }

    .progress {
        background: #007bff;
        height: 10px;
        width: 90%;
        border-radius: 10px;
    }

    .status-aktif {
        color: green;
        font-weight: bold;
        font-size: 1.1em;
    }

    .status-aktif i {
        margin-right: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    table th, table td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background: #17375d;
        color: white;
    }
</style>

<div class="welcome-card">
    <h1>Selamat Datang, Ratna Khoirun Nisa</h1>
    <p>Desain Komunikasi Visual</p>
</div>

<div class="dashboard-container">
    <div class="dashboard-card">
        <h4>Barcode</h4>
        <img src="{{ asset('images/barcode.png') }}" alt="Barcode" style="width:100%; max-width:200px;">
    </div>

    <div class="dashboard-card">
        <h4>Status Kelengkapan Data</h4>
        <div class="progress-bar">
            <div class="progress"></div>
        </div>
        <p style="margin-top:5px;">90%</p>
    </div>

    <div class="dashboard-card">
        <h4>Status di Semester - Ganjil T.A. 2025/2026</h4>
        <p class="status-aktif"><i class="fa fa-check-circle"></i> Aktif</p>
    </div>

    <div class="dashboard-card" style="flex:2;">
        <h4>Jadwal Konseling Anda</h4>
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
