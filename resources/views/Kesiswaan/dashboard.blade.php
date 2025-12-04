@extends('layouts.admin')

@section('title', 'Dashboard Kesiswaan')
@section('page_title', 'Dashboard Kesiswaan')

@section('content')

<div class="welcome-card">
    <h1>Selamat Datang, Kesiswaan</h1>
    <p>Panel Informasi Kesiswaan SMKN 2 Yogyakarta</p>
</div>

<div class="info-cards">

    <div class="info-card">
        <div class="content">
            <p>Total Siswa</p>
            <h3>{{ $totalSiswa }}</h3>
        </div>
        <div class="icon">
           <img src="{{ asset('images/toga1.png') }}" alt="Total Siswa">
        </div>
    </div>

    <div class="info-card">
        <div class="content">
            <p>Total Keterlambatan</p>
            <h3>{{ $totalKeterlambatan }}</h3>
        </div>
        <div class="icon">
            <img src="{{ asset('images/time.png') }}">
        </div>
    </div>

    <div class="info-card">
        <div class="content">
            <p>Dokumen Siswa</p>
            <h3>{{ $totalDokumen }}</h3>
        </div>
        <div class="icon">
            <img src="{{ asset('images/document.jfif') }}">
        </div>
    </div>

    

</div>

{{-- ====================== ROW: Grafik + Notifikasi ====================== --}}
<div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">

    {{-- ========== Grafik (Kecil, Tidak Merusak Warna) ========== --}}
    <div style="
        flex: 1;
        min-width: 450px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    ">
        <h3 style="margin-bottom: 10px;">Grafik Siswa Per Jurusan</h3>
        <canvas id="chartJurusan" style="height: 220px !important;"></canvas>
    </div>

  {{-- ========== Notifikasi Keterlambatan (Kanan) ========== --}}
<div style="
    width: 330px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    flex-shrink: 0;
    height: fit-content;
">
    <h3 style="margin-bottom: 15px;">Notifikasi Keterlambatan</h3>

    @forelse($keterlambatanTerbaru as $t)
        <a href="{{ route('admin.keterlambatan.index') }}" style="
            text-decoration: none;
            color: inherit;
        ">
            <div style="
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px dashed #e0e0e0;
                transition: background 0.15s, transform 0.15s;
            "
            onmouseover="this.style.background='#f7f9ff'; this.style.transform='translateX(4px)';"
            onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)';"
            >
                <div style="
                    width: 38px;
                    height: 38px;
                    background: #1e3a8a11;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                    <i class="fas fa-clock" style="font-size: 20px; color: #1e3a8a;"></i>
                </div>

                <div>
                    <strong style="font-size: 14px;">{{ $t->siswa->nama_lengkap }}</strong><br>
                    <span style="font-size: 12px; color:#777;">
                        Terlambat: {{ $t->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
        </a>
    @empty
        <p style="color:#999;">Belum ada keterlambatan terbaru.</p>
    @endforelse

    <div style="text-align:center; margin-top: 10px;">
        <a href="{{ route('admin.keterlambatan.index') }}" style="
            font-size: 13px;
            color: #1e3a8a;
            text-decoration: none;
        ">Lihat Semua</a>
    </div>
</div>

</div>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartJurusan');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikJurusan->pluck('jurusan')) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode($grafikJurusan->pluck('total')) !!},
                borderWidth: 1
            }]
        }
    });
</script>

@endsection
