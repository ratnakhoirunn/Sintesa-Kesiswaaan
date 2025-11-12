@extends('layouts.siswa')

@section('title', 'Detail Konseling')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4 text-blue-700">Detail Pengajuan Konseling</h2>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="mb-3">
            <label class="font-semibold text-gray-700">Tanggal Pengajuan:</label>
            <p>{{ $konseling->tanggal }}</p>
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Topik Konseling:</label>
            <p>{{ $konseling->topik }}</p>
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Deskripsi:</label>
            <p>{{ $konseling->deskripsi ?? '-' }}</p>
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Status:</label>
            <p>
                @if ($konseling->status == 'Menunggu')
                    <span class="text-yellow-600 font-semibold bg-yellow-100 px-2 py-1 rounded-lg">Menunggu</span>
                @elseif ($konseling->status == 'Disetujui')
                    <span class="text-green-600 font-semibold bg-green-100 px-2 py-1 rounded-lg">Disetujui</span>
                @elseif ($konseling->status == 'Ditolak')
                    <span class="text-red-600 font-semibold bg-red-100 px-2 py-1 rounded-lg">Ditolak</span>
                @else
                    <span class="text-gray-600">{{ $konseling->status }}</span>
                @endif
            </p>
        </div>

        <div class="mb-3">
            <label class="font-semibold text-gray-700">Tanggapan Admin:</label>
            <p>{{ $konseling->tanggapan_admin ?? 'Belum ada tanggapan' }}</p>
        </div>

        <a href="{{ route('siswa.konseling.index') }}" 
           class="inline-block bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 mt-4">
           ← Kembali
        </a>
    </div>
</div>
@endsection
