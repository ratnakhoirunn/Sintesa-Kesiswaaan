<?php
    header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar - {{ $siswa->nama_lengkap }}</title>
    <style>
        @page {
            size: A6 landscape;
            margin: 10mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .kartu-container {
            width: 148mm;
            height: 105mm;
            border: 2px solid #000;
            padding: 10px 20px;
            position: relative;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }

        .header img {
            width: 60px;
            height: 60px;
            position: absolute;
            top: 12px;
            left: 20px;
        }

        .header h1, .header h2, .header p {
            margin: 0;
            padding: 0;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 16px;
            margin-top: 2px;
        }

        .header p {
            font-size: 12px;
        }

        .foto {
            width: 100px;
            height: 120px;
            border: 2px solid #000;
            object-fit: cover;
            position: absolute;
            right: 20px;
            top: 80px;
        }

        table {
            font-size: 13px;
            line-height: 1.5;
            margin-left: 20px;
        }

        td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: right;
            padding-right: 40px;
            font-size: 12px;
        }

        .footer p {
            margin: 2px 0;
        }

        .ttd {
            text-align: center;
            margin-top: 15px;
        }

        .btn-print {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 6px 12px;
            background: #1e3a67;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        @media print {
            .btn-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()">🖨️ Cetak</button>

<div class="kartu-container">
    <div class="header">
        <img src="{{ asset('images/logo_smk.png') }}" alt="Logo Sekolah">
        <h1>PEMERINTAH DAERAH DIY</h1>
        <h2>DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA</h2>
        <h2>SMK NEGERI 2 YOGYAKARTA</h2>
        <p>Jl. A.M Sangaji No.47 Yogyakarta 55233 Telp. (0274) 513202</p>
        <p>Website: www.smkn2yk.sch.id Email: info@smkn2yk.sch.id</p>
    </div>

    <table>
        <tr>
            <td><strong>Nama</strong></td>
            <td>: {{ $siswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td><strong>NIPD</strong></td>
            <td>: {{ $siswa->nis }}</td>
        </tr>
        <tr>
            <td><strong>NISN</strong></td>
            <td>: {{ $siswa->nisn }}</td>
        </tr>
        <tr>
            <td><strong>TTL</strong></td>
            <td>: {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Kelamin</strong></td>
            <td>: {{ $siswa->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td><strong>Agama</strong></td>
            <td>: {{ $siswa->agama }}</td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td>: {{ $siswa->alamat }}</td>
        </tr>
        <tr>
            <td><strong>Nama Orang Tua</strong></td>
            <td>: {{ $siswa->nama_ortu ?? '-' }}</td>
        </tr>
    </table>

    <img class="foto" src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('images/student.png') }}" alt="Foto Siswa">

    <div class="footer">
        <p>Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
        <div class="ttd">
            <p><strong>Kepala Sekolah</strong></p>
            <br><br>
            <p><strong>Drs. Suripto, M.Pd</strong></p>
            <p>NIP. 19601015 198803 1 003</p>
        </div>
    </div>
</div>

</body>
</html>
