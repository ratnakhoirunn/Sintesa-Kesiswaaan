<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar - {{ $siswa->nama }}</title>
    <style>
        @page { margin: 0; }
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .kartu {
            width: 323px;
            height: 204px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background: #f8f9fa;
        }

        /* HEADER BIRU */
        .header {
            background-color: #0073cf;
            color: white;
            text-align: center;
            font-size: 6.5pt;
            line-height: 1.3;
            padding: 5px 5px 2px;
            position: relative;
        }

        .header img {
            position: absolute;
            top: 4px;
            width: 25px;
        }
        .logo-left { left: 8px; }
        .logo-right { right: 8px; }

        .judul {
            font-weight: bold;
            font-size: 7.5pt;
            margin-top: 2px;
        }

        /* BAGIAN ISI */
        .isi {
            padding: 5px 8px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .foto {
            width: 75px;
            text-align: center;
        }

        .foto img {
            width: 65px;
            height: 80px;
            border: 1px solid #ccc;
            object-fit: cover;
        }

        .barcode {
            margin-top: 6px;
        }

        .barcode img {
            width: 65px;
            height: 15px;
        }

        .biodata {
            font-size: 7pt;
            line-height: 1.3;
            width: 65%;
        }

        .biodata td {
            padding: 1px 2px;
            vertical-align: top;
        }

        /* FOOTER KEPSEK */
        .footer {
            font-size: 6pt;
            text-align: right;
            padding-right: 10px;
            margin-top: -5px;
        }

        .footer strong {
            font-size: 6.5pt;
        }

        /* BAGIAN JURUSAN HIJAU */
        .jurusan {
            background-color: #00a859;
            color: white;
            text-align: center;
            font-weight: bold;
            font-size: 7pt;
            padding: 2px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="kartu">
    <div class="header">
        <img src="{{ public_path('images/logo-left.png') }}" class="logo-left">
        <img src="{{ public_path('images/logo-right.png') }}" class="logo-right">
        <div>PEMERINTAH DAERAH ISTIMEWA YOGYAKARTA<br>
        DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA<br>
        BALAI PENDIDIKAN MENENGAH KOTA YOGYAKARTA</div>
        <div class="judul">SMK NEGERI 2 YOGYAKARTA</div>
        <div style="font-size:6pt;">Jl. P. Mangkubumi / A.M Sangaji 47 Yogyakarta Telp. (0274) 513480 Fax. (0274) 512839</div>
    </div>

    <div class="isi">
        <div class="foto">
            <img src="{{ public_path('images/foto-siswa/' . ($siswa->foto ?? 'default.jpg')) }}" alt="Foto Siswa">
            <div class="barcode">
                <img src="{{ public_path('images/barcode.png') }}" alt="Barcode">
            </div>
        </div>

        <table class="biodata">
            <tr><td>Nama</td><td>: <strong>{{ strtoupper($siswa->nama) }}</strong></td></tr>
            <tr><td>NIPD</td><td>: {{ $siswa->nipd }}</td></tr>
            <tr><td>NISN</td><td>: {{ $siswa->nisn ?? '-' }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>: {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin }}</td></tr>
            <tr><td>Agama</td><td>: {{ $siswa->agama }}</td></tr>
            <tr><td>Nama Orang Tua</td><td>: {{ $siswa->orangTua->nama ?? '-' }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $siswa->alamat }}</td></tr>
        </table>
    </div>

    <div class="footer">
        Yogyakarta, {{ now()->translatedFormat('F Y') }}<br>
        Kepala Sekolah<br><br><br>
        <strong>Drs. Agus Waluyo, M.Eng</strong><br>
        NIP. 196512271994121002
    </div>

    <div class="jurusan">
        DESAIN KOMUNIKASI VISUAL
    </div>
</div>

</body>

</html>

