<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

// Rute Halaman Utama (langsung ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute Login (satu form untuk semua user)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard');
});

// Rute untuk Dashboard Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');
});

// Rute untuk Dashboard Admin-Menu Data Siswa
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/datasiswa', [DashboardController::class, 'dataSiswa'])->name('admin.datasiswa');
});


// Rute untuk Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
