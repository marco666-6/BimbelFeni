<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'id_orang_tua',
        'nama_siswa',
        'tanggal_lahir',
        'jenjang',
        'kelas',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orang_tua', 'id_orang_tua');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_siswa', 'id_siswa');
    }

    public function jadwalMateri()
    {
        return $this->hasMany(JadwalMateri::class, 'id_siswa', 'id_siswa');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_siswa', 'id_siswa');
    }

    public function informasi()
    {
        return $this->hasMany(Informasi::class, 'id_siswa', 'id_siswa');
    }

    public function paketBelajar()
    {
        return $this->hasManyThrough(
            PaketBelajar::class,
            Pendaftaran::class,
            'id_siswa',
            'id_paket',
            'id_siswa',
            'id_paket'
        );
    }

    // Status Check Methods
    public function isAktif()
    {
        return $this->status === 'aktif';
    }

    public function isNonAktif()
    {
        return $this->status === 'non-aktif';
    }

    // Age & Date Methods
    public function getUmur()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getTanggalLahirFormatted()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d-m-Y') : '-';
    }

    public function isSD()
    {
        return $this->jenjang === 'SD';
    }

    public function isSMP()
    {
        return $this->jenjang === 'SMP';
    }

    // Task & Schedule Methods
    public function getTugasSelesai()
    {
        return $this->jadwalMateri()
            ->where('jenis', 'tugas')
            ->where('status', 'selesai')
            ->count();
    }

    public function getTugasPending()
    {
        return $this->jadwalMateri()
            ->where('jenis', 'tugas')
            ->where('status', 'pending')
            ->count();
    }

    public function getTugasTerlambat()
    {
        return $this->jadwalMateri()
            ->where('jenis', 'tugas')
            ->where('status', 'terlambat')
            ->count();
    }

    public function getMateriCount()
    {
        return $this->jadwalMateri()
            ->where('jenis', 'materi')
            ->count();
    }

    public function getNilaiRataRata()
    {
        return $this->jadwalMateri()
            ->whereNotNull('nilai')
            ->avg('nilai');
    }

    public function getNilaiTertinggi()
    {
        return $this->jadwalMateri()
            ->whereNotNull('nilai')
            ->max('nilai');
    }

    public function getNilaiTerendah()
    {
        return $this->jadwalMateri()
            ->whereNotNull('nilai')
            ->min('nilai');
    }

    // Transaction Methods
    public function getTotalBayar()
    {
        return $this->transaksi()
            ->where('status', 'diverifikasi')
            ->sum('jumlah');
    }

    public function getTransaksiPending()
    {
        return $this->transaksi()
            ->where('status', 'menunggu')
            ->sum('jumlah');
    }

    // Query Scopes
    public function scopeByJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonAktif($query)
    {
        return $query->where('status', 'non-aktif');
    }

    public function scopeByOrangTua($query, $id_orang_tua)
    {
        return $query->where('id_orang_tua', $id_orang_tua);
    }
}