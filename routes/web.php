<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaImportController;
use App\Http\Controllers\Admin\KartuPelajarController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\Admin\KeterlambatanController;


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

    // --- Konseling ---
    Route::get('/konseling', [KonselingController::class, 'index'])->name('konseling.index');
    Route::get('/konseling/create', [KonselingController::class, 'create'])->name('konseling.create');
    Route::post('/konseling/store', [KonselingController::class, 'store'])->name('konseling.store');
    Route::get('/konseling/{id}/edit', [KonselingController::class, 'edit'])->name('konseling.edit');
    Route::put('/konseling/{id}', [KonselingController::class, 'update'])->name('konseling.update');
    Route::delete('/konseling/{id}', [KonselingController::class, 'destroy'])->name('konseling.destroy');

    // --- Keterlambatan ---
    Route::get('/keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::get('/keterlambatan/create', [KeterlambatanController::class, 'create'])->name('keterlambatan.create');
    Route::post('/keterlambatan/store', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('/keterlambatan/cetak/{id}', [KeterlambatanController::class, 'cetakSurat'])->name('keterlambatan.cetak');

    // --- Dokumen & Role ---
    Route::get('dokumensiswa', [DashboardController::class, 'dokumenSiswa'])->name('dokumensiswa');
    Route::get('role', [DashboardController::class, 'role'])->name('role');
});


// ===================================================================
// 🎓 Rute untuk SISWA
// ===================================================================
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/data', [DashboardSiswaController::class, 'dataSiswa'])->name('data');
    Route::get('/orangtua', [DashboardSiswaController::class, 'dataOrangtua'])->name('orangtua');
    Route::get('/kartu', [DashboardSiswaController::class, 'kartuPelajar'])->name('kartu');
    Route::get('/konseling', [DashboardSiswaController::class, 'konseling'])->name('konseling');
    Route::get('/administrasi', [DashboardSiswaController::class, 'administrasi'])->name('administrasi');
});