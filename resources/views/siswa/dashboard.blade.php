<!-- View: siswa/dashboard.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="row">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ $siswa->user->foto_profil_url }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-circle me-3" width="80" height="80" style="border: 3px solid white;">
                    <div>
                        <h3 class="mb-1">Selamat Datang, {{ $siswa->nama_lengkap }}!</h3>
                        <p class="mb-0">{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-book fs-1 text-primary"></i>
                </div>
                <h3 class="mb-0">{{ $totalMateri }}</h3>
                <p class="text-muted mb-0">Total Materi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                </div>
                <h3 class="mb-0">{{ $totalTugasTerkumpul }}</h3>
                <p class="text-muted mb-0">Tugas Terkumpul</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                </div>
                <h3 class="mb-0">{{ $tugasTertunda }}</h3>
                <p class="text-muted mb-0">Tugas Tertunda</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-award fs-1 text-info"></i>
                </div>
                <h3 class="mb-0">{{ number_format($rataNilai, 1) }}</h3>
                <p class="text-muted mb-0">Rata-rata Nilai</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Hari Ini -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar-week text-primary"></i> Jadwal Hari Ini</h5>
            </div>
            <div class="card-body">
                @if($jadwalHariIni->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada jadwal untuk hari ini
                    </div>
                @else
                    <div class="list-group">
                        @foreach($jadwalHariIni as $j)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $j->mata_pelajaran }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $j->nama_guru }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">{{ $j->jam_formatted }}</span>
                                    @if($j->ruangan)
                                    <br><small class="text-muted">{{ $j->ruangan }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tugas Mendatang -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clipboard-check text-warning"></i> Tugas Mendatang</h5>
            </div>
            <div class="card-body">
                @if($tugasMendatang->isEmpty())
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Semua tugas sudah dikumpulkan!
                    </div>
                @else
                    <div class="list-group">
                        @foreach($tugasMendatang as $t)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $t->judul }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-book"></i> {{ $t->mata_pelajaran }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    @if($t->deadline)
                                    <small class="text-danger">
                                        <i class="bi bi-clock"></i> {{ $t->sisa_waktu_deadline }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('siswa.materi-tugas') }}" class="btn btn-sm btn-outline-primary w-100">
                        Lihat Semua Tugas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pengumuman Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-megaphone text-info"></i> Pengumuman Terbaru</h5>
            </div>
            <div class="card-body">
                @if($pengumuman->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Belum ada pengumuman
                    </div>
                @else
                    @foreach($pengumuman as $p)
                    <div class="card mb-2 border-start border-4 border-info">
                        <div class="card-body">
                            <h6 class="mb-1">{{ $p->judul }}</h6>
                            <p class="mb-1 text-muted small">{{ Str::limit($p->isi, 100) }}</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $p->tanggal_publikasi_formatted }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('siswa.pengumuman') }}" class="btn btn-sm btn-outline-info w-100 mt-2">
                        Lihat Semua Pengumuman
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection