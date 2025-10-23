<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'pekerjaan',
    ];

    // Relasi Many-to-One dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi One-to-Many dengan Siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'orangtua_id');
    }

    // Relasi One-to-Many dengan Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'orangtua_id');
    }

    // Relasi One-to-Many dengan Feedback
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'orangtua_id');
    }

    // Get total anak terdaftar
    public function getTotalAnakAttribute()
    {
        return $this->siswa()->count();
    }

    // Get total transaksi
    public function getTotalTransaksiAttribute()
    {
        return $this->transaksi()->count();
    }

    // Get transaksi yang pending
    public function getTransaksiPendingAttribute()
    {
        return $this->transaksi()->where('status_verifikasi', 'pending')->count();
    }

    // Get total pembayaran verified
    public function getTotalPembayaranVerifiedAttribute()
    {
        return $this->transaksi()
            ->where('status_verifikasi', 'verified')
            ->sum('total_pembayaran');
    }
}