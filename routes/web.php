<?php

use Illuminate\Support\Facades\Route;

// Controller Utama
use App\Http\Controllers\AuthController; // Ganti LoginController ke AuthController
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Admin\KartuPelajarController;
use App\Http\Controllers\Admin\KonselingController;
use App\Http\Controllers\Admin\KeterlambatanController;
use App\Http\Controllers\Admin\DokumenSiswaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\SiswaImportController;


/*
|--------------------------------------------------------------------------
| 🏠 ROUTE UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // kalau login sebagai admin/guru/bk (guard web)
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, ['admin', 'guru', 'bk'])) {
            return redirect()->route('admin.dashboard');
        }
    }

    // kalau login sebagai siswa (guard siswa)
    if (auth('siswa')->check()) {
        return redirect()->route('siswa.dashboard');
    }

    // kalau belum login sama sekali
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| 🔐 LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Tampilkan form login
    Route::get('/login', function () {return view('login');})->name('login');

    // Proses login (gabungan users dan siswas)
      Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Logout
Route::middleware('auth')->get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🧑‍💼 ADMIN / GURU / BK AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,guru,bk'])->group(function () {

    // 🏠 Dashboard
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
    Route::get('/konseling/{id}', [KonselingController::class, 'show'])->name('konseling.show');

    // ⏰ Keterlambatan
    Route::get('/keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::get('/keterlambatan/create', [KeterlambatanController::class, 'create'])->name('keterlambatan.create');
    Route::post('/keterlambatan/store', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('/keterlambatan/cetak/{id}', [KeterlambatanController::class, 'cetakSurat'])->name('keterlambatan.cetak');

    // 📄 Roles
    Route::resource('role', RoleController::class);

    // 📁 Dokumen Siswa
    Route::resource('dokumensiswa', DokumenSiswaController::class);
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
     Route::get('/kartu-pelajar', [DashboardSiswaController::class, 'kartuPelajar'])->name('kartupelajar.index');
    Route::get('/kartu-pelajar/frame/{nis}', [DashboardSiswaController::class, 'frame'])->name('kartupelajar.frame');
    Route::get('/konseling', [DashboardSiswaController::class, 'konseling'])->name('konseling.index');
    Route::get('/keterlambatan', [DashboardSiswaController::class, 'keterlambatan'])->name('keterlambatan.index');
    Route::get('/dokumensiswa', [DashboardSiswaController::class, 'dokumenSiswa'])->name('dokumensiswa');
});




