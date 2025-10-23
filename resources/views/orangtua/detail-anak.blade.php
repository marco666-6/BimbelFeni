<!-- View: orangtua/detail-anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Detail Perkembangan')
@section('page-title', 'Perkembangan - ' . $siswa->nama_lengkap)

@section('content')
<!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('orangtua.anak') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Profile Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $siswa->user->foto_profil_url }}" alt="Foto" class="rounded-circle mb-3" width="120" height="120">
                <h5>{{ $siswa->nama_lengkap }}</h5>
                <p class="text-muted mb-1">{{ $siswa->jenjang }} - {{ $siswa->kelas }}</p>
                <p class="text-muted mb-2">{{ $siswa->user->email }}</p>
                <span class="badge bg-{{ $siswa->user->isAktif() ? 'success' : 'danger' }}">
                    {{ $siswa->user->status }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h6><i class="bi bi-clipboard-check"></i> Persentase Kehadiran</h6>
                        <h2>{{ $persentaseHadir }}%</h2>
                        <small>Hadir dari total pertemuan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h6><i class="bi bi-award"></i> Rata-rata Nilai</h6>
                        <h2>{{ number_format($rataNilai, 1) }}</h2>
                        <small>Nilai tugas yang dikumpulkan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h6><i class="bi bi-file-earmark-check"></i> Total Tugas</h6>
                        <h2>{{ $totalTugas }}</h2>
                        <small>Tugas yang sudah dikumpulkan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h6><i class="bi bi-exclamation-triangle"></i> Tugas Tertunda</h6>
                        <h2>{{ $tugasTertunda }}</h2>
                        <small>Tugas yang belum dikumpulkan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-3" id="detailTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#kehadiran">
            <i class="bi bi-clipboard-check"></i> Kehadiran Terbaru
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nilai">
            <i class="bi bi-award"></i> Nilai Tugas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#feedback">
            <i class="bi bi-chat-left-text"></i> Feedback
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- Kehadiran -->
    <div class="tab-pane fade show active" id="kehadiran">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Kehadiran Terbaru (10 Pertemuan Terakhir)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->kehadiran()->latest('tanggal_pertemuan')->take(10)->get() as $k)
                            <tr>
                                <td>{{ $k->tanggal_pertemuan->format('d/m/Y') }}</td>
                                <td>{{ $k->jadwal->mata_pelajaran }}</td>
                                <td>{{ $k->jadwal->nama_guru }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->status_badge_color }}">
                                        {{ $k->status_label }}
                                    </span>
                                </td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data kehadiran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai -->
    <div class="tab-pane fade" id="nilai">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Nilai Tugas Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul Tugas</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Grade</th>
                                <th>Feedback Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->pengumpulanTugas()->whereNotNull('nilai')->latest('tanggal_pengumpulan')->take(10)->get() as $pt)
                            <tr>
                                <td>{{ $pt->tanggal_pengumpulan->format('d/m/Y') }}</td>
                                <td>{{ $pt->materiTugas->judul }}</td>
                                <td>{{ $pt->materiTugas->mata_pelajaran }}</td>
                                <td>
                                    <span class="badge bg-{{ $pt->status_badge_color }} fs-6">
                                        {{ $pt->nilai }}
                                    </span>
                                </td>
                                <td><span class="badge bg-info">{{ $pt->grade_label }}</span></td>
                                <td>{{ Str::limit($pt->feedback_guru, 50) ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada nilai</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback -->
    <div class="tab-pane fade" id="feedback">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">Riwayat Feedback</h6>
            </div>
            <div class="card-body">
                @forelse($siswa->feedback()->latest()->get() as $f)
                <div class="card mb-3 border-{{ $f->isBaru() ? 'warning' : 'success' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>{{ $f->tanggal_feedback_formatted }}</strong>
                            <span class="badge bg-{{ $f->status_badge_color }}">{{ $f->status_label }}</span>
                        </div>
                        <p class="mb-2"><strong>Feedback Saya:</strong><br>{{ $f->isi_feedback }}</p>
                        @if($f->balasan_admin)
                        <div class="alert alert-success mb-0">
                            <strong><i class="bi bi-reply"></i> Balasan Admin:</strong><br>
                            {{ $f->balasan_admin }}
                        </div>
                        @else
                        <small class="text-muted"><i class="bi bi-clock"></i> Menunggu balasan dari admin</small>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-muted">Belum ada feedback</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-md-4">
        <a href="{{ route('orangtua.anak.jadwal', $siswa->id) }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-calendar-week"></i> Lihat Jadwal Lengkap
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('orangtua.anak.rapor', $siswa->id) }}" class="btn btn-outline-success w-100">
            <i class="bi bi-file-earmark-text"></i> Lihat Rapor
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('orangtua.anak.log-activity', $siswa->id) }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-activity"></i> Log Aktivitas
        </a>
    </div>
</div>
@endsection