<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';

    protected $fillable = [
        'jadwal_id',
        'siswa_id',
        'status',
        'tanggal_pertemuan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
    ];

    // Relasi Many-to-One dengan Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'hadir' => 'success',
            'sakit' => 'warning',
            'izin' => 'info',
            'alpha' => 'danger',
            default => 'secondary',
        };
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alpha' => 'Alpha',
            default => 'Tidak Diketahui',
        };
    }

    // Check status methods
    public function isHadir()
    {
        return $this->status === 'hadir';
    }

    public function isSakit()
    {
        return $this->status === 'sakit';
    }

    public function isIzin()
    {
        return $this->status === 'izin';
    }

    public function isAlpha()
    {
        return $this->status === 'alpha';
    }

    // Scope untuk filter status
    public function scopeHadir($query)
    {
        return $query->where('status', 'hadir');
    }

    public function scopeSakit($query)
    {
        return $query->where('status', 'sakit');
    }

    public function scopeIzin($query)
    {
        return $query->where('status', 'izin');
    }

    public function scopeAlpha($query)
    {
        return $query->where('status', 'alpha');
    }

    // Scope untuk bulan tertentu
    public function scopeBulan($query, $bulan, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        return $query->whereYear('tanggal_pertemuan', $tahun)
                    ->whereMonth('tanggal_pertemuan', $bulan);
    }

    // Scope untuk siswa tertentu
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }
}