@extends('layouts.siswa')
@section('title', 'Konseling')

@section('content')
<div class="konseling-container">
    <div class="header-konseling">
        <h4>📋 Daftar Pengajuan Konseling</h4>

    <div class="tanggal-jam" id="tanggalJamSiswa"></div>

    </div>

    <div class="filter-wrapper">
        <div></div>
        <a href="{{ route('siswa.konseling.create') }}" class="btn-tambah">+ Ajukan Konseling</a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konselings as $item)
                <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td class="text-left">{{ $item->topik }}</td>
                    <td>
                        <span class="status 
                            {{ $item->status == 'Menunggu' ? 'status-menunggu' : 
                               ($item->status == 'Diproses' ? 'status-proses' : 'status-selesai') }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->tanggapan_admin ?? '-' }}</td>
                    <td>
                        <a href="{{ route('siswa.konseling.show', $item->id) }}" class="btn-detail">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-muted">Belum ada pengajuan konseling.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* === HEADER === */
.header-konseling {
    background-color: #123B6B;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 25px;
    border-radius: 8px 8px 0 0;
}

.header-konseling h4 {
    margin: 0;
    font-weight: 600;
}

.tanggal-jam {
    font-size: 14px;
    opacity: 0.9;
}

/* === FILTER + TOMBOL TAMBAH === */
.filter-wrapper {
    background: #f8f9fa;
    padding: 15px 25px;
    border: 1px solid #ddd;
    border-top: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-tambah {
    border: 2px solid #123B6B;
    color: #123B6B;
    background-color: #fff;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn-tambah:hover {
    background-color: #123B6B;
    color: #fff;
}

/* === TABLE === */
.table-wrapper {
    border: 1px solid #ddd;
    border-top: none;
    border-radius: 0 0 8px 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

thead {
    background-color: #2c3e50;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px 12px;
    text-align: center;
}

th {
    color: #fff;
    font-weight: 600;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* === STATUS BADGE === */
.status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 12px;
}
.status-menunggu {
    background-color: #fff8e1;
    color: #b58900;
}
.status-proses {
    background-color: #e3f2fd;
    color: #1565c0;
}
.status-selesai {
    background-color: #e8f5e9;
    color: #2e7d32;
}

/* === Aksi Button === */
.btn-detail {
    color: #123B6B;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}

.btn-detail:hover {
    text-decoration: underline;
}

/* === Text Style === */
.text-muted {
    color: #999;
    font-style: italic;
}

/* === JS ALERT === */
.alert-success-js {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #d1e7dd;
    color: #0f5132;
    border-left: 5px solid #0f5132;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.4s ease;
    z-index: 9999;
}

.tanggal-jam {
    text-align: right;
    font-size: 14px;
    color: #fff;
    font-weight: 600;
    line-height: 1.2;
}
</style>

<script>
function updateClock() {
    const now = new Date();

    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    const tanggal = now.toLocaleDateString('id-ID', options);
    const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second:'2-digit' });

    document.getElementById('tanggalJamSiswa').innerHTML = `
        ${tanggal}<br>${jam}
    `;
}

// update setiap detik
setInterval(updateClock, 1000);
// panggil sekali saat awal load
updateClock();
</script>
@endsection
