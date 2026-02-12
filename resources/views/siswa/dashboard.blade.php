@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('page_title', 'Dashboard Siswa')

@section('content')

@php
    use App\Models\DokumenSiswa;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    // === LOGIC DATA ===
    $nis = Auth::guard('siswa')->user()->nis;
    $siswa = Auth::guard('siswa')->user();

    // 1. Ambil Notifikasi
    $notifikasis = [];
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('notifikasis')) {
            $notifikasis = \App\Models\Notifikasi::where('nis', $nis)
                ->where('is_read', 0)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    } catch (\Throwable $e) {
        $notifikasis = [];
    }

    // 2. Data Dokumen & Progress
    $dokumens = DokumenSiswa::where('nis', $nis)->get();
    $targetWajib = 5; // Default jumlah wajib
    $uploaded = $dokumens->whereNotNull('file_path')->count();

    // Hitung persentase
    $percent = $targetWajib > 0 ? round(($uploaded / $targetWajib) * 100) : 0;
    if($percent > 100) $percent = 100;
@endphp

{{-- === ALERT PASSWORD DEFAULT === --}}
@if(Auth::guard('siswa')->check() && Auth::guard('siswa')->user()->is_default_password)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>⚠️ Peringatan Keamanan!</strong><br>
    Kamu masih menggunakan password default. Segera ubah password untuk menjaga keamanan akunmu.
    <br>
    <a href="{{ route('siswa.ubah-password') }}" class="btn btn-sm btn-warning mt-2">
        🔒 Ganti Password Sekarang
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- === SUCCESS MESSAGE === --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- === 1. AREA NOTIFIKASI === --}}
@foreach($notifikasis as $notif)
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>{{ $notif->judul }}</strong><br>
    {{ $notif->pesan }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach

{{-- === 2. WELCOME CARD === --}}
<div class="welcome-card mb-4">
    <h4>Selamat Datang, {{ $siswa->nama_lengkap }}</h4>
    <p>{{ $siswa->jurusan }} | {{ $siswa->rombel }}</p>
</div>

{{-- === 3. GRID DASHBOARD === --}}
<div class="row g-3 mb-4">
    
    {{-- Card 1: Barcode --}}
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="card-title">Barcode NIS</h6>
                <div class="my-3">
                    @if(class_exists('DNS1D'))
                        {!! DNS1D::getBarcodeHTML($nis, 'C128', 2, 45) !!}
                    @else
                        <p class="text-muted">Library DNS1D Missing</p>
                    @endif
                </div>
                <p class="mb-0"><strong>{{ $nis }}</strong></p>
            </div>
        </div>
    </div>

    {{-- Card 2: Status Dokumen --}}
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="card-title">Kelengkapan Data</h6>
                <div class="progress my-3" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $percent }}%;" 
                         aria-valuenow="{{ $percent }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ $percent }}%
                    </div>
                </div>
                <p class="mb-0">{{ $uploaded }} dari {{ $targetWajib }} Dokumen</p>
            </div>
        </div>
    </div>

    {{-- Card 3: Cetak Kartu --}}
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="card-title">Kartu Pelajar</h6>
                <div class="my-3">
                    <i class="bi bi-credit-card" style="font-size: 3rem;"></i>
                </div>
                <a href="{{ route('siswa.kartu-pelajar') }}" class="btn btn-primary btn-sm">
                    🖨️ Cetak Kartu
                </a>
            </div>
        </div>
    </div>

    {{-- Card 4: Status Akademik --}}
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <h6 class="card-title">Status Akademik</h6>
                <div class="my-3">
                    <span class="badge bg-success" style="font-size: 1.2rem;">Aktif</span>
                </div>
                <p class="mb-0">T.A. 2025/2026</p>
            </div>
        </div>
    </div>

</div>

{{-- === 4. TABEL RIWAYAT KONSELING (RESPONSIVE WRAPPER) === --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📋 Riwayat Konseling</h5>
        <a href="{{ route('siswa.konseling.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>
    <div class="card-body">
        {{-- Wrapper ini penting agar tabel bisa di-scroll di HP --}}
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Guru BK</th>
                        <th>Topik</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($konselings->take(5) as $konseling)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($konseling->tanggal)->format('d M Y') }}<br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($konseling->jam_pengajuan)->format('H:i') }} WIB</small>
                        </td>
                        <td>{{ $konseling->guru->nama ?? '-' }}<br>
                            <small class="text-muted">{{ $konseling->jenis_layanan ?? 'Konseling' }}</small>
                        </td>
                        <td>{{ Str::limit($konseling->topik, 30) }}</td>
                        <td>
                            @php
                                $statusClass = 'bg-warning';
                                if($konseling->status == 'Disetujui') $statusClass = 'bg-info';
                                elseif($konseling->status == 'Ditolak') $statusClass = 'bg-danger';
                                elseif($konseling->status == 'Selesai') $statusClass = 'bg-success';
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($konseling->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <p class="text-muted mb-2">Belum ada riwayat konseling.</p>
                            <a href="{{ route('siswa.konseling.create') }}" class="btn btn-sm btn-success">
                                ➕ Ajukan Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection