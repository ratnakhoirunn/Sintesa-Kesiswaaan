@extends('layouts.admin')

@section('title', 'Kartu Pelajar')
@section('page_title', 'Kartu Pelajar')

@section('content')
<div class="container">
    <h1>Halaman {{ ucfirst($title ?? 'Kartu Pelajar') }}</h1>
    <p>Konten menyusul...</p>
</div>
@endsection