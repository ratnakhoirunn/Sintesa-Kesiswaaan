@extends('layouts.admin')

@section('title', 'Dashboard Kesiswaan')
@section('page_title', 'Dashboard Kesiswaan')

@section('content')

<div class="welcome-card">
    <h1>Selamat Datang, Kesiswaan</h1>
    <p>Panel Informasi Kesiswaan SMKN 2 Yogyakarta</p>
</div>

{{-- Blok PHP: Semua perhitungan harus di sini --}}
@php
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// 1. Pastikan Carbon menggunakan locale Bahasa Indonesia
Carbon::setLocale('id');

// --- LOGIKA PERHITUNGAN DOKUMEN ---
try {
    // Total siswa berdasarkan NIS
    $totalSiswaDok = DB::table('siswas')->count('nis'); 

    // Jumlah siswa yang sudah upload dokumen (distinct nis)
    $sudahUpload = 0;
    if (DB::getSchemaBuilder()->hasTable('dokumen_siswas')) {
        $sudahUpload = DB::table('dokumen_siswas')->distinct()->count('nis');
    } elseif (DB::getSchemaBuilder()->hasTable('dokumen_siswa')) {
        $sudahUpload = DB::table('dokumen_siswa')->distinct()->count('nis');
    }

    // Hitung siswa yang belum upload
    $belumUpload = max(0, $totalSiswaDok - $sudahUpload);

    // Mencegah division by zero
    $persenBelum = $totalSiswaDok > 0 ? number_format(($belumUpload / $totalSiswaDok) * 100, 1) : 0;
    $persenSudah = 100 - $persenBelum; // Persentase yang sudah diunggah
} catch (\Throwable $e) {
    // fallback aman
    $totalSiswaDok = 0;
    $sudahUpload = 0;
    $belumUpload = 0;
    $persenBelum = 0;
    $persenSudah = 0;
}
// --- AKHIR LOGIKA PERHITUNGAN DOKUMEN ---

// --- LOGIKA DATE/FOOTER (Disimpan untuk kelengkapan file) ---
$bulanFooter = request('bulan');
if (!empty($bulanFooter)) {
    try {
        $date = Carbon::parse($bulanFooter);
        $bulanIndonesia = $date->translatedFormat('M');
    } catch (\Exception $e) {
        $bulanIndonesia = $bulanFooter; 
    }
} else {
    $bulanIndonesia = Carbon::now()->translatedFormat('M'); 
}
$tahunFooter = request('tahun') ?? date('Y');
// --- AKHIR LOGIKA DATE/FOOTER ---
@endphp

<div class="info-cards">
    
    {{-- Total Siswa Card (Tetap) --}}
    <div class="info-card">
        <div class="content">
            <p>Total Siswa</p>
            <h3>{{ $totalSiswa }}</h3>
        </div>
        <div class="icon">
           <img src="{{ asset('images/toga1.png') }}" alt="Total Siswa">
        </div>
    </div>

    {{-- Total Keterlambatan Card (Tetap) --}}
    <div class="info-card">
        <div class="content">
            <p>Total Keterlambatan</p>
            <h3>{{ $totalKeterlambatan }}</h3>
        </div>
        <div class="icon">
            <img src="{{ asset('images/time.png') }}">
        </div>
    </div>

    {{-- KARTU DOKUMEN SISWA BARU (Sesuai dengan permintaan) --}}
    <a href="{{ route('admin.dokumensiswa.index') }}" 
        style="text-decoration:none; color:inherit; display:block; flex: 1; min-width: 250px;">

        {{-- Dokumen Siswa menggunakan info-card standar + progress bar di bawah --}}
        <div class="info-card dokumen-progress-card" style="cursor:pointer; transition:.25s;"> 
            
            <div class="content">
                <p>Dokumen Siswa</p> 
                {{-- Angka besar: Siswa yang sudah upload / Total Siswa --}}
                <h3>{{ $sudahUpload }} / {{ $totalSiswaDok }}</h3> 
            </div>

            <div class="icon">
                {{-- Ikon Dokumen --}}
                <img src="{{ asset('images/document.jfif') }}" alt="Dokumen Siswa"> 
            </div>

            {{-- Progress Bar Belum Diunggah --}}
            <div style="margin-top: 15px; width: 100%;">
                <div style="display:flex; justify-content:space-between; font-size: 12px; margin-bottom: 4px;">
                    <span style="font-weight: 600; color: #dc3545;">Belum Diunggah</span>
                    <span style="color: #dc3545;">{{ $belumUpload }} Siswa ({{ $persenBelum }}%)</span> 
                </div>

                <div class="progress-bar-container" style="background:#e9ecef; height:6px; border-radius:3px; overflow:hidden;">
                    {{-- Fill menunjukkan persentase yang sudah upload (100 - Belum) --}}
                    <div class="progress-bar-fill" style="width: {{ $persenSudah }}%; background-color:#28a745; height:100%;"></div>
                </div>
            </div>
            
        </div>
    </a>
    {{-- AKHIR KARTU DOKUMEN SISWA BARU --}}
</div>

{{-- ====================== ROW: Grafik + Notifikasi ====================== --}}
<div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
    {{-- (Sisa kode grafik dan notifikasi tetap sama) --}}

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
                onmouseover="this.style.background='#f7f9ff';"
                onmouseout="this.style.background='transparent';"
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
                            Terlambat: {{ $t->created_at->translatedformat('d M Y, H:i') }}
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
 
<style>
/* Style tambahan untuk progress card, jika diperlukan */
.dokumen-progress-card {
    /* Menambahkan display flex dan flex-wrap agar progress bar ada di bawah content/icon */
    display: flex;
    flex-wrap: wrap; 
    align-items: flex-start;
    justify-content: space-between;
}
.dokumen-progress-card .content {
    /* Pastikan content (judul dan angka) mengambil ruang yang cukup */
    flex: 1;
}
.dokumen-progress-card .icon {
    /* Pastikan ikon tetap di kanan atas */
    flex-shrink: 0;
}
.progress-bar-container {
    /* Pastikan progress bar mengambil lebar penuh */
    width: 100%;
}

.dokumen-progress-card:hover {
    background: #f5f5f5; /* abu muda */
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
</style>

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