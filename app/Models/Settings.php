<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'nama_website',
        'logo',
        'alamat',
        'no_telepon',
        'email',
        'tentang',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
    ];

    // Get logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/no-image.png');
    }

    // Get info bank formatted
    public function getInfoBankFormattedAttribute()
    {
        if (!$this->nama_bank || !$this->nomor_rekening) {
            return 'Belum diatur';
        }
        
        return "{$this->nama_bank} - {$this->nomor_rekening} a.n. {$this->atas_nama}";
    }

    // Static method untuk get settings (singleton pattern)
    public static function getSiteSettings()
    {
        return self::first() ?? self::create([
            'nama_website' => 'Bimbel Oriana Enilin',
            'alamat' => 'Batam, Kepulauan Riau',
            'no_telepon' => '-',
            'email' => 'info@bimbeloriana.com',
            'tentang' => 'Lembaga bimbingan belajar terpercaya untuk siswa SD dan SMP',
        ]);
    }

    // Update settings
    public static function updateSettings(array $data)
    {
        $settings = self::getSiteSettings();
        $settings->update($data);
        return $settings;
    }
}