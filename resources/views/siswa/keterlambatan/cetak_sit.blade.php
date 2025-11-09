<!DOCTYPE html>
<html>
<head>
    <title>Cetak SIT</title>
    <style>
        body { font-family: Arial; padding: 20px; }
    </style>
</head>
<body>
    <h3>Surat Izin Terlambat</h3>

    <p>Nama: {{ $data->siswa->nama_lengkap }}</p>
    <p>Kelas: {{ $data->siswa->rombel }}</p>
    <p>Tanggal: {{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</p>
    <p>Waktu: {{ \Carbon\Carbon::parse($data->jam_datang)->format('H:i') }}</p>
    <p>Alasan: {{ $data->keterangan }}</p>

    <script>
        window.print();
    </script>
</body>
</html>
