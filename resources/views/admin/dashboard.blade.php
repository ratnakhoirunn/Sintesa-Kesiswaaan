@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')

{{-- LOAD FONT AWESOME --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

{{-- ====================== STYLE CSS ====================== --}}
<style>
    /* 1. WELCOME CARD */
    .welcome-card {
        background: linear-gradient(135deg, #123B6B 0%, #0D2B4E 100%);
        color: white; padding: 25px; border-radius: 12px; margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(18, 59, 107, 0.2);
    }
    .welcome-card h1 { font-size: 24px; font-weight: bold; margin: 0 0 5px 0; color: white; }
    .welcome-card p { margin: 0; color: #dcebfb; font-size: 14px; }

    /* 2. STATISTIK CARDS */
    .info-cards {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 25px;
    }
    .info-card {
        background: white; padding: 20px; border-radius: 12px;
        display: flex; justify-content: space-between; align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;
    }
    .info-card h3 { font-size: 26px; font-weight: bold; margin: 5px 0 0 0; color: #333; }
    .info-card p { margin: 0; color: #777; font-size: 13px; }
    .info-card .icon img { width: 50px; height: 50px; object-fit: contain; }

    /* 3. CHART GRID */
    .charts-wrapper {
        display: grid; 
        grid-template-columns: 2fr 1fr; /* Kiri 66%, Kanan 33% */
        gap: 25px; 
        margin-bottom: 25px;
        align-items: start;
    }
    @media (max-width: 992px) { .charts-wrapper { grid-template-columns: 1fr; } }

    .chart-card {
        background: white; padding: 20px; border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;
    }
    .chart-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;
    }
    .chart-header h3 { margin: 0; font-size: 16px; font-weight: 700; color: #1a1a1a; }
    
    /* Container Chart */
    /* Bar chart tingginya bisa kita buat sedikit lebih tinggi agar jurusan banyak muat */
    .chart-container { position: relative; height: 350px; width: 100%; }
    .chart-container-pie { position: relative; height: 220px; width: 100%; display: flex; justify-content: center; }

    /* 4. NOTIFICATION GRID */
    .bottom-actions {
        display: grid; 
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    @media (max-width: 1200px) { .bottom-actions { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .bottom-actions { grid-template-columns: 1fr; } }

    .action-card {
        background: white; padding: 20px; border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;
        display: flex; flex-direction: column; justify-content: center;
    }
    .action-card h3 { margin-bottom: 15px; font-size: 15px; font-weight: 700; color: #1a1a1a; }

    /* === FANCY NOTIF STYLE === */
    .fancy-notif {
        position: relative; display: flex; align-items: center; gap: 15px;
        padding: 12px 15px; border-radius: 10px; background: #ffffff;
        text-decoration: none; overflow: hidden; transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02); border: 1px solid #f3f3f3;
    }
    .fancy-notif span { flex: 1; font-size: 12px; color: #64748b; line-height: 1.3; }
    .fancy-notif span strong { display: block; font-size: 15px; margin-bottom: 2px; color: #1e293b; font-weight: 800; }
    .fancy-notif i { font-size: 22px; transition: transform 0.3s ease; flex-shrink: 0; }
    
    .fancy-notif:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .fancy-notif:hover i { transform: scale(1.1) rotate(-5deg); }

    /* Theme Colors */
    .fancy-notif.default { border-left: 4px solid #f59e0b; background: linear-gradient(to right, #fffbeb, #fff); } 
    .fancy-notif.default i { color: #f59e0b; }
    
    .fancy-late { border-left: 4px solid #ec4899 !important; background: linear-gradient(to right, #fce7f3, #fff) !important; } 
    .fancy-late i { color: #ec4899 !important; }

    .fancy-prestasi { border-left: 4px solid #d97706 !important; background: linear-gradient(to right, #fff8dc, #fff) !important; } 
    .fancy-prestasi i { color: #d97706 !important; }

    .fancy-dokumen { border-left: 4px solid #ef4444 !important; background: linear-gradient(to right, #fef2f2, #fff) !important; } 
    .fancy-dokumen i { color: #ef4444 !important; }

    .filter-dropdown { background: #f8f9fa; border: 1px solid #ddd; border-radius: 6px; padding: 4px 8px; font-size: 12px; cursor: pointer; }
</style>

{{-- ====================== KONTEN DASHBOARD ====================== --}}
<div class="dashboard-content">

    {{-- 1. WELCOME CARD --}}
    <div class="welcome-card">
        <h1>Selamat Datang, {{ ucfirst(str_replace('_', ' ', auth('guru')->user()->role)) }}</h1>
        <p>Kelola Data Siswa SMKN 2 Yogyakarta</p>
    </div>

    {{-- 2. STATISTIK UTAMA --}}
    <div class="info-cards">
        <div class="info-card">
            <div class="content">
                <p>Total Siswa Aktif</p>
                <h3>{{ $totalSiswa }}</h3>
            </div>
            <div class="icon"><img src="{{ asset('images/toga1.png') }}" alt="Total Siswa"></div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Total Admin</p>
                <h3>{{ $totalAdmin }}</h3>
            </div>
            <div class="icon"><img src="{{ asset('images/totaladmin.png') }}" alt="Total Admin"></div>
        </div>
        <div class="info-card">
            <div class="content">
                <p>Kunjungan Konseling</p>
                <h3>{{ $totalKonseling }}</h3>
            </div>
            <div class="icon"><img src="{{ asset('images/totalkonsel.png') }}" alt="Jumlah Konseling"></div>
        </div>
    </div>

    {{-- 3. AREA GRAFIK --}}
    <div class="charts-wrapper">
        
        {{-- GRAFIK KIRI: HORIZONTAL BAR CHART --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3>Grafik Siswa Per Jurusan</h3>
                <select id="filterTahun" class="filter-dropdown" onchange="updateFilter('angkatan', this.value)">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatanList as $angkatan)
                        <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>
                            Angkatan {{ $angkatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="chart-container">
                <canvas id="siswaPerJurusanChart"></canvas>
            </div>
        </div>

        {{-- GRAFIK KANAN: PIE CHART --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3>Statistik Jenis Prestasi</h3>
                <select id="filterTahunPrestasi" class="filter-dropdown" onchange="updateFilter('tahun_prestasi', this.value)">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunPrestasiList as $tahunP)
                        <option value="{{ $tahunP }}" {{ request('tahun_prestasi') == $tahunP ? 'selected' : '' }}>
                            Tahun {{ $tahunP }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="chart-container-pie">
                <canvas id="prestasiPieChart"></canvas>
            </div>
        </div>
    </div>

    {{-- 4. AREA NOTIFIKASI --}}
    <div class="bottom-actions">
        
        {{-- Card 1: Dokumen Siswa --}}
        <div class="action-card">
            <h3>Dokumen Siswa</h3>
            <a href="{{ route('admin.dokumensiswa.index') }}" class="fancy-notif fancy-dokumen">
                <i class="fas fa-file-contract"></i>
                <span>
                    @php
                        $belumUpload = $belumUpload ?? 0;
                        $persenBelum = $persenBelum ?? 0;
                    @endphp
                    <strong>{{ $belumUpload }} Siswa ({{ $persenBelum }}%)</strong>
                    Belum Upload Dokumen
                </span>
            </a>
        </div>

        {{-- Card 2: Konseling --}}
        <div class="action-card">
            <h3>Tindakan Konseling</h3>
            <a href="{{ route('admin.konseling.index') }}" class="fancy-notif default">
                <i class="fas fa-bell"></i>
                <span>
                    <strong>{{ $konselingMenunggu ?? 0 }} Permintaan</strong>
                    Menunggu Jadwal
                </span>
            </a>
        </div>

        {{-- Card 3: Keterlambatan --}}
        <div class="action-card">
            <h3>Pengajuan Keterlambatan</h3>
            <a href="{{ route('admin.keterlambatan.index') }}" class="fancy-notif fancy-late">
                <i class="fas fa-clock"></i>
                <span>
                    @if(($keterlambatanBaru ?? 0) > 0)
                        <strong>{{ $keterlambatanBaru }} Pengajuan</strong>
                        Menunggu Admin
                    @else
                        <strong>Aman</strong>
                        Tidak ada pengajuan
                    @endif
                </span>
            </a>
        </div>

        {{-- Card 4: Prestasi --}}
        <div class="action-card">
            <h3>Data Prestasi</h3>
            <a href="{{ route('admin.prestasi.index') }}" class="fancy-notif fancy-prestasi">
                <i class="fas fa-trophy"></i>
                <span>
                    <strong>{{ $totalPrestasi ?? 0 }} Data</strong>
                    Prestasi Tercatat
                </span>
            </a>
        </div>

    </div>
</div>

{{-- ====================== SCRIPT ====================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. HORIZONTAL BAR CHART (JURUSAN) ---
    const ctxBar = document.getElementById('siswaPerJurusanChart');
    if (ctxBar) {
        // A. PROSES DATA (Sorting Descending)
        // Kita ambil data dari PHP, lalu sort di JS agar yang terbanyak ada di paling atas
        let rawData = {!! json_encode($chartData) !!};
        
        // Sort: Dari total terbesar ke terkecil
        rawData.sort((a, b) => b.total - a.total);

        // Pisahkan kembali ke array label & data
        const labels = rawData.map(item => item.jurusan);
        const totals = rawData.map(item => item.total);

        // B. BUAT GRADIENT (KIRI ke KANAN karena Horizontal)
        const gradient = ctxBar.getContext('2d').createLinearGradient(0, 0, 300, 0); 
        gradient.addColorStop(0, 'rgba(18, 59, 107, 0.9)'); // Gelap di Kiri (Pangkal)
        gradient.addColorStop(1, 'rgba(18, 59, 107, 0.2)'); // Transparan di Kanan (Ujung)

        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    axis: 'y', // PENTING: Ini yang membuat jadi Horizontal
                    label: 'Jumlah Siswa',
                    data: totals,
                    backgroundColor: gradient,
                    borderColor: '#123B6B',
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 20, // Agak tipis agar muat banyak jika jurusan bertambah
                }]
            },
            options: {
                indexAxis: 'y', // Mengubah Orientasi ke Horizontal
                responsive: true,
                maintainAspectRatio: false, 
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            // Tooltip jelas menampilkan nama lengkap jurusan
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    x: { 
                        beginAtZero: true, 
                        grid: { borderDash: [2, 4] },
                        ticks: { font: { size: 10 } }
                    },
                    y: { 
                        grid: { display: false }, 
                        ticks: { 
                            autoSkip: false, // Tampilkan SEMUA nama jurusan jangan ada yang di-skip
                            font: { size: 11, weight: '600' } // Font sedikit dipertegas
                        } 
                    }
                }
            }
        });
    }

    // --- 2. PIE CHART ---
    const ctxPie = document.getElementById('prestasiPieChart');
    if (ctxPie) {
        new Chart(ctxPie, {
            type: 'doughnut', 
            data: {
                labels: ['Lomba', 'Seminar', 'Sertifikat', 'Lainnya'],
                datasets: [{
                    data: [
                        {{ $chartPrestasi['Lomba'] }}, 
                        {{ $chartPrestasi['Seminar'] }}, 
                        {{ $chartPrestasi['Sertifikat'] }},
                        {{ $chartPrestasi['Lainnya'] }}
                    ],
                    backgroundColor: ['#123B6B', '#547792', '#94B4C1', '#E2E6EA'],
                    borderWidth: 0,
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, 
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { usePointStyle: true, boxWidth: 8, font: { size: 10 } }
                    }
                }
            }
        });
    }

    // --- 3. FILTER ---
    function updateFilter(key, value) {
        let currentUrl = new URL(window.location.href);
        let params = new URLSearchParams(currentUrl.search);
        if (value) { params.set(key, value); } else { params.delete(key); }
        window.location.href = currentUrl.pathname + '?' + params.toString();
    }
</script>
@endsection