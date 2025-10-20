<?php
// sides\app\Http\Controllers\HomeController.php

namespace App\Http\Controllers;

use App\Models\PaketBelajar;
use App\Models\Informasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Halaman Landing Page
    public function index()
    {
        // Ambil paket belajar untuk ditampilkan
        $paketBelajar = PaketBelajar::orderBy('harga', 'asc')->get();
        
        // Ambil pengumuman terbaru untuk landing page
        $pengumuman = Informasi::pengumuman()
            ->whereNull('id_siswa') // Hanya pengumuman umum
            ->latest()
            ->take(3)
            ->get();
        
        return view('landing', compact('paketBelajar', 'pengumuman'));
    }

    // Halaman Tentang
    public function tentang()
    {
        return view('tentang');
    }

    // Halaman Kontak
    public function kontak()
    {
        return view('kontak');
    }

    // Halaman Paket Belajar Detail
    public function paketDetail($id)
    {
        $paket = PaketBelajar::findOrFail($id);
        return view('paket-detail', compact('paket'));
    }

    // Submit kontak form
    public function submitKontak(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        // Di sini bisa ditambahkan logic untuk mengirim email
        // Atau menyimpan ke database
        
        // Untuk saat ini hanya redirect dengan pesan sukses
        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
    }

    // Redirect ke WhatsApp
    public function redirectWhatsApp()
    {
        // Nomor WhatsApp admin (sesuaikan dengan nomor bimbel)
        $phoneNumber = '6281234567890'; // Ganti dengan nomor yang sesuai
        $message = 'Halo Bimbel Oriana Enilin, saya ingin bertanya mengenai program bimbingan belajar.';
        
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($message);
        
        return redirect()->away($whatsappUrl);
    }
}