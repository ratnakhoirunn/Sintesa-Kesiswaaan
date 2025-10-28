<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Siswa | Sintesa')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" href="{{ asset('images/skaduta_logo.png') }}" type="image/png"/>

    <style>
        body {
            font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f4f7f6;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #123B6B;
            color: #fff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
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
            font-size: 1rem;
            font-weight: 600;
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
        .sidebar nav ul li a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: #0d2a4a;
            border-left: 4px solid #4a90e2;
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
            margin-left: 250px;
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

        /* Card Dashboard Siswa */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .dashboard-card {
            background-color: #fff;
            border: 2px solid #123B6B; /* Border biru */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .dashboard-card h3 {
            margin-top: 0;
            font-size: 1rem;
            color: #123B6B;
            border-left: 5px solid #123B6B;
            padding-left: 10px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .dashboard-card p {
            margin: 0;
            color: #333;
            font-size: 0.9rem;
        }

        .dashboard-card .qr {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        /* Card Dashboard Siswa */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .dashboard-card {
            background-color: #fff;
            border: 2px solid #123B6B; /* Border biru */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .dashboard-card h3 {
            margin-top: 0;
            font-size: 1rem;
            color: #123B6B;
            border-left: 5px solid #123B6B;
            padding-left: 10px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .dashboard-card p {
            margin: 0;
            color: #333;
            font-size: 0.9rem;
        }

        .dashboard-card .qr {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .pagination svg {
            width: 1rem;
            height: 1rem;
            margin-top: -3px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="header">
            <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK">
            <h3>SINTESA SMKN 2 Yogyakarta</h3>
        </div>

        <div class="profile">
            <img src="{{ asset('images/profil2.jpg') }}" alt="Siswa">
            <div class="info">
                <h4>{{ Auth::user()->name ?? 'Siswa' }}</h4>
                <p>Siswa</p>
            </div>
        </div>

        <nav>
            <ul>
                <li>
                    <a href="{{ route('siswa.dashboard') }}" 
                       class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.datasiswa') }}" class="{{ request()->is('siswa/datasiswa') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Data Siswa
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.orangtua') }}" 
                       class="{{ request()->is('siswa/orangtua*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Data Orang Tua
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.kartu') }}" class="{{ request()->is('siswa/kartupelajar') ? 'active' : '' }}">
                        <i class="fas fa-id-card"></i> Kartu Pelajar
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.konseling') }}" 
                       class="{{ request()->is('siswa/konseling*') ? 'active' : '' }}">
                        <i class="fas fa-comments"></i> Bimbingan Konseling
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.dokumensiswa') }}" 
                       class="{{ request()->is('siswa/dokumensiswa*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Dokumen Siswa
                    </a>
                </li>
            </ul>
        </nav>

        <div class="logout">
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="navbar">
            <h2>@yield('page_title', 'Dashboard Siswa')</h2>
            <div class="user-profile">
                <img src="{{ asset('images/profil2.jpg') }}" alt="Profil Siswa">
            </div>
        </div>

        @yield('content')
    </div>
</body>
</html>
