<!-- View: orangtua/dashboard.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Dashboard Orang Tua')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <h4 class="text-dark">Selamat Datang, {{ $orangTua->nama_lengkap }}! 👋</h4>
                <p class="mb-0 text-dark">Pantau perkembangan belajar anak Anda dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Anak</h6>
                        <h2 class="mb-0">{{ $totalAnak }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Transaksi Pending</h6>
                        <h2 class="mb-0">{{ $transaksiPending }}</h2>
                    </div>
                    <i class="bi bi-clock-history fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Feedback Belum Dibalas</h6>
                        <h2 class="mb-0">{{ $feedbackBelumDibalas }}</h2>
                    </div>
                    <i class="bi bi-chat-left-text fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Siswa Aktif</h6>
                        <h2 class="mb-0">{{ $siswa->where('user.status', 'aktif')->count() }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Anak -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people"></i> Data Anak</h5>
                <a href="{{ route('orangtua.anak') }}" class="btn btn-light btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($siswa as $s)
                    <div class="col-md-6 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img src="{{ $s->user->foto_profil_url }}" alt="Foto" class="rounded-circle me-3" width="60" height="60">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $s->nama_lengkap }}</h6>
                                        <p class="text-muted mb-2 small">
                                            <span class="badge bg-info">{{ $s->jenjang }}</span>
                                            <span class="badge bg-secondary">{{ $s->kelas }}</span>
                                        </p>
                                        <div class="row g-4 mb-2">
                                            <div class="col-6">
                                                <small class="text-muted">Kehadiran</small>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $s->persentase_kehadiran }}%">
                                                        {{ $s->persentase_kehadiran }}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Rata-rata Nilai</small>
                                                <div class="fs-5 fw-bold text-primary">{{ number_format($s->rata_nilai, 1) }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('orangtua.anak.detail', $s->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada data anak terdaftar</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pengumuman Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-megaphone"></i> Pengumuman Terbaru</h5>
                <a href="{{ route('orangtua.pengumuman') }}" class="btn btn-light btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($pengumuman as $p)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0">{{ $p->judul }}</h6>
                        <small class="text-muted">{{ $p->tanggal_publikasi_formatted }}</small>
                    </div>
                    <p class="text-muted mb-2">{{ Str::limit($p->isi, 150) }}</p>
                    <span class="badge bg-{{ $p->target_badge_color }}">{{ $p->target_label }}</span>
                </div>
                @empty
                <p class="text-center text-muted mb-0">Belum ada pengumuman</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection