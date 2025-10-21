{{-- resources/views/admin/jadwal/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Jadwal/Materi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jadwal/Materi</h1>
    <div>
        <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal_materi) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi {{ $jadwal->jenis == 'materi' ? 'Materi' : 'Tugas' }}</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Judul</th>
                        <td><strong>{{ $jadwal->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>
                            @if($jadwal->jenis == 'materi')
                                <span class="badge bg-info">Materi</span>
                            @else
                                <span class="badge bg-warning text-dark">Tugas</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Siswa</th>
                        <td>{{ $jadwal->siswa->nama_siswa }} ({{ $jadwal->siswa->jenjang }} - {{ $jadwal->siswa->kelas }})</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
                    </tr>
                    @if($jadwal->deadline)
                    <tr>
                        <th>Deadline</th>
                        <td>{{ $jadwal->getDeadlineFormatted() }}</td>
                    </tr>
                    @endif
                    @if($jadwal->durasi)
                    <tr>
                        <th>Durasi</th>
                        <td>{{ $jadwal->getDurasiFormatted() }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($jadwal->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                    @if($jadwal->deskripsi)
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $jadwal->deskripsi }}</td>
                    </tr>
                    @endif
                    @if($jadwal->file)
                    <tr>
                        <th>File</th>
                        <td>
                            <a href="{{ Storage::url($jadwal->file) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- File Jawaban Siswa --}}
        @if($jadwal->jenis == 'tugas')
            @php
                // Cek apakah ada file submission
                $submissionPath = 'assignments/submissions/' . $jadwal->id_jadwal_materi . '_';
                $submissionFiles = \Illuminate\Support\Facades\Storage::disk('public')->files('assignments/submissions');
                $studentSubmission = null;
                foreach($submissionFiles as $file) {
                    if(str_contains($file, $submissionPath)) {
                        $studentSubmission = $file;
                        break;
                    }
                }
            @endphp

            @if($studentSubmission)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <strong><i class="fas fa-file-upload"></i> File Jawaban Siswa</strong>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Siswa telah mengumpulkan tugas
                    </div>
                    <a href="{{ Storage::url($studentSubmission) }}" target="_blank" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-download"></i> Download Jawaban Siswa
                    </a>
                    <small class="text-muted d-block">
                        File: {{ basename($studentSubmission) }}
                    </small>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <strong><i class="fas fa-exclamation-triangle"></i> Belum Dikumpulkan</strong>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mb-0">
                        Siswa belum mengumpulkan tugas ini.
                    </div>
                </div>
            </div>
            @endif
        @endif

        {{-- Form Input Nilai --}}
        @if($jadwal->jenis == 'tugas' && !$jadwal->nilai)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong><i class="fas fa-star"></i> Input Nilai</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal.nilai', $jadwal->id_jadwal_materi) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar Penilaian</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3" placeholder="Berikan komentar untuk siswa..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check"></i> Simpan Nilai
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Nilai yang sudah diberikan --}}
        @if($jadwal->nilai)
        <div class="card">
            <div class="card-header bg-success text-white">
                <strong><i class="fas fa-check-circle"></i> Nilai</strong>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-success mb-3">{{ $jadwal->nilai }}</h1>
                <p class="mb-2"><strong>Tugas telah dinilai</strong></p>
                
                {{-- Tampilkan komentar jika ada --}}
                @if($jadwal->deskripsi && str_contains($jadwal->deskripsi, 'Komentar Guru:'))
                    @php
                        $komentarSection = explode('Komentar Guru:', $jadwal->deskripsi);
                        if(count($komentarSection) > 1) {
                            $komentar = trim($komentarSection[1]);
                        }
                    @endphp
                    @if(isset($komentar) && $komentar)
                    <div class="alert alert-light mt-3 text-start">
                        <small class="text-muted d-block mb-1"><strong>Komentar Guru:</strong></small>
                        <small>{{ $komentar }}</small>
                    </div>
                    @endif
                @endif
                
                <form action="{{ route('admin.jadwal.nilai', $jadwal->id_jadwal_materi) }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="reset_nilai" value="1">
                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yakin ingin mengubah nilai?')">
                        <i class="fas fa-edit"></i> Edit Nilai
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection