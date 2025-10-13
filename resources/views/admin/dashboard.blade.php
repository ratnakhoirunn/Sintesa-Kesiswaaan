@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="welcome-card">
        <h1>Selamat Datang, Admin</h1>
        <p>Kelola Data Siswa SMKN 2 Yogyakarta</p>
    </div>

    <div class="info-cards">
        <div class="info-card">
            <div class="content">
                <p>Total Siswa Aktif</p>
                <h3>650</h3>
            </div>
            <div class="icon">
                <img src="{{ asset('images/toga1.png') }}" alt="Total Siswa">
            </div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Total Admin</p>
                <h3>3</h3>
            </div>
            <div class="icon">
                <img src="{{ asset('images/totaladmincb.jpeg') }}" alt="Total Admin">
            </div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Jumlah Kunjungan Konseling</p>
                <h3>10</h3>
            </div>
            <div class="icon">
                <img src="{{ asset('images/totalkonsel.png') }}" alt="Jumlah Konseling">
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="left-grid-column">
            <div class="chart-card">
                <h3>Grafik Siswa Per Jurusan</h3>
                <div class="chart-container">
                    <canvas id="siswaPerJurusanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="right-column-cards">
            <div class="admin-action-card">
                <h3>Dokumen Siswa</h3>
                <div class="action-item">
                    <img src="{{ asset('images/dok_lengkap.jpeg') }}" alt="Dokumen Lengkap">
                    <span>Dokumen Lengkap</span>
                </div>
                <div class="action-item">
                    <img src="{{ asset('images/dok_sedang.png') }}" alt="Sedang">
                    <span>Sedang</span>
                </div>
                <div class="action-item">
                    <img src="{{ asset('images/dok_berat.png') }}" alt="Berat">
                    <span>Berat</span>
                </div>
            </div>
            <div class="konseling-action-card">
                <h3>Tindakan Konseling</h3>
                <div class="notification-item">
                    <i class="fas fa-bell"></i>
                    <span>Jadwal Konseling Menunggu<br>5 Permintaan Masuk</span>
                </div>
            </div>
        </div>
    </div>
@endsection
