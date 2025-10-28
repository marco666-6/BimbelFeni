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

// ============ PUBLIC ROUTES ============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/paket', [HomeController::class, 'paket'])->name('paket');

// ============ AUTH ROUTES ============
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============ ADMIN ROUTES ============
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Orang Tua Management
    Route::get('/orangtua', [AdminController::class, 'orangTua'])->name('orangtua');
    Route::post('/orangtua', [AdminController::class, 'storeOrangTua'])->name('orangtua.store');
    Route::put('/orangtua/{id}', [AdminController::class, 'updateOrangTua'])->name('orangtua.update');
    Route::delete('/orangtua/{id}', [AdminController::class, 'deleteOrangTua'])->name('orangtua.delete');
    
    // Siswa Management
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa');
    Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'deleteSiswa'])->name('siswa.delete');
    
    // Paket Belajar
    Route::get('/paket', [AdminController::class, 'paketBelajar'])->name('paket');
    Route::post('/paket', [AdminController::class, 'storePaket'])->name('paket.store');
    Route::put('/paket/{id}', [AdminController::class, 'updatePaket'])->name('paket.update');
    Route::delete('/paket/{id}', [AdminController::class, 'deletePaket'])->name('paket.delete');
    
    // Transaksi & Pembayaran
    Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('transaksi');
    Route::put('/transaksi/{id}/verifikasi', [AdminController::class, 'verifikasiTransaksi'])->name('transaksi.verifikasi');
    
    // Jadwal
    Route::get('/jadwal', [AdminController::class, 'jadwal'])->name('jadwal');
    Route::post('/jadwal', [AdminController::class, 'storeJadwal'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [AdminController::class, 'deleteJadwal'])->name('jadwal.delete');
    
    // Kehadiran
    Route::get('/kehadiran', [AdminController::class, 'kehadiran'])->name('kehadiran');
    Route::post('/kehadiran', [AdminController::class, 'storeKehadiran'])->name('kehadiran.store');
    Route::put('/kehadiran/{id}', [AdminController::class, 'updateKehadiran'])->name('kehadiran.update');
    Route::delete('/kehadiran/{id}', [AdminController::class, 'deleteKehadiran'])->name('kehadiran.delete');
    Route::get('/kehadiran/{id}/data', [AdminController::class, 'getKehadiranData']);
    Route::put('/kehadiran/{id}/update-status', [AdminController::class, 'updateStatusKehadiran']);
    Route::post('/kehadiran/absensi-massal-jadwal', [AdminController::class, 'absensiMassalJadwal'])->name('kehadiran.absensi-massal-jadwal');
    Route::post('/kehadiran/absensi-massal-semua', [AdminController::class, 'absensiMassalSemua'])->name('kehadiran.absensi-massal-semua');
    Route::get('/laporan-kehadiran', [AdminController::class, 'laporanKehadiran']);
    
    // Materi & Tugas
    Route::get('/materi-tugas', [AdminController::class, 'materiTugas'])->name('materi-tugas');
    Route::post('/materi-tugas', [AdminController::class, 'storeMateriTugas'])->name('materi-tugas.store');
    Route::put('/materi-tugas/{id}', [AdminController::class, 'updateMateriTugas'])->name('materi-tugas.update');
    Route::delete('/materi-tugas/{id}', [AdminController::class, 'deleteMateriTugas'])->name('materi-tugas.delete');
    
    // Pengumpulan Tugas
    Route::get('/pengumpulan-tugas', [AdminController::class, 'pengumpulanTugas'])->name('pengumpulan-tugas');
    Route::put('/pengumpulan-tugas/{id}/nilai', [AdminController::class, 'nilaiTugas'])->name('pengumpulan-tugas.nilai');
    
    // Feedback
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
    Route::put('/feedback/{id}/balas', [AdminController::class, 'balasFeedback'])->name('feedback.balas');
    Route::delete('/feedback/{id}', [AdminController::class, 'deleteFeedback'])->name('feedback.delete');
    
    // Pengumuman
    Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
    Route::post('/pengumuman', [AdminController::class, 'storePengumuman'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [AdminController::class, 'updatePengumuman'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [AdminController::class, 'deletePengumuman'])->name('pengumuman.delete');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Laporan
    Route::get('/laporan-siswa', [AdminController::class, 'laporanSiswa'])->name('laporan-siswa');
    Route::get('/laporan-siswa/{id}', [AdminController::class, 'detailLaporanSiswa'])->name('laporan-siswa.detail');
    
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
});

// ============ ORANG TUA ROUTES ============
Route::middleware(['auth', 'orang_tua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrangTuaController::class, 'dashboard'])->name('dashboard');
    
    // Monitoring Anak
    Route::get('/anak', [OrangTuaController::class, 'anak'])->name('anak');
    Route::get('/anak/{id}', [OrangTuaController::class, 'detailAnak'])->name('anak.detail');
    Route::get('/anak/{id}/jadwal', [OrangTuaController::class, 'jadwalAnak'])->name('anak.jadwal');
    Route::get('/anak/{id}/log-activity', [OrangTuaController::class, 'logActivity'])->name('anak.log-activity');
    Route::get('/anak/{id}/rapor', [OrangTuaController::class, 'raporAnak'])->name('anak.rapor');
    
    // Paket & Pembayaran
    Route::get('/paket-belajar', [OrangTuaController::class, 'paketBelajar'])->name('paket-belajar');
    Route::post('/paket-belajar/beli', [OrangTuaController::class, 'beliPaket'])->name('paket-belajar.beli');
    Route::get('/transaksi', [OrangTuaController::class, 'transaksi'])->name('transaksi');
    
    // Feedback
    Route::get('/feedback', [OrangTuaController::class, 'feedback'])->name('feedback');
    Route::post('/feedback', [OrangTuaController::class, 'storeFeedback'])->name('feedback.store');
    
    // Pengumuman
    Route::get('/pengumuman', [OrangTuaController::class, 'pengumuman'])->name('pengumuman');
    
    // Notifikasi
    Route::get('/notifikasi', [OrangTuaController::class, 'notifikasi'])->name('notifikasi');
    Route::put('/notifikasi/{id}/read', [OrangTuaController::class, 'markNotifikasiRead'])->name('notifikasi.read');
    
    // Profile
    Route::get('/profile', [OrangTuaController::class, 'profile'])->name('profile');
    Route::put('/profile', [OrangTuaController::class, 'updateProfile'])->name('profile.update');
});

// ============ SISWA ROUTES ============
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    
    // Materi & Tugas
    Route::get('/materi-tugas', [SiswaController::class, 'materiTugas'])->name('materi-tugas');
    Route::get('/materi-tugas/{id}', [SiswaController::class, 'detailMateriTugas'])->name('materi-tugas.detail');
    Route::get('/materi-tugas/{id}/download', [SiswaController::class, 'downloadMateriTugas'])->name('materi-tugas.download');
    Route::post('/tugas/kumpulkan', [SiswaController::class, 'kumpulkanTugas'])->name('tugas.kumpulkan');
    
    // Jadwal
    Route::get('/jadwal', [SiswaController::class, 'jadwal'])->name('jadwal');
    
    // Nilai & Rapor
    Route::get('/nilai', [SiswaController::class, 'nilai'])->name('nilai');
    Route::get('/rapor', [SiswaController::class, 'rapor'])->name('rapor');
    
    // Kehadiran
    Route::get('/kehadiran', [SiswaController::class, 'kehadiran'])->name('kehadiran');
    
    // Pengumuman
    Route::get('/pengumuman', [SiswaController::class, 'pengumuman'])->name('pengumuman');
    Route::get('/pengumuman/{id}', [SiswaController::class, 'detailPengumuman'])->name('pengumuman.detail');
    
    // Notifikasi
    Route::get('/notifikasi', [SiswaController::class, 'notifikasi'])->name('notifikasi');
    Route::put('/notifikasi/{id}/read', [SiswaController::class, 'markNotifikasiRead'])->name('notifikasi.read');
    Route::put('/notifikasi/read-all', [SiswaController::class, 'markAllNotifikasiRead'])->name('notifikasi.read-all');
    
    // Profile
    Route::get('/profile', [SiswaController::class, 'profile'])->name('profile');
    Route::put('/profile', [SiswaController::class, 'updateProfile'])->name('profile.update');
});