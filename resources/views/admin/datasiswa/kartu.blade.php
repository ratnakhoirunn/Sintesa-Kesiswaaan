<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d2ebff;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 10px;
            width: 300px;
            height: 180px;
        }
        .header { text-align: center; font-size: 12px; font-weight: bold; }
        .photo { float: left; margin-right: 10px; }
        .data { font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        PEMERINTAH DAERAH DIY<br>
        DINAS PENDIDIKAN MENENGAH KOTA YOGYAKARTA<br>
        SMKN 2 YOGYAKARTA
    </div>
    <div class="photo">
        <img src="{{ public_path('storage/'.$siswa->foto) }}" width="60" height="80">
    </div>
    <div class="data">
        <p><strong>Nama:</strong> {{ $siswa->nama_lengkap }}</p>
        <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
        <p><strong>TTL:</strong> {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
        <p><strong>Agama:</strong> {{ $siswa->agama }}</p>
        <p><strong>Orang Tua:</strong> {{ $siswa->nama_ortu }}</p>
        <p><strong>Alamat:</strong> {{ $siswa->alamat }}</p>
    </div>
</body>
</html>
