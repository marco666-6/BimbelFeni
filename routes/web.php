<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============= PUBLIC ROUTES =============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'submitKontak'])->name('kontak.submit');
Route::get('/paket/{id}', [HomeController::class, 'paketDetail'])->name('paket.detail');
Route::get('/whatsapp', [HomeController::class, 'redirectWhatsApp'])->name('whatsapp');

// ============= AUTH ROUTES =============
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');
});

// ============= ADMIN ROUTES =============
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Paket Belajar
    Route::prefix('paket')->name('paket.')->group(function () {
        Route::get('/', [AdminController::class, 'paketIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'paketCreate'])->name('create');
        Route::post('/', [AdminController::class, 'paketStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'paketEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'paketUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'paketDestroy'])->name('destroy');
    });
    
    // Pendaftaran
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [AdminController::class, 'pendaftaranIndex'])->name('index');
        Route::get('/{id}', [AdminController::class, 'pendaftaranShow'])->name('show');
        Route::post('/{id}/approve', [AdminController::class, 'pendaftaranApprove'])->name('approve');
        Route::post('/{id}/reject', [AdminController::class, 'pendaftaranReject'])->name('reject');
    });
    
    // Siswa
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [AdminController::class, 'siswaIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'siswaCreate'])->name('create');
        Route::post('/', [AdminController::class, 'siswaStore'])->name('store');
        Route::get('/{id}', [AdminController::class, 'siswaShow'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'siswaEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'siswaUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'siswaDestroy'])->name('destroy');
    });
    
    // Orang Tua
    Route::prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/', [AdminController::class, 'orangTuaIndex'])->name('index');
        Route::get('/{id}', [AdminController::class, 'orangTuaShow'])->name('show');
    });
    
    // Jadwal & Materi
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [AdminController::class, 'jadwalIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'jadwalCreate'])->name('create');
        Route::post('/', [AdminController::class, 'jadwalStore'])->name('store');
        Route::get('/{id}', [AdminController::class, 'jadwalShow'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'jadwalEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'jadwalUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'jadwalDestroy'])->name('destroy');
        Route::post('/{id}/nilai', [AdminController::class, 'inputNilai'])->name('nilai');
    });
    
    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [AdminController::class, 'transaksiIndex'])->name('index');
        Route::get('/{id}', [AdminController::class, 'transaksiShow'])->name('show');
        Route::post('/{id}/verify', [AdminController::class, 'transaksiVerify'])->name('verify');
        Route::post('/{id}/reject', [AdminController::class, 'transaksiReject'])->name('reject');
    });
    
    // Informasi
    Route::prefix('informasi')->name('informasi.')->group(function () {
        Route::get('/', [AdminController::class, 'informasiIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'informasiCreate'])->name('create');
        Route::post('/', [AdminController::class, 'informasiStore'])->name('store');
        Route::delete('/{id}', [AdminController::class, 'informasiDestroy'])->name('destroy');
    });
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminController::class, 'laporanIndex'])->name('index');
        Route::get('/siswa', [AdminController::class, 'laporanSiswa'])->name('siswa');
        Route::get('/transaksi', [AdminController::class, 'laporanTransaksi'])->name('transaksi');
        Route::get('/kemajuan/{id}', [AdminController::class, 'laporanKemajuanSiswa'])->name('kemajuan');
    });
    
    // Statistik
    Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
});

// ============= ORANG TUA ROUTES =============
Route::middleware(['auth', 'orang_tua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
    
    // Paket
    Route::prefix('paket')->name('paket.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'paketIndex'])->name('index');
        Route::get('/{id}', [OrangTuaController::class, 'paketShow'])->name('show');
    });
    
    // Pendaftaran
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'pendaftaranIndex'])->name('index');
        Route::get('/create', [OrangTuaController::class, 'pendaftaranCreate'])->name('create');
        Route::post('/', [OrangTuaController::class, 'pendaftaranStore'])->name('store');
        Route::get('/{id}', [OrangTuaController::class, 'pendaftaranShow'])->name('show');
    });
    
    // Siswa (Anak)
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'siswaIndex'])->name('index');
        Route::get('/{id}', [OrangTuaController::class, 'siswaShow'])->name('show');
    });
    
    // Jadwal
    Route::get('/jadwal', [OrangTuaController::class, 'jadwalIndex'])->name('jadwal.index');
    
    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'transaksiIndex'])->name('index');
        Route::get('/create', [OrangTuaController::class, 'transaksiCreate'])->name('create');
        Route::post('/', [OrangTuaController::class, 'transaksiStore'])->name('store');
        Route::get('/{id}', [OrangTuaController::class, 'transaksiShow'])->name('show');
    });
    
    // Riwayat Pembayaran
    Route::get('/riwayat-pembayaran', [OrangTuaController::class, 'riwayatPembayaran'])->name('riwayat-pembayaran');
    
    // Laporan Anak
    Route::get('/laporan-anak/{id}', [OrangTuaController::class, 'laporanAnak'])->name('laporan-anak');
    
    // Informasi
    Route::prefix('informasi')->name('informasi.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'informasiIndex'])->name('index');
    });
    
    // Feedback
    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/create', [OrangTuaController::class, 'feedbackCreate'])->name('create');
        Route::post('/', [OrangTuaController::class, 'feedbackStore'])->name('store');
    });
    
    // Profile
    Route::get('/profile', [OrangTuaController::class, 'profile'])->name('profile');
    Route::post('/profile', [OrangTuaController::class, 'profileUpdate'])->name('profile.update');
    
    // WhatsApp
    Route::get('/whatsapp', [OrangTuaController::class, 'whatsappAdmin'])->name('whatsapp');
});

// ============= SISWA ROUTES =============
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    
    // Jadwal
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [SiswaController::class, 'jadwalIndex'])->name('index');
        Route::get('/{id}', [SiswaController::class, 'jadwalShow'])->name('show');
    });
    
    // Materi
    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('/', [SiswaController::class, 'materiIndex'])->name('index');
        Route::get('/{id}', [SiswaController::class, 'materiShow'])->name('show');
        Route::get('/{id}/download', [SiswaController::class, 'materiDownload'])->name('download');
    });
    
    // Tugas
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [SiswaController::class, 'tugasIndex'])->name('index');
        Route::get('/{id}', [SiswaController::class, 'tugasShow'])->name('show');
        Route::get('/{id}/download', [SiswaController::class, 'tugasDownload'])->name('download');
        Route::post('/{id}/upload', [SiswaController::class, 'tugasUpload'])->name('upload');
    });
    
    // Nilai
    Route::get('/nilai', [SiswaController::class, 'nilaiIndex'])->name('nilai.index');
    
    // Laporan Kemajuan
    Route::get('/laporan-kemajuan', [SiswaController::class, 'laporanKemajuan'])->name('laporan-kemajuan');
    
    // Informasi
    Route::prefix('informasi')->name('informasi.')->group(function () {
        Route::get('/', [SiswaController::class, 'informasiIndex'])->name('index');
        Route::get('/{id}', [SiswaController::class, 'informasiShow'])->name('show');
    });
    
    // Profile
    Route::get('/profile', [SiswaController::class, 'profile'])->name('profile');
    Route::post('/profile', [SiswaController::class, 'profileUpdate'])->name('profile.update');
});