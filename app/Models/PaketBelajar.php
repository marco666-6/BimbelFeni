<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketBelajar extends Model
{
    use HasFactory;

    protected $table = 'paket_belajar';
    protected $primaryKey = 'id_paket';
    public $incrementing = true;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'durasi',
        'komentar',
    ];

    protected $casts = [
        'harga' => 'float',
    ];

    // Relationships
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_paket', 'id_paket');
    }

    public function siswa()
    {
        return $this->hasManyThrough(
            Siswa::class,
            Pendaftaran::class,
            'id_paket',
            'id_siswa',
            'id_paket',
            'id_siswa'
        );
    }

    // Format Methods
    public function getFormattedHarga()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaBulanan()
    {
        return $this->harga / $this->durasi;
    }

    public function getFormattedHargaBulanan()
    {
        return 'Rp ' . number_format($this->getHargaBulanan(), 0, ',', '.');
    }

    // Count Methods
    public function getTotalPendaftar()
    {
        return $this->pendaftaran()->count();
    }

    public function getPendaftarMenunggu()
    {
        return $this->pendaftaran()
            ->where('status', 'menunggu')
            ->count();
    }

    public function getPendaftarDiterima()
    {
        return $this->pendaftaran()
            ->where('status', 'diterima')
            ->count();
    }

    public function getPendaftarDitolak()
    {
        return $this->pendaftaran()
            ->where('status', 'ditolak')
            ->count();
    }

    // Query Scopes
    public function scopeByHarga($query, $min, $max = null)
    {
        $query->where('harga', '>=', $min);
        if ($max) {
            $query->where('harga', '<=', $max);
        }
        return $query;
    }

    public function scopeByDurasi($query, $durasi)
    {
        return $query->where('durasi', $durasi);
    }

    public function scopeSearchNama($query, $nama)
    {
        return $query->where('nama_paket', 'like', "%$nama%");
    }
}