@extends('layouts.admin')

@section('title', 'Manajemen Kartu Pelajar')
@section('page_title', 'Manajemen Kartu Pelajar')

@section('content')
<style>
.kartu-wrap { padding: 18px; }
.search-box {
    background:#1e3a67; padding:18px; border-radius:8px; color:#fff;
    display:flex; gap:12px; align-items:center;
}
.search-input { flex:1; display:flex; gap:8px; align-items:center; }
.search-input input,
.search-input select {
    width:100%; padding:10px 12px; border-radius:6px; border:none; outline:none;
}
.btn-cetak-mass {
    background-color: #17375d;
    color: white;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: 0.2s ease-in-out;
    display: flex;
    align-items: center;
    gap: 5px;
}
.btn-cetak-mass:hover { background-color:#0069d9; }

.card-table { background:#f5f7fa; border-radius:8px; padding:18px; margin-top:18px; }
.table-header {
    padding:12px; border-radius:6px;
    display:flex; justify-content:space-between; align-items:center;
    box-shadow:0 2px 6px rgba(0,0,0,0.04);
}
.table-list { width:100%; border-collapse:collapse; margin-top:12px; }
.table-list th, .table-list td { padding:10px 12px; text-align:left; }
.table-list th {
    font-weight:700; font-size:0.95rem; color:#fff; background:#2c3e50;
}
.table-list tr td { border-bottom:1px solid rgba(0,0,0,0.05); }
.btn-cetak {
    background:#1e3a67; color:#fff; padding:6px 10px; border-radius:20px;
    text-decoration:none; font-size:0.85rem;
}
.checkbox-cell { text-align:center; }

/* Hapus "showing" */
nav[role="navigation"] > div:first-child { display:none !important; }

/* Pagination prev next only */
nav[role="navigation"] {
    display:flex; justify-content:center; align-items:center; gap:8px; margin-top:15px;
}
.pagination .page-item:not(.disabled):not(.active) { display:none !important; }
.pagination .page-item.active { display:none !important; }

.pagination .page-item .page-link {
    padding:8px 18px; border-radius:30px; background:#17375d; color:white; font-weight:600; border:none;
}
.pagination .page-item .page-link:hover { background:#0069d9; color:white; }
nav[role="navigation"] svg { width:16px!important; height:16px!important; }
</style>

<div class="kartu-wrap">
    <div class="search-box">
        <div class="search-input">
            
            <!-- ✅ FILTER & SEARCH -->
            <form id="form-search" action="{{ route('admin.kartupelajar.index') }}" method="GET" 
                  style="width:100%; display:flex; gap:8px;">

                <!-- ✅ Dropdown ROMBEL -->
                <select name="rombel">
                    <option value="">Semua Kelas</option>
                    @foreach($rombels as $r)
                        <option value="{{ $r->rombel }}" {{ request('rombel') == $r->rombel ? 'selected' : '' }}>
                            {{ $r->rombel }}
                        </option>
                    @endforeach
                </select>

                <input name="q" type="text" placeholder="Cari Siswa" value="{{ request('q') }}">

                <button type="submit" style="background:#fff; color:#1e3a67; padding:8px 12px; border-radius:6px; border:none;">
                    Cari
                </button>
            </form>

        </div>
    </div>

    <div class="card-table">
        <div class="table-header">
            <div style="font-weight:700;">Daftar Siswa</div>
            <div style="font-size:0.9rem; color:#666;">Total: {{ $siswas->total() }}</div>
        </div>

        <form id="form-cetak-mass" action="{{ route('admin.kartupelajar.printMass') }}" method="POST">
            @csrf
            <input type="hidden" name="nis_list" id="mass-ids">

            <table class="table-list">
                <thead>
                    <tr>
                        <th class="checkbox-cell"><input type="checkbox" id="check-all"></th>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>ROMBEL</th>
                        <th>Jurusan</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $i => $siswa)
                    <tr>
                        <td class="checkbox-cell"><input class="row-check" data-nis="{{ $siswa->nis }}" type="checkbox"></td>
                        <td>{{ $i + $siswas->firstItem() }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama_lengkap }}</td>
                        <td>{{ $siswa->rombel }}</td>
                        <td>{{ $siswa->jurusan }}</td>
                        <td>
                            <a href="{{ route('admin.kartupelajar.preview', $siswa->nis) }}" class="btn btn-sm btn-success">Lihat Kartu</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:15px; display:flex; justify-content:space-between; align-items:center;">
                <div id="jumlahDipilih" style="color:#555; font-weight:500;">0 siswa dipilih</div>
                <button type="submit" class="btn-cetak-mass">🖨 Cetak Kartu Terpilih</button>
            </div>
        </form>

        <div style="margin-top:12px; display:flex; justify-content:center;">
            {{ $siswas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkAll = document.getElementById('check-all');
    const rowChecks = document.querySelectorAll('.row-check');
    const jumlahDipilih = document.getElementById('jumlahDipilih');
    const massIdsInput = document.getElementById('mass-ids');

    checkAll.addEventListener('change', function() {
        rowChecks.forEach(cb => cb.checked = this.checked);
        updateSelected();
    });

    rowChecks.forEach(cb => cb.addEventListener('change', updateSelected));

    function updateSelected() {
        const checked = Array.from(rowChecks).filter(cb => cb.checked);
        const nisList = checked.map(cb => cb.dataset.nis);
        massIdsInput.value = nisList.join(',');
        jumlahDipilih.textContent = `${nisList.length} siswa dipilih`;
    }
});
</script>
@endsection
