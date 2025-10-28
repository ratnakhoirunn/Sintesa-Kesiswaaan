@extends('layouts.admin')

@section('title', 'Keterlambatan')
@section('page_title', 'Keterlambatan')

@section('content')
<style>
    .header-keterlambatan {
        background-color: #123B6B;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        border-radius: 8px 8px 0 0;
    }

    .header-keterlambatan h4 {
        margin: 0;
        font-weight: 600;
    }

    .tanggal-jam {
        font-size: 14px;
        text-align: right;
    }

    .form-container {
        background: #ffffff;
        padding: 25px;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .btn-primary {
        background-color: #123B6B;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #0f2e52;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<div class="card shadow-sm">
    {{-- Header --}}
    <div class="header-keterlambatan">
        <h4>Tambah Data Keterlambatan</h4>
        <div class="tanggal-jam" id="tanggal-jam"></div>
    </div>

    <div class="form-container">
        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left:15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

 {{-- Form Tambah --}}
        <form method="POST" action="{{ route('admin.keterlambatan.store') }}">
            @csrf

            <div class="form-group">
                <label for="nis">NIS Siswa</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nama_siswa">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jam_datang">Jam Datang</label>
                <input type="time" name="jam_datang" id="jam_datang" value="{{ old('jam_datang') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="menit_terlambat">Menit Terlambat</label>
                <input type="number" name="menit_terlambat" id="menit_terlambat" value="{{ old('menit_terlambat') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="form-control" required>{{ old('keterangan') }}</textarea>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <a href="{{ route('admin.keterlambatan.index') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const hari = now.toLocaleDateString('id-ID', { weekday: 'long' });
        const tanggal = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const jam = now.toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('tanggal-jam').innerHTML = `${hari}, ${tanggal}<br>${jam}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>

@endsection
