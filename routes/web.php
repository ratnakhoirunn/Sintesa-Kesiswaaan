<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\PreventBackHistory;

// 🔹 Rute Halaman Utama (langsung ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔹 Rute Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// 🔹 Rute Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 Admin Routes (dengan middleware prevent back)
Route::middleware(['auth', 'role:admin', PreventBackHistory::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Data Siswa
        Route::get('/datasiswa', [SiswaController::class, 'index'])->name('datasiswa');   // list data siswa
        Route::get('/datasiswa/{id}/read', [SiswaController::class, 'read'])->name('datasiswa.read'); // detail siswa

        // Menu lain
        Route::get('/kartupelajar', [DashboardController::class, 'kartuPelajar'])->name('kartupelajar');
        Route::get('/konseling', [DashboardController::class, 'konseling'])->name('konseling');
        Route::get('/keterlambatan', [DashboardController::class, 'keterlambatan'])->name('keterlambatan');
        Route::get('/dokumensiswa', [DashboardController::class, 'dokumenSiswa'])->name('dokumensiswa');
        Route::get('/role', [DashboardController::class, 'role'])->name('role');
    });

// 🔹 Siswa Routes (dengan middleware prevent back)
Route::middleware(['auth', 'role:siswa', PreventBackHistory::class])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])->name('dashboard');
    });
