@extends('layouts.admin')

@section('title', 'Dokumen Siswa')
@section('page_title', 'Dokumen Siswa Wali Kelas')

@section('content')
@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

<div class="filter-container" style="margin-bottom:20px;">
    <div class="topbar-filter">
        <form method="GET" action="{{ route('wali.dokumensiswa') }}" class="filter-form">
            <div class="filter-container">

                {{-- Filter Jenis Dokumen --}}
                <div class="filter-group">
                    <label for="dokumen">Pilih Dokumen</label>
                    <select name="dokumen" id="dokumen" class="filter-select">
                        <option value="">Semua</option>
                        <option value="kartu_keluarga" {{ request('dokumen') == 'kartu_keluarga' ? 'selected' : '' }}>Kartu Keluarga</option>
                        <option value="akta_kelahiran" {{ request('dokumen') == 'akta_kelahiran' ? 'selected' : '' }}>Akta Kelahiran</option>
                        <option value="KPSPKH" {{ request('dokumen') == 'KPSPKH' ? 'selected' : '' }}>KPSPKH</option>
                        <option value="KIP" {{ request('dokumen') == 'KIP' ? 'selected' : '' }}>KIP</option>
                        <option value="pas_foto" {{ request('dokumen') == 'pas_foto' ? 'selected' : '' }}>Pas Foto</option>
                    </select>
                </div>

                {{-- Pencarian --}}
                <div class="filter-group">
                    <label for="search">Cari</label>
                    <div class="search-box">
                        <input type="text" name="search" id="search" placeholder="Cari berdasarkan NIS atau Nama..." value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


{{-- TABEL --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Total Dokumen</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($siswa as $i => $s)
        <tr>
            <td style="text-align:center;">{{ $i + $siswa->firstItem() }}</td>
            <td>{{ $s->nis }}</td>
            <td>{{ $s->nama_lengkap }}</td>

            <td style="text-align:center;">
                {{-- GANTI DOKUMEN_SISWA_COUNT menjadi DOKUMEN_UPLOADED_COUNT --}}
                <span class="badge-count">{{ $s->dokumen_uploaded_count ?? 0 }} / {{ $totalDokumenWajib ?? 5 }}</span>
            </td>

            <td>
                <div class="aksi-container">

                    {{-- Tombol Lihat (jika nanti mau dipakai) --}}
                    <a href="{{ route('wali.dokumensiswa.show', $s->nis) }}" class="aksi-lihat">
                        <i class="fas fa-eye"></i> Lihat
                    </a> 

                    {{-- Tombol Edit --}}
                    <a href="{{ route('wali.dokumensiswa.edit', $s->nis) }}" class="aksi-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a> 

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('wali.dokumensiswa.destroy', $s->nis) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus dokumen siswa ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="aksi-hapus">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form> 
                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center; padding:10px;">Tidak ada data siswa dalam rombel Anda.</td>
        </tr>
        @endforelse
    </tbody>
</table>


{{-- PAGINATION --}}
<div style="margin-top:20px; display:flex; justify-content:center;">
    {{ $siswa->appends(request()->query())->links('pagination::simple-tailwind') }}
</div>



{{-- STYLE --}}
<style>
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    table-layout: fixed;
}
thead {
    background: #2c3e50;
    color: white;
}
th, td {
    padding: 12px 14px;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
    word-wrap: break-word;
    text-align: left;
}

th:nth-child(1), td:nth-child(1) { width: 6%; text-align: center; }
th:nth-child(2), td:nth-child(2) { width: 15%; }
th:nth-child(3), td:nth-child(3) { width: 30%; }
th:nth-child(4), td:nth-child(4) { width: 15%; text-align:center; }
th:nth-child(5), td:nth-child(5) { width: 20%; text-align:center; }

tbody tr:hover { background: #f8f9fa; }

.badge-count {
    background: #e9ecef;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
}

.aksi-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    
}
.aksi-lihat { color: #007bff; }
.aksi-edit { color: #ff9800; }
.aksi-hapus { color: #e74c3c; }

.aksi-container a,
.aksi-container button {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}
.aksi-container a:hover,
.aksi-container button:hover {
    opacity: 0.8;
}

/* Filter */
.topbar-filter {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
}
.filter-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.filter-group {
    display: flex;
    flex-direction: column;
}
.filter-group label {
    font-weight: 600;
    margin-bottom: 6px;
}

/* Input & Select */
.filter-select,
.search-box input {
    background: #f8f9fa;
    border: none;
    border-radius: 12px;
    padding: 10px 15px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    width: 200px;
}

/* Search box */
.search-box {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border-radius: 12px;
}
.search-box button {
    background: transparent;
    border: none;
    color: #333;
    padding: 10px;
}

</style>

<script>
document.getElementById('dokumen').addEventListener('change', function() {
    this.form.submit();
});
</script>

@endsection
