<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPembayaranController;
use App\Http\Controllers\ShowSiswaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Siswa\SiswasController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\DataKelasController;

// Route untuk login
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');  // GET untuk login form
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // POST untuk login submission

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout'); // POST untuk logout

// Route untuk registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);  // POST untuk registrasi

// Semua route ini memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    // Tagihan
    Route::get('/riwayat-pembayaran', [TagihanController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');
    Route::get('/tagihan/{id}', [TagihanController::class, 'showTagihan'])->name('showTagihan');
    Route::post('/tagihan/siswa/save', [SiswaController::class, 'saveTagihan'])->name('tagihan.siswa.save');
    // Route for rejecting a tagihan (delete it)
    Route::post('/tagihan/siswa/reject', [SiswaController::class, 'rejectTagihan'])->name('reject.tagihan');


    // Data Kelas & Tagihan Siswa
    Route::get('/data-kelas/{kelas_id}/tagihan-siswa/{tagihan_id}', [DataKelasController::class, 'tagihanSiswa'])->name('tagihan-siswa-detail');
    Route::get('/data-kelas/{id}/tagihan-siswa', [DataKelasController::class, 'tagihanSiswa'])->name('data-kelas.tagihanSiswa');
    Route::get('/data-kelas/{id}/tagihan', [DataKelasController::class, 'showTagihanSiswa'])->name('data-kelas.tagihan');
    Route::post('/tagihan/approve', [DataKelasController::class, 'approve'])->name('approve.tagihan');
    Route::get('data-pembayaran', [DataPembayaranController::class, 'index'])->name('data-pembayaran.index');
    Route::get('data-kelas/tagihan/{id}', [DataPembayaranController::class, 'tagihanSiswa'])->name('data-kelas.tagihanSiswa');

    // Resource route untuk Admin (CRUD)
    Route::resource('data-admin', AdminController::class);

    // Resource route untuk Data Kelas, Data Guru, dan Data Siswa
    Route::resource('data-kelas', DataKelasController::class);
    Route::resource('data-guru', GuruController::class);
    Route::resource('data-siswa', SiswaController::class);
    Route::resource('data-tagihan', TagihanController::class);
    Route::resource('data-pembayaran', DataPembayaranController::class);

    // Siswa Dashboard
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard.index');  // Tampilkan halaman dashboard siswa
    })->name('siswa.dashboard');

    Route::get('/siswa/dashboard', [SiswasController::class, 'index'])->name('siswa.dashboard.index');

    Route::get('/siswa/data-tagihan', [SiswasController::class, 'tagihanSiswa'])->name('siswa.tagihan.tagihan');

    Route::get('/siswa/riwayat-pembayaran', [SiswasController::class, 'riwayatPembayaran'])->name('siswa.riwayatPembayaran');

    Route::post('/siswa/tagihan/save', [SiswasController::class, 'saveTagihan'])->name('tagihan.siswas.save');


});