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
        'name',
        'email',
        'password',
        'role',
        'telepon',
        'alamat',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'user_id');
    }

    public function informasi()
    {
        return $this->hasMany(Informasi::class, 'id_pengguna');
    }

    // Role Check Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrangTua()
    {
        return $this->role === 'orang_tua';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Query Methods
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }
}