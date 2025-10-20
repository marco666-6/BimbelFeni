<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $adminUser = DB::table('users')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@feni.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
            'foto_profil' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Parent Users
        $parentUsers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Merdeka No. 45, Jakarta Selatan',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Sudirman No. 78, Jakarta Pusat',
            ],
            [
                'name' => 'Ahmad Dahlan',
                'email' => 'ahmad.dahlan@email.com',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Gatot Subroto No. 12, Jakarta Barat',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'password' => Hash::make('password'),
                'role' => 'orang_tua',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Thamrin No. 90, Jakarta Timur',
            ],
        ];

        $parentUserIds = [];
        foreach ($parentUsers as $parent) {
            $parentUserIds[] = DB::table('users')->insertGetId(array_merge($parent, [
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Student Users
        $studentUsers = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@email.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'telepon' => '081234567895',
                'alamat' => 'Jl. Merdeka No. 45, Jakarta Selatan',
            ],
            [
                'name' => 'Maya Kusuma',
                'email' => 'maya.kusuma@email.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'telepon' => '081234567896',
                'alamat' => 'Jl. Sudirman No. 78, Jakarta Pusat',
            ],
            [
                'name' => 'Rian Firmansyah',
                'email' => 'rian.firmansyah@email.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'telepon' => '081234567897',
                'alamat' => 'Jl. Gatot Subroto No. 12, Jakarta Barat',
            ],
            [
                'name' => 'Zahra Amalia',
                'email' => 'zahra.amalia@email.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'telepon' => '081234567898',
                'alamat' => 'Jl. Thamrin No. 90, Jakarta Timur',
            ],
            [
                'name' => 'Farhan Maulana',
                'email' => 'farhan.maulana@email.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'telepon' => '081234567899',
                'alamat' => 'Jl. Merdeka No. 45, Jakarta Selatan',
            ],
        ];

        $studentUserIds = [];
        foreach ($studentUsers as $student) {
            $studentUserIds[] = DB::table('users')->insertGetId(array_merge($student, [
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 2. Seed Orang Tua
        $orangTuaData = [
            [
                'user_id' => $parentUserIds[0],
                'nama_orang_tua' => 'Budi Santoso',
                'hubungan' => 'ayah',
                'pekerjaan' => 'PNS',
            ],
            [
                'user_id' => $parentUserIds[1],
                'nama_orang_tua' => 'Siti Nurhaliza',
                'hubungan' => 'ibu',
                'pekerjaan' => 'Guru',
            ],
            [
                'user_id' => $parentUserIds[2],
                'nama_orang_tua' => 'Ahmad Dahlan',
                'hubungan' => 'ayah',
                'pekerjaan' => 'Wiraswasta',
            ],
            [
                'user_id' => $parentUserIds[3],
                'nama_orang_tua' => 'Dewi Lestari',
                'hubungan' => 'ibu',
                'pekerjaan' => 'Dokter',
            ],
        ];

        $orangTuaIds = [];
        foreach ($orangTuaData as $orangTua) {
            $orangTuaIds[] = DB::table('orang_tua')->insertGetId(array_merge($orangTua, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 3. Seed Siswa
        $siswaData = [
            [
                'user_id' => $studentUserIds[0],
                'id_orang_tua' => $orangTuaIds[0],
                'nama_siswa' => 'Andi Pratama',
                'tanggal_lahir' => '2012-03-15',
                'jenjang' => 'SD',
                'kelas' => '6A',
                'status' => 'aktif',
            ],
            [
                'user_id' => $studentUserIds[1],
                'id_orang_tua' => $orangTuaIds[1],
                'nama_siswa' => 'Maya Kusuma',
                'tanggal_lahir' => '2011-07-22',
                'jenjang' => 'SMP',
                'kelas' => '7B',
                'status' => 'aktif',
            ],
            [
                'user_id' => $studentUserIds[2],
                'id_orang_tua' => $orangTuaIds[2],
                'nama_siswa' => 'Rian Firmansyah',
                'tanggal_lahir' => '2010-11-08',
                'jenjang' => 'SMP',
                'kelas' => '8A',
                'status' => 'aktif',
            ],
            [
                'user_id' => $studentUserIds[3],
                'id_orang_tua' => $orangTuaIds[3],
                'nama_siswa' => 'Zahra Amalia',
                'tanggal_lahir' => '2013-05-30',
                'jenjang' => 'SD',
                'kelas' => '5C',
                'status' => 'aktif',
            ],
            [
                'user_id' => $studentUserIds[4],
                'id_orang_tua' => $orangTuaIds[0],
                'nama_siswa' => 'Farhan Maulana',
                'tanggal_lahir' => '2014-09-12',
                'jenjang' => 'SD',
                'kelas' => '4B',
                'status' => 'aktif',
            ],
        ];

        $siswaIds = [];
        foreach ($siswaData as $siswa) {
            $siswaIds[] = DB::table('siswa')->insertGetId(array_merge($siswa, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 4. Seed Paket Belajar
        $paketBelajarData = [
            [
                'nama_paket' => 'Paket Belajar SD Reguler',
                'deskripsi' => 'Paket belajar untuk siswa SD dengan materi lengkap semua mata pelajaran',
                'harga' => 500000,
                'durasi' => 3,
                'komentar' => 'Cocok untuk siswa SD kelas 1-6',
            ],
            [
                'nama_paket' => 'Paket Belajar SMP Reguler',
                'deskripsi' => 'Paket belajar untuk siswa SMP dengan fokus mata pelajaran utama',
                'harga' => 750000,
                'durasi' => 3,
                'komentar' => 'Cocok untuk siswa SMP kelas 7-9',
            ],
            [
                'nama_paket' => 'Paket Intensif SD',
                'deskripsi' => 'Paket intensif persiapan ujian untuk siswa SD',
                'harga' => 800000,
                'durasi' => 2,
                'komentar' => 'Program intensif dengan jadwal yang lebih padat',
            ],
            [
                'nama_paket' => 'Paket Intensif SMP',
                'deskripsi' => 'Paket intensif persiapan ujian untuk siswa SMP',
                'harga' => 1000000,
                'durasi' => 2,
                'komentar' => 'Program intensif dengan jadwal yang lebih padat',
            ],
            [
                'nama_paket' => 'Paket Private SD',
                'deskripsi' => 'Les privat 1 on 1 untuk siswa SD',
                'harga' => 1200000,
                'durasi' => 1,
                'komentar' => 'Pembelajaran personal dengan tutor berpengalaman',
            ],
            [
                'nama_paket' => 'Paket Private SMP',
                'deskripsi' => 'Les privat 1 on 1 untuk siswa SMP',
                'harga' => 1500000,
                'durasi' => 1,
                'komentar' => 'Pembelajaran personal dengan tutor berpengalaman',
            ],
        ];

        $paketIds = [];
        foreach ($paketBelajarData as $paket) {
            $paketIds[] = DB::table('paket_belajar')->insertGetId(array_merge($paket, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 5. Seed Pendaftaran
        $pendaftaranData = [
            [
                'id_orang_tua' => $orangTuaIds[0],
                'id_paket' => $paketIds[0],
                'id_siswa' => $siswaIds[0],
                'tanggal_daftar' => Carbon::now()->subDays(60),
                'tanggal_selesai' => Carbon::now()->addDays(30),
                'status' => 'diterima',
                'catatan' => 'Pendaftaran disetujui',
                'id_jawaban_paket' => 'JP001',
            ],
            [
                'id_orang_tua' => $orangTuaIds[1],
                'id_paket' => $paketIds[1],
                'id_siswa' => $siswaIds[1],
                'tanggal_daftar' => Carbon::now()->subDays(45),
                'tanggal_selesai' => Carbon::now()->addDays(45),
                'status' => 'diterima',
                'catatan' => 'Pendaftaran disetujui',
                'id_jawaban_paket' => 'JP002',
            ],
            [
                'id_orang_tua' => $orangTuaIds[2],
                'id_paket' => $paketIds[3],
                'id_siswa' => $siswaIds[2],
                'tanggal_daftar' => Carbon::now()->subDays(30),
                'tanggal_selesai' => Carbon::now()->addDays(30),
                'status' => 'diterima',
                'catatan' => 'Pendaftaran disetujui',
                'id_jawaban_paket' => 'JP003',
            ],
            [
                'id_orang_tua' => $orangTuaIds[3],
                'id_paket' => $paketIds[0],
                'id_siswa' => $siswaIds[3],
                'tanggal_daftar' => Carbon::now()->subDays(5),
                'tanggal_selesai' => null,
                'status' => 'menunggu',
                'catatan' => null,
                'id_jawaban_paket' => 'JP004',
            ],
            [
                'id_orang_tua' => $orangTuaIds[0],
                'id_paket' => $paketIds[4],
                'id_siswa' => $siswaIds[4],
                'tanggal_daftar' => Carbon::now()->subDays(20),
                'tanggal_selesai' => Carbon::now()->addDays(10),
                'status' => 'diterima',
                'catatan' => 'Pendaftaran disetujui',
                'id_jawaban_paket' => 'JP005',
            ],
        ];

        foreach ($pendaftaranData as $pendaftaran) {
            DB::table('pendaftaran')->insert(array_merge($pendaftaran, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 6. Seed Jadwal Materi
        $jadwalMateriData = [
            // Materi untuk Andi Pratama (SD)
            [
                'id_siswa' => $siswaIds[0],
                'judul' => 'Matematika: Perkalian dan Pembagian',
                'deskripsi' => 'Mempelajari operasi perkalian dan pembagian bilangan bulat',
                'file' => 'materi_matematika_sd_01.pdf',
                'jenis' => 'materi',
                'durasi' => 120,
                'awal' => Carbon::now()->subDays(5),
                'nilai' => null,
                'deadline' => null,
                'status' => 'selesai',
            ],
            [
                'id_siswa' => $siswaIds[0],
                'judul' => 'Tugas Matematika: Soal Cerita',
                'deskripsi' => 'Mengerjakan 10 soal cerita tentang perkalian dan pembagian',
                'file' => null,
                'jenis' => 'tugas',
                'durasi' => 60,
                'awal' => Carbon::now()->subDays(3),
                'nilai' => 85,
                'deadline' => Carbon::now()->addDays(2),
                'status' => 'selesai',
            ],
            [
                'id_siswa' => $siswaIds[0],
                'judul' => 'Bahasa Indonesia: Membaca Pemahaman',
                'deskripsi' => 'Membaca teks dan menjawab pertanyaan pemahaman',
                'file' => 'materi_bahasa_indonesia_01.pdf',
                'jenis' => 'materi',
                'durasi' => 90,
                'awal' => Carbon::now(),
                'nilai' => null,
                'deadline' => null,
                'status' => 'pending',
            ],
            // Materi untuk Maya Kusuma (SMP)
            [
                'id_siswa' => $siswaIds[1],
                'judul' => 'Matematika: Aljabar Dasar',
                'deskripsi' => 'Pengenalan variabel dan operasi aljabar',
                'file' => 'materi_matematika_smp_01.pdf',
                'jenis' => 'materi',
                'durasi' => 150,
                'awal' => Carbon::now()->subDays(7),
                'nilai' => null,
                'deadline' => null,
                'status' => 'selesai',
            ],
            [
                'id_siswa' => $siswaIds[1],
                'judul' => 'Tugas Aljabar: Latihan Soal',
                'deskripsi' => 'Mengerjakan 15 soal aljabar',
                'file' => null,
                'jenis' => 'tugas',
                'durasi' => 90,
                'awal' => Carbon::now()->subDays(4),
                'nilai' => 90,
                'deadline' => Carbon::now()->addDays(3),
                'status' => 'selesai',
            ],
            [
                'id_siswa' => $siswaIds[1],
                'judul' => 'IPA: Sistem Tata Surya',
                'deskripsi' => 'Mempelajari planet-planet dalam tata surya',
                'file' => 'materi_ipa_smp_01.pdf',
                'jenis' => 'materi',
                'durasi' => 120,
                'awal' => Carbon::now()->addDays(1),
                'nilai' => null,
                'deadline' => null,
                'status' => 'pending',
            ],
            // Materi untuk Rian Firmansyah (SMP)
            [
                'id_siswa' => $siswaIds[2],
                'judul' => 'Bahasa Inggris: Simple Present Tense',
                'deskripsi' => 'Memahami penggunaan simple present tense',
                'file' => 'materi_english_smp_01.pdf',
                'jenis' => 'materi',
                'durasi' => 100,
                'awal' => Carbon::now()->subDays(10),
                'nilai' => null,
                'deadline' => null,
                'status' => 'selesai',
            ],
            [
                'id_siswa' => $siswaIds[2],
                'judul' => 'Tugas Bahasa Inggris: Membuat Kalimat',
                'deskripsi' => 'Membuat 20 kalimat menggunakan simple present tense',
                'file' => null,
                'jenis' => 'tugas',
                'durasi' => 60,
                'awal' => Carbon::now()->subDays(15),
                'nilai' => 75,
                'deadline' => Carbon::now()->subDays(10),
                'status' => 'terlambat',
            ],
        ];

        foreach ($jadwalMateriData as $jadwal) {
            DB::table('jadwal_materi')->insert(array_merge($jadwal, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 7. Seed Transaksi
        $transaksiData = [
            [
                'id_orang_tua' => $orangTuaIds[0],
                'id_siswa' => $siswaIds[0],
                'jumlah' => 500000,
                'tanggal_bayar' => Carbon::now()->subDays(55),
                'bukti_bayar_path' => 'bukti_bayar/bukti_001.jpg',
                'status' => 'diverifikasi',
                'keterangan' => 'Pembayaran paket SD Reguler untuk Andi Pratama',
                'diverifikasi_pada' => Carbon::now()->subDays(54)->toDateTimeString(),
            ],
            [
                'id_orang_tua' => $orangTuaIds[1],
                'id_siswa' => $siswaIds[1],
                'jumlah' => 750000,
                'tanggal_bayar' => Carbon::now()->subDays(40),
                'bukti_bayar_path' => 'bukti_bayar/bukti_002.jpg',
                'status' => 'diverifikasi',
                'keterangan' => 'Pembayaran paket SMP Reguler untuk Maya Kusuma',
                'diverifikasi_pada' => Carbon::now()->subDays(39)->toDateTimeString(),
            ],
            [
                'id_orang_tua' => $orangTuaIds[2],
                'id_siswa' => $siswaIds[2],
                'jumlah' => 1000000,
                'tanggal_bayar' => Carbon::now()->subDays(25),
                'bukti_bayar_path' => 'bukti_bayar/bukti_003.jpg',
                'status' => 'diverifikasi',
                'keterangan' => 'Pembayaran paket Intensif SMP untuk Rian Firmansyah',
                'diverifikasi_pada' => Carbon::now()->subDays(24)->toDateTimeString(),
            ],
            [
                'id_orang_tua' => $orangTuaIds[0],
                'id_siswa' => $siswaIds[4],
                'jumlah' => 1200000,
                'tanggal_bayar' => Carbon::now()->subDays(15),
                'bukti_bayar_path' => 'bukti_bayar/bukti_004.jpg',
                'status' => 'diverifikasi',
                'keterangan' => 'Pembayaran paket Private SD untuk Farhan Maulana',
                'diverifikasi_pada' => Carbon::now()->subDays(14)->toDateTimeString(),
            ],
            [
                'id_orang_tua' => $orangTuaIds[3],
                'id_siswa' => $siswaIds[3],
                'jumlah' => 500000,
                'tanggal_bayar' => Carbon::now()->subDays(2),
                'bukti_bayar_path' => 'bukti_bayar/bukti_005.jpg',
                'status' => 'menunggu',
                'keterangan' => 'Pembayaran paket SD Reguler untuk Zahra Amalia',
                'diverifikasi_pada' => null,
            ],
        ];

        foreach ($transaksiData as $transaksi) {
            DB::table('transaksi')->insert(array_merge($transaksi, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 8. Seed Informasi (Pengumuman)
        $informasiData = [
            [
                'id_siswa' => null,
                'id_pengguna' => $adminUser,
                'judul' => 'Pengumuman Libur Semester',
                'isi' => 'Libur semester akan dimulai pada tanggal 20 Desember 2024 dan masuk kembali tanggal 6 Januari 2025.',
                'jenis' => 'pengumuman',
                'dibuat_pada' => Carbon::now()->subDays(30)->toDateTimeString(),
                'dibaca' => json_encode([$siswaIds[0], $siswaIds[1]]),
            ],
            [
                'id_siswa' => $siswaIds[0],
                'id_pengguna' => $adminUser,
                'judul' => 'Notifikasi Tugas Baru',
                'isi' => 'Anda memiliki tugas baru di mata pelajaran Matematika. Deadline: 2 hari lagi.',
                'jenis' => 'notifikasi',
                'dibuat_pada' => Carbon::now()->subDays(3)->toDateTimeString(),
                'dibaca' => json_encode([$siswaIds[0]]),
            ],
            [
                'id_siswa' => $siswaIds[1],
                'id_pengguna' => $adminUser,
                'judul' => 'Notifikasi Nilai Tersedia',
                'isi' => 'Nilai tugas Aljabar Anda sudah tersedia. Nilai: 90',
                'jenis' => 'notifikasi',
                'dibuat_pada' => Carbon::now()->subDays(1)->toDateTimeString(),
                'dibaca' => null,
            ],
            [
                'id_siswa' => null,
                'id_pengguna' => $adminUser,
                'judul' => 'Info Jadwal Try Out',
                'isi' => 'Try Out akan diadakan pada tanggal 15 November 2024 untuk semua siswa SMP.',
                'jenis' => 'pengumuman',
                'dibuat_pada' => Carbon::now()->subDays(15)->toDateTimeString(),
                'dibaca' => json_encode([$siswaIds[1], $siswaIds[2]]),
            ],
            [
                'id_siswa' => $siswaIds[2],
                'id_pengguna' => $adminUser,
                'judul' => 'Peringatan Deadline Tugas',
                'isi' => 'Tugas Bahasa Inggris Anda sudah melewati deadline. Harap segera diselesaikan.',
                'jenis' => 'notifikasi',
                'dibuat_pada' => Carbon::now()->subDays(5)->toDateTimeString(),
                'dibaca' => json_encode([$siswaIds[2]]),
            ],
        ];

        foreach ($informasiData as $info) {
            DB::table('informasi')->insert(array_merge($info, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@feni.com / password');
        $this->command->info('Parent credentials: budi.santoso@email.com / password');
        $this->command->info('Student credentials: andi.pratama@email.com / password');
    }
}