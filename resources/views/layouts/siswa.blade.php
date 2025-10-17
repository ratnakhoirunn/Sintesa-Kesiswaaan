<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Siswa | SINTESA')</title>
    <link rel="icon" href="{{ asset('images/skaduta_logo.png') }}" type="image/png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background-color: #f4f7fb;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: #003366;
            color: #fff;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
        }

        .sidebar-header {
            background-color: #ffffff;
            color: #003366;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
        }

        .sidebar-header img {
            width: 40px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .sidebar-profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-profile img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid #fff;
            margin-bottom: 10px;
        }

        .sidebar-profile h4 {
            margin: 0;
            font-size: 16px;
        }

        .sidebar-profile p {
            margin: 5px 0 0;
            color: #d1e3ff;
            font-size: 13px;
        }

        .sidebar nav {
            flex: 1;
            padding-top: 10px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .sidebar nav a i {
            margin-right: 10px;
            width: 18px;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background-color: #0055a5;
            border-left: 4px solid #00b4ff;
            padding-left: 21px;
        }

        .sidebar .logout {
            padding: 15px 25px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar .logout a {
            background: #ffffff;
            color: #003366;
            font-weight: bold;
            display: block;
            text-align: center;
            padding: 10px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar .logout a:hover {
            background: #dbe9ff;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 25px;
        }

        .navbar {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .navbar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .content {
            margin-top: 25px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK">
            <span>SINTESA SMK N 2 Yogyakarta</span>
        </div>

        <div class="sidebar-profile">
            <img src="{{ asset('images/siswa.jpg') }}" alt="Foto Siswa">
            <h4>{{ Auth::user()->name ?? 'Ratna Khoirun Nisa' }}</h4>
            <p>{{ Auth::user()->nis ?? '0800891' }}</p>
        </div>

        <nav>
            <a href="{{ route('siswa.dashboard') }}" class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('siswa.data') }}" class="{{ request()->is('siswa/data*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i> Data Siswa</a>
            <a href="{{ route('siswa.orangtua') }}" class="{{ request()->is('siswa/orangtua*') ? 'active' : '' }}"><i class="fas fa-users"></i> Data Orang Tua</a>
            <a href="{{ route('siswa.kartu') }}" class="{{ request()->is('siswa/kartu*') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Kartu Pelajar</a>
            <a href="#" class="{{ request()->is('siswa/konseling*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Bimbingan Konseling</a>
            <a href="#" class="{{ request()->is('siswa/administrasi*') ? 'active' : '' }}"><i class="fas fa-book"></i> Administrasi Siswa</a>
        </nav>

        <div class="logout">
            <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="navbar">
            <h2>@yield('page_title', 'Dashboard Siswa')</h2>
            <img src="{{ asset('images/siswa.jpg') }}" alt="Siswa">
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>
