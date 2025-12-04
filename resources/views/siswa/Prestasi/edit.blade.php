@extends('layouts.siswa')

@section('title', 'Edit Prestasi')

@section('content')

<style>
    /* === OVERLAY === */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.45);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999;
        padding: 20px;
    }

    /* === MODAL BOX === */
    .modal-box {
        width: 95%;
        max-width: 650px;
        max-height: 90vh;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-left: 6px solid #1e3a8a;
        position: relative;
        display: flex;
        flex-direction: column;
        animation: slideUp .25s ease-out;
    }

    /* Header tetap, body bisa scroll */
    .modal-content {
        padding: 25px 30px;
        overflow-y: auto;
        max-height: 80vh;
    }

    @keyframes slideUp {
        from { transform: translateY(15px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    /* === CLOSE BUTTON === */
    .modal-close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 22px;
        background: none;
        border: none;
        color: #777;
        cursor: pointer;
        font-weight: bold;
        transition: .2s;
    }
    .modal-close:hover {
        color: #000;
    }

    /* === TITLE === */
    .modal-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e3a8a;
        text-align: center;
        margin-bottom: 20px;
        margin-top: 10px;
    }

    /* === INPUT === */
    .modal-label {
        font-weight: 600;
        margin-bottom: 6px;
        margin-top: 12px;
        display: block;
    }

    .modal-input {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #cfd4dc;
        font-size: 15px;
        transition: .2s;
    }
    .modal-input:focus {
        border-color: #1e3a8a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30,58,138,0.15);
    }

    /* === Upload Button === */
    .upload-btn {
        display: inline-block;
        background: #1e3a8a;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 6px;
        font-size: 14px;
        transition: .2s;
    }
    .upload-btn:hover {
        background: #142a57;
    }

    /* === BUTTON WRAPPER === */
    .btn-area {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 25px;
    }

    /* === Buttons === */
    .btn-back {
        background: #6b7280;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        width: 140px;
        cursor: pointer;
        transition: .2s;
    }
    .btn-back:hover {
        background: #4b5563;
    }

    .submit-btn {
        background: #1e3a8a;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        font-size: 15px;
        font-weight: 600;
        width: 140px;
        cursor: pointer;
        transition: .2s;
    }
    .submit-btn:hover {
        background: #142a57;
    }
</style>

{{-- === MODAL EDIT PRESTASI === --}}
<div class="modal-overlay">
    <div class="modal-box">

        <button class="modal-close" onclick="window.history.back()">×</button>

        <div class="modal-content">

            <h3 class="modal-title">Edit Data Prestasi</h3>

            <form method="POST" action="{{ route('siswa.prestasi.update', $prestasi->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label class="modal-label">Judul Prestasi</label>
                <input type="text" name="judul" class="modal-input" value="{{ $prestasi->judul }}" required>

                <label class="modal-label">Jenis Prestasi</label>
                <select name="jenis" class="modal-input" required>
                    <option value="sertifikat" {{ $prestasi->jenis == 'sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                    <option value="seminar" {{ $prestasi->jenis == 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="lomba" {{ $prestasi->jenis == 'lomba' ? 'selected' : '' }}>Lomba</option>
                    <option value="lainnya" {{ $prestasi->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <label class="modal-label">Tanggal Prestasi</label>
                <input type="date" name="tanggal_prestasi" class="modal-input"
                    value="{{ $prestasi->tanggal_prestasi }}" required>

                <label class="modal-label">Keterangan</label>
                <textarea name="deskripsi" class="modal-input" rows="3">{{ $prestasi->deskripsi }}</textarea>

                <label class="modal-label">Link (opsional)</label>
                <input type="text" name="link" class="modal-input" value="{{ $prestasi->link }}">

                <label class="modal-label">Upload File (Opsional)</label>

                <label class="upload-btn" for="fileInput">Ganti Dokumen/Foto</label>
                <input type="file" id="fileInput" name="file" style="display:none">

                <p id="fileName" style="font-size:14px; margin-top:6px; color:#333;"></p>

                @if($prestasi->file)
                    <p style="font-size:13px; margin-top:4px; color:#444;">
                        File saat ini: <strong>{{ $prestasi->file }}</strong>
                    </p>
                @endif

                <script>
                    document.getElementById('fileInput').addEventListener('change', function() {
                        document.getElementById('fileName').innerText =
                            this.files.length ? "File dipilih: " + this.files[0].name : "";
                    });
                </script>

                {{-- BUTTON AREA --}}
                <div class="btn-area">
                    <button type="button" class="btn-back" onclick="window.history.back()">Kembali</button>
                    <button type="submit" class="submit-btn">Update</button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
