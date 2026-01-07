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
            width: 300px;
            background-color: #17375d;
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
        flex-direction: column; /* ⬅️ susun vertikal */
        align-items: center; /* ⬅️ tengah horizontal */
        text-align: center; /* ⬅️ teks di tengah */
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
        margin: 10px 0 2px;
        font-size: 12px;
        font-weight: 550;
        color: #fff;
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
        align-items: center; /* ✅ pastikan ini ada */
        gap: 10px; /* ✅ tambahkan agar jarak icon dan teks lebih seimbang */
        padding: 12px 20px;
        color: #fff;
        text-decoration: none;
        font-size: 0.95rem;
        line-height: 1; /* ✅ tambahkan agar teks tidak turun */
        transition: background-color 0.3s;
}

        .sidebar nav ul li a i {
            font-size: 1rem; /* ✅ lebih kecil sedikit dari teks */
            line-height: 1;  /* ✅ biar sejajar vertikal */
            display: flex;
            align-items: center;
}

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: #0d2a4a;
            border-left: 4px solid #4a90e2;
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
            margin-left: 300px;
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

        /* 🔔 Animasi masuk lembut */
@keyframes slideDown {
    0% { transform: translateY(-20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}

.alert-password {
    background: #fffbe6;
    border-left: 6px solid #facc15;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 25px;
    animation: slideDown 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 15px;
    width: 100%;
}

.alert-icon {
    font-size: 28px;
    color: #d97706;
    flex-shrink: 0;
}

.alert-text h4 {
    margin: 0;
    font-weight: 700;
    color: #92400e;
}

.alert-text p {
    margin: 4px 0 8px;
    color: #78350f;
    font-size: 0.95rem;
}

.alert-button {
    display: inline-block;
    background: #facc15;
    color: #78350f;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.alert-button:hover {
    background: #fbbf24;
    transform: scale(1.05);
}

.alert-close {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    color: #92400e;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s;
}

.alert-close:hover {
    color: #000;
}

.alert-success {
    background-color: #e6ffed;
    border-left: 5px solid #22c55e;
    color: #166534;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.alert-success i {
    color: #22c55e;
}

.header-title {
    font-size: 14px !important;
    font-weight: 900 !important;
    white-space: nowrap;
    color: #ffffff; /* tulisan putih */
    margin: 0;
}

.header-white {
    background: #123B6B;   /* biru */
    color: #ffffff;        /* tulisan putih */
    display: flex;
    align-items: center;
    padding: 10px 20px;
    border-bottom: 2px solid #17375d;
}

/* ============================= */
/* RESPONSIVE SIDEBAR */
/* ============================= */
.mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
}

/* MOBILE */
@media (max-width: 991px) {
    body {
        overflow-x: hidden;
    }

    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1050;
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0 !important;
        padding: 20px;
    }

    .mobile-toggle {
        display: block;
    }
}


        
    </style>
</head>
<body>
    <div class="sidebar">
         <div class="header header-white">
        <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK" class="header-logo">
        <h3 class="header-title">SINTESA SMKN 2 YOGYAKARTA</h3>
    </div>

        <div class="profile">
            <img 
                    src="{{ $siswa->foto ? asset('uploads/foto_siswa/' . $siswa->foto) : asset('images/icon pelajar.jpeg') }}" 
                    alt="Foto Siswa" 
                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;"
                />

            <div class="info">
                <h4>{{ Auth::guard('siswa')->user()->nama_lengkap ?? 'Siswa' }}</h4>
                <p>{{ Auth::guard('siswa')->user()->role ?? 'Siswa' }}</p>
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
                    <a href="{{ route('siswa.kartupelajar.index') }}" 
                        class="{{ request()->is('siswa/kartu-pelajar') ? 'active' : '' }}">
                            <i class="fas fa-id-card"></i> Kartu Pelajar
                        </a>
                </li>

                <li class="dropdown {{ request()->is('siswa/konseling*') || request()->is('siswa/keterlambatan*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="fas fa-comments"></i> Bimbingan Konseling <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu" style="{{ request()->is('siswa/konseling*') || request()->is('admin/keterlambatan*') ? 'display:block;' : '' }}">
                        <li>
                           <a href="{{ route('siswa.konseling.index') }}" 
                                class="{{ request()->is('siswa/konseling*') ? 'active' : '' }}">
                                Konseling
                            </a>

                        </li>
                        <li>
                            <a href="{{ route('siswa.keterlambatan.index') }}" 
                            class="{{ request()->is('siswa/keterlambatan*') ? 'active' : '' }}">
                                Keterlambatan
                            </a>
                        </li>
                    </ul>
                </li>
            
                <li>
                    <a href="{{ route('siswa.dokumensiswa') }}" 
                       class="{{ request()->is('siswa/dokumensiswa*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Dokumen Siswa
                    </a>
                </li>

                <li>
                    <a href="{{ route('siswa.prestasi.index') }}" 
                       class="{{ request()->is('siswa/prestasi*') ? 'active' : '' }}">
                        <i class="fas fa-trophy"></i> Prestasi Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('siswa.password.edit') }}">
                        <i class="fas fa-key"></i> Ubah Password
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
            <button class="mobile-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2>@yield('page_title', 'Dashboard Siswa')</h2>
            <div class="user-profile">
                <img 
                    src="{{ $siswa->foto ? asset('uploads/foto_siswa/' . $siswa->foto) : asset('images/icon pelajar.jpeg') }}" 
                    alt="Foto Siswa" />
            </div>
        </div>
         
        @if(Auth::guard('siswa')->check() && Auth::guard('siswa')->user()->is_default_password)
<div id="alert-password" class="alert-password">
    <div class="alert-content">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-text">
            <h4>Peringatan Keamanan!</h4>
            <p>Kamu masih menggunakan password default <br>
            Segera ubah password untuk menjaga keamanan akunmu.</p>
            <a href="{{ route('siswa.password.edit') }}" class="alert-button">Ganti Password Sekarang</a>
        </div>
        <button class="alert-close" onclick="closeAlert()">×</button>
    </div>
</div>

@endif

@if(session('success'))
<div class="alert-success">
    <div class="alert-content">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif




        @yield('content')
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownToggles = document.querySelectorAll('.sidebar nav ul li.dropdown > .dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault(); // biar gak langsung redirect

                const parentLi = this.parentElement;

                // Tutup dropdown lain jika ingin hanya satu terbuka
                document.querySelectorAll('.sidebar nav ul li.dropdown').forEach(li => {
                    if (li !== parentLi) {
                        li.classList.remove('active');
                    }
                });

                // Toggle dropdown yang diklik
                parentLi.classList.toggle('active');
            });
        });
    });

    function closeAlert() {
    const alertBox = document.getElementById('alert-password');
    alertBox.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    alertBox.style.opacity = '0';
    alertBox.style.transform = 'translateY(-10px)';
    setTimeout(() => alertBox.remove(), 400);
}

// Opsional: auto-hide setelah 10 detik
setTimeout(() => {
    const alertBox = document.getElementById('alert-password');
    if (alertBox) closeAlert();
}, 10000);
</script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('show');
}

/* Auto close sidebar ketika klik di luar (mobile) */
document.addEventListener('click', function(e) {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.mobile-toggle');

    if (window.innerWidth <= 991) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    }
});
</script>

</body>
</html>
