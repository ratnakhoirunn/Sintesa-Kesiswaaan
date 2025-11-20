@extends('layouts.admin')

@section('title', 'Dashboard BK')
@section('page_title', 'Dashboard Guru BK')

@section('content')

<style>

.info-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.info-card .content p {
    margin: 0;
    font-size: 13px;
    color: #666;
}
.info-card .content h3 {
    margin: 5px 0 0;
    font-size: 24px;
    font-weight: bold;
    color:#123B6B;
}

.info-card .icon i {
    font-size: 28px;
    color: #123B6B;
}

/* ===== RECENT ACTIVITY ===== */
.recent-activity {
    background: white;
    padding: 18px;
    border-radius: 12px;
    margin-top: 35px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.recent-activity h4 {
    margin-bottom: 15px;
    font-size: 17px;
    font-weight: 600;
    color: #123B6B;
}

.recent-activity ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-activity li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    font-size: 13px;
}
.recent-activity li:last-child {
    border-bottom: none;
}

/* ===== CHART ===== */
.chart-container {
    background: white;
    margin-top: 35px;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

{{-- NOTIFIKASI BARU --}}
@if($konselingBaru > 0)
<div class="alert alert-info" style="font-size:14px;">
    🔔 Ada <strong>{{ $konselingBaru }}</strong> pengajuan konseling baru hari ini.
</div>
@endif


{{-- WELCOME CARD --}}
<div class="welcome-card">
    <h1>Selamat Datang, Guru BK</h1>
    <p>Kelola pengajuan konseling siswa di dashboard ini</p>
</div>


{{-- INFO CARDS --}}
<div class="info-cards">

    <div class="info-card">
        <div class="content">
            <p>Pengajuan Menunggu</p>
            <h3>{{ $konselingMenunggu }}</h3>
        </div>
        <div class="icon">
            <i class="fas fa-bell"></i>
        </div>
    </div>

    <div class="info-card">
        <div class="content">
            <p>Diproses</p>
            <h3>{{ $konselingProses }}</h3>
        </div>
        <div class="icon">
            <i class="fas fa-spinner"></i>
        </div>
    </div>

    <div class="info-card">
        <div class="content">
            <p>Selesai</p>
            <h3>{{ $konselingSelesai }}</h3>
        </div>
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>

</div>


{{-- GRAFIK --}}
<div class="chart-container">
    <h4 style="color:#123B6B; margin-bottom:10px;">Statistik Pengajuan Konseling Per Bulan</h4>
    <canvas id="chartKonseling"></canvas>
</div>


{{-- RECENT ACTIVITY --}}
<div class="recent-activity">
    <h4>Pengajuan Konseling Terbaru</h4>

    <ul>
        @forelse($recent as $r)
        <li>
            <strong>{{ $r->nama_siswa }}</strong> – {{ ucfirst($r->status) }}
            <span style="float:right; color:#777; font-size:12px;">
                {{ $r->created_at->format('d M Y') }}
            </span>
        </li>
        @empty
        <li>Tidak ada data terbaru.</li>
        @endforelse
    </ul>
</div>


{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartKonseling');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($bulan),  // array bulan
        datasets: [{
            label: 'Pengajuan',
            data: @json($jumlah),
            borderWidth: 2,
            tension: 0.4
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

@endsection