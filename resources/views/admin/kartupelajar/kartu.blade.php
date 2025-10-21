<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
    size: 8.6cm 5.4cm;
    margin: 0;
}
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    font-size: 8px;
    line-height: 1.1;
    width: 8.6cm;
}


/* =======================
   HALAMAN DEPAN
======================= */
.card {
    width: 8.6cm;
    height: 5.4cm;
    border: 1px solid #000;
    position: relative;
    overflow: hidden;
}

/* HEADER */
.header {
    background-color: #3aa0d8;
    color: white;
    text-align: center;
    padding: 1px 20px;
    font-size: 6.5px;
    line-height: 1.1;
    position: relative;
}
.header img.logo-left {
    position: absolute;
    left: 5px;
    top: 3px;
    width: 18px;
    height: 18px;
}
.header img.logo-right {
    position: absolute;
    right: 5px;
    top: 3px;
    width: 18px;
    height: 18px;
}
.header strong {
    font-size: 7px;
}
.judul {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    font-size: 8px;
    text-align: center;
    padding: 1px 0;
}

/* ISI DEPAN */
.content {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: flex-start;
    padding: 3px 5px;
}

/* FOTO DAN BARCODE */
.foto-area {
    width: 2cm;
    text-align: center;
    margin-right: 5px;
}
.foto-area .foto {
    width: 2cm;
    height: 2.1cm;
    border: 1px solid #000;
    margin-bottom: 1px;
}
.foto-area img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.barcode {
    transform: scale(0.7);
    transform-origin: top center;
    margin-top: 0;
}

/* DATA SISWA */
.data {
    flex: 1;
    font-size: 7.5px;
    line-height: 1.05;
}
.data table {
    width: 100%;
    border-collapse: collapse;
}
.data td {
    vertical-align: top;
    padding: 0;
}

/* FOOTER */
.footer {
    position: absolute;
    bottom: 13px;
    right: 8px;
    text-align: right;
    font-size: 7px;
    line-height: 1.1;
}
.footer strong {
    display: block;
}

/* JURUSAN */
.jurusan {
    position: absolute;
    bottom: 0;
    width: 100%;
    background-color: #009c3b;
    color: white;
    font-size: 8px;
    font-weight: bold;
    text-align: center;
    padding: 1px 0;
}

/* =======================
   HALAMAN BELAKANG
======================= */
.card-back {
    width: 8.6cm;
    height: 5.4cm;
    border: 1px solid #000;
    position: relative;
    overflow: hidden;
    page-break-before: always;
}
.back-header {
    background-color: #3aa0d8;
    height: 10px;
    width: 100%;
}
.back-content {
    padding: 12px 15px;
    font-size: 8px;
    line-height: 1.3;
}
.back-content strong {
    display: block;
    font-weight: bold;
    margin-bottom: 3px;
}
.back-footer {
    background-color: #3aa0d8;
    height: 10px;
    width: 100%;
    position: absolute;
    bottom: 0;
}
</style>
</head>
<body>

<!-- ================= HALAMAN DEPAN ================= -->
<div class="card">
    <div class="header">
        <img src="file://{{ public_path('images/jogja.png') }}" class="logo-left" alt="Logo Jogja">
        <img src="file://{{ public_path('images/skaduta_logo.png') }}" class="logo-right" alt="Logo SMK">
        PEMERINTAH DAERAH ISTIMEWA YOGYAKARTA<br>
        DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA<br>
        <strong>SMK NEGERI 2 YOGYAKARTA</strong><br>
        <span style="font-size:6px;">Jl. P. Mangkubumi / AM Sangaji 47 Yogyakarta Telp. (0274) 513480 Fax. (0274) 512589</span><br>
        <span style="font-size:6px;">Pos-el: info@smk2-yk.sch.id | www.smk2-yk.sch.id</span>
    </div>

    <div class="judul">KARTU PELAJAR</div>

    <div class="content">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <!-- FOTO -->
                <td style="width: 2.4cm; text-align: center; vertical-align: top;">
                    <div style="width: 2.3cm; height: 2.8cm; border: 1px solid #000; margin-bottom: 2px;">
                        @if($siswa->foto)
                            <img src="file://{{ public_path('uploads/foto_siswa/'.$siswa->foto) }}" 
                                alt="Foto Siswa"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size:7px;">Foto Siswa</span>
                        @endif
                    </div>
                    <div style="transform:scale(0.75);transform-origin:top center;margin-top:1px;">
                        {!! DNS1D::getBarcodeHTML($siswa->nis, 'C39', 0.6, 10) !!}
                    </div>
                </td>

                <!-- DATA SISWA -->
                <td style="vertical-align: top; padding-left: 5px; padding-right: 5px; text-align: left;">
                    <table style="width: 100%; font-size: 7.5px; line-height: 1.05;">
                        <tr><td><strong>Nama</strong></td><td>:</td><td>{{ $siswa->nama_lengkap }}</td></tr>
                        <tr><td><strong>NIPD</strong></td><td>:</td><td>{{ $siswa->nis ?? '-' }}</td></tr>
                        <tr><td><strong>NISN</strong></td><td>:</td><td>{{ $siswa->nisn ?? '-' }}</td></tr>
                        <tr><td><strong>Tempat, Tgl Lahir</strong></td><td>:</td><td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ?? '-' }}</td></tr>
                        <tr><td><strong>Jenis Kelamin</strong></td><td>:</td><td>{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
                        <tr><td><strong>Agama</strong></td><td>:</td><td>{{ $siswa->agama ?? '-' }}</td></tr>
                        <tr><td><strong>Nama Orang Tua</strong></td><td>:</td><td>{{ $siswa->nama_ortu ?? '-' }}</td></tr>
                        <tr><td><strong>Alamat</strong></td><td>:</td><td>{{ $siswa->alamat ?? '-' }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Yogyakarta, Oktober 2025<br>
        <strong>Drs. Agus Waluyo M.Eng.</strong>
        NIP.196512271994121002
    </div>
    <div class="jurusan">DESAIN KOMUNIKASI VISUAL</div>
</div>
<div class="card-back">
    <div class="back-header"></div>
    <div class="back-content">
        <strong>KETENTUAN</strong>
        <ul style="margin: 0; padding-left: 12px;">
            <li>Kartu ini berlaku selama pemiliknya masih berstatus sebagai siswa SMK Negeri 2 Yogyakarta.</li>
            <li>Kartu ini tidak boleh dipindahtangankan, kepemilikan, dipinjamkan atau digunakan oleh orang lain.</li>
            <li>Apabila kehilangan atau menemukan kartu ini mohon segera menghubungi alamat/nomor telepon sekolah yang bersangkutan.</li>
            <li>Penyalahgunaan kartu ini akan ditindak sesuai peraturan yang berlaku.</li>
        </ul>
    </div>
    <div class="back-footer"></div>
</div>
</body>
</html>