<?php
// sides\app\Http\Controllers\AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\PaketBelajar;
use App\Models\Pendaftaran;
use App\Models\JadwalMateri;
use App\Models\Transaksi;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ============= DASHBOARD =============
    public function dashboard()
    {
        $stats = [
            'total_siswa' => Siswa::count(),
            'siswa_aktif' => Siswa::aktif()->count(),
            'total_orangtua' => OrangTua::count(),
            'total_paket' => PaketBelajar::count(),
            'pendaftaran_menunggu' => Pendaftaran::menunggu()->count(),
            'transaksi_menunggu' => Transaksi::menunggu()->count(),
            'total_materi' => JadwalMateri::materi()->count(),
            'total_tugas' => JadwalMateri::tugas()->count(),
        ];

        // Data untuk chart
        $siswaByJenjang = [
            'SD' => Siswa::byJenjang('SD')->aktif()->count(),
            'SMP' => Siswa::byJenjang('SMP')->aktif()->count(),
        ];

        // Pendaftaran terbaru
        $pendaftaranTerbaru = Pendaftaran::with(['orangTua.user', 'paketBelajar'])
            ->latest()
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['orangTua.user', 'siswa'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'siswaByJenjang', 'pendaftaranTerbaru', 'transaksiTerbaru'));
    }

    // ============= PAKET BELAJAR =============
    public function paketIndex()
    {
        $pakets = PaketBelajar::withCount('pendaftaran')->orderBy('created_at', 'desc')->get();
        return view('admin.paket.index', compact('pakets'));
    }

    public function paketCreate()
    {
        return view('admin.paket.create');
    }

    public function paketStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'komentar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        PaketBelajar::create($request->all());

        return redirect()->route('admin.paket.index')->with('success', 'Paket belajar berhasil ditambahkan');
    }

    public function paketEdit($id)
    {
        $paket = PaketBelajar::findOrFail($id);
        return view('admin.paket.edit', compact('paket'));
    }

    public function paketUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'komentar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $paket = PaketBelajar::findOrFail($id);
        $paket->update($request->all());

        return redirect()->route('admin.paket.index')->with('success', 'Paket belajar berhasil diperbarui');
    }

    public function paketDestroy($id)
    {
        $paket = PaketBelajar::findOrFail($id);
        
        // Cek apakah ada pendaftaran
        if ($paket->pendaftaran()->count() > 0) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus paket yang sudah memiliki pendaftaran']);
        }

        $paket->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket belajar berhasil dihapus');
    }

    // ============= PENDAFTARAN =============
    public function pendaftaranIndex()
    {
        $pendaftarans = Pendaftaran::with(['orangTua.user', 'paketBelajar', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function pendaftaranShow($id)
    {
        $pendaftaran = Pendaftaran::with(['orangTua.user', 'paketBelajar', 'siswa'])
            ->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function pendaftaranApprove(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status !== 'menunggu') {
            return back()->withErrors(['error' => 'Pendaftaran ini sudah diproses']);
        }

        // Hitung tanggal selesai otomatis berdasarkan durasi paket (dalam bulan)
        $tanggalSelesai = now()->addMonths($pendaftaran->paketBelajar->durasi);

        $pendaftaran->update([
            'status' => 'diterima',
            'tanggal_selesai' => $tanggalSelesai,
            'catatan' => $request->catatan,
        ]);

        // Update status siswa jadi aktif
        if ($pendaftaran->siswa) {
            $pendaftaran->siswa->update(['status' => 'aktif']);
        }

        // Buat notifikasi
        Informasi::create([
            'id_siswa' => $pendaftaran->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => 'Pendaftaran Diterima',
            'isi' => 'Selamat! Pendaftaran Anda untuk paket "' . $pendaftaran->paketBelajar->nama_paket . '" telah diterima. Masa aktif sampai ' . $tanggalSelesai->format('d F Y') . '.',
            'jenis' => 'notifikasi',
        ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil disetujui. Masa aktif sampai ' . $tanggalSelesai->format('d F Y'));
    }

    public function pendaftaranReject(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status !== 'menunggu') {
            return back()->withErrors(['error' => 'Pendaftaran ini sudah diproses']);
        }

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $pendaftaran->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        // Buat notifikasi
        Informasi::create([
            'id_siswa' => $pendaftaran->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => 'Pendaftaran Ditolak',
            'isi' => 'Mohon maaf, pendaftaran Anda ditolak. Alasan: ' . $request->catatan,
            'jenis' => 'notifikasi',
        ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil ditolak');
    }

    // ============= SISWA =============
    public function siswaIndex()
    {
        $siswas = Siswa::with(['user', 'orangTua.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function siswaCreate()
    {
        $orangTuas = OrangTua::with('user')->get();
        return view('admin.siswa.create', compact('orangTuas'));
    }

    public function siswaStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_orang_tua' => 'required|exists:orang_tua,id_orang_tua',
            'tanggal_lahir' => 'required|date_format:Y-m-d\TH:i',
            'jenjang' => 'required|in:SD,SMP',
            'kelas' => 'required|string',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Buat user
            $user = User::create([
                'name' => $request->nama_siswa,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            // Buat siswa
            Siswa::create([
                'user_id' => $user->id,
                'id_orang_tua' => $request->id_orang_tua,
                'nama_siswa' => $request->nama_siswa,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'status' => 'aktif',
            ]);

            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function siswaEdit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $orangTuas = OrangTua::with('user')->get();
        return view('admin.siswa.edit', compact('siswa', 'orangTuas'));
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'id_orang_tua' => 'required|exists:orang_tua,id_orang_tua',
            'tanggal_lahir' => 'required|date_format:Y-m-d\TH:i',
            'jenjang' => 'required|in:SD,SMP',
            'kelas' => 'required|string',
            'status' => 'required|in:aktif,non-aktif',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Update user
            $siswa->user->update([
                'name' => $request->nama_siswa,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            // Update password jika diisi
            if ($request->filled('password')) {
                $siswa->user->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            // Update siswa
            $siswa->update([
                'id_orang_tua' => $request->id_orang_tua,
                'nama_siswa' => $request->nama_siswa,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function siswaDestroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        
        // Hapus user juga
        $user = $siswa->user;
        $siswa->delete();
        $user->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function siswaShow($id)
    {
        $siswa = Siswa::with(['user', 'orangTua.user', 'jadwalMateri', 'transaksi'])
            ->findOrFail($id);
        
        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'nilai_rata' => $siswa->getNilaiRataRata(),
        ];

        return view('admin.siswa.show', compact('siswa', 'stats'));
    }

    // ============= ORANG TUA =============
    public function orangTuaIndex()
    {
        $orangTuas = OrangTua::with('user')->withCount('siswa')->orderBy('created_at', 'desc')->get();
        return view('admin.orangtua.index', compact('orangTuas'));
    }

    public function orangTuaShow($id)
    {
        $orangTua = OrangTua::with(['user', 'siswa.user', 'pendaftaran', 'transaksi'])
            ->findOrFail($id);
        return view('admin.orangtua.show', compact('orangTua'));
    }

    // ============= JADWAL & MATERI =============
    public function jadwalIndex(Request $request)
    {
        $query = JadwalMateri::with('siswa.user');

        // Filter by jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by siswa name
        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->siswa . '%');
            });
        }

        $jadwals = $query->orderBy('created_at', 'desc')->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function jadwalCreate()
    {
        $siswas = Siswa::with('user')->aktif()->get();
        return view('admin.jadwal.create', compact('siswas'));
    }

    public function jadwalStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:materi,tugas',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240',
            'durasi' => 'nullable|integer|min:1',
            'awal' => 'required|date_format:Y-m-d\TH:i',
            'deadline' => 'nullable|date_format:Y-m-d\TH:i|after:awal',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('file');
            $data['status'] = 'pending';

            // Handle upload file dengan nama original + timestamp
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                
                if ($request->jenis === 'materi') {
                    $file->storeAs('materials', $filename, 'public');
                    $data['file'] = 'materials/' . $filename;
                } else {
                    $file->storeAs('assignments', $filename, 'public');
                    $data['file'] = 'assignments/' . $filename;
                }
            }

            $jadwal = JadwalMateri::create($data);

            // Buat notifikasi untuk siswa
            Informasi::create([
                'id_siswa' => $request->id_siswa,
                'id_pengguna' => auth()->id(),
                'judul' => ($request->jenis === 'materi' ? 'Materi Baru' : 'Tugas Baru'),
                'isi' => 'Anda mendapat ' . $request->jenis . ' baru: ' . $request->judul,
                'jenis' => 'notifikasi',
            ]);

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal/Materi berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // Helper method untuk download file
    public function jadwalDownload($id)
    {
        $jadwal = JadwalMateri::findOrFail($id);
        
        if (!$jadwal->file || !Storage::disk('public')->exists($jadwal->file)) {
            return back()->withErrors(['error' => 'File tidak ditemukan']);
        }
        
        // Ambil nama file original dari path
        $filename = basename($jadwal->file);
        // Hapus timestamp dari nama file untuk download
        $originalName = preg_replace('/^\d+_/', '', $filename);
        
        return Storage::disk('public')->download($jadwal->file, $originalName);
    }

    public function jadwalEdit($id)
    {
        $jadwal = JadwalMateri::with('siswa')->findOrFail($id);
        $siswas = Siswa::with('user')->aktif()->get();
        return view('admin.jadwal.edit', compact('jadwal', 'siswas'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = JadwalMateri::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:materi,tugas',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240',
            'durasi' => 'nullable|integer|min:1',
            'awal' => 'required|date_format:Y-m-d\TH:i',
            'deadline' => 'nullable|date_format:Y-m-d\TH:i|after:awal',
            'status' => 'required|in:pending,selesai,terlambat',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('file');

            // Handle upload file baru
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($jadwal->file && Storage::disk('public')->exists($jadwal->file)) {
                    Storage::disk('public')->delete($jadwal->file);
                }
                
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . $originalName;
                
                if ($request->jenis === 'materi') {
                    $file->storeAs('materials', $filename, 'public');
                    $data['file'] = 'materials/' . $filename;
                } else {
                    $file->storeAs('assignments', $filename, 'public');
                    $data['file'] = 'assignments/' . $filename;
                }
            }

            $jadwal->update($data);

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal/Materi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function jadwalDestroy($id)
    {
        $jadwal = JadwalMateri::findOrFail($id);
        
        // Hapus file jika ada
        if ($jadwal->file && Storage::disk('public')->exists($jadwal->file)) {
            Storage::disk('public')->delete($jadwal->file);
        }

        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal/Materi berhasil dihapus');
    }

    public function jadwalShow($id)
    {
        $jadwal = JadwalMateri::with('siswa.user')->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    // Input nilai tugas
    // Input nilai tugas - DIPERBAIKI
    public function inputNilai(Request $request, $id)
    {
        $jadwal = JadwalMateri::findOrFail($id);

        // Cek apakah request untuk reset nilai
        if ($request->has('reset_nilai')) {
            $jadwal->update([
                'nilai' => null,
                'status' => 'pending',
            ]);
            
            return back()->with('info', 'Nilai berhasil direset. Silakan input nilai baru.');
        }

        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'komentar' => 'nullable|string',
        ]);

        // Update nilai dan komentar
        $deskripsiUpdate = $jadwal->deskripsi ?? '';
        
        // Hapus komentar lama jika ada
        if (str_contains($deskripsiUpdate, "\n\nKomentar Guru:")) {
            $deskripsiUpdate = explode("\n\nKomentar Guru:", $deskripsiUpdate)[0];
        }
        
        // Tambahkan komentar baru jika ada
        if ($request->komentar) {
            $deskripsiUpdate .= "\n\nKomentar Guru: " . $request->komentar;
        }

        $jadwal->update([
            'nilai' => $request->nilai,
            'deskripsi' => $deskripsiUpdate,
            'status' => 'selesai',
        ]);

        // Buat notifikasi
        Informasi::create([
            'id_siswa' => $jadwal->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => 'Nilai Tugas',
            'isi' => 'Tugas "' . $jadwal->judul . '" telah dinilai. Nilai: ' . $request->nilai,
            'jenis' => 'notifikasi',
        ]);

        return back()->with('success', 'Nilai berhasil diinput');
    }

    // ============= TRANSAKSI =============
    public function transaksiIndex()
    {
        $transaksis = Transaksi::with(['orangTua.user', 'siswa'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function transaksiShow($id)
    {
        $transaksi = Transaksi::with(['orangTua.user', 'siswa'])->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function transaksiVerify(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'menunggu') {
            return back()->withErrors(['error' => 'Transaksi ini sudah diproses']);
        }

        $transaksi->update([
            'status' => 'diverifikasi',
            'keterangan' => $request->keterangan,
            'diverifikasi_pada' => now(),
        ]);

        // Buat notifikasi
        Informasi::create([
            'id_siswa' => $transaksi->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => 'Pembayaran Diverifikasi',
            'isi' => 'Pembayaran sebesar ' . $transaksi->getFormattedJumlah() . ' telah diverifikasi.',
            'jenis' => 'notifikasi',
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diverifikasi');
    }

    public function transaksiReject(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'menunggu') {
            return back()->withErrors(['error' => 'Transaksi ini sudah diproses']);
        }

        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $transaksi->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        // Buat notifikasi
        Informasi::create([
            'id_siswa' => $transaksi->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => 'Pembayaran Ditolak',
            'isi' => 'Pembayaran Anda ditolak. Alasan: ' . $request->keterangan,
            'jenis' => 'notifikasi',
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil ditolak');
    }

    // ============= INFORMASI & PENGUMUMAN =============
    public function informasiIndex()
    {
        $informasis = Informasi::with(['siswa', 'pengguna'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.informasi.index', compact('informasis'));
    }

    public function informasiCreate()
    {
        $siswas = Siswa::with('user')->aktif()->get();
        return view('admin.informasi.create', compact('siswas'));
    }

    public function informasiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'jenis' => 'required|in:pengumuman,notifikasi',
            'id_siswa' => 'nullable|exists:siswa,id_siswa',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Informasi::create([
            'id_siswa' => $request->id_siswa,
            'id_pengguna' => auth()->id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil ditambahkan');
    }

    public function informasiDestroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();

        return redirect()->route('admin.informasi.index')->with('success', 'Informasi berhasil dihapus');
    }

    // ============= LAPORAN =============
    public function laporanIndex()
    {
        return view('admin.laporan.index');
    }

    public function laporanSiswa(Request $request)
    {
        $siswas = Siswa::with(['user', 'orangTua.user'])
            ->when($request->jenjang, fn($q) => $q->byJenjang($request->jenjang))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->get();

        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.siswa-pdf', compact('siswas'));
            return $pdf->download('laporan-siswa-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.laporan.siswa', compact('siswas'));
    }

    public function laporanTransaksi(Request $request)
    {
        $transaksis = Transaksi::with(['orangTua.user', 'siswa'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->tanggal_dari, fn($q) => $q->where('tanggal_bayar', '>=', $request->tanggal_dari))
            ->when($request->tanggal_sampai, fn($q) => $q->where('tanggal_bayar', '<=', $request->tanggal_sampai))
            ->get();

        $total = $transaksis->where('status', 'diverifikasi')->sum('jumlah');

        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.transaksi-pdf', compact('transaksis', 'total'));
            return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
        }

        return view('admin.laporan.transaksi', compact('transaksis', 'total'));
    }

    public function laporanKemajuanSiswa($id)
    {
        $siswa = Siswa::with(['user', 'orangTua.user', 'jadwalMateri'])->findOrFail($id);
        
        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'tugas_terlambat' => $siswa->getTugasTerlambat(),
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2),
            'nilai_tertinggi' => $siswa->getNilaiTertinggi(),
            'nilai_terendah' => $siswa->getNilaiTerendah(),
        ];

        $pdf = Pdf::loadView('admin.laporan.kemajuan-siswa-pdf', compact('siswa', 'stats'));
        return $pdf->download('laporan-kemajuan-' . $siswa->nama_siswa . '-' . date('Y-m-d') . '.pdf');
    }

    // ============= STATISTIK =============
    public function statistik()
    {
        $stats = [
            'total_siswa' => Siswa::count(),
            'siswa_aktif' => Siswa::aktif()->count(),
            'siswa_sd' => Siswa::byJenjang('SD')->aktif()->count(),
            'siswa_smp' => Siswa::byJenjang('SMP')->aktif()->count(),
            'total_orangtua' => OrangTua::count(),
            'total_paket' => PaketBelajar::count(),
            'pendaftaran_menunggu' => Pendaftaran::menunggu()->count(),
            'pendaftaran_diterima' => Pendaftaran::diterima()->count(),
            'pendaftaran_ditolak' => Pendaftaran::ditolak()->count(),
            'transaksi_menunggu' => Transaksi::menunggu()->count(),
            'transaksi_diverifikasi' => Transaksi::diverifikasi()->count(),
            'total_pendapatan' => Transaksi::diverifikasi()->sum('jumlah'),
            'total_materi' => JadwalMateri::materi()->count(),
            'total_tugas' => JadwalMateri::tugas()->count(),
        ];

        // Data untuk chart
        $chartData = [
            'siswa_per_bulan' => $this->getSiswaPerBulan(),
            'transaksi_per_bulan' => $this->getTransaksiPerBulan(),
        ];

        return view('admin.statistik', compact('stats', 'chartData'));
    }

    private function getSiswaPerBulan()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[$date->format('M Y')] = Siswa::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $data;
    }

    private function getTransaksiPerBulan()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[$date->format('M Y')] = Transaksi::diverifikasi()
                ->whereYear('tanggal_bayar', $date->year)
                ->whereMonth('tanggal_bayar', $date->month)
                ->sum('jumlah');
        }
        return $data;
    }
}