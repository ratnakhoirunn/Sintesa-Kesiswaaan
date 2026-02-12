@extends('layouts.siswa')

@section('title', 'Prestasi Siswa')
@section('page_title', 'Prestasi Siswa')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
:root {
    --primary: #1e3a8a;
    --primary-hover: #172554;
    --secondary: #64748b;
    --bg-light: #f1f5f9;
    --white: #ffffff;
    --shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    --radius: 16px;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 50px;
}

/* HEADER */
.header-card {
    background: linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
    padding: 30px;
    border-radius: var(--radius);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow);
    margin-bottom: 30px;
}

.header-icon i {
    font-size: 60px;
    opacity: 0.8;
}

/* STATS */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    gap: 20px;
    align-items: center;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.icon-blue { background:#eff6ff; color:#3b82f6; }
.icon-yellow { background:#fffbeb; color:#d97706; }

/* CONTENT */
.content-card {
    background: white;
    border-radius: var(--radius);
    padding: 25px;
    box-shadow: var(--shadow);
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.btn-add {
    background: var(--primary);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    display: inline-flex;
    gap: 8px;
    align-items: center;
}

.btn-add:hover { background: var(--primary-hover); }

/* TABLE */
.table-responsive { overflow-x:auto; }

.custom-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.custom-table th,
.custom-table td {
    padding: 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}

.custom-table th {
    background: #f8fafc;
    text-transform: uppercase;
    font-size: 12px;
    color: #64748b;
}

.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-sertifikat { background:#dbeafe; color:#1e40af; }
.badge-lomba { background:#dcfce7; color:#166534; }
.badge-seminar { background:#fce7f3; color:#9d174d; }
.badge-lainnya { background:#f3f4f6; color:#4b5563; }

.action-group { display:flex; gap:8px; }

.btn-icon {
    width:32px;
    height:32px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:none;
    cursor:pointer;
}

.btn-edit { background:#fff7ed; color:#c2410c; }
.btn-delete { background:#fef2f2; color:#b91c1c; }

/* MODAL */
.modal-overlay {
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box {
    background:white;
    width:90%;
    max-width:600px;
    border-radius:20px;
    padding:30px;
    max-height:90vh;
    overflow-y:auto;
}

.modal-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.form-group { margin-bottom:15px; }

.form-control {
    width:100%;
    padding:10px 15px;
    border:1px solid #cbd5e1;
    border-radius:10px;
}

.btn-submit {
    width:100%;
    background:var(--primary);
    color:white;
    padding:12px;
    border:none;
    border-radius:12px;
    font-weight:600;
}
</style>

<div class="dashboard-container">

    {{-- HEADER --}}
    <div class="header-card">
        <div>
            <h2>Portofolio Prestasi</h2>
            <p>{{ $siswa->nama_lengkap }} | {{ $siswa->rombel }}</p>
        </div>
        <div class="header-icon">
            <i class="bi bi-trophy-fill"></i>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="bi bi-award-fill"></i>
            </div>
            <div>
                <p>Total Prestasi</p>
                <h3>{{ $totalPrestasi }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-yellow">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <div>
                <p>Total Sertifikat</p>
                <h3>{{ $totalSertifikat }}</h3>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content-card">
        <div class="content-header">
            <h4>Riwayat Prestasi</h4>
            <button onclick="openModal()" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Prestasi
            </button>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $i => $p)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><strong>{{ $p->judul }}</strong></td>
                        <td>
                            @php
                                $badge = match($p->jenis){
                                    'sertifikat'=>'badge-sertifikat',
                                    'lomba'=>'badge-lomba',
                                    'seminar'=>'badge-seminar',
                                    default=>'badge-lainnya'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($p->jenis) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_prestasi)->format('d M Y') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($p->deskripsi,40) }}</td>
                        <td>
                            @if($p->link)
                                <a href="{{ $p->link }}" target="_blank">Link</a>
                            @elseif($p->file)
                                <a href="{{ asset('storage/prestasi/'.$p->file) }}" target="_blank">File</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('siswa.prestasi.edit',$p->id) }}" class="btn-icon btn-edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('siswa.prestasi.destroy',$p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal-overlay" id="modalPrestasi">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Tambah Prestasi</h3>
            <button onclick="closeModal()">×</button>
        </div>

        <form method="POST" action="{{ route('siswa.prestasi.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="text" name="judul" class="form-control" placeholder="Judul Prestasi" required>
            </div>

            <div class="form-group">
                <select name="jenis" class="form-control" required>
                    <option value="">Pilih Jenis</option>
                    <option value="sertifikat">Sertifikat</option>
                    <option value="seminar">Seminar</option>
                    <option value="lomba">Lomba</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <input type="date" name="tanggal_prestasi" class="form-control" required>
            </div>

            <div class="form-group">
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi"></textarea>
            </div>

            <div class="form-group">
                <input type="url" name="link" class="form-control" placeholder="Link (opsional)">
            </div>

            <div class="form-group">
                <input type="file" name="file" class="form-control">
            </div>

            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>
</div>

<script>
function openModal(){
    document.getElementById('modalPrestasi').style.display='flex';
}
function closeModal(){
    document.getElementById('modalPrestasi').style.display='none';
}
window.onclick=function(e){
    const modal=document.getElementById('modalPrestasi');
    if(e.target===modal){ closeModal(); }
}
</script>

@endsection
