<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'target',
        'tanggal_publikasi',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];

    // Relasi Many-to-One dengan User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get tanggal publikasi formatted
    public function getTanggalPublikasiFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_publikasi)
            ->locale('id')
            ->isoFormat('DD MMMM YYYY, HH:mm');
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return $this->status === 'published' ? 'success' : 'warning';
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return $this->status === 'published' ? 'Dipublikasikan' : 'Draft';
    }

    // Get target badge color
    public function getTargetBadgeColorAttribute()
    {
        return match($this->target) {
            'semua' => 'primary',
            'orangtua' => 'info',
            'siswa' => 'success',
            default => 'secondary',
        };
    }

    // Get target label
    public function getTargetLabelAttribute()
    {
        return match($this->target) {
            'semua' => 'Semua Pengguna',
            'orangtua' => 'Orang Tua',
            'siswa' => 'Siswa',
            default => 'Tidak Diketahui',
        };
    }

    // Check if published
    public function isPublished()
    {
        return $this->status === 'published';
    }

    // Check if draft
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    // Publish pengumuman
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'tanggal_publikasi' => now(),
        ]);
    }

    // Send notification ke target users
    protected function sendNotificationToTarget()
    {
        $query = User::query()->where('status', 'aktif');
        
        if ($this->target === 'orangtua') {
            $query->where('role', 'orangtua');
        } elseif ($this->target === 'siswa') {
            $query->where('role', 'siswa');
        }
        
        $userIds = $query->pluck('id')->toArray();
        
        if (!empty($userIds)) {
            Notifikasi::broadcastToUsers(
                $userIds,
                'Pengumuman Baru: ' . $this->judul,
                $this->isi,
                'pengumuman'
            );
        }
    }

    // Scope untuk status published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope untuk draft
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Scope untuk target tertentu
    public function scopeTarget($query, $target)
    {
        return $query->where('target', $target);
    }

    // Scope untuk user tertentu (berdasarkan target)
    public function scopeForUser($query, $userRole)
    {
        return $query->where('status', 'published')
                    ->where(function($q) use ($userRole) {
                        $q->where('target', 'semua')
                          ->orWhere('target', $userRole);
                    });
    }
}