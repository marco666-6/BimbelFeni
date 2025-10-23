<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'foto_profil',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi One-to-One dengan OrangTua
    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }

    // Relasi One-to-One dengan Siswa
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    // Relasi One-to-Many dengan Notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    // Relasi One-to-Many dengan Pengumuman (sebagai creator)
    public function pengumumanDibuat()
    {
        return $this->hasMany(Pengumuman::class, 'created_by');
    }

    // Helper methods untuk check role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrangTua()
    {
        return $this->role === 'orangtua';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function isAktif()
    {
        return $this->status === 'aktif';
    }

    // Get foto profil URL
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('storage/' . $this->foto_profil);
        }
        return asset('images/no-image.png');
    }

    // Get notifikasi yang belum dibaca
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifikasi()->where('dibaca', false)->count();
    }
}