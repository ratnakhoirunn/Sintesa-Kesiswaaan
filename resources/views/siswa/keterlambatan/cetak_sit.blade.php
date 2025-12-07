<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterlambatan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.6;
        }
        /* Style untuk Konten Surat Keterlambatan */
        .content-surat { 
            margin: 0 50px;
        }
        .footer-surat {
            text-align: right;
            margin-top: 40px;
        }
        
        /* ===== STYLE KOP SURAT BARU ===== */
        .header-kop {
            text-align: center;
            border-bottom: none; 
            padding: 10px 50px 5px 50px; /* Padding untuk ruang logo */
            margin-bottom: 20px;
            position: relative;
            font-family: Arial, sans-serif;
            border-bottom: 3px solid black;
        }
        .header-kop .title-utama { 
            font-size: 16px; 
            font-weight: bold; 
            margin-top: -5px; 
        }
        .header-kop .title-pendukung { 
            font-size: 12px; 
            line-height: 1.2; 
        }
        
        .logo-left,
        .logo-right {
            position: absolute;
            top: 10px; 
            width: 70px;
            height: 70px;
        }
        .logo-left { left: 50px; }
        .logo-right { right: 50px; }
        
        /* Agar gambar logo tidak ada background kotak putih di PDF/Browser */
        .header-kop img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        
        .aksara-jawa-kop img {
            width: 200px;
            height: auto;
            display: block;
            margin: 5px auto;
        }
        .alamat-kop {
            font-size: 11px;
            line-height: 1.2;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    @php
    use Carbon\Carbon;
    
    // 1. Pastikan Carbon menggunakan locale Bahasa Indonesia
    Carbon::setLocale('id');

    // 2. Fungsi helper untuk Base64 Encoding (PENTING untuk PDF/Gambar)
    if (!function_exists('getBase64Image')) {
        function getBase64Image($path) {
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                // Menambahkan data:image/png;base64,
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return '';
        }
    }
    
    // Definisikan path gambar (Asumsi: di public/images)
    $logoJogjaPath = public_path('images/jogja.png');
    $logoSmkPath = public_path('images/skaduta_logo.png');
    $aksaraJawaPath = public_path('images/aksara_jawa.png');

    // ... (Logika footer tetap sama)
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

    {{-- KOP SURAT BARU DENGAN BACKGROUND BIRU --}}
    <div class="header-kop">
        
        <div class="logo-left">
            <img src="{{ getBase64Image($logoJogjaPath) }}" alt="Logo DIY">
        </div>
        <div class="logo-right">
            <img src="{{ getBase64Image($logoSmkPath) }}" alt="Logo SMK">
        </div>
        
        <p class="title-pendukung">
            PEMERINTAH DAERAH DAERAH ISTIMEWA YOGYAKARTA<br>
            DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA<br>
            BALAI PENDIDIKAN MENENGAH KOTA YOGYAKARTA
        </p>
        <p class="title-utama">SMK NEGERI 2 YOGYAKARTA</p>
        
        <div class="aksara-jawa-kop">
            <img src="{{ getBase64Image($aksaraJawaPath) }}" alt="Aksara Jawa">
        </div>
        
        <p class="alamat-kop">
            Jl. P.Mangkubumi / AM.Sangaji 47 55233 Telp. (0274) 513490 Fax. (0274) 512639<br>
            Pos-el: info@smk2-yk.sch.id | www.smk2-yk.sch.id
        </p>
    </div>

    {{-- JUDUL DITEMPATKAN DI BAWAH KOP --}}
    <h2 style="text-align:center; margin-top: 20px;">SURAT KETERLAMBATAN</h2>

    <div class="content-surat">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
        <table style="margin-left: 20px;">
            <tr><td>Nama Siswa</td><td>:</td><td>{{ $data->nama_siswa }}</td></tr>
            <tr><td>NIS</td><td>:</td><td>{{ $data->nis }}</td></tr>
            <tr><td>Tanggal</td><td>:</td><td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}</td></tr>
            <tr><td>Jam Datang</td><td>:</td><td>{{ $data->jam_datang }}</td></tr>
            <tr><td>Menit Terlambat</td><td>:</td><td>{{ $data->menit_terlambat }} menit</td></tr>
            <tr><td>Keterangan</td><td>:</td><td>{{ $data->keterangan }}</td></tr>
        </table>

        <p style="margin-top: 20px;">Demikian surat keterangan keterlambatan ini dibuat untuk digunakan sebagaimana mestinya.</p>

        <div class="footer-surat">
            <p>Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Guru BK</p>
            <br><br>
            <p><strong>________________________</strong></p>
        </div>
    </div>
</body>
</html>