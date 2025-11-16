@extends('layouts.admin')

@section('title', 'Dashboard BK')
@section('page_title', 'Dashboard Guru BK')

@section('content')

<div class="welcome-card">
    <h1>Selamat Datang, Guru BK</h1>
    <p>Kelola pengajuan konseling siswa</p>
</div>

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

@endsection
