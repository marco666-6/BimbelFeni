<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketBelajar extends Model
{
    use HasFactory;

    protected $table = 'paket_belajar';

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'durasi_bulan',
        'jenjang',
        'status',
    ];

    protected $casts = [
        'harga' => 'float',
    ];

    // Relasi One-to-Many dengan Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'paket_id');
    }

    // Get harga formatted
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Check if paket tersedia
    public function isTersedia()
    {
        return $this->status === 'tersedia';
    }

    // Get total pembelian paket
    public function getTotalPembelianAttribute()
    {
        return $this->transaksi()
            ->where('status_verifikasi', 'verified')
            ->count();
    }

    // Get total pendapatan dari paket
    public function getTotalPendapatanAttribute()
    {
        return $this->transaksi()
            ->where('status_verifikasi', 'verified')
            ->sum('total_pembayaran');
    }

    // Scope untuk paket tersedia
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    // Scope untuk jenjang tertentu
    public function scopeJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang)
            ->orWhere('jenjang', 'SD & SMP');
    }
}