<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar</title>

     <style>
    @page {
        size: 8.6cm 5.4cm;
        margin: 0;
    }

    html, body {
        width: 8.6cm;
        height: 5.4cm;
        margin: 0;
        padding: 0;
        background: white;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    body {
        font-family: 'ariel', sans-serif;
    }

    .card, .back {
        width: 8.6cm;
        height: 5.4cm;
        border: 1px solid #000;
        background: white;
        position: relative;
        overflow: hidden;
        page-break-after: always;
    }

    /* ===== HEADER ===== */
    .header {
        background-color: #3aa0d8;
        color: white;
        text-align: center;
        padding: 2px 5px;
        font-size: 4px;
        line-height: 1.2;
        position: relative;
    }

    .header strong {
        font-size: 6px;
    }

    .logo-left,
    .logo-right {
        position: absolute;
        top: 4px;
        width: 36px;
        height: 36px;
    }

    .logo-left { left: 10px; }
    .logo-right { right: 10px; }

    .header img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .aksara-jawa img {
        width: 100px;
        height: auto;
        display: block;
        margin: 2px auto 0 auto;
        margin-top: -3px;
    }

    .title {
        background-color: #5ec2f3;
        color: white;
        text-align: center;
        font-weight: bold;
        font-size: 7px;
        padding: 1px 0;
    }

    /* ===== ISI ===== */
    .content {
        display: flex;
        padding: 3px 6px;
        font-size: 7px;
        align-items: flex-start;
    }

    .foto {
        width: 1.9cm;
        height: 2.5cm;
        border: 1px solid #000;
        text-align: center;
        margin-right: 6px;
        overflow: hidden;
    }

    .foto img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .barcode {
        width: 1.9cm;
        height: 0.6cm;
        margin-top: 2px;
        text-align: center;
    }

    .barcode img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .data {
        flex: 1;
        line-height: 1.1;
        font-weight: bold;
    }

    .data table {
        width: 100%;
        font-size: 6.3px;
    }

    .data td {
        padding: 0;
        vertical-align: top;
    }

   /* ===== FOOTER ===== */
.footer {
    position: absolute;
    bottom: 12px;
    right: 10px; /* 🔹 geser footer ke kanan bawah */
    width: fit-content; /* 🔹 biar lebarnya pas sesuai isi teks */
    font-size: 5.5px;
    line-height: 1.3;
    text-align: left; /* 🔹 isi teks sejajar vertikal rata kiri */
}

/* Nama Kepala Sekolah */
.footer strong:first-of-type {
    display: block;
    margin-top: 25px; /* jarak antara jabatan dan nama */
}

/* NIP tanpa jarak tambahan */
.footer strong:last-of-type {
    display: block;
    margin-top: 0;
}

/* Tambahan sedikit jarak dari tepi kanan */
.footer div,
.footer strong {
    margin: 0;
}

/* ===== BARIS BAWAH: Nama Jurusan ===== */
.jurusan {
    position: absolute;
    bottom: 0;
    width: 100%;
    background-color: #00a651;
    color: white;
    text-align: center;
    font-size: 8px;
    font-weight: bold;
    padding: 2px 0;
}



    /* ===== BELAKANG ===== */
    .back-header {
        background-color: #3aa0d8;
        color: white;
        text-align: center;
        font-weight: bold;
        font-size: 8px;
        padding: 2px 0;
    }

    .rules {
        padding: 6px 12px;
        font-size: 8px;
        line-height: 1.3;
        text-align: justify;
        margin-left: 4px;
    }

    .blue-line {
        width: 100%;
        height: 20px;
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: #2196F3;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .card, .back {
            overflow: visible !important;
        }
        img {
            display: block !important;
            visibility: visible !important;
        }
    }

    @media print {
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .card, .back {
        overflow: visible !important;
    }
    img {
        display: block !important;
        visibility: visible !important;
    }
}
</style> 
<body>

    {{-- 📄 HALAMAN DEPAN --}}
    <div class="card">
        <div class="header">
            <div class="logo-left">
                <img src="{{ asset('images/jogja.png') }}" alt="Logo Jogja">
            </div>
            <div class="logo-right">
                <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK">
            </div>

            PEMERINTAH DAERAH DAERAH ISTIMEWA YOGYAKARTA<br>
            DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA<br>
            BALAI PENDIDIKAN MENENGAH KOTA YOGYAKARTA<br>
            <strong>SMK NEGERI 2 YOGYAKARTA</strong><br>
            <div class="aksara-jawa">
                <img src="{{ asset('images/aksara_jawa.png') }}" alt="Aksara Jawa">
            </div>
            <span style="font-size:4px;">
                Jl. P.Mangkubumi / AM.Sangaji 47 55233 Telp. (0274) 513490 Fax. (0274) 512639<br>
                Pos-el: info@smk2-yk.sch.id | www.smk2-yk.sch.id
            </span>
        </div>

        <div class="title">KARTU PELAJAR</div>

        <div class="content">
            <div>
                <div class="foto">
                    @if($siswa->foto)
                        <img src="{{ asset('uploads/foto_siswa/'.$siswa->foto) }}" alt="Foto Siswa">
                    @else
                        <span style="font-size:7px;">Foto Siswa</span>
                    @endif
                </div>
                <div class="barcode">
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($siswa->nis, 'C39', 1, 30) }}" alt="Barcode">
                </div>
            </div>

            <div class="data">
                <table>
                    <tr><td>Nama</td><td>:</td><td>{{ strtoupper($siswa->nama_lengkap) }}</td></tr>
                    <tr><td>NIPD</td><td>:</td><td>{{ $siswa->nis }}</td></tr>
                    <tr><td>NISN</td><td>:</td><td>{{ $siswa->nisn }}</td></tr>
                    <tr><td>Tempat, Tgl Lahir</td><td>:</td><td>{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $siswa->jenis_kelamin }}</td></tr>
                    <tr><td>Agama</td><td>:</td><td>{{ $siswa->agama }}</td></tr>
                    <tr><td>Nama Orang Tua</td><td>:</td><td>{{ $siswa->nama_ortu }}</td></tr>
                    <tr><td>Alamat</td><td>:</td><td>{{ $siswa->alamat }}</td></tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <div>Yogyakarta, Agustus 2025<br>
            Kepala Sekolah</div>
            <strong>Drs. Agus Waluyo M.Eng.</strong>
            <strong>NIP.196512271994121002</strong>
        </div>


        <div class="jurusan">DESAIN KOMUNIKASI VISUAL</div>
    </div>

    {{-- 📘 HALAMAN BELAKANG --}}
    <div class="back">
        <div class="back-header">KETENTUAN</div>
        <div class="rules">
            <li>Kartu ini berlaku selama pemiliknya masih berstatus sebagai siswa SMK Negeri 2 Yogyakarta.</li>
            <li>Kartu ini tidak boleh dipindahtangankan, dipinjamkan, atau digunakan oleh orang lain.</li>
            <li>Apabila kehilangan atau menemukan kartu ini mohon segera menghubungi pihak sekolah.</li>
            <li>Pemegang kartu ini wajib menjaga kartu agar tetap bersih dan tidak rusak.</li>
            <li>Penyalahgunaan kartu akan ditindak sesuai peraturan yang berlaku.</li>
        </div>
        <div class="blue-line"></div>
    </div>

</body>
</html>