<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\PaketBelajar;
use App\Models\Transaksi;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\MateriTugas;
use App\Models\PengumpulanTugas;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\Settings;
use App\Models\Notifikasi;
use App\Helpers\FileUploadHelper;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalOrangTua = OrangTua::count();
        $totalPaket = PaketBelajar::count();
        $transaksiPending = Transaksi::pending()->count();
        $feedbackBaru = Feedback::baru()->count();
        
        $recentTransaksi = Transaksi::with(['orangTua', 'siswa', 'paketBelajar'])
            ->latest()
            ->take(5)
            ->get();
        
        $recentFeedback = Feedback::with(['orangTua', 'siswa'])
            ->baru()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalOrangTua',
            'totalPaket',
            'transaksiPending',
            'feedbackBaru',
            'recentTransaksi',
            'recentFeedback'
        ));
    }

    // ============ USER MANAGEMENT ============
    
    /**
     * Kelola Users (Admin, Orang Tua, Siswa)
     */
    public function users(Request $request)
    {
        $role = $request->get('role', 'all');
        
        $query = User::with(['orangTua', 'siswa']);
        
        if ($role !== 'all') {
            $query->where('role', $role);
        }
        
        $users = $query->latest()->get();
        
        return view('admin.users', compact('users', 'role'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,orangtua,siswa',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['username', 'email', 'role']);
        $data['password'] = Hash::make($request->password);
        $data['status'] = 'aktif';

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = FileUploadHelper::uploadFile(
                $request->file('foto_profil'),
                'profile_photos'
            );
        }

        $user = User::create($data);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,orangtua,siswa',
            'status' => 'required|in:aktif,nonaktif',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['username', 'email', 'role', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = FileUploadHelper::uploadFile(
                $request->file('foto_profil'),
                'profile_photos',
                $user->foto_profil
            );
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diupdate!');
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->foto_profil) {
            FileUploadHelper::deleteFile($user->foto_profil);
        }
        
        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }

    // ============ ORANG TUA MANAGEMENT ============
    
    /**
     * Kelola Orang Tua Detail
     */
    public function orangTua()
    {
        $orangTua = OrangTua::with(['user', 'siswa'])->get();
        $usersOrangTua = User::where('role', 'orangtua')
            ->whereDoesntHave('orangTua')
            ->get();
        
        return view('admin.orangtua', compact('orangTua', 'usersOrangTua'));
    }

    /**
     * Store orang tua
     */
    public function storeOrangTua(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lengkap' => 'required|max:255',
            'no_telepon' => 'required|max:20',
            'alamat' => 'required',
            'pekerjaan' => 'nullable|max:255',
        ]);

        OrangTua::create($request->all());

        return back()->with('success', 'Data orang tua berhasil ditambahkan!');
    }

    /**
     * Update orang tua
     */
    public function updateOrangTua(Request $request, $id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|max:255',
            'no_telepon' => 'required|max:20',
            'alamat' => 'required',
            'pekerjaan' => 'nullable|max:255',
        ]);

        $orangTua->update($request->all());

        return back()->with('success', 'Data orang tua berhasil diupdate!');
    }

    /**
     * Delete orang tua
     */
    public function deleteOrangTua($id)
    {
        $orangTua = OrangTua::findOrFail($id);
        $orangTua->delete();

        return back()->with('success', 'Data orang tua berhasil dihapus!');
    }

    // ============ SISWA MANAGEMENT ============
    
    /**
     * Kelola Siswa
     */
    public function siswa()
    {
        $siswa = Siswa::with(['user', 'orangTua'])->get();
        $usersSiswa = User::where('role', 'siswa')
            ->whereDoesntHave('siswa')
            ->get();
        $orangTua = OrangTua::all();
        
        return view('admin.siswa', compact('siswa', 'usersSiswa', 'orangTua'));
    }

    /**
     * Store siswa
     */
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'orangtua_id' => 'required|exists:orang_tua,id',
            'nama_lengkap' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'jenjang' => 'required|in:SD,SMP',
            'kelas' => 'required|max:10',
        ]);

        Siswa::create($request->all());

        return back()->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Update siswa
     */
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'orangtua_id' => 'required|exists:orang_tua,id',
            'nama_lengkap' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'jenjang' => 'required|in:SD,SMP',
            'kelas' => 'required|max:10',
        ]);

        $siswa->update($request->all());

        return back()->with('success', 'Data siswa berhasil diupdate!');
    }

    /**
     * Delete siswa
     */
    public function deleteSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return back()->with('success', 'Data siswa berhasil dihapus!');
    }

    // ============ PAKET BELAJAR MANAGEMENT ============
    
    /**
     * Kelola Paket Belajar
     */
    public function paketBelajar()
    {
        $paket = PaketBelajar::withCount('transaksi')->get();
        
        return view('admin.paket', compact('paket'));
    }

    /**
     * Store paket belajar
     */
    public function storePaket(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'durasi_bulan' => 'required|integer|min:1',
            'jenjang' => 'required|in:SD,SMP,SD & SMP',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        PaketBelajar::create($request->all());

        return back()->with('success', 'Paket belajar berhasil ditambahkan!');
    }

    /**
     * Update paket belajar
     */
    public function updatePaket(Request $request, $id)
    {
        $paket = PaketBelajar::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'durasi_bulan' => 'required|integer|min:1',
            'jenjang' => 'required|in:SD,SMP,SD & SMP',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        $paket->update($request->all());

        return back()->with('success', 'Paket belajar berhasil diupdate!');
    }

    /**
     * Delete paket belajar
     */
    public function deletePaket($id)
    {
        $paket = PaketBelajar::findOrFail($id);
        $paket->delete();

        return back()->with('success', 'Paket belajar berhasil dihapus!');
    }

    // ============ TRANSAKSI & PEMBAYARAN ============
    
    /**
     * Kelola Transaksi
     */
    public function transaksi(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Transaksi::with(['orangTua', 'siswa', 'paketBelajar']);
        
        if ($status !== 'all') {
            $query->where('status_verifikasi', $status);
        }
        
        $transaksi = $query->latest()->get();
        
        return view('admin.transaksi', compact('transaksi', 'status'));
    }

    /**
     * Verifikasi pembayaran
     */
    public function verifikasiTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:verified,rejected',
            'catatan_admin' => 'nullable|string',
        ]);

        $transaksi->update($request->only(['status_verifikasi', 'catatan_admin']));

        // Send notification to orang tua
        $message = $request->status_verifikasi === 'verified' 
            ? 'Pembayaran Anda untuk ' . $transaksi->siswa->nama_lengkap . ' telah diverifikasi.'
            : 'Pembayaran Anda untuk ' . $transaksi->siswa->nama_lengkap . ' ditolak. ' . $request->catatan_admin;

        Notifikasi::createNotification(
            $transaksi->orangTua->user_id,
            'Status Pembayaran',
            $message,
            'pembayaran'
        );

        return back()->with('success', 'Status transaksi berhasil diupdate!');
    }

    // ============ JADWAL MANAGEMENT ============
    
    /**
     * Kelola Jadwal
     */
    public function jadwal()
    {
        $jadwal = Jadwal::with(['siswa'])->get();
        $siswa = Siswa::all();
        
        return view('admin.jadwal', compact('jadwal', 'siswa'));
    }

    /**
     * Store jadwal
     */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran' => 'required|max:255',
            'nama_guru' => 'required|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'nullable|max:255',
        ]);

        // Check bentrok jadwal
        if (Jadwal::checkBentrok($request->hari, $request->jam_mulai, $request->jam_selesai, $request->siswa_id)) {
            return back()->with('error', 'Jadwal bentrok dengan jadwal lain!');
        }

        Jadwal::create($request->all());

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Update jadwal
     */
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran' => 'required|max:255',
            'nama_guru' => 'required|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'nullable|max:255',
        ]);

        // Check bentrok jadwal
        if (Jadwal::checkBentrok($request->hari, $request->jam_mulai, $request->jam_selesai, $request->siswa_id, $id)) {
            return back()->with('error', 'Jadwal bentrok dengan jadwal lain!');
        }

        $jadwal->update($request->all());

        return back()->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Delete jadwal
     */
    public function deleteJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus!');
    }

    // ============ KEHADIRAN MANAGEMENT ============
    
    /**
     * Kelola Kehadiran
     */
    public function kehadiran()
    {
        $kehadiran = Kehadiran::with(['jadwal', 'siswa'])->latest('tanggal_pertemuan')->get();
        $jadwal = Jadwal::with('siswa')->get();
        
        return view('admin.kehadiran', compact('kehadiran', 'jadwal'));
    }

    /**
     * Store kehadiran
     */
    public function storeKehadiran(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'tanggal_pertemuan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Kehadiran::create($request->all());

        return back()->with('success', 'Kehadiran berhasil ditambahkan!');
    }

    /**
     * Update kehadiran
     */
    public function updateKehadiran(Request $request, $id)
    {
        $kehadiran = Kehadiran::findOrFail($id);

        $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'tanggal_pertemuan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $kehadiran->update($request->only(['status', 'tanggal_pertemuan', 'keterangan']));

        return back()->with('success', 'Kehadiran berhasil diupdate!');
    }

    /**
     * Delete kehadiran
     */
    public function deleteKehadiran($id)
    {
        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->delete();

        return back()->with('success', 'Kehadiran berhasil dihapus!');
    }

    // ============ MATERI & TUGAS MANAGEMENT ============
    
    /**
     * Kelola Materi & Tugas
     */
    public function materiTugas(Request $request)
    {
        $tipe = $request->get('tipe', 'all');
        $jenjang = $request->get('jenjang', 'all');
        
        $query = MateriTugas::query();
        
        if ($tipe !== 'all') {
            $query->where('tipe', $tipe);
        }
        
        if ($jenjang !== 'all') {
            $query->where('jenjang', $jenjang);
        }
        
        $materiTugas = $query->latest()->get();
        
        return view('admin.materi-tugas', compact('materiTugas', 'tipe', 'jenjang'));
    }

    /**
     * Store materi/tugas
     */
    public function storeMateriTugas(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required|in:materi,tugas',
            'mata_pelajaran' => 'required|max:255',
            'jenjang' => 'required|in:SD,SMP',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
            'deadline' => 'nullable|date|after:today',
        ]);

        $data = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            $folder = $request->tipe === 'materi' ? 'materi' : 'tugas';
            $data['file_path'] = FileUploadHelper::uploadFile(
                $request->file('file_path'),
                $folder
            );
        }

        MateriTugas::create($data);

        return back()->with('success', ucfirst($request->tipe) . ' berhasil ditambahkan!');
    }

    /**
     * Update materi/tugas
     */
    public function updateMateriTugas(Request $request, $id)
    {
        $materiTugas = MateriTugas::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'mata_pelajaran' => 'required|max:255',
            'jenjang' => 'required|in:SD,SMP',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
            'deadline' => 'nullable|date',
        ]);

        $data = $request->except('file_path');

        if ($request->hasFile('file_path')) {
            $folder = $materiTugas->tipe === 'materi' ? 'materi' : 'tugas';
            $data['file_path'] = FileUploadHelper::uploadFile(
                $request->file('file_path'),
                $folder,
                $materiTugas->file_path
            );
        }

        $materiTugas->update($data);

        return back()->with('success', ucfirst($materiTugas->tipe) . ' berhasil diupdate!');
    }

    /**
     * Delete materi/tugas
     */
    public function deleteMateriTugas($id)
    {
        $materiTugas = MateriTugas::findOrFail($id);
        
        if ($materiTugas->file_path) {
            FileUploadHelper::deleteFile($materiTugas->file_path);
        }
        
        $materiTugas->delete();

        return back()->with('success', ucfirst($materiTugas->tipe) . ' berhasil dihapus!');
    }

    // ============ PENGUMPULAN TUGAS MANAGEMENT ============
    
    /**
     * Kelola Pengumpulan Tugas
     */
    public function pengumpulanTugas(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = PengumpulanTugas::with(['materiTugas', 'siswa']);
        
        if ($status === 'belum_dinilai') {
            $query->belumDinilai();
        } elseif ($status === 'sudah_dinilai') {
            $query->sudahDinilai();
        }
        
        $pengumpulan = $query->latest('tanggal_pengumpulan')->get();
        
        return view('admin.pengumpulan-tugas', compact('pengumpulan', 'status'));
    }

    /**
     * Nilai tugas siswa
     */
    public function nilaiTugas(Request $request, $id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback_guru' => 'nullable|string',
        ]);

        $pengumpulan->update($request->only(['nilai', 'feedback_guru']));

        // Send notification to siswa
        Notifikasi::createNotification(
            $pengumpulan->siswa->user_id,
            'Tugas Telah Dinilai',
            'Tugas "' . $pengumpulan->materiTugas->judul . '" Anda telah dinilai dengan nilai ' . $request->nilai,
            'tugas'
        );

        return back()->with('success', 'Tugas berhasil dinilai!');
    }

    // ============ FEEDBACK MANAGEMENT ============
    
    /**
     * Kelola Feedback
     */
    public function feedback(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Feedback::with(['orangTua', 'siswa']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $feedback = $query->latest()->get();
        
        return view('admin.feedback', compact('feedback', 'status'));
    }

    /**
     * Balas feedback
     */
    public function balasFeedback(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $request->validate([
            'balasan_admin' => 'required|string',
        ]);

        $feedback->update([
            'balasan_admin' => $request->balasan_admin,
            'status' => 'dibaca',
        ]);

        // Send notification to orang tua
        Notifikasi::createNotification(
            $feedback->orangTua->user_id,
            'Balasan Feedback',
            'Admin telah membalas feedback Anda mengenai ' . $feedback->siswa->nama_lengkap,
            'feedback'
        );

        return back()->with('success', 'Feedback berhasil dibalas!');
    }

    /**
     * Delete feedback
     */
    public function deleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return back()->with('success', 'Feedback berhasil dihapus!');
    }

    // ============ PENGUMUMAN MANAGEMENT ============
    
    /**
     * Kelola Pengumuman
     */
    public function pengumuman()
    {
        $pengumuman = Pengumuman::with('creator')->latest()->get();
        
        return view('admin.pengumuman', compact('pengumuman'));
    }

    /**
     * Store pengumuman
     */
    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'target' => 'required|in:semua,orangtua,siswa',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['tanggal_publikasi'] = $request->status === 'published' ? now() : null;

        $pengumuman = Pengumuman::create($data);

        // Send notification if published
        if ($request->status === 'published') {
            $pengumuman->publish();
        }

        return back()->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    /**
     * Update pengumuman
     */
    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'target' => 'required|in:semua,orangtua,siswa',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only(['judul', 'isi', 'target', 'status']);
        
        // If changing from draft to published
        if ($pengumuman->isDraft() && $request->status === 'published') {
            $data['tanggal_publikasi'] = now();
        }

        $pengumuman->update($data);

        // Send notification if newly published
        if ($pengumuman->wasChanged('status') && $pengumuman->isPublished()) {
            $pengumuman->publish();
        }

        return back()->with('success', 'Pengumuman berhasil diupdate!');
    }

    /**
     * Delete pengumuman
     */
    public function deletePengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }

    // ============ SETTINGS MANAGEMENT ============
    
    /**
     * Kelola Settings Website
     */
    public function settings()
    {
        $settings = Settings::getSiteSettings();
        
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'nama_website' => 'required|max:255',
            'alamat' => 'required',
            'no_telepon' => 'required|max:20',
            'email' => 'required|email',
            'tentang' => 'nullable',
            'nama_bank' => 'nullable|max:255',
            'nomor_rekening' => 'nullable|max:255',
            'atas_nama' => 'nullable|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $settings = Settings::getSiteSettings();
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = FileUploadHelper::uploadFile(
                $request->file('logo'),
                'logos',
                $settings->logo
            );
        }

        $settings->update($data);

        return back()->with('success', 'Pengaturan berhasil diupdate!');
    }

    // ============ LAPORAN & MONITORING ============
    
    /**
     * Laporan Siswa
     */
    public function laporanSiswa()
    {
        $siswa = Siswa::with(['orangTua', 'transaksi', 'kehadiran', 'pengumpulanTugas'])->get();
        
        return view('admin.laporan-siswa', compact('siswa'));
    }

    /**
     * Detail Laporan Siswa
     */
    public function detailLaporanSiswa($id)
    {
        $siswa = Siswa::with([
            'orangTua',
            'jadwal',
            'kehadiran.jadwal',
            'pengumpulanTugas.materiTugas',
            'transaksi.paketBelajar',
            'feedback',
            'logActivity'
        ])->findOrFail($id);

        return view('admin.detail-laporan-siswa', compact('siswa'));
    }

    // ============ PROFILE MANAGEMENT ============
    
    /**
     * Profil Admin
     */
    public function profile()
    {
        $user = auth()->user();
        
        return view('admin.profile', compact('user'));
    }

    /**
     * Update profil admin
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['username', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = FileUploadHelper::uploadFile(
                $request->file('foto_profil'),
                'profile_photos',
                $user->foto_profil
            );
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diupdate!');
    }
}