<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
<<<<<<< HEAD
use App\Http\Controllers\SiswaImportController;
=======
use App\Http\Middleware\PreventBackHistory;
>>>>>>> bf367b5ee2c3fca5276fd5b4a6f129a095100eaa

// 🔹 Rute Halaman Utama (langsung ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

<<<<<<< HEAD
// Rute Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// ===================================================================
// Rute untuk ADMIN
// ===================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // --- Rute Import Data Siswa ---
    Route::get('/admin/datasiswa/import', [SiswaImportController::class, 'showImportForm'])
        ->name('admin.datasiswa.import.form'); // menampilkan form import

   Route::post('/admin/datasiswa/import', [SiswaImportController::class, 'import'])
    ->name('admin.datasiswa.import');

    Route::get('/admin/datasiswa', [SiswaController::class, 'index'])->name('admin.datasiswa.index');
    Route::post('/admin/datasiswa/import', [SiswaImportController::class, 'import'])->name('admin.datasiswa.import');

    // --- Rute CRUD Data Siswa ---
    Route::get('/admin/datasiswa', [SiswaController::class, 'index'])->name('admin.datasiswa');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.datasiswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('admin.datasiswa.store');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('admin.datasiswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('admin.datasiswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('admin.datasiswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.datasiswa.destroy');
    Route::get('/siswa/{id}/kartu', [SiswaController::class, 'cetakKartu'])->name('admin.datasiswa.kartu');
});

    // Logout Admin
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
;

// ===================================================================
// Rute untuk SISWA
// ===================================================================
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');
});
