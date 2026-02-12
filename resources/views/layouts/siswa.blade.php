<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Siswa | Sintesa')</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="icon" href="{{ asset('images/skaduta_logo.png') }}" type="image/png"/>

<style>
* { box-sizing: border-box; }

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #f4f7f6;
    min-height: 100vh;
}

/* ================= SIDEBAR ================= */

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
    z-index: 1050;
    left: 0;
    top: 0;
    transition: transform 0.3s ease;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar::-webkit-scrollbar { display: none; }

.sidebar .header {
    display: flex;
    align-items: center;
    padding: 0 20px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 20px;
}

.header-logo {
    width: 40px;
    margin-right: 10px;
}

.header-title {
    font-size: 14px;
    font-weight: 700;
    margin: 0;
}

.profile-admin {
    text-align: center;
    margin-bottom: 20px;
}

.profile-admin-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    margin-bottom: 5px;
}

.profile-admin-name {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}

.profile-admin-role {
    font-size: 12px;
    opacity: 0.85;
    margin: 0;
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
    transition: 0.3s;
}

.sidebar nav ul li a:hover,
.sidebar nav ul li a.active {
    background-color: #0d2a4a;
    border-left: 4px solid #4a90e2;
}

.sidebar nav ul li a i {
    margin-right: 10px;
    width: 25px;
    text-align: center;
}

.dropdown-menu {
    display: none;
    background-color: #0d2a4a;
}

.dropdown.active .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding-left: 55px;
    font-size: 0.9rem;
}

.logout {
    margin-top: auto;
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.logout a {
    display: block;
    text-align: center;
    padding: 12px;
    background: #e74c3c;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: 0.3s;
}

.logout a:hover {
    background-color: #c0392b;
}

/* ================= MAIN ================= */

.main-content {
    margin-left: 300px;
    padding: 30px;
    transition: margin-left 0.3s ease;
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
    font-size: 1.2rem;
}

.mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    margin-right: 15px;
}

.user-profile img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
}

/* ================= ALERT ================= */

.alert-password {
    background: #fffbe6;
    border-left: 6px solid #facc15;
    border-radius: 10px;
    padding: 15px 20px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
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
}

.alert-text h4 {
    margin: 0;
    font-weight: 700;
    font-size: 1rem;
}

.alert-text p {
    margin: 4px 0 8px;
    font-size: 0.9rem;
}

.alert-button {
    display: inline-block;
    background: #facc15;
    color: #78350f;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.85rem;
}

.alert-close {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

/* ================= MOBILE ================= */

@media (max-width: 991px) {

    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
        padding: 15px;
    }

    .mobile-toggle {
        display: block;
    }

}
</style>
</head>

<body>

<div class="sidebar">
    <div class="header">
        <img src="{{ asset('images/skaduta_logo.png') }}" class="header-logo">
        <h3 class="header-title">SINTESA SMKN 2 YOGYAKARTA</h3>
    </div>

    <div class="profile-admin">
        <img src="{{ $siswa->foto ? asset('uploads/foto_siswa/' . $siswa->foto) : asset('images/icon pelajar.jpeg') }}"
             class="profile-admin-img">
        <h4 class="profile-admin-name">{{ Auth::guard('siswa')->user()->nama_lengkap ?? 'Siswa' }}</h4>
        <p class="profile-admin-role">{{ Auth::guard('siswa')->user()->role ?? 'Siswa' }}</p>
    </div>

    <nav>
        <ul>
            <li><a href="{{ route('siswa.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('siswa.datasiswa') }}"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
            <li><a href="{{ route('siswa.orangtua') }}"><i class="fas fa-users"></i> Data Orang Tua</a></li>
            <li><a href="{{ route('siswa.kartupelajar.index') }}"><i class="fas fa-id-card"></i> Kartu Pelajar</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="fas fa-comments"></i> Bimbingan Konseling <i class="fas fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('siswa.konseling.index') }}">Konseling</a></li>
                    <li><a href="{{ route('siswa.keterlambatan.index') }}">Keterlambatan</a></li>
                </ul>
            </li>

            <li><a href="{{ route('siswa.dokumensiswa') }}"><i class="fas fa-book"></i> Dokumen Siswa</a></li>
            <li><a href="{{ route('siswa.prestasi.index') }}"><i class="fas fa-trophy"></i> Prestasi Siswa</a></li>
            <li><a href="{{ route('siswa.password.edit') }}"><i class="fas fa-key"></i> Ubah Password</a></li>
        </ul>
    </nav>

    <div class="logout">
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
</div>

<div class="main-content">

    <div class="navbar">
        <div style="display:flex;align-items:center;">
            <button class="mobile-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2>@yield('page_title', 'Dashboard Siswa')</h2>
        </div>

        <div class="user-profile">
            <img src="{{ $siswa->foto ? asset('uploads/foto_siswa/' . $siswa->foto) : asset('images/icon pelajar.jpeg') }}">
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
                <p>Kamu masih menggunakan password default. Segera ubah untuk keamanan akunmu.</p>
                <a href="{{ route('siswa.password.edit') }}" class="alert-button">
                    Ganti Password Sekarang
                </a>
            </div>
            <button type="button" class="alert-close" onclick="closeAlert()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @yield('content')

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".dropdown-toggle").forEach(toggle => {
        toggle.addEventListener("click", function(e){
            e.preventDefault();
            this.parentElement.classList.toggle("active");
        });
    });

});

function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('show');
}

document.addEventListener('click', function(e) {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.mobile-toggle');

    if (window.innerWidth <= 991 && sidebar.classList.contains('show')) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    }
});

function closeAlert() {
    const alertBox = document.getElementById('alert-password');
    if (!alertBox) return;

    alertBox.style.opacity = '0';
    alertBox.style.transform = 'translateY(-10px)';
    alertBox.style.transition = '0.4s ease';

    setTimeout(() => {
        if (alertBox) alertBox.remove();
    }, 400);
}

setTimeout(() => {
    const alertBox = document.getElementById('alert-password');
    if (alertBox) closeAlert();
}, 10000);
</script>

</body>
</html>
