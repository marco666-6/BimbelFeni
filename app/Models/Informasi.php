<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasi';
    protected $primaryKey = 'id_informasi';
    public $incrementing = true;

    protected $fillable = [
        'id_siswa',
        'id_pengguna',
        'judul',
        'isi',
        'jenis',
        'dibuat_pada',
        'dibaca',
    ];

    protected $casts = [
        'dibuat_pada' => 'timestamp',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    // Jenis Check Methods
    public function isPengumuman()
    {
        return $this->jenis === 'pengumuman';
    }

    public function isNotifikasi()
    {
        return $this->jenis === 'notifikasi';
    }

    // Date Methods
    public function getDibuat()
    {
        return $this->created_at->format('d-m-Y H:i');
    }

    public function getDibuatFormatted()
    {
        return $this->created_at->diffForHumans();
    }

    // Query Scopes
    public function scopePengumuman($query)
    {
        return $query->where('jenis', 'pengumuman');
    }

    public function scopeNotifikasi($query)
    {
        return $query->where('jenis', 'notifikasi');
    }

    public function scopeBySiswa($query, $id_siswa)
    {
        return $query->where('id_siswa', $id_siswa);
    }

    public function scopeByPengguna($query, $id_pengguna)
    {
        return $query->where('id_pengguna', $id_pengguna);
    }

    public function scopeTerbaru($query, $limit = 10)
    {
        return $query->latest('created_at')->limit($limit);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('judul', 'like', "%$keyword%")
                     ->orWhere('isi', 'like', "%$keyword%");
    }
}