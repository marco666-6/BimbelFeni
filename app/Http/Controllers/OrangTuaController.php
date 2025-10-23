<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\PaketBelajar;
use App\Models\Transaksi;
use App\Models\Jadwal;
use App\Models\MateriTugas;
use App\Models\Kehadiran;
use App\Models\PengumpulanTugas;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\LogActivity;
use App\Models\Settings;
use App\Models\Notifikasi;
use App\Helpers\FileUploadHelper;

class OrangTuaController extends Controller
{
    /**
     * Dashboard Orang Tua
     */
    public function dashboard()
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = $orangTua->siswa;
        $totalAnak = $siswa->count();
        $transaksiPending = $orangTua->transaksi()->pending()->count();
        $feedbackBelumDibalas = $orangTua->feedback()->belumDibalas()->count();

        $pengumuman = Pengumuman::published()
            ->forUser('orangtua')
            ->latest()
            ->take(5)
            ->get();

        return view('orangtua.dashboard', compact(
            'orangTua',
            'siswa',
            'totalAnak',
            'transaksiPending',
            'feedbackBelumDibalas',
            'pengumuman'
        ));
    }

    // ============ MONITORING ANAK ============
    
    /**
     * Daftar Anak
     */
    public function anak()
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = $orangTua->siswa()->with(['jadwal', 'transaksi'])->get();

        return view('orangtua.anak', compact('siswa'));
    }

    /**
     * Detail Perkembangan Anak
     */
    public function detailAnak($id)
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = Siswa::where('orangtua_id', $orangTua->id)
            ->with([
                'jadwal',
                'kehadiran.jadwal',
                'pengumpulanTugas.materiTugas',
                'feedback',
                'logActivity'
            ])
            ->findOrFail($id);

        // Statistik
        $totalKehadiran = $siswa->kehadiran()->count();
        $persentaseHadir = $totalKehadiran > 0 
            ? round(($siswa->kehadiran()->hadir()->count() / $totalKehadiran) * 100, 2)
            : 0;

        $rataNilai = $siswa->pengumpulanTugas()
            ->whereNotNull('nilai')
            ->avg('nilai');
        $rataNilai = $rataNilai ? round($rataNilai, 2) : 0;

        $totalTugas = $siswa->pengumpulanTugas()->count();
        $tugasTertunda = MateriTugas::where('tipe', 'tugas')
            ->where('jenjang', $siswa->jenjang)
            ->where('deadline', '>=', now())
            ->whereNotIn('id', $siswa->pengumpulanTugas()->pluck('materi_tugas_id'))
            ->count();

        return view('orangtua.detail-anak', compact(
            'siswa',
            'persentaseHadir',
            'rataNilai',
            'totalTugas',
            'tugasTertunda'
        ));
    }

    /**
     * Jadwal Anak
     */
    public function jadwalAnak($id)
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = Siswa::where('orangtua_id', $orangTua->id)->findOrFail($id);
        $jadwal = $siswa->jadwal()->get();

        return view('orangtua.jadwal-anak', compact('siswa', 'jadwal'));
    }

    /**
     * Log Activity Anak
     */
    public function logActivity($id)
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = Siswa::where('orangtua_id', $orangTua->id)->findOrFail($id);
        $logs = $siswa->logActivity()->latest('waktu_aktivitas')->paginate(20);

        return view('orangtua.log-activity', compact('siswa', 'logs'));
    }

    /**
     * Rapor Anak
     */
    public function raporAnak($id)
    {
        $orangTua = auth()->user()->orangTua;
        $siswa = Siswa::where('orangtua_id', $orangTua->id)
            ->with([
                'kehadiran.jadwal',
                'pengumpulanTugas.materiTugas'
            ])
            ->findOrFail($id);

        // Data untuk rapor bulan ini
        $bulan = date('m');
        $tahun = date('Y');

        $kehadiranBulanIni = $siswa->kehadiran()->bulan($bulan, $tahun)->get();
        $nilaiTugasBulanIni = $siswa->pengumpulanTugas()
            ->bulan($bulan, $tahun)
            ->whereNotNull('nilai')
            ->get();

        return view('orangtua.rapor-anak', compact(
            'siswa',
            'kehadiranBulanIni',
            'nilaiTugasBulanIni',
            'bulan',
            'tahun'
        ));
    }

    // ============ PAKET & PEMBAYARAN ============
    
    /**
     * Lihat Paket Belajar
     */
    public function paketBelajar()
    {
        $paketSD = PaketBelajar::tersedia()->jenjang('SD')->get();
        $paketSMP = PaketBelajar::tersedia()->jenjang('SMP')->get();
        $paketKombo = PaketBelajar::tersedia()->where('jenjang', 'SD & SMP')->get();

        $orangTua = auth()->user()->orangTua;
        $siswa = $orangTua->siswa;

        return view('orangtua.paket-belajar', compact(
            'paketSD',
            'paketSMP',
            'paketKombo',
            'siswa'
        ));
    }

    /**
     * Proses Pembelian Paket (Upload Bukti Pembayaran)
     */
    public function beliPaket(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'paket_id' => 'required|exists:paket_belajar,id',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $orangTua = auth()->user()->orangTua;
        
        // Verify siswa belongs to this orang tua
        $siswa = Siswa::where('id', $request->siswa_id)
            ->where('orangtua_id', $orangTua->id)
            ->firstOrFail();

        $paket = PaketBelajar::findOrFail($request->paket_id);

        $buktiPath = FileUploadHelper::uploadFile(
            $request->file('bukti_pembayaran'),
            'bukti_pembayaran'
        );

        Transaksi::create([
            'orangtua_id' => $orangTua->id,
            'siswa_id' => $siswa->id,
            'paket_id' => $paket->id,
            'total_pembayaran' => $paket->harga,
            'bukti_pembayaran' => $buktiPath,
            'status_verifikasi' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    /**
     * Riwayat Transaksi
     */
    public function transaksi()
    {
        $orangTua = auth()->user()->orangTua;
        $transaksi = $orangTua->transaksi()
            ->with(['siswa', 'paketBelajar'])
            ->latest()
            ->get();

        return view('orangtua.transaksi', compact('transaksi'));
    }

    // ============ FEEDBACK ============
    
    /**
     * Feedback
     */
    public function feedback()
    {
        $orangTua = auth()->user()->orangTua;
        $feedback = $orangTua->feedback()
            ->with('siswa')
            ->latest()
            ->get();
        $siswa = $orangTua->siswa;

        return view('orangtua.feedback', compact('feedback', 'siswa'));
    }

    /**
     * Kirim Feedback
     */
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'isi_feedback' => 'required|string',
        ]);

        $orangTua = auth()->user()->orangTua;

        // Verify siswa belongs to this orang tua
        $siswa = Siswa::where('id', $request->siswa_id)
            ->where('orangtua_id', $orangTua->id)
            ->firstOrFail();

        Feedback::create([
            'orangtua_id' => $orangTua->id,
            'siswa_id' => $siswa->id,
            'isi_feedback' => $request->isi_feedback,
        ]);

        // Notify admin
        $adminUsers = \App\Models\User::where('role', 'admin')->pluck('id');
        foreach ($adminUsers as $adminId) {
            Notifikasi::createNotification(
                $adminId,
                'Feedback Baru',
                $orangTua->nama_lengkap . ' memberikan feedback untuk ' . $siswa->nama_lengkap,
                'feedback'
            );
        }

        return back()->with('success', 'Feedback berhasil dikirim!');
    }

    // ============ PENGUMUMAN ============
    
    /**
     * Lihat Pengumuman
     */
    public function pengumuman()
    {
        $pengumuman = Pengumuman::published()
            ->forUser('orangtua')
            ->latest()
            ->get();

        return view('orangtua.pengumuman', compact('pengumuman'));
    }

    // ============ NOTIFIKASI ============
    
    /**
     * Lihat Notifikasi
     */
    public function notifikasi()
    {
        $notifikasi = auth()->user()
            ->notifikasi()
            ->latest()
            ->paginate(20);

        return view('orangtua.notifikasi', compact('notifikasi'));
    }

    /**
     * Tandai notifikasi dibaca
     */
    public function markNotifikasiRead($id)
    {
        $notifikasi = auth()->user()
            ->notifikasi()
            ->findOrFail($id);

        $notifikasi->markAsRead();

        return back()->with('success', 'Notifikasi ditandai telah dibaca!');
    }

    // ============ PROFILE ============
    
    /**
     * Profil Orang Tua
     */
    public function profile()
    {
        $user = auth()->user();
        $orangTua = $user->orangTua;

        return view('orangtua.profile', compact('user', 'orangTua'));
    }

    /**
     * Update Profil
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $orangTua = $user->orangTua;

        $request->validate([
            'username' => 'required|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_lengkap' => 'required|max:255',
            'no_telepon' => 'required|max:20',
            'alamat' => 'required',
            'pekerjaan' => 'nullable|max:255',
        ]);

        // Update user data
        $userData = $request->only(['username', 'email']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            $userData['foto_profil'] = FileUploadHelper::uploadFile(
                $request->file('foto_profil'),
                'profile_photos',
                $user->foto_profil
            );
        }

        $user->update($userData);

        // Update orang tua data
        $orangTua->update($request->only([
            'nama_lengkap',
            'no_telepon',
            'alamat',
            'pekerjaan'
        ]));

        return back()->with('success', 'Profil berhasil diupdate!');
    }
}