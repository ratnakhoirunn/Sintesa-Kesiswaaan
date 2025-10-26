@extends('layouts.admin')
@section('title', 'Kartu Pelajar')
@section('page_title', 'Preview Kartu Pelajar')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    /* Batasi Poppins hanya di area preview */
    .preview-container,
    .preview-container * {
        font-family: 'Poppins', sans-serif !important;
    }

    /* Container preview tengah */
    .preview-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 1.8rem;
        padding: 20px;
    }

    /* Hilangkan background putih / bayangan */
    iframe {
        display: block;
        width: 100%;
        max-width: 750px;
        height: 850px;
        border: none;
        background: transparent; /* 🔥 tidak ada background putih */
        box-shadow: none;        /* 🔥 tidak ada bayangan */
    }

    /* Tombol */
    .btn-action {
        font-weight: 600;
        font-size: 15px;
        border-radius: 12px;
        padding: 10px 28px;
        transition: all 0.2s ease-in-out;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-cetak {
        background-color: #27ae60;
        color: white;
    }

    .btn-cetak:hover {
        background-color: #219150;
    }

    .btn-unduh {
        background-color: #007bff;
        color: white;
    }

    .btn-unduh:hover {
        background-color: #005fc8;
    }

    .btn-batal {
        background-color: #f8f9fa;
        color: #e63946;
        border: 1px solid #e63946;
    }

    .btn-batal:hover {
        background-color: #e63946;
        color: white;
    }

    /* Responsif */
    @media (max-width: 768px) {
        iframe {
            height: 600px;
        }
    }
</style>

<div class="container py-5">
    <div class="text-center mb-4">
        <p class="text-muted" style="font-size: 0.95rem;">
            Periksa kembali tampilan kartu sebelum dicetak atau diunduh.
        </p>
    </div>

    <div class="preview-container">
        <iframe id="kartuFrame" src="{{ route('admin.kartupelajar.frame', $siswa->nis) }}"></iframe>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button onclick="printKartu()" class="btn-action btn-cetak">🖨 Cetak</button>
            <a href="{{ route('admin.kartupelajar.download.pdf', $siswa->nis) }}" class="btn-action btn-unduh">📄 Unduh PDF</a>
            <a href="{{ route('admin.kartupelajar.index') }}" class="btn-action btn-batal">✖ Batal</a>
        </div>
    </div>
</div>

<script>
function printKartu() {
    const frame = document.getElementById('kartuFrame').contentWindow;
    frame.focus();
    frame.print();
}
</script>
@endsection
