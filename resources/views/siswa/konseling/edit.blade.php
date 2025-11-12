@extends('layouts.siswa')
@section('title', 'Edit Pengajuan Konseling')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-blue-700">Edit Pengajuan Konseling</h2>

    <form action="{{ route('siswa.konseling.update', $konseling->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- NIS -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">NIS</label>
                <input type="text" name="nis" value="{{ $konseling->nis }}" readonly
                    class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
            </div>

            <!-- Nama Siswa -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Siswa</label>
                <input type="text" name="nama_siswa" value="{{ $konseling->nama_siswa }}" readonly
                    class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
            </div>

            <!-- Kelas -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                <input type="text" name="kelas" value="{{ $konseling->kelas }}" readonly
                    class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $konseling->tanggal }}"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Topik -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Topik</label>
                <input type="text" name="topik" value="{{ $konseling->topik }}"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Latar Belakang -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Latar Belakang</label>
                <textarea name="latar_belakang" rows="3"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $konseling->latar_belakang }}</textarea>
            </div>

            <!-- Kegiatan Layanan -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kegiatan Layanan</label>
                <textarea name="kegiatan_layanan" rows="3"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ $konseling->kegiatan_layanan }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('siswa.konseling.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Batal</a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
