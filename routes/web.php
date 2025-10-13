<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaImportController;
use App\Http\Controllers\Admin\KartuPelajarController;

// ===================================================================
// 🏠 Route Halaman Utama (Root)
// ===================================================================
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('siswa.dashboard');
});

// ===================================================================
// 🔐 Login & Logout
// ===================================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ===================================================================
// 🧑‍💼 Rute untuk ADMIN
// ===================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // --- CRUD Data Siswa ---
    Route::resource('datasiswa', SiswaController::class)->names([
        'index' => 'datasiswa.index',
        'create' => 'datasiswa.create',
        'store' => 'datasiswa.store',
        'show' => 'datasiswa.show',
        'edit' => 'datasiswa.edit',
        'update' => 'datasiswa.update',
        'destroy' => 'datasiswa.destroy',
    ]);

    // --- Import Data Siswa ---
    Route::get('datasiswa/import', [SiswaImportController::class, 'showImportForm'])->name('datasiswa.import.form');
    Route::post('datasiswa/import', [SiswaImportController::class, 'import'])->name('datasiswa.import');

    // --- Kartu Pelajar ---
    Route::get('kartupelajar', [KartuPelajarController::class, 'index'])->name('kartupelajar.index');
    Route::get('kartupelajar/print/{id}', [KartuPelajarController::class, 'printSingle'])->name('kartupelajar.print');
    Route::post('kartupelajar/print-mass', [KartuPelajarController::class, 'printMass'])->name('kartupelajar.printMass');
    Route::get('kartupelajar/search', [KartuPelajarController::class, 'search'])->name('kartupelajar.search');

    // --- Menu Admin Lainnya ---
    Route::get('konseling', [DashboardController::class, 'konseling'])->name('konseling');
    Route::get('keterlambatan', [DashboardController::class, 'keterlambatan'])->name('keterlambatan');
    Route::get('dokumensiswa', [DashboardController::class, 'dokumenSiswa'])->name('dokumensiswa');
    Route::get('role', [DashboardController::class, 'role'])->name('role');
});

// ===================================================================
// 🎓 Rute untuk SISWA
// ===================================================================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])->name('dashboard');
});
