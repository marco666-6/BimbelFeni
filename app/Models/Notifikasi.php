<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'tipe',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];

    // Relasi Many-to-One dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get tipe badge color
    public function getTipeBadgeColorAttribute()
    {
        return match($this->tipe) {
            'pengumuman' => 'info',
            'jadwal' => 'primary',
            'pembayaran' => 'warning',
            'feedback' => 'success',
            'tugas' => 'danger',
            default => 'secondary',
        };
    }

    // Get tipe icon
    public function getTipeIconAttribute()
    {
        return match($this->tipe) {
            'pengumuman' => 'megaphone',
            'jadwal' => 'calendar',
            'pembayaran' => 'credit-card',
            'feedback' => 'message-circle',
            'tugas' => 'file-text',
            default => 'bell',
        };
    }

    // Get waktu formatted
    public function getWaktuFormattedAttribute()
    {
        return Carbon::parse($this->created_at)
            ->locale('id')
            ->diffForHumans();
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['dibaca' => true]);
    }

    // Check if belum dibaca
    public function isBelumDibaca()
    {
        return !$this->dibaca;
    }

    // Scope untuk belum dibaca
    public function scopeBelumDibaca($query)
    {
        return $query->where('dibaca', false);
    }

    // Scope untuk sudah dibaca
    public function scopeSudahDibaca($query)
    {
        return $query->where('dibaca', true);
    }

    // Scope untuk user tertentu
    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk tipe tertentu
    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // Static method untuk create notifikasi
    public static function createNotification($userId, $judul, $pesan, $tipe = 'lainnya')
    {
        return self::create([
            'user_id' => $userId,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
        ]);
    }

    // Static method untuk broadcast ke multiple users
    public static function broadcastToUsers($userIds, $judul, $pesan, $tipe = 'lainnya')
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'judul' => $judul,
                'pesan' => $pesan,
                'tipe' => $tipe,
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        return self::insert($notifications);
    }
}