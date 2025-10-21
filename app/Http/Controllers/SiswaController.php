<?php
// sides\app\Http\Controllers\SiswaController.php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\JadwalMateri;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    // ============= DASHBOARD =============
    public function dashboard()
    {
        $siswa = Auth::user()->siswa;

        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2) ?? 0,
        ];

        // Jadwal terdekat
        $jadwalTerdekat = $siswa->jadwalMateri()
            ->where('awal', '>=', now())
            ->orderBy('awal', 'asc')
            ->take(5)
            ->get();

        // Tugas pending
        $tugasPending = $siswa->jadwalMateri()
            ->tugas()
            ->pending()
            ->orderBy('deadline', 'asc')
            ->get();

        // Pengumuman terbaru
        $pengumuman = Informasi::where(function($query) use ($siswa) {
            $query->whereNull('id_siswa')
                  ->orWhere('id_siswa', $siswa->id_siswa);
        })
        ->latest()
        ->take(5)
        ->get();

        return view('siswa.dashboard', compact('stats', 'jadwalTerdekat', 'tugasPending', 'pengumuman'));
    }

    // ============= JADWAL =============
    public function jadwalIndex()
    {
        $siswa = Auth::user()->siswa;
        $jadwals = $siswa->jadwalMateri()
            ->orderBy('awal', 'desc')
            ->get();

        return view('siswa.jadwal.index', compact('jadwals'));
    }

    public function jadwalShow($id)
    {
        $siswa = Auth::user()->siswa;
        $jadwal = $siswa->jadwalMateri()->findOrFail($id);

        return view('siswa.jadwal.show', compact('jadwal'));
    }

    // ============= MATERI =============
    public function materiIndex()
    {
        $siswa = Auth::user()->siswa;
        $materis = $siswa->jadwalMateri()
            ->materi()
            ->orderBy('awal', 'desc')
            ->get();

        return view('siswa.materi.index', compact('materis'));
    }

    public function materiShow($id)
    {
        $siswa = Auth::user()->siswa;
        $materi = $siswa->jadwalMateri()
            ->materi()
            ->findOrFail($id);

        return view('siswa.materi.show', compact('materi'));
    }

    public function materiDownload($id)
    {
        $siswa = Auth::user()->siswa;
        $materi = $siswa->jadwalMateri()
            ->materi()
            ->findOrFail($id);

        if (!$materi->file) {
            return back()->withErrors(['error' => 'File tidak tersedia']);
        }

        $filePath = storage_path('app/public/' . $materi->file);

        if (!file_exists($filePath)) {
            return back()->withErrors(['error' => 'File tidak ditemukan']);
        }

        return response()->download($filePath);
    }

    // ============= TUGAS =============
    public function tugasIndex()
    {
        $siswa = Auth::user()->siswa;
        $tugas = $siswa->jadwalMateri()
            ->tugas()
            ->orderBy('deadline', 'asc')
            ->get();

        return view('siswa.tugas.index', compact('tugas'));
    }

    public function tugasShow($id)
    {
        $siswa = Auth::user()->siswa;
        $tugas = $siswa->jadwalMateri()
            ->tugas()
            ->findOrFail($id);

        return view('siswa.tugas.show', compact('tugas'));
    }

    public function tugasDownload($id)
    {
        $siswa = Auth::user()->siswa;
        $tugas = $siswa->jadwalMateri()
            ->tugas()
            ->findOrFail($id);

        if (!$tugas->file) {
            return back()->withErrors(['error' => 'File tugas tidak tersedia']);
        }

        $filePath = storage_path('app/public/' . $tugas->file);

        if (!file_exists($filePath)) {
            return back()->withErrors(['error' => 'File tidak ditemukan']);
        }

        return response()->download($filePath);
    }

    public function tugasUpload(Request $request, $id)
    {
        $siswa = Auth::user()->siswa;
        $tugas = $siswa->jadwalMateri()
            ->tugas()
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            // Hapus file jawaban lama jika ada
            if ($tugas->file_jawaban && Storage::disk('public')->exists($tugas->file_jawaban)) {
                Storage::disk('public')->delete($tugas->file_jawaban);
            }

            // Upload file jawaban dengan format: submissions/[id]_[timestamp]_[originalname]
            $file = $request->file('file_jawaban');
            $originalName = $file->getClientOriginalName();
            $filename = $tugas->id_jadwal_materi . '_' . time() . '_' . $originalName;
            
            $file->storeAs('assignments/submissions/', $filename, 'public');
            $filePath = 'assignments/submissions/' . $filename;

            // Update deskripsi dengan catatan pengumpulan
            $catatanPengumpulan = "\n\n=== Catatan Pengumpulan ===\n";
            $catatanPengumpulan .= "Dikumpulkan pada: " . now()->format('d-m-Y H:i') . "\n";
            if ($request->catatan) {
                $catatanPengumpulan .= "Catatan: " . $request->catatan . "\n";
            }

            $tugas->update([
                'file_jawaban' => $filePath,
                'deskripsi' => ($tugas->deskripsi ?? '') . $catatanPengumpulan,
                'status' => $tugas->isOverdue() ? 'terlambat' : 'selesai',
            ]);

            // Buat notifikasi untuk admin
            Informasi::create([
                'id_pengguna' => auth()->id(),
                'judul' => 'Tugas Dikumpulkan',
                'isi' => 'Siswa ' . $siswa->nama_siswa . ' telah mengumpulkan tugas: ' . $tugas->judul,
                'jenis' => 'notifikasi',
            ]);

            return redirect()->route('siswa.tugas.show', $id)
                ->with('success', 'Tugas berhasil dikumpulkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // ============= NILAI =============
    public function nilaiIndex()
    {
        $siswa = Auth::user()->siswa;
        $nilais = $siswa->jadwalMateri()
            ->whereNotNull('nilai')
            ->orderBy('awal', 'desc')
            ->get();

        $stats = [
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2) ?? 0,
            'nilai_tertinggi' => $siswa->getNilaiTertinggi() ?? 0,
            'nilai_terendah' => $siswa->getNilaiTerendah() ?? 0,
            'total_tugas_dinilai' => $nilais->count(),
        ];

        return view('siswa.nilai.index', compact('nilais', 'stats'));
    }

    // ============= LAPORAN KEMAJUAN =============
    public function laporanKemajuan()
    {
        $siswa = Auth::user()->siswa;

        $stats = [
            'total_materi' => $siswa->getMateriCount(),
            'tugas_selesai' => $siswa->getTugasSelesai(),
            'tugas_pending' => $siswa->getTugasPending(),
            'tugas_terlambat' => $siswa->getTugasTerlambat(),
            'nilai_rata' => round($siswa->getNilaiRataRata(), 2) ?? 0,
            'nilai_tertinggi' => $siswa->getNilaiTertinggi() ?? 0,
            'nilai_terendah' => $siswa->getNilaiTerendah() ?? 0,
        ];

        // Data nilai per bulan untuk chart
        $nilaiPerBulan = $this->getNilaiPerBulan($siswa);

        // Tugas terbaru dengan nilai
        $tugasDinilai = $siswa->jadwalMateri()
            ->tugas()
            ->whereNotNull('nilai')
            ->orderBy('awal', 'desc')
            ->take(10)
            ->get();

        return view('siswa.laporan-kemajuan', compact('stats', 'nilaiPerBulan', 'tugasDinilai'));
    }

    private function getNilaiPerBulan($siswa)
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $nilai = $siswa->jadwalMateri()
                ->whereNotNull('nilai')
                ->whereYear('awal', $date->year)
                ->whereMonth('awal', $date->month)
                ->avg('nilai');
            
            $data[$date->format('M Y')] = round($nilai, 2) ?? 0;
        }
        return $data;
    }

    // ============= INFORMASI & PENGUMUMAN =============
    public function informasiIndex()
    {
        $siswa = Auth::user()->siswa;

        $informasis = Informasi::where(function($query) use ($siswa) {
            $query->whereNull('id_siswa')
                  ->orWhere('id_siswa', $siswa->id_siswa);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('siswa.informasi.index', compact('informasis'));
    }

    public function informasiShow($id)
    {
        $siswa = Auth::user()->siswa;

        $informasi = Informasi::where(function($query) use ($siswa) {
            $query->whereNull('id_siswa')
                  ->orWhere('id_siswa', $siswa->id_siswa);
        })
        ->findOrFail($id);

        return view('siswa.informasi.show', compact('informasi'));
    }

    // ============= PROFIL =============
    public function profile()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        return view('siswa.profile', compact('user', 'siswa'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $userData = [
                'name' => $request->nama_siswa,
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

            // Update nama siswa
            $siswa->update([
                'nama_siswa' => $request->nama_siswa,
            ]);

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}