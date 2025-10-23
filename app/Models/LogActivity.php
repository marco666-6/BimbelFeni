<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'log_activity';

    protected $fillable = [
        'siswa_id',
        'jenis_aktivitas',
        'deskripsi',
        'waktu_aktivitas',
        'ip_address',
    ];

    protected $casts = [
        'waktu_aktivitas' => 'datetime',
    ];

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Get waktu formatted
    public function getWaktuFormattedAttribute()
    {
        return Carbon::parse($this->waktu_aktivitas)
            ->locale('id')
            ->isoFormat('DD MMMM YYYY, HH:mm:ss');
    }

    // Get waktu relative
    public function getWaktuRelativeAttribute()
    {
        return Carbon::parse($this->waktu_aktivitas)
            ->locale('id')
            ->diffForHumans();
    }

    // Get icon berdasarkan jenis aktivitas
    public function getIconAttribute()
    {
        return match($this->jenis_aktivitas) {
            'login' => 'log-in',
            'logout' => 'log-out',
            'pengumpulan_tugas' => 'upload',
            'akses_materi' => 'book-open',
            'lihat_jadwal' => 'calendar',
            'lihat_nilai' => 'award',
            default => 'activity',
        };
    }

    // Get badge color berdasarkan jenis
    public function getBadgeColorAttribute()
    {
        return match($this->jenis_aktivitas) {
            'login' => 'success',
            'logout' => 'secondary',
            'pengumpulan_tugas' => 'primary',
            'akses_materi' => 'info',
            'lihat_jadwal' => 'warning',
            'lihat_nilai' => 'success',
            default => 'dark',
        };
    }

    // Scope untuk siswa tertentu
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    // Scope untuk jenis aktivitas tertentu
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_aktivitas', $jenis);
    }

    // Scope untuk hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('waktu_aktivitas', today());
    }

    // Scope untuk bulan tertentu
    public function scopeBulan($query, $bulan, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        return $query->whereYear('waktu_aktivitas', $tahun)
                    ->whereMonth('waktu_aktivitas', $bulan);
    }

    // Static method untuk log aktivitas
    public static function logActivity($siswaId, $jenisAktivitas, $deskripsi, $ipAddress = null)
    {
        return self::create([
            'siswa_id' => $siswaId,
            'jenis_aktivitas' => $jenisAktivitas,
            'deskripsi' => $deskripsi,
            'waktu_aktivitas' => now(),
            'ip_address' => $ipAddress ?? request()->ip(),
        ]);
    }

    // Static method untuk log login
    public static function logLogin($siswaId)
    {
        return self::logActivity(
            $siswaId,
            'login',
            'Siswa melakukan login ke sistem',
            request()->ip()
        );
    }

    // Static method untuk log logout
    public static function logLogout($siswaId)
    {
        return self::logActivity(
            $siswaId,
            'logout',
            'Siswa melakukan logout dari sistem',
            request()->ip()
        );
    }
}