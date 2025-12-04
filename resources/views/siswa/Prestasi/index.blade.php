@extends('layouts.siswa')

@section('title', 'Prestasi Siswa')
@section('page_title', 'Prestasi Siswa')

@section('content')

<style>
* { font-family: 'Poppins', sans-serif; }

/* ===== WRAPPER ===== */
.bg-wrapper {
    background: linear-gradient(to bottom, #e8f0ff, #ffffff);
    padding: 30px;
    border-radius: 25px;
}

/* HEADER */
.header-siswa {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header-siswa h2 {
    font-size: 20px;
    font-weight: 700;
    color: #1e3a8a;
}

.header-siswa p {
    font-size: 14px;
    color: #6b7280;
}

/* FOTO */
.header-siswa img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #60a5fa;
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
}

.stat-blue { background: #1e3a8a; }
.stat-yellow { background: #d97706; }

.stat-box h2 {
    font-size: 26px;
    margin-top: 5px;
}

/* ===== MODAL ===== */
.modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,.35);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal-box {
    background: white;
    width: 95%;
    max-width: 650px;
    padding: 25px;
    border-radius: 25px;
    position: relative;
}

.modal-close {
    position: absolute;
    top: 15px; right: 15px;
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #f3f4f6;
    border: none;
    font-weight: bold;
    cursor: pointer;
}

.modal-title {
    font-size: 20px;
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 15px;
}

.modal-input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #d4d8e0;
    background: #f3f6fa;
}

.modal-label {
    font-size: 14px;
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 6px;
    display: block;
}

.upload-btn {
    border: 2px dashed #64748b;
    width: 100%;
    padding: 12px;
    border-radius: 14px;
    text-align: center;
    cursor: pointer;
}

/* BUTTON */
.submit-btn {
    width: 100%;
    padding: 12px;
    background: #1e3a8a;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    margin-top: 15px;
}

/* ===== RIWAYAT ===== */
.riwayat-title {
    font-size: 17px;
    font-weight: 700;
    color: #1e3a8a;
    margin-top: 40px;
}

.riwayat-table {
    width: 100%;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    margin-top: 10px;
}

.riwayat-table thead {
    background: #dbeafe;
    color: #1e3a8a;
}

.riwayat-table td, 
.riwayat-table th {
    padding: 12px;
    font-size: 14px;
}


</style>


<div class="bg-wrapper">

    {{-- HEADER SISWA --}}
    <div class="header-siswa">
        <div>
            <h2>{{ $siswa->nama_lengkap }}</h2>
            <p>{{ $siswa->rombel }}</p>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="stat-container">
        <div class="stat-box stat-blue">
            <p>Total Prestasi</p>
            <h2>{{ $totalPrestasi }}</h2>
        </div>

        <div class="stat-box stat-yellow">
            <p>Total Sertifikat</p>
            <h2>{{ $totalSertifikat }}</h2>
        </div>
    </div>

    {{-- BUTTON FORM --}}
    <button onclick="openModal()" class="btn-primary" style="padding:10px 18px; border-radius:12px; background:#1e3a8a; color:#fff; border:none;">
        Tambah Prestasi
    </button>


    {{-- === MODAL FORM PRESTASI === --}}
    <div class="modal-overlay" id="modalPrestasi">
        <div class="modal-box">

            <button class="modal-close" onclick="closeModal()">×</button>

            <h3 class="modal-title">Tambah Data Prestasi</h3>

            <form method="POST" action="{{ route('siswa.prestasi.store') }}" enctype="multipart/form-data">
                @csrf

                <label class="modal-label">Judul Prestasi</label>
                <input type="text" name="judul" class="modal-input" required>

                <label class="modal-label">Jenis Prestasi</label>
                <select name="jenis" class="modal-input" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="sertifikat">Sertifikat</option>
                    <option value="seminar">Seminar</option>
                    <option value="lomba">Lomba</option>
                    <option value="lainnya">Lainnya</option>
                </select>

                <label class="modal-label">Tanggal Prestasi</label>
                <input type="date" name="tanggal_prestasi" class="modal-input" required>

                <label class="modal-label">Keterangan</label>
                <textarea name="deskripsi" class="modal-input" rows="3"></textarea>

                <label class="modal-label">Link (opsional)</label>
                <input type="text" name="link" class="modal-input">

               <label class="modal-label">Upload File</label>

                <label class="upload-btn" for="fileInput">
                    Upload Dokumen/Foto
                </label>

                <input type="file" id="fileInput" name="file" style="display:none">

                <p id="fileName" style="font-size:14px; margin-top:6px; color:#333;"></p>

                <script>
                document.getElementById('fileInput').addEventListener('change', function() {
                    document.getElementById('fileName').innerText =
                        this.files.length ? "File dipilih: " + this.files[0].name : "";
                });
                </script>
                <button type="submit" class="submit-btn">Simpan</button>
            </form>
        </div>
    </div>


    {{-- ================== RIWAYAT ================== --}}
    <h3 class="riwayat-title"><i class="bi bi-clock-history"></i> Daftar Prestasi</h3>

    <div class="overflow-x-auto">
        <table class="riwayat-table">
            <thead>
                <tr>
                    <th>Judul Prestasi/Kegiatan</th>
                    <th>Jenis Prestasi</th>
                    <th>Keterangan</th>
                    <th>Tanggal Prestasi</th>
                    <th>Bukti Pendukung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasi as $p)
                    <tr>
                        <td>{{ $p->judul }}</td>
                        <td>{{ ucfirst($p->jenis) }}</td>
                        <td>{{ ucfirst($p->deskripsi) }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_prestasi)->format('d M Y') }}</td>
                        <td>
                            @if ($p->link)
                                {{-- Jika ada LINK yang diinput --}}
                                <a href="{{ $p->link }}" target="_blank" style="color:#1e3a8a;">
                                    Buka Link
                                </a>

                            @elseif ($p->file)
                                {{-- Jika tidak ada link tapi ada FILE --}}
                                <a href="{{ asset('storage/prestasi/'.$p->file) }}" target="_blank" style="color:#1e3a8a;">
                                    Lihat File
                                </a>

                            @else
                                -
                            @endif
                        </td>
                         <td>
                <a href="{{ route('siswa.prestasi.edit', $p->id) }}" 
                class="btn btn-sm btn-warning" 
                style="padding:5px 10px; border-radius:8px; font-size:13px;">
                Edit
                </a>

                <form action="{{ route('siswa.prestasi.destroy', $p->id) }}" 
                    method="POST" 
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                     <button type="submit" 
                        onclick="return confirm('Yakin hapus user ini?')"
                        style="background:none; border:none; color:red; cursor:pointer; font-size:18px; padding:0;">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                </form>
            </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-3 text-gray-500">
                            Belum ada prestasi
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

{{-- Modal Script --}}
<script>
function openModal() {
    document.getElementById('modalPrestasi').style.display = 'flex';
}
function closeModal() {
    document.getElementById('modalPrestasi').style.display = 'none';
}
</script>

@endsection
