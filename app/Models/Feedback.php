<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'orangtua_id',
        'siswa_id',
        'isi_feedback',
        'tanggal_feedback',
        'status',
        'balasan_admin',
    ];

    protected $casts = [
        'tanggal_feedback' => 'datetime',
    ];

    // Relasi Many-to-One dengan OrangTua
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'orangtua_id');
    }

    // Relasi Many-to-One dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Get tanggal formatted
    public function getTanggalFeedbackFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_feedback)
            ->locale('id')
            ->isoFormat('DD MMMM YYYY, HH:mm');
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return $this->status === 'baru' ? 'warning' : 'success';
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return $this->status === 'baru' ? 'Baru' : 'Sudah Dibaca';
    }

    // Check if baru
    public function isBaru()
    {
        return $this->status === 'baru';
    }

    // Check if sudah dibaca
    public function isSudahDibaca()
    {
        return $this->status === 'dibaca';
    }

    // Check if sudah dibalas
    public function isSudahDibalas()
    {
        return !empty($this->balasan_admin);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['status' => 'dibaca']);
    }

    // Scope untuk status baru
    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    // Scope untuk sudah dibaca
    public function scopeDibaca($query)
    {
        return $query->where('status', 'dibaca');
    }

    // Scope untuk belum dibalas
    public function scopeBelumDibalas($query)
    {
        return $query->whereNull('balasan_admin')
                    ->orWhere('balasan_admin', '');
    }

    // Scope untuk sudah dibalas
    public function scopeSudahDibalas($query)
    {
        return $query->whereNotNull('balasan_admin')
                    ->where('balasan_admin', '!=', '');
    }

    // Scope untuk siswa tertentu
    public function scopeSiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    // Scope untuk orang tua tertentu
    public function scopeOrangTua($query, $orangTuaId)
    {
        return $query->where('orangtua_id', $orangTuaId);
    }
}