<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaImportController;
use App\Http\Controllers\Admin\KartuPelajarController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\Admin\KeterlambatanController;
use App\Http\Controllers\Admin\DokumenSiswaController;
use App\Http\Controllers\Admin\RoleController;
/*
|--------------------------------------------------------------------------
| 🏠 ROUTE UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 'siswa') {
        return redirect()->route('siswa.dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| 🔐 LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->get('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🧑‍💼 ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // 🏠 Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // 👨‍🎓 Data Siswa (CRUD)
    Route::resource('datasiswa', SiswaController::class);

    // 📤 Import Data Siswa
    Route::get('datasiswa/import', [SiswaImportController::class, 'showImportForm'])->name('datasiswa.import.form');
    Route::post('datasiswa/import', [SiswaImportController::class, 'import'])->name('datasiswa.import');

    // 🪪 Kartu Pelajar
Route::prefix('kartupelajar')->name('kartupelajar.')->group(function () {
    Route::get('/', [KartuPelajarController::class, 'index'])->name('index');
    Route::get('/preview/{nis}', [KartuPelajarController::class, 'cetak'])->name('preview');
    Route::post('/print-mass', [KartuPelajarController::class, 'printMass'])->name('printMass');
    Route::get('/search', [KartuPelajarController::class, 'search'])->name('search');
    Route::get('/download-pdf/{nis}', [KartuPelajarController::class, 'downloadPDF'])->name('download.pdf');
    Route::get('/frame/{nis}', [KartuPelajarController::class, 'previewFrame'])->name('frame');
});

    // 💬 Konseling
    Route::get('konseling', [KonselingController::class, 'index'])->name('konseling.index');
    Route::get('konseling/create', [KonselingController::class, 'create'])->name('konseling.create');
    Route::post('konseling/store', [KonselingController::class, 'store'])->name('konseling.store');
    Route::get('konseling/{id}/edit', [KonselingController::class, 'edit'])->name('konseling.edit');
    Route::put('konseling/{id}', [KonselingController::class, 'update'])->name('konseling.update');
    Route::delete('konseling/{id}', [KonselingController::class, 'destroy'])->name('konseling.destroy');

    // ⏰ Keterlambatan
     Route::get('/keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::get('/keterlambatan/create', [KeterlambatanController::class, 'create'])->name('keterlambatan.create');
    Route::post('/keterlambatan/store', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('/keterlambatan/cetak/{id}', [KeterlambatanController::class, 'cetakSurat'])->name('keterlambatan.cetak');

    // 📄 Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
}); 

    // Dokumen Siswa
Route::prefix('admin')->name('admin.')->group(function () {
    // Dokumen Siswa CRUD
    Route::resource('dokumensiswa', DokumenSiswaController::class)->names([
        'index' => 'dokumensiswa.index',
        'create' => 'dokumensiswa.create',
        'store' => 'dokumensiswa.store',
        'show' => 'dokumensiswa.show',
        'edit' => 'dokumensiswa.edit',
        'update' => 'dokumensiswa.update',
        'destroy' => 'dokumensiswa.destroy',
    ]);
});

/*
|--------------------------------------------------------------------------
| 🎓 SISWA AREA
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/datasiswa', [DashboardSiswaController::class, 'dataSiswa'])->name('datasiswa');
    Route::get('/orangtua', [DashboardSiswaController::class, 'dataOrangtua'])->name('orangtua');
    Route::get('/kartu', [DashboardSiswaController::class, 'kartuPelajar'])->name('kartu');
    Route::get('/konseling', [DashboardSiswaController::class, 'konseling'])->name('konseling');
    Route::get('/dokumensiswa', [DashboardSiswaController::class, 'dokumenSiswa'])->name('dokumensiswa');
});
