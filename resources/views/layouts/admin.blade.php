<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | Sintesa')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="icon" href="{{ asset('images/skaduta_logo.png') }}" type="image/png"/>
    
    <style>
        /* =========================================
           1. RESET & GLOBAL
           ========================================= */
        * { 
            box-sizing: border-box; 
            font-family: 'Poppins', sans-serif; /* Pastikan semua pakai Poppins */
        }
        
        body {
            margin: 0;
            background-color: #f4f7f6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* =========================================
           2. SIDEBAR STYLES
           ========================================= */
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
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar::-webkit-scrollbar { display: none; }

        .sidebar .header { 
            display: flex; 
            align-items: center; 
            padding: 0 20px 20px; 
            border-bottom: 1px solid rgba(255,255,255,0.1); 
            margin-bottom: 20px; 
        }
        .header-logo { width: 40px; height: 40px; margin-right: 10px; }
        .header-title { font-size: 13px; font-weight: 700; color: #fff; margin: 0; line-height: 1.2; }

        .profile-admin { text-align: center; margin-bottom: 20px; padding: 0 10px; }
        .profile-admin-img { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; margin-bottom: 10px; }
        .profile-admin-name { font-size: 14px; font-weight: 600; margin-bottom: 2px; color: white; }
        .profile-admin-role { font-size: 12px; opacity: 0.8; }

        .sidebar nav ul { list-style: none; padding: 0; margin: 0; }
        .sidebar nav ul li { margin-bottom: 2px; }
        .sidebar nav ul li a { 
            display: flex; 
            align-items: center; 
            padding: 12px 20px; 
            color: rgba(255,255,255,0.8); 
            text-decoration: none; 
            font-size: 0.9rem; 
            transition: 0.3s; 
        }
        
        .sidebar nav ul li a i { margin-right: 12px; font-size: 1.1rem; width: 25px; text-align: center; }
        
        /* State Active & Hover */
        .sidebar nav ul li a:hover, 
        .sidebar nav ul li a.active { 
            background-color: #0d2a4a; 
            color: #fff;
            border-left: 4px solid #4a90e2; 
        }

        /* Dropdown Styles */
        .dropdown-menu { 
            display: none; 
            background-color: #0d2a4a; 
            padding: 5px 0; 
            list-style: none;
        }
        
        /* Logic: Tetap terbuka jika class 'active' atau 'open' ada */
        .dropdown.active .dropdown-menu,
        .dropdown.open .dropdown-menu { 
            display: block; 
        }
        
        .dropdown-menu li a { padding-left: 57px !important; font-size: 0.85rem !important; }
        .dropdown-toggle { position: relative; }
        .dropdown-toggle .fa-caret-down { 
            position: absolute; 
            right: 20px; 
            transition: transform 0.3s; 
        }
        .dropdown.active .dropdown-toggle .fa-caret-down { transform: rotate(180deg); }

        .logout { margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .logout a { 
            display: block; 
            text-align: center; 
            padding: 10px; 
            background: #e74c3c; 
            color: #fff; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* =========================================
           3. MAIN CONTENT & NAVBAR
           ========================================= */
        .main-content {
            margin-left: 300px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .navbar {
            background-color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h2 { margin: 0; color: #17375d; font-size: 1.1rem; font-weight: 700; }
        .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }

        .mobile-toggle {
            display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #17375d;
        }

        /* =========================================
           4. RESPONSIF MOBILE
           ========================================= */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .mobile-toggle { display: block; margin-right: 15px; }
            .navbar { padding: 10px 15px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
       <div class="header">
            <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK" class="header-logo">
            <h3 class="header-title">SINTESA SMKN 2 YOGYAKARTA</h3>
       </div>

       <div class="profile-admin">
            <img src="{{ auth('guru')->user()->foto ? asset('uploads/foto_guru/' . auth('guru')->user()->foto) : asset('images/profil_admin_tem.jfif') }}" 
                 alt="Foto Guru" class="profile-admin-img" />
            <div class="profile-admin-text">
                <h4 class="profile-admin-name">{{ auth('guru')->user()->nama ?? 'Guru' }}</h4>
                <p class="profile-admin-role">{{ ucfirst(str_replace('_', ' ', auth('guru')->user()->role)) }}</p>
            </div>
       </div>

       <nav>
            <ul>
                @if(auth('guru')->user()->role == 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.datasiswa.index') }}" class="{{ request()->is('admin/datasiswa*') ? 'active' : '' }}"><i class="fas fa-users"></i> Data Siswa</a></li>
                    <li><a href="{{ route('admin.kartupelajar.index') }}" class="{{ request()->is('admin/kartupelajar*') ? 'active' : '' }}"><i class="fas fa-id-card"></i> Kartu Pelajar</a></li>
                    
                    {{-- DROPDOWN MENU BK --}}
                    <li class="dropdown {{ request()->is('admin/konseling*') || request()->is('admin/keterlambatan*') ? 'open' : '' }}">
                        <a href="#" class="dropdown-toggle">
                            <i class="fas fa-comments"></i> Bimbingan Konseling <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('admin.konseling.index') }}" class="{{ request()->is('admin/konseling*') ? 'active' : '' }}">Konseling</a></li>
                            <li><a href="{{ route('admin.keterlambatan.index') }}" class="{{ request()->is('admin/keterlambatan*') ? 'active' : '' }}">Keterlambatan</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('admin.dokumensiswa.index') }}" class="{{ request()->is('admin/dokumensiswa*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Dokumen Siswa</a></li>
                    <li><a href="{{ route('admin.prestasi.index') }}" class="{{ request()->is('admin/prestasisiswa*') ? 'active' : '' }}"><i class="fas fa-trophy"></i> Prestasi Siswa</a></li>
                    <li><a href="{{ route('admin.role.index') }}" class="{{ request()->is('admin/role*') ? 'active' : '' }}"><i class="fas fa-user-cog"></i> Manajemen Role</a></li>
                    <li><a href="{{ route('admin.password.index') }}" class="{{ request()->is('admin/password*') ? 'active' : '' }}"><i class="fas fa-key"></i> Kelola Password</a></li>
                @endif
                
                @if(auth('guru')->user()->role == 'guru_bk')
                    <li><a href="{{ route('bk.dashboard') }}" class="{{ request()->is('bk/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard BK</a></li>
                    <li><a href="{{ route('bk.konseling.index') }}" class="{{ request()->is('bk/konseling*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Konseling</a></li>
                    <li><a href="{{ route('bk.keterlambatan.index') }}" class="{{ request()->is('bk/keterlambatan*') ? 'active' : '' }}"><i class="fas fa-clock"></i> Keterlambatan</a></li>
                    <li><a href="{{ route('bk.dokumen.index') }}" class="{{ request()->is('bk/dokumen*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Dokumen Siswa</a></li>
                    <li><a href="{{ route('bk.prestasi.index') }}" class="{{ request()->is('bk/prestasi*') ? 'active' : '' }}"><i class="fas fa-trophy"></i> Prestasi</a></li>
                @endif

                {{-- ... role kesiswaan dan wali kelas tetap sama ... --}}
            </ul>
       </nav>

       <div class="logout">
            <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Log Out</a>
       </div>
    </div>

    <div class="main-content">
        <div class="navbar">
            <div style="display: flex; align-items: center;">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>@yield('page_title', 'Dashboard Admin')</h2>
            </div>
            <div class="user-profile">
                <img src="{{ asset('images/profil_admin_tem.jfif') }}" alt="Admin Profile">
            </div>
        </div>

        @yield('content')
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownToggles = document.querySelectorAll(".dropdown-toggle");
        
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                
                // Jika ingin hanya satu dropdown yang terbuka dalam satu waktu:
                document.querySelectorAll(".sidebar nav ul li.dropdown").forEach(drop => {
                    if (drop !== parent) {
                        drop.classList.remove("active");
                        drop.classList.remove("open");
                    }
                });
                
                // Toggle status klik manual
                parent.classList.toggle("active");
            });
        });
    });

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('show');
    }

    // Klik di luar sidebar untuk menutup (Mobile)
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        if (window.innerWidth <= 991 && sidebar.classList.contains('show')) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    </script>
</body>
</html>