<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'materi_tugas_id',
        'siswa_id',
        'file_path',
        'tanggal_pengumpulan',
        'nilai',
        'feedback_guru',
    ];

    protected $casts = [
        'tanggal_pengumpulan' => 'datetime',
        'nilai' => 'decimal:2',
    ];

    // Relasi Many-to-One dengan MateriTugas
    public function materiTugas()
    {
        return $this->belongsTo(MateriTugas::class, 'materi_tugas_id');
    }

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Get file URL
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Get tanggal pengumpulan formatted
    public function getTanggalPengumpulanFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_pengumpulan)
            ->locale('id')
            ->isoFormat('DD MMMM YYYY, HH:mm');
    }

    // Check apakah terlambat
    public function isTerlambat()
    {
        if (!$this->materiTugas->deadline) return false;
        
        return Carbon::parse($this->tanggal_pengumpulan)
            ->isAfter(Carbon::parse($this->materiTugas->deadline));
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        if ($this->isTerlambat()) return 'danger';
        if ($this->nilai === null) return 'warning';
        if ($this->nilai >= 75) return 'success';
        if ($this->nilai >= 60) return 'info';
        return 'danger';
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        if ($this->isTerlambat()) return 'Terlambat';
        if ($this->nilai === null) return 'Belum Dinilai';
        return 'Sudah Dinilai';
    }

    // Get grade label
    public function getGradeLabelAttribute()
    {
        if ($this->nilai === null) return '-';
        
        if ($this->nilai >= 90) return 'A';
        if ($this->nilai >= 80) return 'B+';
        if ($this->nilai >= 75) return 'B';
        if ($this->nilai >= 70) return 'C+';
        if ($this->nilai >= 60) return 'C';
        if ($this->nilai >= 50) return 'D';
        return 'E';
    }

    // Check if sudah dinilai
    public function isSudahDinilai()
    {
        return $this->nilai !== null;
    }

    // Scope untuk siswa tertentu
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    // Scope untuk belum dinilai
    public function scopeBelumDinilai($query)
    {
        return $query->whereNull('nilai');
    }

    // Scope untuk sudah dinilai
    public function scopeSudahDinilai($query)
    {
        return $query->whereNotNull('nilai');
    }

    // Scope untuk bulan tertentu
    public function scopeBulan($query, $bulan, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        return $query->whereYear('tanggal_pengumpulan', $tahun)
                    ->whereMonth('tanggal_pengumpulan', $bulan);
    }
}