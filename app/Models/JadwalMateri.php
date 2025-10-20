<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMateri extends Model
{
    use HasFactory;

    protected $table = 'jadwal_materi';
    protected $primaryKey = 'id_jadwal_materi';
    public $incrementing = true;

    protected $fillable = [
        'id_siswa',
        'judul',
        'deskripsi',
        'file',
        'jenis',
        'durasi',
        'awal',
        'nilai',
        'deadline',
        'status',
    ];

    protected $casts = [
        'awal' => 'datetime',
        'deadline' => 'datetime',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // Jenis Check Methods
    public function isMateri()
    {
        return $this->jenis === 'materi';
    }

    public function isTugas()
    {
        return $this->jenis === 'tugas';
    }

    // Status Check Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isTerlambat()
    {
        return $this->status === 'terlambat';
    }

    public function isOverdue()
    {
        return $this->deadline && now()->greaterThan($this->deadline) && !$this->isSelesai();
    }

    // Date Methods
    public function getTanggalAwalFormatted()
    {
        return $this->awal ? $this->awal->format('d-m-Y') : '-';
    }

    public function getDeadlineFormatted()
    {
        return $this->deadline ? $this->deadline->format('d-m-Y') : '-';
    }

    public function getHariTersisaUntilDeadline()
    {
        if (!$this->deadline || $this->isSelesai()) {
            return null;
        }
        $sisa = now()->diffInDays($this->deadline, false);
        return $sisa;
    }

    public function getDurasiFormatted()
    {
        if (!$this->durasi) return '-';
        if ($this->durasi < 60) {
            return $this->durasi . ' menit';
        }
        $jam = intval($this->durasi / 60);
        $menit = $this->durasi % 60;
        return $jam . ' jam' . ($menit > 0 ? ' ' . $menit . ' menit' : '');
    }

    // Query Scopes
    public function scopeMateri($query)
    {
        return $query->where('jenis', 'materi');
    }

    public function scopeTugas($query)
    {
        return $query->where('jenis', 'tugas');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat');
    }

    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
            ->where('status', '!=', 'selesai');
    }

    public function scopeBySiswa($query, $id_siswa)
    {
        return $query->where('id_siswa', $id_siswa);
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeWithNilai($query)
    {
        return $query->whereNotNull('nilai');
    }
}