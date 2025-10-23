<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MateriTugas extends Model
{
    use HasFactory;

    protected $table = 'materi_tugas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tipe',
        'mata_pelajaran',
        'jenjang',
        'file_path',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relasi One-to-Many dengan PengumpulanTugas
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'materi_tugas_id');
    }

    // Get file URL
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Get tipe badge color
    public function getTipeBadgeColorAttribute()
    {
        return $this->tipe === 'materi' ? 'primary' : 'warning';
    }

    // Get tipe label
    public function getTipeLabelAttribute()
    {
        return $this->tipe === 'materi' ? 'Materi' : 'Tugas';
    }

    // Check if materi or tugas
    public function isMateri()
    {
        return $this->tipe === 'materi';
    }

    public function isTugas()
    {
        return $this->tipe === 'tugas';
    }

    // Check if deadline sudah lewat
    public function isDeadlinePassed()
    {
        if (!$this->deadline) return false;
        return Carbon::parse($this->deadline)->isPast();
    }

    // Get deadline formatted
    public function getDeadlineFormattedAttribute()
    {
        if (!$this->deadline) return '-';
        return Carbon::parse($this->deadline)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm');
    }

    // Get sisa waktu deadline
    public function getSisaWaktuDeadlineAttribute()
    {
        if (!$this->deadline) return null;
        
        $deadline = Carbon::parse($this->deadline);
        if ($deadline->isPast()) return 'Deadline telah lewat';
        
        return $deadline->locale('id')->diffForHumans();
    }

    // Get jumlah siswa yang sudah mengumpulkan
    public function getTotalPengumpulanAttribute()
    {
        return $this->pengumpulanTugas()->count();
    }

    // Get rata-rata nilai tugas
    public function getRataNilaiAttribute()
    {
        $nilai = $this->pengumpulanTugas()
            ->whereNotNull('nilai')
            ->avg('nilai');
        
        return $nilai ? round($nilai, 2) : 0;
    }

    // Scope untuk tipe tertentu
    public function scopeMateri($query)
    {
        return $query->where('tipe', 'materi');
    }

    public function scopeTugas($query)
    {
        return $query->where('tipe', 'tugas');
    }

    // Scope untuk jenjang tertentu
    public function scopeJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    // Scope untuk mata pelajaran tertentu
    public function scopeMataPelajaran($query, $mapel)
    {
        return $query->where('mata_pelajaran', $mapel);
    }

    // Scope untuk tugas aktif (belum deadline)
    public function scopeAktif($query)
    {
        return $query->where('tipe', 'tugas')
                    ->where(function($q) {
                        $q->whereNull('deadline')
                          ->orWhere('deadline', '>=', now());
                    });
    }
}