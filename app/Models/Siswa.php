<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'orangtua_id',
        'nama_lengkap',
        'tanggal_lahir',
        'jenjang',
        'kelas',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi Many-to-One dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Many-to-One dengan OrangTua
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'orangtua_id');
    }

    // Relasi One-to-Many dengan Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan Jadwal
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan Kehadiran
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan PengumpulanTugas
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan Feedback
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'siswa_id');
    }

    // Relasi One-to-Many dengan LogActivity
    public function logActivity()
    {
        return $this->hasMany(LogActivity::class, 'siswa_id');
    }

    // Get usia siswa
    public function getUsiaAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    // Get persentase kehadiran
    public function getPersentaseKehadiranAttribute()
    {
        $totalKehadiran = $this->kehadiran()->count();
        if ($totalKehadiran == 0) return 0;
        
        $hadir = $this->kehadiran()->where('status', 'hadir')->count();
        return round(($hadir / $totalKehadiran) * 100, 2);
    }

    // Get rata-rata nilai
    public function getRataNilaiAttribute()
    {
        $nilai = $this->pengumpulanTugas()
            ->whereNotNull('nilai')
            ->avg('nilai');
        
        return $nilai ? round($nilai, 2) : 0;
    }

    // Get jumlah tugas terkumpul
    public function getTotalTugasTerkumpulAttribute()
    {
        return $this->pengumpulanTugas()->count();
    }

    // Get jumlah tugas tertunda
    public function getTugasTertundaAttribute()
    {
        $tugasIds = $this->pengumpulanTugas()->pluck('materi_tugas_id');
        
        return MateriTugas::where('tipe', 'tugas')
            ->where('jenjang', $this->jenjang)
            ->where('deadline', '>=', now())
            ->whereNotIn('id', $tugasIds)
            ->count();
    }

    // Get status pembayaran terakhir
    public function getStatusPembayaranTerakhirAttribute()
    {
        $transaksiTerakhir = $this->transaksi()
            ->latest('tanggal_transaksi')
            ->first();
        
        return $transaksiTerakhir ? $transaksiTerakhir->status_verifikasi : null;
    }

    /**
     * Check if siswa has active subscription
     */
    public function hasActiveSubscription()
    {
        $latestTransaction = $this->transaksi()
            ->where('status_verifikasi', 'verified')
            ->latest('tanggal_transaksi')
            ->first();
        
        if (!$latestTransaction) {
            return false;
        }
        
        $paket = $latestTransaction->paketBelajar;
        $endDate = Carbon::parse($latestTransaction->tanggal_transaksi)
            ->addMonths($paket->durasi_bulan);
        
        return now()->lte($endDate);
    }

    /**
     * Get subscription end date
     */
    public function getSubscriptionEndDateAttribute()
    {
        $latestTransaction = $this->transaksi()
            ->where('status_verifikasi', 'verified')
            ->latest('tanggal_transaksi')
            ->first();
        
        if (!$latestTransaction) {
            return null;
        }
        
        $paket = $latestTransaction->paketBelajar;
        return Carbon::parse($latestTransaction->tanggal_transaksi)
            ->addMonths($paket->durasi_bulan);
    }

    /**
     * Get remaining subscription days
     */
    public function getRemainingSubscriptionDaysAttribute()
    {
        $endDate = $this->subscription_end_date;
        
        if (!$endDate) {
            return 0;
        }
        
        $remaining = now()->diffInDays($endDate, false);
        return $remaining > 0 ? $remaining : 0;
    }
}