@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <div style="background:#17375d; color:white; border-radius:10px; padding:20px; flex:1; min-width:250px;">
        <h3>Selamat Datang, Ratna Khoirun Nisa</h3>
        <p>Desain Komunikasi Visual</p>
    </div>

    <div style="background:white; border-radius:10px; padding:20px; flex:1; min-width:250px;">
        <h4>Barcode</h4>
        <img src="{{ asset('images/barcode.png') }}" width="100%">
    </div>

    <div style="background:white; border-radius:10px; padding:20px; flex:1; min-width:250px;">
        <h4>Status Kelengkapan Data</h4>
        <div style="background:#eee; border-radius:10px; height:10px;">
            <div style="background:#007bff; height:10px; width:90%; border-radius:10px;"></div>
        </div>
        <p style="margin-top:5px;">90%</p>
    </div>

    <div style="background:white; border-radius:10px; padding:20px; flex:1; min-width:250px;">
        <h4>Status di Semester - Ganjil T.A. 2025/2026</h4>
        <p style="color:green; font-weight:bold;"><i class="fa fa-check-circle"></i> Aktif</p>
    </div>

    <div style="background:white; border-radius:10px; padding:20px; flex:2;">
        <h4>Jadwal Konseling Anda</h4>
        <table style="width:100%; border-collapse:collapse;">
            <tr style="background:#17375d; color:white;">
                <th style="padding:8px;">Tanggal</th>
                <th>Waktu</th>
                <th>Konselor</th>
            </tr>
            <tr><td>10 Mei 2024</td><td>10:00</td><td>Siti Aminah</td></tr>
            <tr><td>10 Mei 2024</td><td>14:00</td><td>Budi Santoso</td></tr>
            <tr><td>11 Mei 2024</td><td>10:00</td><td>Joko Susilo</td></tr>
            <tr><td>11 Mei 2024</td><td>13:00</td><td>Ani Wijaya</td></tr>
        </table>
    </div>
</div>
@endsection
