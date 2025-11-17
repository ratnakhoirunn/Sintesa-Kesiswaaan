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
        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .content {
            margin: 0 50px;
        }
        .footer {
            text-align: right;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT KETERLAMBATAN</h2>
        <p>SMKN 2 Yogyakarta</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
        <table style="margin-left: 20px;">
            <tr><td>Nama Siswa</td><td>:</td><td>{{ $data->nama_siswa }}</td></tr>
            <tr><td>NIS</td><td>:</td><td>{{ $data->nis }}</td></tr>
            <tr><td>Tanggal</td><td>:</td><td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}</td></tr>
            <tr><td>Jam Datang</td><td>:</td><td>{{ $data->jam_datang }}</td></tr>
            <tr><td>Menit Terlambat</td><td>:</td><td>{{ $data->menit_terlambat }} menit</td></tr>
            <tr><td>Keterangan</td><td>:</td><td>{{ $data->keterangan }}</td></tr>
        </table>

        <p style="margin-top: 20px;">Demikian surat keterangan keterlambatan ini dibuat untuk digunakan sebagaimana mestinya.</p>

        <div class="footer">
            <p>Yogyakarta, {{ now()->format('d F Y') }}</p>
            <p>Guru BK</p>
            <br><br>
            <p><strong>________________________</strong></p>
        </div>
    </div>
</body>
</html>
