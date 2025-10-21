<?php
// sides\app\Http\Controllers\OrangTuaController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\PaketBelajar;
use App\Models\Pendaftaran;
use App\Models\Transaksi;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrangTuaController extends Controller
{
    // ============= DASHBOARD =============
    public function dashboard()
    {
        $orangTua = Auth::user()->orangTua;
        
        $stats = [
            'total_anak' => $orangTua->getTotalSiswa(),
            'anak_aktif' => $orangTua->getSiswaAktif(),
            'pendaftaran_menunggu' => $orangTua->getPendaftaranMenunggu(),
            'transaksi_menunggu' => $orangTua->getTransaksiMenunggu(),
        ];

        // Daftar anak
        $siswas = $orangTua->siswa()->with('user')->get();

        // Pengumuman terbaru
        $pengumuman = Informasi::pengumuman()
            ->whereNull('id_siswa')
            ->latest()
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = $orangTua->transaksi()
            ->with('siswa')
            ->latest()
            ->take(5)
            ->get();

        return view('orangtua.dashboard', compact('stats', 'siswas', 'pengumuman', 'transaksiTerbaru'));
    }

    // ============= PAKET BELAJAR =============
    public function paketIndex()
    {
        $pakets = PaketBelajar::orderBy('harga', 'asc')->get();
        return view('orangtua.paket.index', compact('pakets'));
    }

    public function paketShow($id)
    {
        $paket = PaketBelajar::findOrFail($id);
        return view('orangtua.paket.show', compact('paket'));
    }

    // ============= PENDAFTARAN =============
    public function pendaftaranIndex()
    {
        $orangTua = Auth::user()->orangTua;
        $pendaftarans = $orangTua->pendaftaran()
            ->with(['paketBelajar', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orangtua.pendaftaran.index', compact('pendaftarans'));
    }

    public function pendaftaranCreate()
    {
        $pakets = PaketBelajar::all();
        $orangTua = Auth::user()->orangTua;
        
        // Cek apakah sudah punya siswa
        $siswas = $orangTua->siswa;

        return view('orangtua.pendaftaran.create', compact('pakets', 'siswas'));
    }

    public function pendaftaranStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_paket' => 'required|exists:paket_belajar,id_paket',
            'nama_siswa' => 'required|string|max:255',
            'email_siswa' => 'required|email|unique:users,email',
            'password_siswa' => 'required|min:6',
            'tanggal_lahir' => 'required|date',
            'jenjang' => 'required|in:SD,SMP',
            'kelas' => 'required|string',
            'telepon_siswa' => 'nullable|string',
            'alamat_siswa' => 'nullable|string',
            'id_jawaban_paket' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $orangTua = Auth::user()->orangTua;

            // Buat user untuk siswa
            $userSiswa = User::create([
                'name' => $request->nama_siswa,
                'email' => $request->email_siswa,
                'password' => Hash::make($request->password_siswa),
                'role' => 'siswa',
                'telepon' => $request->telepon_siswa,
                'alamat' => $request->alamat_siswa,
            ]);

            // Buat data siswa
            $siswa = Siswa::create([
                'user_id' => $userSiswa->id,
                'id_orang_tua' => $orangTua->id_orang_tua,
                'nama_siswa' => $request->nama_siswa,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'status' => 'non-aktif', // Akan aktif setelah disetujui
            ]);

            // Buat pendaftaran
            Pendaftaran::create([
                'id_orang_tua' => $orangTua->id_orang_tua,
                'id_paket' => $request->id_paket,
                'id_siswa' => $siswa->id_siswa,
                'tanggal_daftar' => now(),
                'status' => 'menunggu',
                'id_jawaban_paket' => $request->id_jawaban_paket,
            ]);

            return redirect()->route('orangtua.pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil dikirim. Silakan tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function pendaftaranShow($id)
    {
        $orangTua = Auth::user()->orangTua;
        $pendaftaran = $orangTua->pendaftaran()
            ->with(['paketBelajar', 'siswa'])
            ->findOrFail($id);

        return view('orangtua.pendaftaran.show', compact('pendaftaran'));
    }

    // ============= SISWA (ANAK) =============
    public function siswaIndex()
    {
        $orangTua = Auth::user()->orangTua;
        $siswas = $orangTua->siswa()->with('user')->get();

        return view('orangtua.siswa.index', compact('siswas'));
    }

    public function siswaShow($id)
    {
        $orangTua = Auth::user()->orangTua;
        $siswa = $orangTua->siswa()
            ->with(['user', 'jadwalMateri', 'transaksi'])
            ->findOrFail($id);

        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2),
        ];

        // Jadwal terbaru
        $jadwalTerbaru = $siswa->jadwalMateri()
            ->latest()
            ->take(10)
            ->get();

        return view('orangtua.siswa.show', compact('siswa', 'stats', 'jadwalTerbaru'));
    }

    // ============= JADWAL =============
    public function jadwalIndex()
    {
        $orangTua = Auth::user()->orangTua;
        $siswas = $orangTua->siswa;

        // Jika punya request filter siswa
        $siswaId = request('siswa_id');
        
        if ($siswaId) {
            $jadwals = \App\Models\JadwalMateri::bySiswa($siswaId)
                ->with('siswa.user')
                ->orderBy('awal', 'desc')
                ->get();
        } else {
            // Ambil semua jadwal anak-anak
            $siswaIds = $siswas->pluck('id_siswa');
            $jadwals = \App\Models\JadwalMateri::whereIn('id_siswa', $siswaIds)
                ->with('siswa.user')
                ->orderBy('awal', 'desc')
                ->get();
        }

        return view('orangtua.jadwal.index', compact('jadwals', 'siswas'));
    }

    // ============= TRANSAKSI & PEMBAYARAN =============
    public function transaksiIndex()
    {
        $orangTua = Auth::user()->orangTua;
        $transaksis = $orangTua->transaksi()
            ->with('siswa')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orangtua.transaksi.index', compact('transaksis'));
    }

    public function transaksiCreate()
    {
        $orangTua = Auth::user()->orangTua;
        $siswas = $orangTua->siswa()->aktif()->get();

        return view('orangtua.transaksi.create', compact('siswas'));
    }

    public function transaksiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $orangTua = Auth::user()->orangTua;

            // Validasi siswa milik orang tua ini
            if (!$orangTua->siswa()->where('id_siswa', $request->id_siswa)->exists()) {
                return back()->withErrors(['error' => 'Siswa tidak valid']);
            }

            $data = $request->except('bukti_bayar');
            $data['id_orang_tua'] = $orangTua->id_orang_tua;
            $data['status'] = 'menunggu';

            // Handle upload bukti bayar
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $filename = time() . '_' . $orangTua->id_orang_tua . '_' . $file->getClientOriginalName();
                $file->storeAs('public/payments', $filename);
                $data['bukti_bayar_path'] = 'payments/' . $filename;
            }

            Transaksi::create($data);

            return redirect()->route('orangtua.transaksi.index')
                ->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi dari admin.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function transaksiShow($id)
    {
        $orangTua = Auth::user()->orangTua;
        $transaksi = $orangTua->transaksi()
            ->with('siswa')
            ->findOrFail($id);

        return view('orangtua.transaksi.show', compact('transaksi'));
    }

    public function riwayatPembayaran()
    {
        $orangTua = Auth::user()->orangTua;
        $transaksis = $orangTua->transaksi()
            ->with('siswa')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $total_bayar = $orangTua->getTotalBayarVerifikasi();

        return view('orangtua.riwayat-pembayaran', compact('transaksis', 'total_bayar'));
    }

    // ============= LAPORAN ANAK =============
    public function laporanAnak($id)
    {
        $orangTua = Auth::user()->orangTua;
        $siswa = $orangTua->siswa()
            ->with(['user', 'jadwalMateri'])
            ->findOrFail($id);

        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'tugas_terlambat' => $siswa->getTugasTerlambat(),
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2),
            'nilai_tertinggi' => $siswa->getNilaiTertinggi(),
            'nilai_terendah' => $siswa->getNilaiTerendah(),
        ];

        // Jadwal dengan nilai
        $jadwalsWithNilai = $siswa->jadwalMateri()
            ->whereNotNull('nilai')
            ->orderBy('awal', 'desc')
            ->get();

        return view('orangtua.laporan-anak', compact('siswa', 'stats', 'jadwalsWithNilai'));
    }

    // ============= INFORMASI & PENGUMUMAN =============
    public function informasiIndex()
    {
        $orangTua = Auth::user()->orangTua;
        $siswaIds = $orangTua->siswa->pluck('id_siswa');

        // Pengumuman umum dan notifikasi untuk anak-anak
        $informasis = Informasi::where(function($query) use ($siswaIds) {
            $query->whereNull('id_siswa')
                  ->orWhereIn('id_siswa', $siswaIds);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('orangtua.informasi.index', compact('informasis'));
    }

    // ============= UMPAN BALIK =============
    public function feedbackCreate()
    {
        return view('orangtua.feedback.create');
    }

    public function feedbackStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Buat informasi sebagai feedback
        Informasi::create([
            'id_pengguna' => auth()->id(),
            'judul' => 'Feedback: ' . $request->subjek,
            'isi' => $request->pesan,
            'jenis' => 'notifikasi',
        ]);

        return redirect()->route('orangtua.dashboard')
            ->with('success', 'Terima kasih! Umpan balik Anda telah terkirim.');
    }

    // ============= PROFIL =============
    public function profile()
    {
        $user = Auth::user();
        $orangTua = $user->orangTua;

        return view('orangtua.profile', compact('user', 'orangTua'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $orangTua = $user->orangTua;

        $validator = Validator::make($request->all(), [
            'nama_orang_tua' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'pekerjaan' => 'nullable|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $userData = [
                'name' => $request->nama_orang_tua,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ];

            // Handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama
                if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
                    unlink(public_path($user->foto_profil));
                }

                $file = $request->file('foto_profil');
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/profiles'), $filename);
                $userData['foto_profil'] = 'storage/profiles/' . $filename;
            }

            $user->update($userData);

            // Update data orang tua
            $orangTua->update([
                'nama_orang_tua' => $request->nama_orang_tua,
                'hubungan' => $request->hubungan,
                'pekerjaan' => $request->pekerjaan,
            ]);

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // ============= REDIRECT WHATSAPP =============
    public function whatsappAdmin()
    {
        $phoneNumber = '6281234567890'; // Sesuaikan dengan nomor admin
        $message = 'Halo Admin Bimbel Oriana Enilin, saya ' . Auth::user()->name . ' ingin bertanya.';
        
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($message);
        
        return redirect()->away($whatsappUrl);
    }
}