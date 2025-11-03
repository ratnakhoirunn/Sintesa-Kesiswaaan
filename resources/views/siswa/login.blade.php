<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SINTESA - Login Admin SMKN 2 Yogyakarta</title>
    <link rel="icon" href="{{ asset('images/skaduta_logo.png') }}" type="image/png"/>
    
    {{-- Memuat aset CSS & JS dari Laravel Vite/Mix --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    {{-- CSS Kustom untuk Desain Dua Kolom --}}
    <style>
        .login-container {
            display: flex;
            min-height: 100vh;
            background-color: #f7f9fc; /* Latar belakang abu-abu muda */
        }
        .image-side {
            flex: 1;
            /* Ganti 'images/smkn2_yogyakarta.jpg' dengan path gambar Anda */
            background-image:url('/images/smk2_yogyakarta.png'); /* Ganti dengan link gambar gedung SMK 2 */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 2.5rem; /* Padding lebih besar untuk estetika */
            color: white;
            position: relative;
        }
        /* Efek sun-ray/cahaya dari gambar asli */
        .image-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Memberikan sedikit overlay gelap agar teks terbaca */
            background: linear-gradient(to top, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0) 50%);
        }
        .image-text {
            position: relative;
            z-index: 10;
            font-family: sans-serif;
            line-height: 1.2;
        }
        .image-text h1 {
            font-size: 1.6rem;
            font-weight: 700;
        }
        .image-text p {
            font-size: 1.1rem;
        }
        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .form-card {
            width: 100%;
            max-width: 420px; /* Lebar form yang lebih baik */
        }
        /* Styling Input Field seperti pada gambar */
        .input-field-custom {
            background-color: #e6f0ff; /* Biru muda */
            border: 1px solid #d4e2ff;
            border-radius: 0.375rem; /* rounded-md */
            padding: 0.75rem 1rem;
            width: 100%;
            height: 3.2rem; /* Membuat tinggi input seragam */
            font-size: 1rem;
            transition: all 0.2s;
            padding-left: 3rem; /* Ruang untuk ikon */
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #1e3a67; /* Biru tua untuk ikon */
            font-size: 1.2rem;
            z-index: 5;
        }
        /* Styling Button seperti pada gambar */
        .login-button-custom {
            background-color: #1e3a67; /* Biru tua */
            color: white;
            padding: 0.8rem 0;
            border-radius: 0.375rem;
            font-weight: 700;
            width: 100%;
            margin-top: 1.5rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-button-custom:hover {
            background-color: #2a4c7e;
        }
        /* Styling Teks Judul */
        .header-text {
            color: #1e3a67;
            font-size: 1.7rem;
            font-weight: 700;
            text-align: center;
        }
        
        /* Responsif Sederhana (opsional: sembunyikan gambar di layar kecil) */
        @media (max-width: 1024px) {
            .image-side {
                display: none;
            }
            .form-side {
                flex: 100%;
            }
            .login-container {
                justify-content: center;
            }
        }
    </style>
</head>
<body class="antialiased">

<div class="login-container">
    {{-- Sisi Kiri: Gambar Gedung --}}
    <div class="image-side"></div>

    {{-- Sisi Kanan: Form Login --}}
    <div class="form-side">
        <div class="form-card">
            
            <p style="text-align: left; margin-bottom: 0.5rem; font-size: 1rem;">Selamat Datang di</p>
            
            <div class="header-text" style="margin-bottom: 1rem;">
                <span class="text-sintesa">SINTESA</span> SMKN 2 YOGYAKARTA
            </div>
            
            {{-- Logo Tengah --}}
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="{{ asset('images/skaduta_logo.png') }}" alt="Logo SMK N 2" style="width: 120px; height: auto; display: inline-block;">
            </div>

            <p style="text-align: center; margin-bottom: 2rem; font-size: 1.1rem; font-weight: 500;">Login Siswa Untuk Melanjutkan</p>


            {{-- Status Sesi (Bisa dihapus jika tidak digunakan) --}}
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

           <form method="POST" action="{{ route('siswa.login') }}">

                @csrf

               {{-- Input Admin (NIP/NIS) --}}
                    <div class="mb-4">
                        <label for="username" style="display: block; margin-bottom: 0.3rem; font-weight: 500;">Siswa</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span> 
                            <input id="nis" class="input-field-custom" type="text" name="nis" value="{{ old('nis') }}" required autofocus autocomplete="nis" placeholder="Masukkan NIS">

                        </div>
                        @error('username')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                {{-- Input Password --}}
                <div class="mt-4">
                    <label for="password" style="display: block; margin-bottom: 0.3rem; font-weight: 500;">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input id="password" class="input-field-custom" type="password" name="password" 
                                required autocomplete="current-password" placeholder="Masukkan Password">
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Hapus bagian "Remember Me" dan "Forgot Password" agar persis seperti gambar --}}
                
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="login-button-custom">
                        Log In
                    </button>
                </div>
                <div style="text-align:center;margin-top:10px;">
                    <a href="/login" style="color:#1e3a67;font-weight:500;">Login sebagai Admin</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>