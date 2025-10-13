@extends('layouts.admin')

@section('title', 'Manajemen Kartu Pelajar')
@section('page_title', 'Manajemen Kartu Pelajar')

@section('content')
<style>
/* container utama mirip gambar */
.kartu-wrap { padding: 18px; }
.search-box {
    background:#1e3a67; padding:18px; border-radius:8px; color:#fff;
    display:flex; gap:12px; align-items:center;
}
.search-input {
    flex:1; display:flex; gap:8px; align-items:center;
}
.search-input input {
    width:100%; padding:10px 12px; border-radius:6px; border:none;
    outline:none;
}
.btn-cetak-mass { background:#fff; color:#1e3a67; padding:8px 12px; border-radius:6px; text-decoration:none; }

/* tabel */
.card-table {
    background:#f5f7fa; border-radius:8px; padding:18px; margin-top:18px;
}
.table-header {
    background:#fff; padding:12px; border-radius:6px; display:flex; justify-content:space-between; align-items:center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.table-list {
    width:100%; border-collapse:collapse; margin-top:12px;
}
.table-list th, .table-list td { padding:10px 12px; text-align:left; }
.table-list th { font-weight:700; font-size:0.95rem; color:#2c3e50; }
.table-list tr td { background:transparent; border-bottom:1px solid rgba(0,0,0,0.05); }

/* tombol cetak per baris */
.btn-cetak {
    background:#1e3a67; color:#fff; padding:6px 10px; border-radius:20px; text-decoration:none; font-size:0.85rem;
}

/* checkbox */
.checkbox-cell { text-align:center; }

/* responsive */
@media(max-width:900px) {
    .form-search { flex-direction:column; align-items:stretch; gap:8px; }
}
</style>

<div class="kartu-wrap">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h3 style="margin:0; color:#1e3a67;">Manajemen Kartu Pelajar</h3>
        
    </div>

    <div class="search-box">
        <div class="search-input">
            <form id="form-search" action="{{ route('admin.kartupelajar.index') }}" method="GET" style="width:100%; display:flex; gap:8px;">
                <input name="q" type="text" placeholder="Cari Siswa" value="{{ $q ?? '' }}">
                <button type="submit" style="background:#fff; color:#1e3a67; padding:8px 12px; border-radius:6px; border:none;">Cari</button>
            </form>
        </div>
    </div>

    <div class="card-table">
        <div class="table-header">
            <div style="font-weight:700;">Daftar Siswa</div>
            <div style="font-size:0.9rem; color:#666;">Total: {{ $siswas->total() }}</div>
        </div>

        <table class="table-list">
            <thead>
                <tr>
                    <th style="width:40px;" class="checkbox-cell"><input type="checkbox" id="check-all"></th>
                    <th style="width:40px;">No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>ROMBEL</th>
                    <th>Jurusan</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-rows">
                @foreach($siswas as $i => $siswa)
                <tr>
                    <td class="checkbox-cell"><input class="row-check" data-id="{{ $siswa->id }}" type="checkbox"></td>
                    <td>{{ $i + $siswas->firstItem() }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td>{{ $siswa->rombel }}</td>
                    <td>{{ $siswa->jurusan }}</td>
                    <td>
                        <a href="{{ route('admin.kartupelajar.print', $siswa->id) }}" target="_blank" class="btn-cetak">Cetak</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:12px; display:flex; justify-content:center;">
            {{ $siswas->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('check-all');
    const rowChecks = document.querySelectorAll('.row-check');
    const massIdsInput = document.getElementById('mass-ids');
    const massForm = document.getElementById('form-cetak-mass');

    checkAll?.addEventListener('change', function() {
        rowChecks.forEach(cb => cb.checked = this.checked);
        updateMassIds();
    });

    rowChecks.forEach(cb => cb.addEventListener('change', updateMassIds));

    function updateMassIds() {
        const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(e => e.dataset.id);
        // set input value as JSON or CSV - server expects array; we'll send as CSV string
        massIdsInput.value = ids.join(',');
    }

    // intercept mass form submit to convert CSV to array on server side;
    // alternatively send ids[] via JS or use hidden input as CSV (controller will parse)
});
</script>
@endsection
