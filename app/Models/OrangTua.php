<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';
    protected $primaryKey = 'id_orang_tua';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'nama_orang_tua',
        'hubungan',
        'pekerjaan',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_orang_tua', 'id_orang_tua');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_orang_tua', 'id_orang_tua');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_orang_tua', 'id_orang_tua');
    }

    // Count Methods
    public function getTotalSiswa()
    {
        return $this->siswa()->count();
    }

    public function getSiswaAktif()
    {
        return $this->siswa()
            ->where('status', 'aktif')
            ->count();
    }

    public function getSiswaNonAktif()
    {
        return $this->siswa()
            ->where('status', 'non-aktif')
            ->count();
    }

    // Pendaftaran Methods
    public function getPendaftaranMenunggu()
    {
        return $this->pendaftaran()
            ->where('status', 'menunggu')
            ->count();
    }

    public function getPendaftaranDiterima()
    {
        return $this->pendaftaran()
            ->where('status', 'diterima')
            ->count();
    }

    public function getPendaftaranDitolak()
    {
        return $this->pendaftaran()
            ->where('status', 'ditolak')
            ->count();
    }

    // Transaction Methods
    public function getTotalTransaksi()
    {
        return $this->transaksi()
            ->sum('jumlah');
    }

    public function getTotalBayarVerifikasi()
    {
        return $this->transaksi()
            ->where('status', 'diverifikasi')
            ->sum('jumlah');
    }

    public function getTotalBayarMenunggu()
    {
        return $this->transaksi()
            ->where('status', 'menunggu')
            ->sum('jumlah');
    }

    public function getTotalBayarDitolak()
    {
        return $this->transaksi()
            ->where('status', 'ditolak')
            ->sum('jumlah');
    }

    public function getTransaksiMenunggu()
    {
        return $this->transaksi()
            ->where('status', 'menunggu')
            ->count();
    }

    // Query Scopes
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama_orang_tua', 'like', "%$nama%");
    }

    public function scopeByPekerjaan($query, $pekerjaan)
    {
        return $query->where('pekerjaan', $pekerjaan);
    }

    public function scopeByHubungan($query, $hubungan)
    {
        return $query->where('hubungan', $hubungan);
    }
}