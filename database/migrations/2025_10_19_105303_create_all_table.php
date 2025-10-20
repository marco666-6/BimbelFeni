<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users table (extends default Laravel users)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'orang_tua', 'siswa'])->default('siswa');
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_profil')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. Orang Tua table
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id('id_orang_tua');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_orang_tua');
            $table->string('hubungan')->nullable(); // ayah/ibu/wali
            $table->string('pekerjaan')->nullable();
            $table->timestamps();
        });

        // 2. Siswa table
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_orang_tua')->nullable()->constrained('orang_tua', 'id_orang_tua')->onDelete('set null');
            $table->string('nama_siswa');
            $table->datetime('tanggal_lahir')->nullable();
            $table->enum('jenjang', ['SD', 'SMP'])->default('SD');
            $table->string('kelas')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });

        // 4. Paket Belajar table
        Schema::create('paket_belajar', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('nama_paket');
            $table->text('deskripsi')->nullable();
            $table->float('harga', 10);
            $table->integer('durasi')->comment('durasi dalam bulan');
            $table->text('komentar')->nullable();
            $table->timestamps();
        });

        // 5. Pendaftaran table
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_orang_tua')->constrained('orang_tua', 'id_orang_tua')->onDelete('cascade');
            $table->foreignId('id_paket')->constrained('paket_belajar', 'id_paket')->onDelete('cascade');
            $table->foreignId('id_siswa')->nullable()->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->datetime('tanggal_daftar');
            $table->datetime('tanggal_selesai')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->string('id_jawaban_paket')->nullable();
            $table->timestamps();
        });

        // 6. Jadwal Materi table
        Schema::create('jadwal_materi', function (Blueprint $table) {
            $table->id('id_jadwal_materi');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file')->nullable();
            $table->string('jenis'); // materi/tugas
            $table->integer('durasi')->nullable();
            $table->datetime('awal')->nullable();
            $table->integer('nilai')->nullable();
            $table->datetime('deadline')->nullable();
            $table->enum('status', ['pending', 'selesai', 'terlambat'])->default('pending');
            $table->timestamps();
        });

        // 7. Transaksi table
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_orang_tua')->constrained('orang_tua', 'id_orang_tua')->onDelete('cascade');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->float('jumlah', 10);
            $table->datetime('tanggal_bayar');
            $table->string('bukti_bayar_path')->nullable();
            $table->enum('status', ['menunggu', 'diverifikasi', 'ditolak'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->text('diverifikasi_pada')->nullable();
            $table->timestamps();
        });

        // 8. Informasi table (pengumuman)
        Schema::create('informasi', function (Blueprint $table) {
            $table->id('id_informasi');
            $table->foreignId('id_siswa')->nullable()->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_pengguna')->nullable()->constrained('users')->onDelete('set null');
            $table->string('judul');
            $table->text('isi');
            $table->string('jenis'); // pengumuman/notifikasi
            $table->string('dibuat_pada')->nullable();
            $table->text('dibaca')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('jadwal_materi');
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('paket_belajar');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('orang_tua');
        Schema::dropIfExists('users');
    }
};