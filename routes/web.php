<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Admin\KartuPelajarController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\Admin\KeterlambatanController;
use App\Http\Controllers\Admin\DokumenSiswaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserPasswordController;
use App\Http\Controllers\Admin\SiswaAksesController;

use App\Http\Controllers\bk\DashboardBKController;
use App\Http\Controllers\Kesiswaan\KesiswaanDashboardController;

use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\SiswaImportController;
use App\Http\Controllers\Siswa\PasswordController;
use App\Http\Controllers\Siswa\ForgotPasswordController;
use App\Http\Controllers\Siswa\KeterlambatanSiswaController;
use App\Http\Controllers\Siswa\DokumenController;
use App\Http\Controllers\Siswa\KonselingsiswaController;

/*
|--------------------------------------------------------------------------
| 🏠 ROUTE ROOT
|--------------------------------------------------------------------------
| Mengarahkan user berdasarkan guard & role
*/
Route::get('/', function () {

    // Jika login melalui guard guru
    if (auth('guru')->check()) {

        $role = auth('guru')->user()->role;

        return match ($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'guru_bk'    => redirect()->route('bk.dashboard'),
            'kesiswaan'  => redirect()->route('kesiswaan.dashboard'),
            default      => redirect()->route('guru.dashboard'),
        };
    }

    // Jika login siswa
    if (auth('siswa')->check()) {
        return redirect()->route('siswa.dashboard');
    }

    // Belum login
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| 🔐 LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Logout universal
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🧑‍💼 ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')
    ->middleware(['auth:guru', 'role:admin,guru_bk,kesiswaan'])
    ->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // CRUD Data Siswa untuk ADMIN
    Route::resource('datasiswa', SiswaController::class);

    // Akses Edit Siswa
    Route::put('/datasiswa/{nis}/toggle-akses', [\App\Http\Controllers\Admin\SiswaAksesController::class, 'toggleAkses'])->name('datasiswa.toggleAkses');

   // === DATA SISWA (Admin full, Kesiswaan read-only) ===
    Route::middleware(['kesiswaan.readonly'])->group(function () {
        Route::resource('datasiswa', SiswaController::class);
    });
    

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
    Route::get('/konseling/{id}', [KonselingController::class, 'show'])->name('konseling.show');
     Route::put('konseling/{id}/proses', [KonselingController::class, 'proses'])->name('konseling.proses');

    // ⏰ Keterlambatan
    Route::get('/keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::get('/keterlambatan/create', [KeterlambatanController::class, 'create'])->name('keterlambatan.create');
    Route::post('/keterlambatan/store', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('/keterlambatan/cetak/{id}', [KeterlambatanController::class, 'cetakSurat'])->name('keterlambatan.cetak');
    Route::put('/admin/keterlambatan/{id}/status', [KeterlambatanController::class, 'updateStatus'])->name('keterlambatan.updateStatus');

    // 📄 Roles
    Route::resource('role', RoleController::class);

    Route::middleware(['kesiswaan.readonly'])->group(function () {
    Route::resource('dokumensiswa', DokumenSiswaController::class);
});

    //Ubah Password Siswa
    Route::prefix('password')->name('password.')->group(function () {

    Route::get('/', [UserPasswordController::class, 'index'])
        ->name('index');

    Route::get('/edit/{type}/{id}', [UserPasswordController::class, 'edit'])
        ->name('edit');

    Route::post('/update/{type}/{id}', [UserPasswordController::class, 'update'])
        ->name('update');
    Route::post('/update-self', [UserPasswordController::class, 'updateSelf'])->name('updateSelf');

});

});

/*
|--------------------------------------------------------------------------
| 👨‍🏫 BK AREA (Guru BK)
|--------------------------------------------------------------------------
*/
Route::prefix('bk')->name('bk.')
    ->middleware(['auth:guru', 'role:guru_bk'])
    ->group(function () {

    // Dashboard BK
    Route::get('/dashboard', [DashboardBKController::class, 'index'])
        ->name('dashboard');

    // Konseling (BK mengelola pengajuan siswa)
    Route::resource('konseling', KonselingController::class);

    Route::put('/konseling/{id}/proses',
        [KonselingController::class, 'proses']
    )->name('konseling.proses');

    //Keterlambatan (BK Mengelola Pengajuan Keterlambatan)
    Route::resource('keterlambatan', Keterlambatancontroller::class);

    Route::put('/keterlambatan/{id}/proses',
        [KeterlambatanController::class, 'proses']
    )->name('keterlambatan.proses');

    // Dokumen siswa (read only)
    Route::get('/dokumen', [DokumenSiswaController::class, 'index'])
        ->name('dokumen.index');

});

/*
|--------------------------------------------------------------------------
| 👨‍🏫 Kesiswaan Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:guru', 'role:kesiswaan'])
    ->prefix('kesiswaan')
    ->name('kesiswaan.')
    ->group(function () {

    Route::get('/dashboard', [KesiswaanDashboardController::class, 'index'])
        ->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| 🎓 SISWA AREA (Dashboard & Halaman Siswa)
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')->name('siswa.')->middleware(['auth:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/datasiswa', [DashboardSiswaController::class, 'dataSiswa'])->name('datasiswa');
    Route::get('/orangtua', [DashboardSiswaController::class, 'dataOrangtua'])->name('orangtua');

    //Kartu Pelajar Siswa 
    Route::get('/kartu-pelajar', [DashboardSiswaController::class, 'kartuPelajar'])->name('kartupelajar.index');
    Route::get('/kartu-pelajar/frame/{nis}', [DashboardSiswaController::class, 'frame'])->name('kartupelajar.frame');

    // Konseling Siswa
    Route::get('/konseling', [KonselingsiswaController::class, 'index'])->name('konseling.index');
    Route::get('/konseling/create', [KonselingsiswaController::class, 'create'])->name('konseling.create');
    Route::post('/konseling', [KonselingsiswaController::class, 'store'])->name('konseling.store');
    Route::get('/konseling/{id}', [KonselingsiswaController::class, 'show'])->name('konseling.show');
    Route::get('/konseling/{id}/edit', [KonselingsiswaController::class, 'edit'])->name('konseling.edit');

    //Keterlambatan Siswa 
    Route::get('/keterlambatan', [KeterlambatanSiswaController::class, 'index'])->name('keterlambatan.index');
    Route::post('/keterlambatan/ajukan', [KeterlambatanSiswaController::class, 'ajukan'])->name('keterlambatan.ajukan');
    Route::get('/cetak-sit/{id}', [KeterlambatanSiswaController::class, 'cetakSIT'])->name('cetak.sit');


    //Dokumen Siswa
    Route::get('/dokumensiswa', [DokumenController::class, 'index'])->name('dokumensiswa');
    Route::post('/dokumensiswa/upload/{id}', [DokumenController::class, 'upload'])->name('dokumensiswa.upload');

    //Ubah dan Lupa Password Siswa 
    Route::get('/ubah-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/ubah-password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showForm'])->name('password.form');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
});
