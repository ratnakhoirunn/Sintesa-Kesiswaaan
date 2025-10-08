@extends('layouts.admin')

@section('title', 'Konseling')
@section('page_title', 'Konseling')

@section('content')
<div class="container">
    <h1>Halaman {{ ucfirst($title ?? 'Konseling') }}</h1>
    <p>Konten menyusul...</p>
</div>
@endsection