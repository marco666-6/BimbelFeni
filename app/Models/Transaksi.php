<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'orangtua_id',
        'siswa_id',
        'paket_id',
        'total_pembayaran',
        'bukti_pembayaran',
        'status_verifikasi',
        'catatan_admin',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'total_pembayaran' => 'float',
        'tanggal_transaksi' => 'datetime',
    ];

    // Generate kode transaksi otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            if (empty($transaksi->kode_transaksi)) {
                $transaksi->kode_transaksi = 'TRX' . date('Ymd') . Str::upper(Str::random(6));
            }
        });
    }

    // Relasi Many-to-One dengan OrangTua
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'orangtua_id');
    }

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi Many-to-One dengan PaketBelajar
    public function paketBelajar()
    {
        return $this->belongsTo(PaketBelajar::class, 'paket_id');
    }

    // Get bukti pembayaran URL
    public function getBuktiPembayaranUrlAttribute()
    {
        if ($this->bukti_pembayaran) {
            return asset('storage/' . $this->bukti_pembayaran);
        }
        return null;
    }

    // Get total pembayaran formatted
    public function getTotalPembayaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_pembayaran, 0, ',', '.');
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_verifikasi) {
            'pending' => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status_verifikasi) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    // Check status
    public function isPending()
    {
        return $this->status_verifikasi === 'pending';
    }

    public function isVerified()
    {
        return $this->status_verifikasi === 'verified';
    }

    public function isRejected()
    {
        return $this->status_verifikasi === 'rejected';
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_verifikasi', 'rejected');
    }
}