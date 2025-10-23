<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\MateriTugas;
use App\Models\PengumpulanTugas;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\Pengumuman;
use App\Models\Notifikasi;
use App\Models\LogActivity;
use App\Helpers\FileUploadHelper;
use Carbon\Carbon;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa
     */
    public function dashboard()
    {
        $siswa = auth()->user()->siswa;
        
        // Statistik
        $totalMateri = MateriTugas::materi()
            ->where('jenjang', $siswa->jenjang)
            ->count();
        
        $totalTugasTerkumpul = $siswa->pengumpulanTugas()->count();
        
        $tugasTertunda = MateriTugas::tugas()
            ->where('jenjang', $siswa->jenjang)
            ->aktif()
            ->whereNotIn('id', $siswa->pengumpulanTugas()->pluck('materi_tugas_id'))
            ->count();
        
        $rataNilai = $siswa->rata_nilai;
        
        // Jadwal hari ini
        $hariIni = now()->locale('id')->dayName;
        $jadwalHariIni = $siswa->jadwal()
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();
        
        // Pengumuman terbaru
        $pengumuman = Pengumuman::published()
            ->forUser('siswa')
            ->latest()
            ->take(5)
            ->get();
        
        // Tugas mendatang
        $tugasMendatang = MateriTugas::tugas()
            ->where('jenjang', $siswa->jenjang)
            ->aktif()
            ->whereNotIn('id', $siswa->pengumpulanTugas()->pluck('materi_tugas_id'))
            ->orderBy('deadline')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'totalMateri',
            'totalTugasTerkumpul',
            'tugasTertunda',
            'rataNilai',
            'jadwalHariIni',
            'pengumuman',
            'tugasMendatang'
        ));
    }

    // ============ MATERI & TUGAS ============
    
    /**
     * Lihat Materi & Tugas
     */
    public function materiTugas(Request $request)
    {
        $siswa = auth()->user()->siswa;
        $tipe = $request->get('tipe', 'all');
        
        $query = MateriTugas::where('jenjang', $siswa->jenjang);
        
        if ($tipe !== 'all') {
            $query->where('tipe', $tipe);
        }
        
        $materiTugas = $query->latest()->get();
        
        // Get data pengumpulan siswa
        $pengumpulanIds = $siswa->pengumpulanTugas()->pluck('materi_tugas_id')->toArray();
        
        return view('siswa.materi-tugas', compact('materiTugas', 'tipe', 'pengumpulanIds'));
    }

    /**
     * Detail Materi/Tugas
     */
    public function detailMateriTugas($id)
    {
        $siswa = auth()->user()->siswa;
        $materiTugas = MateriTugas::where('jenjang', $siswa->jenjang)
            ->findOrFail($id);
        
        // Log activity untuk akses materi
        if ($materiTugas->isMateri()) {
            LogActivity::logActivity(
                $siswa->id,
                'akses_materi',
                'Siswa mengakses materi: ' . $materiTugas->judul
            );
        }
        
        // Get pengumpulan jika tugas
        $pengumpulan = null;
        if ($materiTugas->isTugas()) {
            $pengumpulan = $siswa->pengumpulanTugas()
                ->where('materi_tugas_id', $materiTugas->id)
                ->first();
        }
        
        return view('siswa.detail-materi-tugas', compact('materiTugas', 'pengumpulan'));
    }

    /**
     * Download Materi/Tugas
     */
    public function downloadMateriTugas($id)
    {
        $siswa = auth()->user()->siswa;
        $materiTugas = MateriTugas::where('jenjang', $siswa->jenjang)
            ->findOrFail($id);
        
        if (!$materiTugas->file_path) {
            return back()->with('error', 'File tidak tersedia!');
        }
        
        $filePath = storage_path('app/public/' . $materiTugas->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan!');
        }
        
        return response()->download($filePath);
    }

    /**
     * Kumpulkan Tugas
     */
    public function kumpulkanTugas(Request $request)
    {
        $request->validate([
            'materi_tugas_id' => 'required|exists:materi_tugas,id',
            'file_tugas' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ], [
            'file_tugas.required' => 'File tugas harus diunggah',
            'file_tugas.mimes' => 'Format file harus: pdf, doc, docx, jpg, jpeg, png',
            'file_tugas.max' => 'Ukuran file maksimal 10MB',
        ]);

        $siswa = auth()->user()->siswa;
        
        // Verify materi tugas exists and is tugas type
        $materiTugas = MateriTugas::where('id', $request->materi_tugas_id)
            ->where('tipe', 'tugas')
            ->where('jenjang', $siswa->jenjang)
            ->firstOrFail();
        
        // Check if already submitted
        $existing = PengumpulanTugas::where('materi_tugas_id', $materiTugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();
        
        if ($existing) {
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini!');
        }
        
        // Upload file
        $filePath = FileUploadHelper::uploadFile(
            $request->file('file_tugas'),
            'pengumpulan_tugas'
        );
        
        if (!$filePath) {
            return back()->with('error', 'Gagal mengunggah file!');
        }
        
        // Create pengumpulan
        PengumpulanTugas::create([
            'materi_tugas_id' => $materiTugas->id,
            'siswa_id' => $siswa->id,
            'file_path' => $filePath,
            'tanggal_pengumpulan' => now(),
        ]);
        
        // Log activity
        LogActivity::logActivity(
            $siswa->id,
            'pengumpulan_tugas',
            'Siswa mengumpulkan tugas: ' . $materiTugas->judul
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    // ============ JADWAL ============
    
    /**
     * Lihat Jadwal
     */
    public function jadwal()
    {
        $siswa = auth()->user()->siswa;
        $jadwal = $siswa->jadwal()->orderBy('hari')->orderBy('jam_mulai')->get();
        
        // Group by hari
        $jadwalGrouped = $jadwal->groupBy('hari');
        
        // Log activity
        LogActivity::logActivity(
            $siswa->id,
            'lihat_jadwal',
            'Siswa melihat jadwal pembelajaran'
        );

        return view('siswa.jadwal', compact('jadwal', 'jadwalGrouped'));
    }

    // ============ NILAI & RAPOR ============
    
    /**
     * Lihat Nilai
     */
    public function nilai()
    {
        $siswa = auth()->user()->siswa;
        $pengumpulanTugas = $siswa->pengumpulanTugas()
            ->with('materiTugas')
            ->latest('tanggal_pengumpulan')
            ->get();
        
        // Statistik nilai
        $nilaiList = $pengumpulanTugas->where('nilai', '!=', null)->pluck('nilai');
        $rataNilai = $nilaiList->avg() ?? 0;
        $nilaiTertinggi = $nilaiList->max() ?? 0;
        $nilaiTerendah = $nilaiList->min() ?? 0;
        $totalDinilai = $nilaiList->count();
        
        // Log activity
        LogActivity::logActivity(
            $siswa->id,
            'lihat_nilai',
            'Siswa melihat nilai tugas'
        );

        return view('siswa.nilai', compact(
            'pengumpulanTugas',
            'rataNilai',
            'nilaiTertinggi',
            'nilaiTerendah',
            'totalDinilai'
        ));
    }

    /**
     * Rapor Siswa
     */
    public function rapor(Request $request)
    {
        $siswa = auth()->user()->siswa;
        
        // Default bulan dan tahun
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        // Data kehadiran bulan ini
        $kehadiran = $siswa->kehadiran()
            ->bulan($bulan, $tahun)
            ->with('jadwal')
            ->get();
        
        // Data nilai bulan ini
        $nilaiTugas = $siswa->pengumpulanTugas()
            ->bulan($bulan, $tahun)
            ->whereNotNull('nilai')
            ->with('materiTugas')
            ->get();
        
        // Statistik kehadiran
        $totalPertemuan = $kehadiran->count();
        $totalHadir = $kehadiran->where('status', 'hadir')->count();
        $persentaseHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 2) : 0;
        
        // Statistik nilai
        $rataNilai = $nilaiTugas->avg('nilai') ?? 0;

        return view('siswa.rapor', compact(
            'siswa',
            'kehadiran',
            'nilaiTugas',
            'bulan',
            'tahun',
            'totalPertemuan',
            'totalHadir',
            'persentaseHadir',
            'rataNilai'
        ));
    }

    // ============ KEHADIRAN ============
    
    /**
     * Lihat Kehadiran
     */
    public function kehadiran()
    {
        $siswa = auth()->user()->siswa;
        $kehadiran = $siswa->kehadiran()
            ->with('jadwal')
            ->latest('tanggal_pertemuan')
            ->get();
        
        // Statistik
        $totalKehadiran = $kehadiran->count();
        $totalHadir = $kehadiran->where('status', 'hadir')->count();
        $totalSakit = $kehadiran->where('status', 'sakit')->count();
        $totalIzin = $kehadiran->where('status', 'izin')->count();
        $totalAlpha = $kehadiran->where('status', 'alpha')->count();
        
        $persentaseHadir = $totalKehadiran > 0 ? round(($totalHadir / $totalKehadiran) * 100, 2) : 0;

        return view('siswa.kehadiran', compact(
            'kehadiran',
            'totalKehadiran',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlpha',
            'persentaseHadir'
        ));
    }

    // ============ PENGUMUMAN ============
    
    /**
     * Lihat Pengumuman
     */
    public function pengumuman()
    {
        $pengumuman = Pengumuman::published()
            ->forUser('siswa')
            ->latest()
            ->get();

        return view('siswa.pengumuman', compact('pengumuman'));
    }

    /**
     * Detail Pengumuman
     */
    public function detailPengumuman($id)
    {
        $pengumuman = Pengumuman::published()
            ->forUser('siswa')
            ->findOrFail($id);

        return view('siswa.detail-pengumuman', compact('pengumuman'));
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

        return view('siswa.notifikasi', compact('notifikasi'));
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

    /**
     * Tandai semua notifikasi dibaca
     */
    public function markAllNotifikasiRead()
    {
        auth()->user()
            ->notifikasi()
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca!');
    }

    // ============ PROFILE ============
    
    /**
     * Profil Siswa
     */
    public function profile()
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        return view('siswa.profile', compact('user', 'siswa'));
    }

    /**
     * Update Profil
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $request->validate([
            'username' => 'required|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_lengkap' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required|max:10',
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

        // Update siswa data
        $siswa->update($request->only([
            'nama_lengkap',
            'tanggal_lahir',
            'kelas'
        ]));

        return back()->with('success', 'Profil berhasil diupdate!');
    }
}