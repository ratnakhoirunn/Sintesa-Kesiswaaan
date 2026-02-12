<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin | Sintesa')</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="icon" href="{{ asset('images/skaduta_logo.png') }}">

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
    width: 280px;
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
}

.profile-admin-name {
    font-size: 13px;
    font-weight: 600;
}

.profile-admin-role {
    font-size: 12px;
    opacity: 0.8;
}

.sidebar nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar nav ul li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar nav ul li a:hover,
.sidebar nav ul li a.active {
    background-color: #0d2a4a;
    border-left: 4px solid #4a90e2;
}

.sidebar nav ul li a i {
    margin-right: 10px;
    width: 20px;
}

.dropdown-menu {
    display: none;
    background-color: #0d2a4a;
}

.dropdown.active .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding-left: 50px;
}

/* ================= MAIN ================= */

.main-content {
    margin-left: 280px;
    padding: 30px;
    transition: margin-left 0.3s ease;
}

.navbar {
    background: #fff;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.menu-toggle {
    display: none;
    font-size: 1.4rem;
    cursor: pointer;
    margin-right: 15px;
}

/* ================= MOBILE ================= */

@media (max-width: 991px) {

    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
        padding: 20px;
    }

    .menu-toggle {
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
        <img src="{{ auth('guru')->user()->foto 
            ? asset('uploads/foto_guru/' . auth('guru')->user()->foto) 
            : asset('images/profil_admin_tem.jfif') }}" 
            class="profile-admin-img">
        <div class="profile-admin-name">
            {{ auth('guru')->user()->nama ?? 'Guru' }}
        </div>
        <div class="profile-admin-role">
            {{ ucfirst(str_replace('_',' ',auth('guru')->user()->role)) }}
        </div>
    </div>

    <nav>
        <ul>
            @if(auth('guru')->user()->role == 'admin')
                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.datasiswa.index') }}"><i class="fas fa-users"></i> Data Siswa</a></li>
                <li><a href="{{ route('admin.kartupelajar.index') }}"><i class="fas fa-id-card"></i> Kartu Pelajar</a></li>
            @endif
        </ul>
    </nav>

    <div class="logout" style="margin-top:auto;padding:20px;">
        <a href="{{ route('logout') }}" 
           style="display:block;background:#e74c3c;padding:10px;text-align:center;color:#fff;border-radius:5px;text-decoration:none;">
           <i class="fas fa-sign-out-alt"></i> Log Out
        </a>
    </div>
</div>

<div class="main-content">
    <div class="navbar">
        <div style="display:flex;align-items:center;">
            <div class="menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </div>
            <h2 style="margin:0;">@yield('page_title','Dashboard')</h2>
        </div>

        <div>
            <img src="{{ asset('images/profil_admin_tem.jfif') }}" 
                 style="width:35px;height:35px;border-radius:50%;">
        </div>
    </div>

    @yield('content')
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Dropdown toggle
    document.querySelectorAll(".dropdown-toggle").forEach(toggle => {
        toggle.addEventListener("click", function(e){
            e.preventDefault();
            this.parentElement.classList.toggle("active");
        });
    });

});

// Sidebar toggle
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}

// Klik luar sidebar = tutup (mobile)
document.addEventListener("click", function(e){
    const sidebar = document.querySelector(".sidebar");
    const toggle = document.querySelector(".menu-toggle");

    if(window.innerWidth <= 991){
        if(!sidebar.contains(e.target) && !toggle.contains(e.target)){
            sidebar.classList.remove("open");
        }
    }
});
</script>

</body>
</html>
