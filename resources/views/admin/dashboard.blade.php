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
                <h3>{{ $totalSiswa }}</h3>
            </div>
            <div class="icon">
                <img src="{{ asset('images/toga1.png') }}" alt="Total Siswa">
            </div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Total Admin</p>
                <h3>{{ $totalAdmin }}</h3>
            </div>
            <div class="icon">
                <img src="{{ asset('images/totaladmin.png') }}" alt="Total Admin">
            </div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Jumlah Kunjungan Konseling</p>
                <h3>{{ $totalKonseling }}</h3>
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

                @php
                    // Data contoh: jumlah dokumen yang sudah terpenuhi
                    $dokumenLengkap = 30;
                    $dokumenSedang = 15;
                    $dokumenBerat = 5; // Dokumen belum diunggah
                    $totalDokumen = $dokumenLengkap + $dokumenSedang + $dokumenBerat;

                    $items = [
                        ['label' => 'Belum Diunggah', 'count' => $dokumenBerat, 'icon' => 'dok_berat.png', 'color' => '#dc3545'],
                    ];
                @endphp

                @foreach($items as $item)
                    @php
                        // Persentase berdasarkan dokumen belum terpenuhi
                        $persen = round(($item['count'] / $totalDokumen) * 100);
                    @endphp
                    <div class="action-item" style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                        <img src="{{ asset('images/' . $item['icon']) }}" alt="{{ $item['label'] }}" style="width:40px; height:40px;">
                        <div style="flex:1;">
                            <div style="display:flex; justify-content:space-between;">
                                <span>{{ $item['label'] }}</span>
                                <span>{{ $persen }}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $persen }}%; background-color: {{ $item['color'] }};"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <style>
            .progress-bar-container {
                width: 100%;
                height: 8px;
                background-color: #e9ecef;
                border-radius: 4px;
                overflow: hidden;
                margin-top: 5px;
            }
            .progress-bar-fill {
                height: 100%;
                transition: width 0.4s ease;
            }
            </style>

            <div class="konseling-action-card">
                <h3>Tindakan Konseling</h3>
                <div class="notification-item">
                    <i class="fas fa-bell"></i>
                    <span>Jadwal Konseling Menunggu<br>5 Permintaan Masuk</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Script ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('siswaPerJurusanChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData->pluck('jurusan')) !!},
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: {!! json_encode($chartData->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
