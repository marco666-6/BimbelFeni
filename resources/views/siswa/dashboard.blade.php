@extends('layouts.ortusiswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard Siswa</h2>
    <span class="text-muted">Selamat datang, {{ Auth::user()->name }}!</span>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Materi</div>
                        <h3 class="mb-0">{{ $stats['total_materi'] }}</h3>
                    </div>
                    <i class="fas fa-book fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tugas Selesai</div>
                        <h3 class="mb-0">{{ $stats['tugas_selesai'] }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tugas Pending</div>
                        <h3 class="mb-0">{{ $stats['tugas_pending'] }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Nilai Rata-rata</div>
                        <h3 class="mb-0">{{ $stats['nilai_rata'] }}</h3>
                    </div>
                    <i class="fas fa-star fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Terdekat -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-alt"></i> Jadwal Terdekat</span>
                <a href="{{ route('siswa.jadwal.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($jadwalTerdekat as $jadwal)
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $jadwal->judul }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> {{ $jadwal->awal->format('d M Y, H:i') }}
                            </small>
                            @if($jadwal->durasi)
                                <small class="text-muted ms-2">
                                    <i class="fas fa-hourglass-half"></i> {{ $jadwal->getDurasiFormatted() }}
                                </small>
                            @endif
                        </div>
                        <span class="badge bg-{{ $jadwal->jenis === 'materi' ? 'primary' : 'warning' }}">
                            {{ ucfirst($jadwal->jenis) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                        <p>Tidak ada jadwal terdekat</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tugas Pending -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-tasks"></i> Tugas Pending</span>
                <a href="{{ route('siswa.tugas.index') }}" class="btn btn-sm btn-warning">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($tugasPending as $tugas)
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $tugas->judul }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> Deadline: {{ $tugas->getDeadlineFormatted() }}
                            </small>
                            @if($tugas->getHariTersisaUntilDeadline() !== null)
                                <br>
                                <small class="text-{{ $tugas->getHariTersisaUntilDeadline() < 2 ? 'danger' : 'warning' }}">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    @if($tugas->getHariTersisaUntilDeadline() < 0)
                                        Terlambat {{ abs($tugas->getHariTersisaUntilDeadline()) }} hari
                                    @else
                                        {{ $tugas->getHariTersisaUntilDeadline() }} hari lagi
                                    @endif
                                </small>
                            @endif
                        </div>
                        <a href="{{ route('siswa.tugas.show', $tugas->id_jadwal_materi) }}" class="btn btn-sm btn-outline-primary">
                            Kerjakan
                        </a>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <p>Tidak ada tugas pending</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Pengumuman Terbaru -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bullhorn"></i> Pengumuman Terbaru</span>
        <a href="{{ route('siswa.informasi.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @forelse($pengumuman as $info)
            <div class="mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $info->judul }}</h6>
                        <p class="mb-1 text-muted">{{ Str::limit($info->isi, 150) }}</p>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> {{ $info->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <span class="badge bg-{{ $info->jenis === 'pengumuman' ? 'info' : 'warning' }}">
                        {{ ucfirst($info->jenis) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-3">
                <i class="fas fa-inbox fa-2x mb-2"></i>
                <p>Tidak ada pengumuman</p>
            </div>
        @endforelse
    </div>
</div>
@endsection