<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Users - Inti autentikasi
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'orangtua', 'siswa'])->default('siswa');
            $table->string('foto_profil')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Orang Tua - Detail profil orang tua
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('no_telepon', 20);
            $table->text('alamat');
            $table->string('pekerjaan')->nullable();
            $table->timestamps();
        });

        // Tabel Siswa - Detail profil siswa
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('orangtua_id')->constrained('orang_tua')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->enum('jenjang', ['SD', 'SMP']);
            $table->string('kelas', 10);
            $table->timestamps();
        });

        // Tabel Paket Belajar - Paket pembelajaran
        Schema::create('paket_belajar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->text('deskripsi');
            $table->float('harga', 10);
            $table->integer('durasi_bulan');
            $table->enum('jenjang', ['SD', 'SMP', 'SD & SMP']);
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();
        });

        // Tabel Transaksi - Pembelian paket
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('orangtua_id')->constrained('orang_tua')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('paket_id')->constrained('paket_belajar')->onDelete('cascade');
            $table->float('total_pembayaran', 10);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
        });

        // Tabel Jadwal - Penjadwalan kelas
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->string('nama_guru');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan')->nullable();
            $table->timestamps();
        });

        // Tabel Kehadiran - Absensi siswa
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha'])->default('alpha');
            $table->date('tanggal_pertemuan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Materi Tugas - Materi dan tugas pembelajaran
        Schema::create('materi_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('tipe', ['materi', 'tugas']);
            $table->string('mata_pelajaran');
            $table->enum('jenjang', ['SD', 'SMP']);
            $table->string('file_path')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->timestamps();
        });

        // Tabel Pengumpulan Tugas - Submit tugas siswa
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materi_tugas_id')->constrained('materi_tugas')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamp('tanggal_pengumpulan')->useCurrent();
            $table->float('nilai', 5)->nullable();
            $table->text('feedback_guru')->nullable();
            $table->timestamps();
        });

        // Tabel Feedback - Tanggapan orang tua
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orangtua_id')->constrained('orang_tua')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->text('isi_feedback');
            $table->timestamp('tanggal_feedback')->useCurrent();
            $table->enum('status', ['baru', 'dibaca'])->default('baru');
            $table->text('balasan_admin')->nullable();
            $table->timestamps();
        });

        // Tabel Notifikasi - Notifikasi sistem
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['pengumuman', 'jadwal', 'pembayaran', 'feedback', 'tugas', 'lainnya']);
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });

        // Tabel Log Activity - Riwayat aktivitas siswa
        Schema::create('log_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('jenis_aktivitas');
            $table->text('deskripsi');
            $table->timestamp('waktu_aktivitas')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        // Tabel Pengumuman - Broadcast message
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->enum('target', ['semua', 'orangtua', 'siswa'])->default('semua');
            $table->timestamp('tanggal_publikasi')->useCurrent();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Settings - Konfigurasi website
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_website');
            $table->string('logo')->nullable();
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email');
            $table->text('tentang')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('log_activity');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('pengumpulan_tugas');
        Schema::dropIfExists('materi_tugas');
        Schema::dropIfExists('kehadiran');
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('paket_belajar');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('orang_tua');
        Schema::dropIfExists('users');
    }
};