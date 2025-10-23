<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\PaketBelajar;
use App\Models\Settings;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Settings
        Settings::create([
            'nama_website' => 'Bimbel Oriana Enilin',
            'logo' => null,
            'alamat' => 'Batam, Kepulauan Riau, Indonesia',
            'no_telepon' => '081234567890',
            'email' => 'info@bimbeloriana.com',
            'tentang' => 'Bimbel Oriana Enilin adalah lembaga bimbingan belajar terpercaya yang telah beroperasi selama 5 tahun di Batam. Kami menyediakan program pembelajaran untuk siswa SD dan SMP dengan tenaga pengajar berpengalaman.',
            'nama_bank' => 'Bank BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Oriana Enilin',
        ]);

        // Create Admin User
        $admin1 = User::create([
            'username' => 'admin1',
            'email' => 'admin1@bimbeloriana.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        $admin2 = User::create([
            'username' => 'admin2',
            'email' => 'admin2@bimbeloriana.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        // Create Orang Tua Users
        $orangTua1User = User::create([
            'username' => 'budi_santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        $orangTua1 = OrangTua::create([
            'user_id' => $orangTua1User->id,
            'nama_lengkap' => 'Budi Santoso',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Merdeka No. 123, Batam',
            'pekerjaan' => 'Wiraswasta',
        ]);

        $orangTua2User = User::create([
            'username' => 'siti_rahayu',
            'email' => 'siti@email.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        $orangTua2 = OrangTua::create([
            'user_id' => $orangTua2User->id,
            'nama_lengkap' => 'Siti Rahayu',
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Sudirman No. 456, Batam',
            'pekerjaan' => 'PNS',
        ]);

        // Create Siswa Users
        $siswa1User = User::create([
            'username' => 'ahmad_fauzi',
            'email' => 'ahmad@email.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        Siswa::create([
            'user_id' => $siswa1User->id,
            'orangtua_id' => $orangTua1->id,
            'nama_lengkap' => 'Ahmad Fauzi',
            'tanggal_lahir' => '2012-05-15',
            'jenjang' => 'SD',
            'kelas' => '5',
        ]);

        $siswa2User = User::create([
            'username' => 'rina_putri',
            'email' => 'rina@email.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        Siswa::create([
            'user_id' => $siswa2User->id,
            'orangtua_id' => $orangTua1->id,
            'nama_lengkap' => 'Rina Putri',
            'tanggal_lahir' => '2010-08-20',
            'jenjang' => 'SMP',
            'kelas' => '8',
        ]);

        $siswa3User = User::create([
            'username' => 'dani_pratama',
            'email' => 'dani@email.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'foto_profil' => null,
            'status' => 'aktif',
        ]);

        Siswa::create([
            'user_id' => $siswa3User->id,
            'orangtua_id' => $orangTua2->id,
            'nama_lengkap' => 'Dani Pratama',
            'tanggal_lahir' => '2013-03-10',
            'jenjang' => 'SD',
            'kelas' => '4',
        ]);

        // Create Paket Belajar
        PaketBelajar::create([
            'nama_paket' => 'Paket SD Reguler',
            'deskripsi' => 'Paket belajar untuk siswa SD kelas 1-6 dengan bimbingan semua mata pelajaran.',
            'harga' => 500000,
            'durasi_bulan' => 1,
            'jenjang' => 'SD',
            'status' => 'tersedia',
        ]);

        PaketBelajar::create([
            'nama_paket' => 'Paket SMP Reguler',
            'deskripsi' => 'Paket belajar untuk siswa SMP kelas 7-9 dengan bimbingan semua mata pelajaran.',
            'harga' => 600000,
            'durasi_bulan' => 1,
            'jenjang' => 'SMP',
            'status' => 'tersedia',
        ]);

        PaketBelajar::create([
            'nama_paket' => 'Paket Intensif SD',
            'deskripsi' => 'Paket belajar intensif untuk persiapan ujian siswa SD dengan 3x pertemuan per minggu.',
            'harga' => 1200000,
            'durasi_bulan' => 3,
            'jenjang' => 'SD',
            'status' => 'tersedia',
        ]);

        PaketBelajar::create([
            'nama_paket' => 'Paket Intensif SMP',
            'deskripsi' => 'Paket belajar intensif untuk persiapan ujian siswa SMP dengan 3x pertemuan per minggu.',
            'harga' => 1500000,
            'durasi_bulan' => 3,
            'jenjang' => 'SMP',
            'status' => 'tersedia',
        ]);

        PaketBelajar::create([
            'nama_paket' => 'Paket Kombinasi SD & SMP',
            'deskripsi' => 'Paket hemat untuk keluarga yang memiliki anak di tingkat SD dan SMP.',
            'harga' => 1000000,
            'durasi_bulan' => 1,
            'jenjang' => 'SD & SMP',
            'status' => 'tersedia',
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@bimbeloriana.com');
        $this->command->info('Password: admin123');
    }
}