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
                        @if($hasActiveSubscription && $subscriptionEndDate)
                            <small class="badge bg-light text-dark mt-2">
                                <i class="bi bi-calendar-check"></i> Aktif hingga: {{ $subscriptionEndDate->format('d M Y') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subscription Alerts -->
@if(!$hasActiveSubscription)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">⚠️ Tidak Ada Paket Aktif</h5>
                        <p class="mb-2">Anda tidak memiliki paket belajar yang aktif. Fitur-fitur pembelajaran telah dikunci.</p>
                        <p class="mb-0 small">Silakan hubungi orang tua Anda untuk melakukan pembayaran dan aktivasi paket belajar.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@elseif($showWarning)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-3 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">ℹ️ Langganan Akan Berakhir</h5>
                        <p class="mb-2">Paket belajar Anda akan berakhir dalam <strong>{{ $remainingDays }} hari</strong> ({{ $subscriptionEndDate->format('d M Y') }}).</p>
                        <p class="mb-0 small">Silakan ingatkan orang tua untuk melakukan perpanjangan agar pembelajaran tidak terganggu.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<!-- Statistik Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm {{ !$hasActiveSubscription ? 'opacity-50' : '' }}">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-book fs-1 text-primary"></i>
                    @if(!$hasActiveSubscription)
                        <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-muted"></i>
                    @endif
                </div>
                <h3 class="mb-0">{{ $totalMateri }}</h3>
                <p class="text-muted mb-0">Total Materi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm {{ !$hasActiveSubscription ? 'opacity-50' : '' }}">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    @if(!$hasActiveSubscription)
                        <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-muted"></i>
                    @endif
                </div>
                <h3 class="mb-0">{{ $totalTugasTerkumpul }}</h3>
                <p class="text-muted mb-0">Tugas Terkumpul</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm {{ !$hasActiveSubscription ? 'opacity-50' : '' }}">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                    @if(!$hasActiveSubscription)
                        <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-muted"></i>
                    @endif
                </div>
                <h3 class="mb-0">{{ $tugasTertunda }}</h3>
                <p class="text-muted mb-0">Tugas Tertunda</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card border-0 shadow-sm {{ !$hasActiveSubscription ? 'opacity-50' : '' }}">
            <div class="card-body text-center">
                <div class="mb-2">
                    <i class="bi bi-award fs-1 text-info"></i>
                    @if(!$hasActiveSubscription)
                        <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-muted"></i>
                    @endif
                </div>
                <h3 class="mb-0">{{ number_format($rataNilai, 1) }}</h3>
                <p class="text-muted mb-0">Rata-rata Nilai</p>
            </div>
        </div>
    </div>
</div>

@if($hasActiveSubscription)
    <!-- Content when subscription is active -->
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

@else
    <!-- Content when NO active subscription -->
    <div class="row">
        <!-- Locked Jadwal Hari Ini -->
        <div class="col-md-6 mb-4">
            <div class="card border-warning">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-muted">
                        <i class="bi bi-calendar-week"></i> Jadwal Hari Ini
                        <i class="bi bi-lock-fill float-end"></i>
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="bi bi-lock fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Konten Terkunci</h5>
                    <p class="text-muted small mb-0">Aktifkan paket belajar untuk melihat jadwal</p>
                </div>
            </div>
        </div>

        <!-- Locked Tugas Mendatang -->
        <div class="col-md-6 mb-4">
            <div class="card border-warning">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-muted">
                        <i class="bi bi-clipboard-check"></i> Tugas Mendatang
                        <i class="bi bi-lock-fill float-end"></i>
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="bi bi-lock fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">Konten Terkunci</h5>
                    <p class="text-muted small mb-0">Aktifkan paket belajar untuk melihat tugas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-body text-center py-5">
                    <i class="bi bi-bag-check fs-1 text-primary mb-3"></i>
                    <h4 class="mb-3">Aktifkan Paket Belajar Anda</h4>
                    <p class="text-muted mb-4">Untuk mengakses materi, tugas, jadwal, dan fitur pembelajaran lainnya, silakan minta orang tua Anda untuk melakukan pembayaran paket belajar.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('siswa.profile') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person"></i> Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .opacity-50 {
        opacity: 0.5;
        filter: grayscale(50%);
    }
    
    .card.border-warning {
        border-width: 2px !important;
    }
    
    .card.border-primary {
        border-width: 2px !important;
    }
</style>
@endpush