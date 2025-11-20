@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="welcome-card">
    <h1>Selamat Datang, {{ ucfirst(str_replace('_', ' ', auth('guru')->user()->role)) }}</h1>
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
                 <div class="mb-3">
                    <label for="filterTahun" class="block text-sm font-medium text-gray-700">Filter Angkatan</label>
                    <select id="filterTahun" 
                        class="border border-gray-300 rounded-lg p-2 mt-1 filter-dropdown"
                        style="font-family: inherit;">
                        <option value="">Semua</option>
                        @foreach($angkatanList as $angkatan)
                            <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="siswaPerJurusanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="right-column-cards">
        <a href="{{ route('admin.dokumensiswa.index') }}" 
        style="text-decoration:none; color:inherit; display:block;">
            
            <div class="admin-action-card" 
                style="cursor:pointer; transition:.25s;">
                
                <h3>Dokumen Siswa</h3>

                @php
                    $dokumenLengkap = 30;
                    $dokumenSedang = 15;
                    $dokumenBerat = 5;
                    $totalDokumen = $dokumenLengkap + $dokumenSedang + $dokumenBerat;

                    $items = [
                        ['label' => 'Belum Diunggah', 'count' => $dokumenBerat, 'icon' => 'dok_berat.png', 'color' => '#dc3545'],
                    ];
                @endphp

                @foreach($items as $item)
                    @php
                        $persen = round(($item['count'] / $totalDokumen) * 100);
                    @endphp

                    <div class="action-item" style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                        <img src="{{ asset('images/' . $item['icon']) }}" 
                            alt="{{ $item['label'] }}" 
                            style="width:40px; height:40px;">
                            
                        <div style="flex:1;">
                            <div style="display:flex; justify-content:space-between;">
                                <span>{{ $item['label'] }}</span>
                                <span>{{ $persen }}%</span>
                            </div>

                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" 
                                    style="width: {{ $persen }}%; background-color: {{ $item['color'] }};">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </a>

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
            .admin-action-card {
                transition: .25s ease-in-out;
            }

            .admin-action-card:hover {
                background: #f5f5f5; /* abu muda */
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            }
            </style>

<div class="konseling-action-card">
    <h3>Tindakan Konseling</h3>

    <a href="{{ route('admin.konseling.index') }}" 
       class="notification-item fancy-notif">

        <i class="fas fa-bell"></i>

        <span>
            Jadwal Konseling Menunggu<br>
            {{ $konselingMenunggu }} Permintaan Masuk
        </span>

    </a>
</div>

<!-- === KETERLAMBATAN (DIBUAT SAMA STYLING SEPERTI KONSELING) === -->

<div class="konseling-action-card" style="margin-top:20px;">
    <h3>Pengajuan Keterlambatan</h3>

    <a href="{{ route('admin.keterlambatan.index') }}" 
       class="notification-item fancy-notif fancy-late">

        <i class="fas fa-clock"></i>

        <span>
            @if($keterlambatanBaru > 0)
                <strong>{{ $keterlambatanBaru }} Pengajuan Baru</strong><br>
                Menunggu tindakan admin
            @else
                <strong>Tidak ada pengajuan baru</strong>
            @endif
        </span>

    </a>
</div>

<style>
/* === BASE STYLE KONSELING (tetap kuning) === */
.fancy-notif {
    display: flex;
    align-items: center;
    gap: 12px;

    background: #fff7d6; /* kuning */
    border: 1px solid #ffdd85;
    padding: 15px 18px;
    border-radius: 12px;

    text-decoration: none;
    color: #5a4600;

    transition: all .25s ease-in-out;
    animation: notif-shake 1.2s ease infinite;
}

.fancy-notif i {
    font-size: 24px;
}

/* === KETERLAMBATAN (warna dibuat PINK) === */
.fancy-late {
    background: #ffe4ec !important;       /* pink lembut */
    border: 1px solid #ffb5c8 !important; /* border pink */
    color: #7a3242 !important;            /* teks pink tua */
}

.fancy-late i {
    color: #ff6b8b !important; /* ikon pink */
}

/* Hover effect */
.fancy-notif:hover,
.fancy-late:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

/* Hover khusus keterlambatan */
.fancy-late:hover {
    background: #ffd3df !important;
}

/* Animasi getar */
@keyframes notif-shake {
    0% { transform: translateX(0); }
    20% { transform: translateX(-2px); }
    40% { transform: translateX(2px); }
    60% { transform: translateX(-2px); }
    80% { transform: translateX(2px); }
    100% { transform: translateX(0); }
}

/* === Judul Card jadi HITAM === */
.konseling-action-card h3 {
    margin-bottom: 12px;
    font-size: 18px;
    font-weight: 700;
    color: #000; /* warna hitam */
}

</style>


<style>
    .filter-dropdown {
    background: #f8f9fa;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    border-radius: 12px !important; /* biar lebih lembut */
    transition: .2s;
    width: 100px; /* kecil seperti awal */
}

.filter-dropdown:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.filter-dropdown:focus {
    outline: none;
    box-shadow: 0 0 6px rgba(0,123,255,0.4);
}

</style>


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

         // Event listener untuk filter tahun
    document.getElementById('filterTahun').addEventListener('change', function() {
        let selected = this.value;
        window.location.href = `?angkatan=${selected}`;
    });
    </script>
@endsection
