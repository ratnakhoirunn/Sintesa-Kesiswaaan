@extends('layouts.siswa')

@section('title', 'Keterlambatan')
@section('page_title', 'Keterlambatan')

@section('content')
<style>
/* ===== WRAPPER UTAMA ===== */
.bg-gradient-to-b {
    background: linear-gradient(to bottom, #e8f0ff, #ffffff);
    padding: 30px;
    border-radius: 25px;
}

/* ===== HEADER PROFIL ===== */
.header-siswa {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header-siswa .info {
    line-height: 1.2;
}

.header-siswa h2 {
    font-size: 20px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 3px;
}

.header-siswa p {
    font-size: 14px;
    color: #6b7280;
}

/* ===== FOTO PROFIL KECIL ===== */
.header-siswa img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #60a5fa;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

/* ===== STATISTIK ===== */
.stat-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 25px;
}

.stat-box {
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    color: #fff;
    font-weight: 600;
    box-shadow: 0px 4px 10px rgba(0,0,0,.15);
    transition: .2s;
}

.stat-box:hover {
    transform: translateY(-4px);
    box-shadow: 0px 6px 15px rgba(0,0,0,.22);
}

.stat-blue {
    background: #1e3a8a;
}

.stat-red {
    background: #dc2626;
}

.stat-box p {
    font-size: 14px;
    margin-bottom: 5px;
}

.stat-box h2 {
    font-size: 28px;
    margin: 0;
}

/* ===== FORM ===== */
.form-control {
    background: #f3f6fa;
    border: 1px solid #d4d8e0;
    padding: 10px 12px;
    border-radius: 10px;
}

.form-control:focus {
    border-color: #1e3a8a;
    background: #ffffff;
    box-shadow: 0 0 0 2px rgba(30,58,138,.25);
}

label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #1e3a8a;
    font-size: 14px;
}

/* ===== TOMBOL ===== */
.btn-primary {
    background: #1e3a8a !important;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 600;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #162d6d !important;
}

.btn-secondary {
    background: #e2e8f0 !important;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 600;
    color: #1e293b;
    border: none;
}

.btn-secondary:hover {
    background: #cfd8e3 !important;
}

/* ===== TABEL RIWAYAT ===== */
table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

thead {
    background: #dbeafe;
    color: #1e3a8a;
}

tbody tr:hover {
    background: #f1f5f9;
}

/* ===== STATUS BADGE ===== */
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    color: white;
    font-weight: 600;
}

/* ===== OVERLAY MODAL ===== */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .35);
    backdrop-filter: blur(3px);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* ===== CONTAINER MODAL ===== */
.modal-box {
    background: white;
    width: 95%;
    max-width: 650px;
    padding: 25px;
    border-radius: 25px;
    box-shadow: 0 10px 35px rgba(0,0,0,.25);
    position: relative;
    animation: fadeIn .3s ease-out;
}

/* ===== ANIMASI ===== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== BUTTON CLOSE ===== */
.modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 32px;
    height: 32px;
    background: #f3f4f6;
    border-radius: 50%;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    cursor: pointer;
    color: #1e3a8a;
    font-weight: bold;
    transition: .2s;
}

.modal-close:hover {
    background: #e0e7ff;
    transform: scale(1.1);
}

/* ===== TITLE ===== */
.modal-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 20px;
}

/* ===== GRID FORM ===== */
.modal-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

/* ===== INPUT/SELECT/TEXT AREA ===== */
.modal-input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    background: #f7f9fc;
    font-size: 14px;
    transition: .2s;
}

.modal-input:focus {
    border-color: #1e3a8a;
    background: #fff;
    box-shadow: 0 0 0 2px rgba(30,58,138,.25);
    outline: none;
}

/* ===== TEXTAREA FULL WIDTH ===== */
.modal-textarea {
    grid-column: span 2;
    resize: none;
}

/* ===== LABEL ===== */
.modal-label {
    font-size: 14px;
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 6px;
    display: block;
}

/* ===== BUTTON UPLOAD ===== */
.upload-btn {
    border: 2px dashed #64748b;
    padding: 12px;
    border-radius: 14px;
    width: 100%;
    text-align: center;
    cursor: pointer;
    transition: .2s;
    color: #475569;
    font-weight: 500;
}

.upload-btn:hover {
    border-color: #1e3a8a;
    background: #f0f5ff;
    color: #1e3a8a;
}

/* ===== BUTTON AJUKAN ===== */
.submit-btn {
    width: 100%;
    background: #1e3a8a;
    color: white;
    padding: 12px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    transition: .2s;
}

.submit-btn:hover {
    background: #162d6d;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

/* ===== MOBILE RESPONSIVE ===== */
@media(max-width: 600px) {
    .modal-form-grid {
        grid-template-columns: 1fr;
    }
    .modal-textarea {
        grid-column: span 1;
    }

}

/* ===== WRAPPER RIWAYAT ===== */
.riwayat-wrapper {
    margin-top: 40px;
}

/* ===== TITLE RIWAYAT ===== */
.riwayat-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ===== TABEL ===== */
.riwayat-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
    font-size: 14px;
}

/* ===== HEADER TABEL ===== */
.riwayat-table thead {
    background: #dbeafe;
    color: #1e3a8a;
    text-transform: uppercase;
    font-weight: 600;
}

.riwayat-table thead th {
    padding: 14px;
    letter-spacing: 0.5px;
}

/* ===== BODY ===== */
.riwayat-table tbody tr {
    transition: .2s;
}

.riwayat-table tbody tr:hover {
    background: #f1f5f9;
    transform: scale(1.01);
}

/* ===== CELL ===== */
.riwayat-table td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

/* ===== STATUS BADGE ===== */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    display: inline-block;
}

.status-pending {
    background: #facc15; /* kuning */
}

.status-diproses {
    background: #3b82f6; /* biru */
}

.status-diterima {
    background: #16a34a; /* hijau */
}

/* ===== RESPONSIVE ===== */
@media(max-width: 600px) {
    .riwayat-table {
        font-size: 12px;
    }

    .riwayat-table thead th,
    .riwayat-table td {
        padding: 10px;
    }
}

</style>

<div class="bg-gradient-to-b from-blue-50 to-white p-6 rounded-2xl shadow-md transition-all duration-300">

    {{-- === Header Profil Siswa === --}}
    <div class="header-siswa">
    <div class="info">
        <h2>{{ $siswa->nama_lengkap }}</h2>
        <p>{{ $siswa->rombel }}</p>
    </div>

</div>


    {{-- === Statistik Keterlambatan === --}}
    <div class="stat-container">
    <div class="stat-box stat-blue">
        <p>Total Keterlambatan</p>
        <h2>{{ $jumlah }}</h2>
    </div>

    <div class="stat-box stat-red">
        <p>Point Pelanggaran</p>
        <h2>{{ $poin }}</h2>
    </div>
</div>


    <!-- === MODAL FORM IZIN === -->
<div class="modal-overlay" id="modalIzin">

    <div class="modal-box">

        <button class="modal-close" onclick="closeModal()">×</button>

        <h3 class="modal-title">Formulir Pengajuan Izin Keterlambatan</h3>

        <form method="POST" action="{{ route('siswa.keterlambatan.ajukan') }}" enctype="multipart/form-data">
            @csrf

            <div class="modal-form-grid">

                <div>
                    <label class="modal-label">Nama Siswa</label>
                    <input type="text" class="modal-input" value="{{ $siswa->nama_lengkap }}" readonly>
                </div>

                <div>
                    <label class="modal-label">Kelas</label>
                    <input type="text" class="modal-input" value="{{ $siswa->rombel }}" readonly>
                </div>

                <div>
                    <label class="modal-label">Tanggal</label>
                    <input type="date" name="tanggal" class="modal-input" required>
                </div>

                <div>
                    <label class="modal-label">Waktu Kehadiran</label>
                    <input type="time" name="jam_datang" class="modal-input" required>
                </div>

                <div class="modal-textarea">
                    <label class="modal-label">Alasan Keterlambatan</label>
                    <textarea name="keterangan" class="modal-input" rows="4" required></textarea>
                </div>

                <div class="modal-textarea">
                    <label class="modal-label">Dokumen Pendukung (opsional)</label>
                    <label class="upload-btn">
                        Unggah Dokumen Pendukung
                        <input type="file" name="dokumen" hidden>
                    </label>
                </div>

            </div>

            <button type="submit" class="submit-btn">Ajukan Izin</button>
        </form>
    </div>
</div>

<button onclick="openModal()" class="btn-primary">
    Ajukan Izin
</button>



   <div class="riwayat-wrapper">
    <h3 class="riwayat-title">
        <i class="bi bi-clock-history"></i> Riwayat Pengajuan SIT
    </h3>

    <div class="overflow-x-auto">
        <table class="riwayat-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Alasan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->jam_datang)->format('H:i') }}</td>
                    <td class="text-left">{{ $data->keterangan }}</td>
                    <td>
    @if ($data->status == 'diterima')
        <a href="{{ route('siswa.cetak.sit', $data->id) }}"
            class="status-badge status-diterima"
            style="text-decoration:none; cursor:pointer; display:inline-block;">
            Cetak SIT
        </a>
    @else
        <span class="status-badge 
            {{ $data->status == 'pending' ? 'status-pending' :
               ($data->status == 'diproses' ? 'status-diproses' : 'status-diterima') }}">
            {{ ucfirst($data->status) }}
        </span>
    @endif
</td>


                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-3 text-gray-500 text-center">Belum ada data keterlambatan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- === SweetAlert Success === --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    confirmButtonColor: '#1e3a8a',
    timer: 2500,
    showConfirmButton: false
});

</script>
@endif
<script>
function openModal() {
    document.getElementById('modalIzin').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalIzin').style.display = 'none';
}
</script>
@endsection
