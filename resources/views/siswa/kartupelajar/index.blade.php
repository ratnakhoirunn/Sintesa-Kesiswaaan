@extends('layouts.siswa')

@section('title', 'Kartu Pelajar | SINTESA')
@section('page_title', 'Kartu Pelajar')

@section('content')
<div style="background:#fff; padding:20px; border-radius:10px; text-align:center;">
    <h4>Kartu Pelajar Digital</h4>
    <hr>
    <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo" width="100"><br>
    <p><strong>{{ Auth::user()->name }}</strong></p>
    <p>NIS: {{ Auth::user()->nis }}</p>
    <button style="background:#003366; color:#fff; padding:10px 20px; border:none; border-radius:6px;">
        <i class="fas fa-download"></i> Unduh PDF
    </button>
</div>
@endsection
