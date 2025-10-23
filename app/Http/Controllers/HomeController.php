<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\PaketBelajar;
use App\Models\Pengumuman;

class HomeController extends Controller
{
    /**
     * Halaman landing page
     */
    public function index()
    {
        $settings = Settings::getSiteSettings();
        $paketBelajar = PaketBelajar::tersedia()->get();
        $pengumuman = Pengumuman::published()
            ->where('target', 'semua')
            ->latest()
            ->take(5)
            ->get();

        return view('home.index', compact('settings', 'paketBelajar', 'pengumuman'));
    }

    /**
     * Halaman tentang bimbel
     */
    public function tentang()
    {
        $settings = Settings::getSiteSettings();
        return view('home.tentang', compact('settings'));
    }

    /**
     * Halaman kontak
     */
    public function kontak()
    {
        $settings = Settings::getSiteSettings();
        return view('home.kontak', compact('settings'));
    }

    /**
     * Halaman paket belajar
     */
    public function paket()
    {
        $settings = Settings::getSiteSettings();
        $paketSD = PaketBelajar::tersedia()->jenjang('SD')->get();
        $paketSMP = PaketBelajar::tersedia()->jenjang('SMP')->get();
        $paketKombo = PaketBelajar::tersedia()->where('jenjang', 'SD & SMP')->get();

        return view('home.paket', compact('settings', 'paketSD', 'paketSMP', 'paketKombo'));
    }
}