@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')

@php
use App\Models\DokumenSiswa;
@endphp

<style>
    body {
        background-color: #f5f7fa;
    }

    /* ====== Header Biru Sambutan ====== */
    .welcome-card {
        background-color: #17375d;
        color: #fff;
        border-radius: 10px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .welcome-card h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .welcome-card p {
        margin-top: 6px;
        font-size: 14px;
        opacity: 0.9;
    }

    /* ====== Grid Kartu ====== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
    }

    /* ====== Card Style dengan header biru ====== */
    .card-box {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .card-box:hover {
        transform: translateY(-3px);
    }

    .card-header {
        background-color: #17375d;
        color: white;
        font-weight: 600;
        font-size: 15px;
        padding: 10px 15px;
        text-align: left;
    }

    .card-content {
        padding: 15px;
        text-align: center;
        background: #fff;
    }

    /* ====== Barcode ====== */
    .barcode-box {
        background: #f1f4ff;
        border-radius: 8px;
        padding: 12px 5px;
        margin-top: 8px;
    }

    /* ====== Progress Bar ====== */
    .progress-bar {
        background: #e9ecef;
        border-radius: 8px;
        height: 10px;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress {
        background: #007bff;
        height: 10px;
        width: 90%;
        border-radius: 8px;
    }

    /* ====== Status Aktif ====== */
    .status-circle {
        background: #e6f5e9;
        color: #28a745;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        margin: 10px auto;
    }

    /* ====== Tombol Cetak Kartu ====== */
    .btn-cetak {
        background-color: #17375d;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .btn-cetak:hover {
        background-color: #0f2740;
    }

    /* ====== Jadwal Konseling ====== */
    .jadwal-box {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-top: 20px;
    }

    .jadwal-header {
        background: #17375d;
        color: white;
        font-weight: 600;
        padding: 12px 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
    }

    table th {
        background: #f7f9fc;
        color: #17375d;
        font-weight: 600;
    }

    .jadwal-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    margin-top: 20px;
}

.jadwal-header {
    background-color: #123B6B;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    border-bottom: 1px solid #0f2e58;
}

.jadwal-box table {
    width: 100%;
    border-collapse: collapse;
}

.jadwal-box th, .jadwal-box td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.jadwal-box th {
    background: #f4f6f8;
}

.status-menunggu {
    background-color: #fff8e1;
    color: #b58900;
    padding: 3px 10px;
    border-radius: 10px;
}

.status-proses {
    background-color: #e3f2fd;
    color: #1565c0;
    padding: 3px 10px;
    border-radius: 10px;
}

.status-selesai {
    background-color: #e8f5e9;
    color: #2e7d32;
    padding: 3px 10px;
    border-radius: 10px;
}

/* Progress Bar Wrapper */
.progress-bar {
    width: 100%;
    height: 10px;
    background: #e9ecef;
    border-radius: 20px;
    overflow: hidden;
}

/* Progress Fill */
.progress {
    height: 100%;
    background: #0d6efd;
    border-radius: 20px;
    transition: width 0.4s ease;
}



</style>

<div class="welcome-card">
    <h2>Selamat Datang, {{ $siswa->nama_lengkap }}</h2>
    <p>{{ $siswa->jurusan }}</p>
</div>

<div class="dashboard-grid">
    {{-- Barcode --}}
    <div class="card-box">
        <div class="card-header">Barcode NIS</div>
        <div class="card-content">
            <div class="barcode-box">
                {!! DNS1D::getBarcodeHTML(Auth::guard('siswa')->user()->nis, 'C128', 2, 40) !!}
            </div>
            <p style="margin-top:8px; font-weight:bold;">{{ Auth::guard('siswa')->user()->nis }}</p>
        </div>
    </div>

 {{-- Ambil data dokumen langsung di blade --}}
@php
    $nis = Auth::guard('siswa')->user()->nis;

    // Ambil dokumen siswa
    $dokumens = DokumenSiswa::where('nis', $nis)->get();

    // Hitung progress
    $total = $dokumens->count();
    $uploaded = $dokumens->whereNotNull('file_path')->count();
    $percent = $total > 0 ? round(($uploaded / $total) * 100) : 0;
@endphp

<div class="card-box"
     onclick="window.location='{{ route('siswa.dokumensiswa') }}'"
     style="cursor:pointer;">
    
    <div class="card-header">Status Kelengkapan Data</div>

    <div class="card-content">
        <div class="progress-bar">
            <div class="progress" style="width: {{ $percent }}%;"></div>
        </div>

        <p style="font-weight:600; color:#007bff; margin-top:8px;">
            {{ $percent }}%
        </p>
    </div>
</div>

    {{-- Cetak Kartu Pelajar --}}
    <div class="card-box">
        <div class="card-header">Cetak Kartu Pelajar</div>
        <div class="card-content">
            <button class="btn-cetak" onclick="window.location.href='{{ route('siswa.kartupelajar.index') }}'">
                🖨 Cetak Kartu
            </button>
        </div>
    </div>

    {{-- Status Aktif --}}
    <div class="card-box">
        <div class="card-header">Status di Semester - Ganjil T.A. 2025/2026</div>
        <div class="card-content">
            <div class="status-circle">
                <i class="fa fa-check"></i>
            </div>
            <p style="font-weight:600; color:#28a745;">Aktif</p>
        </div>
    </div>
</div>

{{-- Riwayat Konseling --}}
<div class="jadwal-box">
    <div class="jadwal-header">Riwayat Konseling</div>
    <div style="padding:15px;">
        <table>
            <thead>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <th>Topik Konseling</th>
                    <th>Kegiatan Layanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konselings as $konseling)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($konseling->tanggal)->format('d M Y') }}</td>
                        <td>{{ $konseling->topik }}</td>
                        <td>{{ $konseling->kegiatan_layanan ?? '-' }}</td>
                        <td>
                            <span class="status 
                                {{ $konseling->status == 'Menunggu' ? 'status-menunggu' : 
                                   ($konseling->status == 'Diproses' ? 'status-proses' : 'status-selesai') }}">
                                {{ $konseling->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada pengajuan konseling.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
