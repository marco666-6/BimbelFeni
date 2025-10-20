<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;

    protected $fillable = [
        'id_orang_tua',
        'id_siswa',
        'jumlah',
        'tanggal_bayar',
        'bukti_bayar_path',
        'status',
        'keterangan',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'jumlah' => 'float',
    ];

    // Relationships
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orang_tua', 'id_orang_tua');
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

    public function isDiverifikasi()
    {
        return $this->status === 'diverifikasi';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    // Format Methods
    public function getFormattedJumlah()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getTanggalBayarFormatted()
    {
        return $this->tanggal_bayar->format('d-m-Y');
    }

    public function getStatusBadge()
    {
        $badges = [
            'menunggu' => 'warning',
            'diverifikasi' => 'success',
            'ditolak' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    // Query Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiverifikasi($query)
    {
        return $query->where('status', 'diverifikasi');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeByOrangTua($query, $id_orang_tua)
    {
        return $query->where('id_orang_tua', $id_orang_tua);
    }

    public function scopeBySiswa($query, $id_siswa)
    {
        return $query->where('id_siswa', $id_siswa);
    }

    public function scopeByTanggal($query, $start, $end = null)
    {
        $query->where('tanggal_bayar', '>=', $start);
        if ($end) {
            $query->where('tanggal_bayar', '<=', $end);
        }
        return $query;
    }

    public function scopeByJumlah($query, $min, $max = null)
    {
        $query->where('jumlah', '>=', $min);
        if ($max) {
            $query->where('jumlah', '<=', $max);
        }
        return $query;
    }
}