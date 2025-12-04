@extends('layouts.admin')

@section('title', 'Dashboard Wali Kelas')
@section('page_title', 'Dashboard Wali Kelas')

@section('content')

<div class="welcome-card">
    <h1>Selamat Datang, Wali Kelas {{ auth('guru')->user()->walikelas }}</h1>
    <p>Monitoring Data Siswa Rombel {{ auth('guru')->user()->walikelas }}</p>
</div>
{{-- === KARTU INFORMASI === --}}
<div class="info-cards">

    {{-- Total Siswa --}}
    <div class="info-card">
        <div class="content">
            <p>Total Siswa Kelas</p>
            <h3>{{ $totalSiswa }}</h3>
        </div>
        <div class="icon">
            <i class="bi bi-mortarboard-fill" style="font-size: 38px; color:#1e3a8a;"></i>
        </div>
    </div>

    {{-- Laki-Laki --}}
    <div class="info-card">
        <div class="content">
            <p>Laki-Laki</p>
            <h3>{{ $totalLaki }}</h3>
        </div>
        <div class="icon">
            <i class="bi bi-person-fill" style="font-size: 38px; color:#0d6efd;"></i>
        </div>
    </div>

    {{-- Perempuan --}}
    <div class="info-card">
        <div class="content">
            <p>Perempuan</p>
            <h3>{{ $totalPerempuan }}</h3>
        </div>
        <div class="icon">
            <i class="bi bi-person-fill" style="font-size: 38px; color:#c18ba6;"></i>
        </div>
    </div>

</div>



{{-- === GRAFIK JENIS KELAMIN === --}}
<div class="dashboard-grid">
    <div class="left-grid-column">
        <div class="chart-card">
            <h3>Grafik Siswa Berdasarkan Jenis Kelamin</h3>

            <div class="chart-container">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="right-column-cards">

        {{-- === DOKUMEN SISWA === --}}
        <a href="{{ route('wali.dokumensiswa') }}" style="text-decoration:none; display:block;">
            <div class="admin-action-card">

                <h3>Dokumen Siswa</h3>

                <div class="action-item" style="display:flex; align-items:center; gap:10px;">
                    <i class="bi bi-file-earmark-text" style="font-size:40px; color:#1e3a8a;"></i>
                    
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between;">
                            <span>Belum Lengkap</span>
                            <span>{{ $dokumenBelum }}</span>
                        </div>

                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: 100%; background:#dc3545"></div>
                        </div>
                    </div>
                </div>

            </div>
        </a>


    </div>
</div>


{{-- === CHART.JS === --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('genderChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Laki-Laki', 'Perempuan'],
            datasets: [{
                data: [{{ $totalLaki }}, {{ $totalPerempuan }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)', 
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', 
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>

@endsection
