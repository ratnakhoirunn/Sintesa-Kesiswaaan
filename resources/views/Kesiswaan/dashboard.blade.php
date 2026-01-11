@extends('layouts.admin')

@section('title', 'Dashboard Kesiswaan')
@section('page_title', 'Dashboard Kesiswaan')

@section('content')

{{-- Import Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --primary: #123B6B;
        --secondary: #64748b;
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --radius: 12px;
    }

    body { font-family: 'Poppins', sans-serif; background-color: var(--bg-body); }

    /* ===== WELCOME CARD ===== */
    .welcome-card {
        background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%);
        padding: 35px 40px; border-radius: var(--radius); color: white;
        margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: var(--shadow);
    }
    .welcome-card::before { content: ''; position: absolute; top: -60px; right: -60px; width: 250px; height: 250px; background: rgba(255,255,255,0.1); border-radius: 50%; }
    .welcome-content h1 { margin: 0; font-size: 24px; font-weight: 700; }
    .welcome-content p { margin: 5px 0 0; opacity: 0.9; font-size: 14px; font-weight: 300; }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px; margin-bottom: 30px;
    }

    .stat-card {
        background: var(--card-bg); padding: 25px; border-radius: var(--radius);
        box-shadow: var(--shadow); display: flex; flex-direction: column; justify-content: space-between;
        border-left: 4px solid transparent; transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }

    .border-blue { border-left-color: #3b82f6; }
    .border-orange { border-left-color: #f97316; }
    .border-green { border-left-color: #10b981; }

    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
    .stat-icon {
        width: 50px; height: 50px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; background: #f1f5f9; color: var(--primary);
    }
    .stat-value h3 { margin: 0; font-size: 28px; font-weight: 700; color: #1e293b; }
    .stat-label { font-size: 13px; color: var(--secondary); font-weight: 500; text-transform: uppercase; }

    /* Progress Bar Dokumen */
    .progress-wrapper { margin-top: 15px; }
    .progress-info { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 5px; font-weight: 600; }
    .progress-bg { width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 3px; transition: width 1s ease-in-out; }

    /* ===== MAIN CONTENT GRID ===== */
    .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
    
    .chart-card {
        background: var(--card-bg); padding: 25px; border-radius: var(--radius);
        box-shadow: var(--shadow); margin-bottom: 25px;
    }
    .card-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;
    }
    .card-title { font-size: 16px; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 8px; }

    /* Notifikasi Style */
    .notif-list { display: flex; flex-direction: column; gap: 10px; }
    .notif-item {
        display: flex; align-items: center; gap: 15px; padding: 12px;
        border-radius: 10px; background: #fff; border: 1px solid #f1f5f9;
        transition: 0.2s; text-decoration: none; color: inherit;
    }
    .notif-item:hover { background: #f8fafc; border-color: #e2e8f0; transform: translateX(3px); }
    .notif-icon {
        width: 40px; height: 40px; border-radius: 10px; background: #fee2e2; color: #dc2626;
        display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
    }
    .notif-info h6 { margin: 0; font-size: 13px; font-weight: 600; color: #334155; }
    .notif-info span { font-size: 11px; color: #94a3b8; }

    /* Dropdown Filter */
    .filter-select {
        padding: 6px 12px; border-radius: 8px; border: 1px solid #e2e8f0;
        font-size: 12px; color: #333; outline: none; cursor: pointer; background: #f8fafc; font-weight: 500;
    }
    .filter-select:hover { border-color: #3b82f6; }

    /* Responsive */
    @media (max-width: 992px) { .main-grid { grid-template-columns: 1fr; } }
</style>

{{-- 1. WELCOME --}}
<div class="welcome-card">
    <div class="welcome-content">
        <h1>Dashboard Kesiswaan</h1>
        <p>Panel Monitoring Data Siswa, Pelanggaran, dan Prestasi SMKN 2 Yogyakarta</p>
    </div>
</div>

{{-- 2. STATISTIK UTAMA --}}
<div class="stats-grid">
    {{-- Total Siswa --}}
    <div class="stat-card border-blue">
        <div class="stat-header">
            <div class="stat-value">
                <span class="stat-label">Total Siswa</span>
                <h3>{{ $totalSiswa }}</h3>
            </div>
            <div class="stat-icon" style="background:#eff6ff; color:#3b82f6;"><i class="fas fa-users"></i></div>
        </div>
    </div>

    {{-- Total Keterlambatan --}}
    <div class="stat-card border-orange">
        <div class="stat-header">
            <div class="stat-value">
                <span class="stat-label">Total Pelanggaran</span>
                <h3>{{ $totalKeterlambatan }}</h3>
            </div>
            <div class="stat-icon" style="background:#fff7ed; color:#f97316;"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
    </div>

    {{-- Dokumen Siswa Progress --}}
    <div class="stat-card border-green">
        <div class="stat-header">
            <div class="stat-value">
                <span class="stat-label">Upload Dokumen</span>
                <h3>{{ $sudahUpload }} <small style="font-size:14px; color:#94a3b8; font-weight:400;">/ {{ $totalSiswa }}</small></h3>
            </div>
            <div class="stat-icon" style="background:#f0fdf4; color:#10b981;"><i class="fas fa-file-alt"></i></div>
        </div>
        <div class="progress-wrapper">
            <div class="progress-info">
                <span style="color:#10b981;">{{ $persenSudah }}% Selesai</span>
                <span style="color:#ef4444;">{{ $belumUpload }} Belum</span>
            </div>
            <div class="progress-bg">
                <div class="progress-fill" style="width: {{ $persenSudah }}%; background-color:#10b981;"></div>
            </div>
        </div>
    </div>
</div>

{{-- 3. CONTENT GRID (Charts & Notif) --}}
<div class="main-grid">
    
    {{-- KOLOM KIRI: GRAFIK --}}
    <div class="left-column">
        
        {{-- A. GRAFIK JURUSAN (HORIZONTAL + FILTER JS) --}}
        <div class="chart-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-chart-bar"></i> Siswa Per Jurusan</div>
                {{-- Dropdown Filter Angkatan (JS Only) --}}
                <select id="filterAngkatan" class="filter-select">
                    <option value="all">Semua Angkatan</option>
                    @foreach($listAngkatan as $thn)
                        <option value="{{ $thn }}">Angkatan {{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div style="position: relative; height: 320px;">
                <canvas id="chartJurusanHorizontal"></canvas>
            </div>
        </div>

        {{-- B. GRAFIK PRESTASI (FILTER SERVER-SIDE) --}}
        <div class="chart-card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-trophy"></i> Tren Prestasi</div>
                
                {{-- Form Filter Tahun (Reload Page) --}}
                <form action="{{ url()->current() }}" method="GET">
                    @foreach(request()->except(['year_prestasi']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <select name="year_prestasi" onchange="this.form.submit()" class="filter-select" style="background:#fffbeb; border-color:#fcd34d; color:#b45309;">
                        @foreach($listTahunPrestasi as $thn)
                            <option value="{{ $thn }}" {{ $tahunPilihan == $thn ? 'selected' : '' }}>Tahun {{ $thn }}</option>
                        @endforeach
                        @if($listTahunPrestasi->isEmpty())
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        @endif
                    </select>
                </form>
            </div>

            <div style="position: relative; height: 250px;">
                <canvas id="chartPrestasi"></canvas>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: NOTIFIKASI --}}
    <div class="right-column">
        <div class="chart-card" style="height: 100%;">
            <div class="card-header">
                <div class="card-title" style="color:#dc2626;"><i class="fas fa-bell"></i> Keterlambatan Terbaru</div>
                <a href="{{ route('admin.keterlambatan.index') }}" style="font-size:12px; text-decoration:none; color:#64748b;">Lihat Semua</a>
            </div>

            <div class="notif-list">
                @forelse($keterlambatanTerbaru as $t)
                    <a href="{{ route('admin.keterlambatan.index') }}" class="notif-item">
                        <div class="notif-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="notif-info">
                            <h6>{{ $t->siswa->nama_lengkap ?? 'Siswa' }}</h6>
                            <span>{{ $t->created_at->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                    </a>
                @empty
                    <div style="text-align:center; padding:30px; color:#94a3b8;">
                        <i class="fas fa-check-circle" style="font-size:24px; margin-bottom:10px;"></i><br>
                        Tidak ada data terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- SCRIPT CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // ============================================
    // 1. HORIZONTAL BAR CHART (JURUSAN + FILTER)
    // ============================================
    const rawDataJurusan = {!! json_encode($dataJurusan) !!};
    const ctxJurusan = document.getElementById('chartJurusanHorizontal').getContext('2d');
    
    // Gradient Warna Admin (Biru Mewah)
    let gradAdmin = ctxJurusan.createLinearGradient(0, 0, 400, 0);
    gradAdmin.addColorStop(0, '#0F2854'); // Biru Gelap
    gradAdmin.addColorStop(1, '#3b82f6'); // Biru Terang

    let chartJurusan;

    function renderJurusanChart(filteredData) {
        let grouped = {};
        filteredData.forEach(item => {
            if (!grouped[item.jurusan]) grouped[item.jurusan] = 0;
            grouped[item.jurusan] += parseInt(item.total);
        });

        // Convert, Sort, Map
        let chartArray = Object.keys(grouped).map(key => ({ jurusan: key, total: grouped[key] }));
        chartArray.sort((a, b) => b.total - a.total); // Sort Descending

        const labels = chartArray.map(i => i.jurusan);
        const values = chartArray.map(i => i.total);

        if (chartJurusan) chartJurusan.destroy();

        chartJurusan = new Chart(ctxJurusan, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: values,
                    
                    // === GANTI BAGIAN WARNA DI SINI ===
                    backgroundColor: 'rgba(30, 58, 138, 0.25)', // Warna isi (Biru muda transparan)
                    borderColor: '#1e3a8a',       // Warna garis tepi (Biru Tua)
                    borderWidth: 2,               // Ketebalan garis tepi
                    borderRadius: 5,              // Lengkungan sudut
                    borderSkipped: false,         // Agar semua sudut melengkung (opsional)
                    // ==================================
                    
                    barThickness: 25
                }]
            },
            options: {
                indexAxis: 'y', // Pastikan ini 'y' agar horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e3a8a',
                        titleFont: { size: 13 },
                        bodyFont: { size: 13 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false // Hilangkan kotak warna di tooltip biar rapi
                    }
                },
                scales: {
                    x: { 
                        beginAtZero: true, 
                        grid: { color: '#e2e8f0' } // Warna grid tipis
                    },
                    y: { 
                        grid: { display: false },
                        ticks: { font: { weight: '600', family: 'Poppins' }, color: '#334155' } 
                    }
                }
            }
        });
    }

    // Init Chart & Listener
    renderJurusanChart(rawDataJurusan);
    document.getElementById('filterAngkatan').addEventListener('change', function() {
        const val = this.value;
        const filtered = (val === 'all') ? rawDataJurusan : rawDataJurusan.filter(i => i.angkatan == val);
        renderJurusanChart(filtered);
    });


    // ============================================
    // 2. LINE CHART (PRESTASI) - Gradient Emas
    // ============================================
    const ctxPrestasi = document.getElementById('chartPrestasi').getContext('2d');
    
    let gradGold = ctxPrestasi.createLinearGradient(0, 0, 0, 300);
    gradGold.addColorStop(0, 'rgba(234, 179, 8, 0.2)');
    gradGold.addColorStop(1, 'rgba(234, 179, 8, 0)');

    new Chart(ctxPrestasi, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Prestasi',
                data: {!! json_encode($prestasiData) !!},
                borderColor: '#eab308',
                backgroundColor: gradGold,
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#eab308',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

});
</script>

@endsection