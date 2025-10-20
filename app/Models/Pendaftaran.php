<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    public $incrementing = true;

    protected $fillable = [
        'id_orang_tua',
        'id_paket',
        'id_siswa',
        'tanggal_daftar',
        'tanggal_selesai',
        'status',
        'catatan',
        'id_jawaban_paket',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relationships
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orang_tua', 'id_orang_tua');
    }

    public function paketBelajar()
    {
        return $this->belongsTo(PaketBelajar::class, 'id_paket', 'id_paket');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // Status Check Methods
    public function isMenunggu()
    {
        return $this->status === 'menunggu';
    }

    public function isDiterima()
    {
        return $this->status === 'diterima';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    public function isActive()
    {
        return $this->isDiterima() && (!$this->tanggal_selesai || now()->lessThan($this->tanggal_selesai));
    }

    public function isExpired()
    {
        return $this->tanggal_selesai && now()->greaterThan($this->tanggal_selesai);
    }

    // Utility Methods
    public function getTanggalDaftarFormatted()
    {
        return $this->tanggal_daftar->format('d-m-Y');
    }

    public function getTanggalSelesaiFormatted()
    {
        return $this->tanggal_selesai ? $this->tanggal_selesai->format('d-m-Y') : 'Belum Selesai';
    }

    public function getSisaDurasi()
    {
        if (!$this->tanggal_selesai || !$this->isDiterima()) {
            return null;
        }
        return now()->diffInDays($this->tanggal_selesai);
    }

    // Query Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'diterima')
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where('tanggal_selesai', '<', now());
    }

    public function scopeByOrangTua($query, $id_orang_tua)
    {
        return $query->where('id_orang_tua', $id_orang_tua);
    }

    public function scopeByPaket($query, $id_paket)
    {
        return $query->where('id_paket', $id_paket);
    }
}