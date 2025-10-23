<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'siswa_id',
        'mata_pelajaran',
        'nama_guru',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan Kehadiran
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'jadwal_id');
    }

    // Get jam formatted
    public function getJamFormattedAttribute()
    {
        return Carbon::parse($this->jam_mulai)->format('H:i') . ' - ' . 
               Carbon::parse($this->jam_selesai)->format('H:i');
    }

    // Check if jadwal hari ini
    public function isToday()
    {
        return $this->hari === now()->locale('id')->dayName;
    }

    // Get durasi dalam menit
    public function getDurasiMenitAttribute()
    {
        $mulai = Carbon::parse($this->jam_mulai);
        $selesai = Carbon::parse($this->jam_selesai);
        return $mulai->diffInMinutes($selesai);
    }

    // Get total pertemuan
    public function getTotalPertemuanAttribute()
    {
        return $this->kehadiran()->count();
    }

    // Get persentase kehadiran siswa di jadwal ini
    public function getPersentaseKehadiranAttribute()
    {
        $total = $this->kehadiran()->count();
        if ($total == 0) return 0;
        
        $hadir = $this->kehadiran()->where('status', 'hadir')->count();
        return round(($hadir / $total) * 100, 2);
    }

    // Scope untuk hari tertentu
    public function scopeHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }

    // Scope untuk mata pelajaran tertentu
    public function scopeMataPelajaran($query, $mapel)
    {
        return $query->where('mata_pelajaran', $mapel);
    }

    // Scope untuk siswa tertentu
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    // Check bentrok jadwal
    public static function checkBentrok($hari, $jamMulai, $jamSelesai, $siswaId = null, $jadwalId = null)
    {
        $query = self::where('hari', $hari)
            ->where(function($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                  ->orWhere(function($q2) use ($jamMulai, $jamSelesai) {
                      $q2->where('jam_mulai', '<=', $jamMulai)
                         ->where('jam_selesai', '>=', $jamSelesai);
                  });
            });

        if ($siswaId) {
            $query->where('siswa_id', $siswaId);
        }

        if ($jadwalId) {
            $query->where('id', '!=', $jadwalId);
        }

        return $query->exists();
    }
}