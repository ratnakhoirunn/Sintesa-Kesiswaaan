<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            background: white;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 10mm;
            flex-wrap: wrap;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .card, .back {
            width: 8.6cm;
            height: 5.4cm;
            border: 1px solid #000;
            background: white;
            position: relative;
            overflow: hidden;
            font-family: Arial, sans-serif;
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

        .header strong { font-size: 6px; }

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
            font-size: 8px;
            padding: 1px 0;
        }

        /* ===== ISI ===== */
        .content {
            display: flex;
            padding: 3px 6px;
            font-size: 9px;
            align-items: flex-start;
        }

        .left-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-right: -9px;
            margin-left: 10px;
            width: 2.3cm;
        }

        .foto {
            width: 1.9cm;
            height: 2.5cm;
            border: 1px solid #000;
            text-align: center;
            overflow: hidden;
            background: #eee;
        }

        .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .barcode {
            width: 2.3cm;
            height: 1.2cm;
            margin-top: -3px;
            text-align: center;
        }

        .barcode img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .data {
            flex: 1;
            line-height: 1.1;
            font-weight: bold;
        }

        .data table {
            width: 100%;
            font-size: 6px;
        }

        .data td {
            padding: 0;
            vertical-align: top;
        }

        .data td:nth-child(1) {
            width: 15%;
            white-space: nowrap;
        }

        .data td:nth-child(2) {
            width: 2%;
            text-align: center;
        }

        .data td:nth-child(3) {
            width: 65%;
            white-space: normal;
        }

        /* ===== FOOTER ===== */
        .footer {
            position: absolute;
            bottom: 17px;
            right: 10px;
            font-size: 5.3px;
            line-height: 1.3;
            text-align: left;
        }

        .ttd-single {
            position: relative;
            margin-top: -8px;
            margin-bottom: -4px;
            text-align: right;
            margin-right: 10px;
        }

        .ttd-single .ttd-cap {
            width: 60px;
            opacity: 0.9;
            display: inline-block;
            transform: translateX(-25px) rotate(-3deg);
        }

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
                justify-content: center;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    $bulanFooter = request('bulan');
    if (!empty($bulanFooter)) {
        try {
            $date = Carbon::parse($bulanFooter);
            $bulanIndonesia = $date->translatedFormat('F');
        } catch (\Exception $e) {
            $bulanIndonesia = $bulanFooter;
        }
    } else {
        $bulanIndonesia = Carbon::now()->translatedFormat('F');
    }

    $tahunFooter = request('tahun') ?? date('Y');
@endphp

{{-- ===== HALAMAN DEPAN ===== --}}
<div class="card">

    <div class="header">
        <div class="logo-left">
            <img src="{{ asset('images/jogja.png') }}">
        </div>
        <div class="logo-right">
            <img src="{{ asset('images/skaduta_logo.png') }}">
        </div>

        PEMERINTAH DAERAH DAERAH ISTIMEWA YOGYAKARTA<br>
        DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA<br>
        BALAI PENDIDIKAN MENENGAH KOTA YOGYAKARTA<br>
        <strong>SMK NEGERI 2 YOGYAKARTA</strong><br>

        <div class="aksara-jawa">
            <img src="{{ asset('images/aksara_jawa.png') }}">
        </div>

        <span style="font-size:4px;">
            Jl. P.Mangkubumi / AM.Sangaji 47 55233 Telp. (0274) 513490 Fax. (0274) 512639<br>
            Pos-el: info@smk2-yk.sch.id | www.smk2-yk.sch.id
        </span>
    </div>

    <div class="title">KARTU PELAJAR</div>

    <div class="content">

        <div class="left-section">
            <div class="foto">
                @if($siswa->foto)
                    <img src="{{ asset('uploads/foto_siswa/'.$siswa->foto) }}">
                @else
                    <span style="font-size:7px; display:block; padding-top:1cm;">Foto Siswa</span>
                @endif
            </div>

            <div class="barcode">
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($siswa->nis, 'C39', 1.5, 45) }}">
            </div>
        </div>

        <div class="data">
            <table>
                <tr><td>Nama</td><td>:</td><td>{{ strtoupper($siswa->nama_lengkap) }}</td></tr>
                <tr><td>NIPD</td><td>:</td><td>{{ $siswa->nis }}</td></tr>
                <tr><td>NISN</td><td>:</td><td>{{ $siswa->nisn }}</td></tr>
                <tr><td>Tempat, Tgl Lahir</td><td>:</td>
                    <td>{{ $siswa->tempat_lahir }}, {{ Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $siswa->jenis_kelamin }}</td></tr>
                <tr><td>Agama</td><td>:</td><td>{{ $siswa->agama }}</td></tr>
                <tr><td>Nama Orang Tua</td><td>:</td><td>{{ $siswa->nama_ortu }}</td></tr>
                <tr><td>Alamat</td><td>:</td><td>{{ $siswa->alamat }}</td></tr>
            </table>
        </div>

    </div>

    <div class="footer">
        <div>
            Yogyakarta, {{ $bulanIndonesia }} {{ $tahunFooter }}<br>
            Kepala Sekolah
        </div>

        <div class="ttd-single">
            @php
                $capKepsek = request('cap_kepsek') ?: asset('images/ttd_cap_kepsek.png');
            @endphp
            <img src="{{ $capKepsek }}" class="ttd-cap">
        </div>

        <strong>{{ request('nama_kepsek') ?? 'Drs. Agus Waluyo, M.Eng.' }}</strong>
        <div>NIP. {{ request('nip') ?? '196512271994121002' }}</div>
    </div>

    <div class="jurusan">{{ strtoupper($siswa->jurusan) }}</div>

</div>

{{-- ===== HALAMAN BELAKANG ===== --}}
<div class="back">
    <div class="back-header">KETENTUAN</div>
    <div class="rules">
        <li>Kartu ini berlaku selama pemiliknya masih berstatus sebagai siswa SMK Negeri 2 Yogyakarta.</li>
        <li>Kartu ini tidak boleh dipindahtangankan.</li>
        <li>Apabila kehilangan segera lapor sekolah.</li>
        <li>Wajib menjaga kartu tetap baik.</li>
        <li>Penyalahgunaan akan ditindak.</li>
    </div>
    <div class="blue-line"></div>
</div>

</body>
</html>
