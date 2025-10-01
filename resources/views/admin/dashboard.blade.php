<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Sintesa SMKN 2 Yogyakarta</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f4f7f6; /* Warna latar belakang umum */
            display: flex; /* Mengaktifkan Flexbox untuk layout utama */
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #17375d; /* Warna biru gelap */
            color: #fff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed; /* Sidebar tetap di tempatnya */
            height: 100%;
            overflow-y: auto; /* Jika konten sidebar banyak, bisa discroll */
        }
        .sidebar .header {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .header img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .sidebar .header h3 {
            margin: 0;
            font-size: 1.1rem;
        }
        .sidebar .profile {
            display: flex;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 20px;
        }
        .sidebar .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid #fff;
        }
        .sidebar .profile .info h4 {
            margin: 0;
            font-size: 1rem;
        }
        .sidebar .profile .info p {
            margin: 0;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
        }
        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar nav ul li {
            margin-bottom: 5px;
        }
        .sidebar nav ul li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }
        .sidebar nav ul li a i { /* Untuk ikon */
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: #0d2a4a; /* Warna hover/aktif */
            border-left: 4px solid #4a90e2; /* Garis biru aktif */
        }
        .sidebar nav ul li.dropdown .dropdown-toggle {
            position: relative;
        }
        .sidebar nav ul li.dropdown .dropdown-toggle i.fa-caret-down {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
        }
        .sidebar nav ul li.dropdown .dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #0d2a4a; /* Warna submenu */
            display: none; /* Sembunyikan secara default */
        }
        .sidebar nav ul li.dropdown.active .dropdown-menu {
            display: block; /* Tampilkan jika dropdown aktif */
        }
        .sidebar nav ul li.dropdown .dropdown-menu li a {
            padding-left: 45px; /* Indentasi submenu */
            font-size: 0.9rem;
        }
        .sidebar .logout {
            margin-top: auto; /* Dorong ke bawah */
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar .logout a {
            display: block;
            text-align: center;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            background-color: #e74c3c; /* Warna tombol logout */
            margin: 0 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar .logout a:hover {
            background-color: #c0392b;
        }


        /* Main Content */
        .main-content {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            flex-grow: 1;
            padding: 30px;
            background-color: #f4f7f6;
        }
        .navbar {
            background-color: #fff;
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h2 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }
        .navbar .user-profile {
            display: flex;
            align-items: center;
        }
        .navbar .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-left: 15px;
        }

        .welcome-card {
            background-color: #17375d; /* Biru gelap */
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .welcome-card h1 {
            margin: 0 0 5px;
            font-size: 1.8rem;
        }
        .welcome-card p {
            margin: 0;
            font-size: 1rem;
            color: rgba(255,255,255,0.8);
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .info-card .content {
            text-align: left;
        }
        .info-card .content p {
            margin: 0;
            font-size: 0.9rem;
            color: #777;
        }
        .info-card .content h3 {
            margin: 5px 0 0;
            font-size: 1.6rem;
            color: #333;
        }
        .info-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #e0f0ff; /* Warna latar belakang ikon */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .info-card .icon img {
            width: 30px;
            height: 30px;
        }

        /* Grafik */
        .chart-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .chart-card h3 {
            margin-top: 0;
            color: #333;
            font-size: 1.1rem;
        }
        /* Style untuk chart, butuh library JS Chart.js */
        .chart-container {
            height: 300px;
            width: 100%;
        }

        /* Dokumen Siswa & Tindakan Konseling Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Grafik lebih lebar dari sidebar kanan */
            gap: 30px;
        }
        .right-column-cards {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .admin-action-card, .konseling-action-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .admin-action-card h3, .konseling-action-card h3 {
            margin-top: 0;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
        .action-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.95rem;
            color: #555;
        }
        .action-item img {
            width: 25px;
            height: 25px;
            margin-right: 15px;
        }
        .action-item:last-child {
            margin-bottom: 0;
        }
        .konseling-action-card .notification-item {
            display: flex;
            align-items: center;
            background-color: #fff3cd; /* Warna kuning */
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #664d03;
        }
        .konseling-action-card .notification-item i { /* Untuk ikon */
            margin-right: 15px;
            font-size: 1.2rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="header">
            <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK">
            <h3>Sintesa SMKN 2 Yogyakarta</h3>
        </div>
        <div class="profile">
            <img src="{{ asset('images/profil2.jpg') }}" alt="Admin Profile">
            <div class="info">
                <h4>Admin</h4>
                <p>Administrator</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

                <li><a href="#"><i class="fas fa-users"></i> Data Siswa</a></li>

                <li><a href="#"><i class="fas fa-id-card"></i> Kartu Pelajar</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"><i class="fas fa-comments"></i> Bimbingan Konseling <i class="fas fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Konseling</a></li>
                        <li><a href="#">Keterlambatan</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-file-alt"></i> Dokumen Siswa</a></li>
                <li><a href="#"><i class="fas fa-user-cog"></i> Manajemen Role</a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
    </div>

    <div class="main-content">
        <div class="navbar">
            <h2>Dashboard Admin</h2>
            <div class="user-profile">
                <img src="{{ asset('images/profil2.jpg') }}" alt="Admin Profile">
            </div>
        </div>

        <div class="welcome-card">
            <h1>Selamat Datang, Admin</h1>
            <p>Kelola Data Siswa SMKN 2 Yogyakarta</p>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <div class="content">
                    <p>Total Siswa Aktif</p>
                    <h3>650</h3>
                </div>
                <div class="icon">
                    <img src="{{ asset('images/toga1.png') }}" alt="Total Siswa">
                </div>
            </div>
            <div class="info-card">
                <div class="content">
                    <p>Total Admin</p>
                    <h3>3</h3>
                </div>
                <div class="icon">
                    <img src="{{ asset('images/totaladmin.png') }}" alt="Total Admin">
                </div>
            </div>
            <div class="info-card">
                <div class="content">
                    <p>Jumlah Kunjungan Konseling</p>
                    <h3>10</h3>
                </div>
                <div class="icon">
                    <img src="{{ asset('images/totalkonsel.png') }}" alt="Jumlah Konseling">
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="left-grid-column">
                <div class="chart-card">
                    <h3>Grafik Siswa Per Jurusan</h3>
                    <div class="chart-container">
                        <canvas id="siswaPerJurusanChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="right-column-cards">
                <div class="admin-action-card">
                    <h3>Dokumen Siswa</h3>
                    <div class="action-item">
                        <img src="{{ asset('images/dok_lengkap.jpeg') }}" alt="Dokumen Lengkap">
                        <span>Dokumen Lengkap</span>
                    </div>
                    <div class="action-item">
                        <img src="{{ asset('images/dok_sedang.png') }}" alt="Sedang">
                        <span>Sedang</span>
                    </div>
                    <div class="action-item">
                        <img src="{{ asset('images/dok_berat.png') }}" alt="Berat">
                        <span>Berat</span>
                    </div>
                </div>
                <div class="konseling-action-card">
                    <h3>Tindakan Konseling</h3>
                    <div class="notification-item">
                        <i class="fas fa-bell"></i>
                        <span>Jadwal Konseling Menunggu<br>5 Permintaan Masuk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script untuk dropdown sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parentLi = this.closest('li.dropdown');
                    parentLi.classList.toggle('active');
                });
            }

            // Contoh inisialisasi Chart.js (Anda perlu mengimpor Chart.js di sini atau di head)
            // const ctx = document.getElementById('siswaPerJurusanChart');
            // if (ctx) {
            //     new Chart(ctx, {
            //         type: 'bar', // atau 'line', 'pie'
            //         data: {
            //             labels: ['Teknik', 'Desain', 'Manajemen', 'Otomotif', 'Teknik Audio', 'Sistem', 'Desain'],
            //             datasets: [{
            //                 label: 'Jumlah Siswa',
            //                 data: [150, 120, 180, 90, 110, 200, 130], // Data contoh
            //                 backgroundColor: 'rgba(74, 144, 226, 0.7)',
            //                 borderColor: 'rgba(74, 144, 226, 1)',
            //                 borderWidth: 1
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             maintainAspectRatio: false,
            //             scales: {
            //                 y: {
            //                     beginAtZero: true
            //                 }
            //             }
            //         }
            //     });
            // }
        });
    </script>
    </body>
</html>