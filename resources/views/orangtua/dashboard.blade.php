<!-- View: orangtua/dashboard.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Dashboard Orang Tua')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        border-radius: 20px !important;
        padding: 2rem;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.5s ease;
    }
    
    .stat-card:hover::before {
        top: -20%;
        right: -20%;
    }
    
    .stat-icon {
        font-size: 3rem;
        opacity: 0.9;
    }
    
    .child-card {
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
    }
    
    .child-card:hover {
        border-color: var(--primary-blue);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
    }
    
    .progress-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        position: relative;
    }
    
    .grade-badge {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .quick-action-card {
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border: 2px solid transparent;
    }
    
    .quick-action-card:hover {
        background: var(--gradient-primary);
        border-color: var(--primary-blue);
        transform: translateY(-5px);
    }
    
    .quick-action-card:hover * {
        color: white !important;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        padding-bottom: 1.5rem;
        border-left: 2px solid #e2e8f0;
    }
    
    .timeline-item:last-child {
        border-left-color: transparent;
    }
    
    .timeline-dot {
        position: absolute;
        left: -6px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-blue);
    }
    
    .announcement-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .announcement-card:hover {
        border-left-color: var(--primary-blue);
        background: #f8fafc;
        transform: translateX(5px);
    }
</style>
@endpush

@section('content')
<!-- Welcome Section -->
<div class="row mb-4 animate-fade-in">
    <div class="col-12">
        <div class="card welcome-card border-0 text-white">
            <div class="card-body" style="position: relative; z-index: 2;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">👋 Selamat Datang, {{ $orangTua->nama_lengkap }}!</h2>
                        <p class="mb-3 opacity-90">Pantau perkembangan belajar anak Anda dengan mudah dan efektif</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-white text-primary px-3 py-2">
                                <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                            <span class="badge bg-white text-primary px-3 py-2">
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <i class="bi bi-person-hearts" style="font-size: 6rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card text-white border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 opacity-90">Total Anak Terdaftar</p>
                        <h2 class="mb-0 fw-bold">{{ $totalAnak }}</h2>
                        <small class="opacity-75">Siswa aktif</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card text-white border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 opacity-90">Transaksi Pending</p>
                        <h2 class="mb-0 fw-bold">{{ $transaksiPending }}</h2>
                        <small class="opacity-75">Menunggu verifikasi</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card text-white border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 opacity-90">Feedback Belum Dibalas</p>
                        <h2 class="mb-0 fw-bold">{{ $feedbackBelumDibalas }}</h2>
                        <small class="opacity-75">Menunggu respons</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-chat-left-text-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stat-card text-white border-0" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 opacity-90">Status Siswa</p>
                        <h2 class="mb-0 fw-bold">{{ $siswa->where('user.status', 'aktif')->count() }}/{{ $totalAnak }}</h2>
                        <small class="opacity-75">Siswa aktif</small>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3"><i class="bi bi-lightning-charge-fill text-warning"></i> Aksi Cepat</h5>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('orangtua.paket-belajar') }}" class="text-decoration-none">
            <div class="card quick-action-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-box-seam-fill text-primary" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1 text-dark">Beli Paket Belajar</h6>
                    <small class="text-muted">Pilih paket terbaik</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('orangtua.transaksi') }}" class="text-decoration-none">
            <div class="card quick-action-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-credit-card-fill text-success" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1 text-dark">Riwayat Transaksi</h6>
                    <small class="text-muted">Lihat pembayaran</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('orangtua.feedback') }}" class="text-decoration-none">
            <div class="card quick-action-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-chat-heart-fill text-info" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1 text-dark">Kirim Feedback</h6>
                    <small class="text-muted">Sampaikan masukan</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('orangtua.anak') }}" class="text-decoration-none">
            <div class="card quick-action-card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-graph-up-arrow text-warning" style="font-size: 2.5rem;"></i>
                    <h6 class="mt-3 mb-1 text-dark">Monitor Progress</h6>
                    <small class="text-muted">Pantau perkembangan</small>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Data Anak -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> Perkembangan Anak Anda</h5>
                <a href="{{ route('orangtua.anak') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-right-circle"></i> Lihat Detail
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    @forelse($siswa as $s)
                    <div class="col-lg-6 mb-4">
                        <div class="card child-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <img src="{{ $s->user->foto_profil_url }}" alt="Foto" class="rounded-circle me-3" width="70" height="70" style="border: 3px solid var(--primary-blue);">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $s->nama_lengkap }}</h5>
                                        <div class="mb-2">
                                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">{{ $s->jenjang }}</span>
                                            <span class="badge bg-secondary">Kelas {{ $s->kelas }}</span>
                                            <span class="badge bg-info">{{ $s->usia }} tahun</span>
                                        </div>
                                        <a href="{{ route('orangtua.anak.detail', $s->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <!-- Kehadiran -->
                                    <div class="col-6">
                                        <div class="text-center p-3 rounded" style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
                                            <div class="progress-circle mx-auto mb-2" style="background: rgba(255, 255, 255, 0.5);">
                                                <span class="text-success">{{ number_format($s->persentase_kehadiran, 0) }}%</span>
                                            </div>
                                            <small class="d-block fw-bold text-dark">Kehadiran</small>
                                            <small class="text-muted">{{ $s->kehadiran()->hadir()->count() }}/{{ $s->kehadiran()->count() }} hadir</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Nilai -->
                                    <div class="col-6">
                                        <div class="text-center p-3 rounded" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                                            <div class="grade-badge mx-auto mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                @php
                                                    $nilai = $s->rata_nilai;
                                                    $grade = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : ($nilai >= 60 ? 'D' : 'E')));
                                                @endphp
                                                {{ $grade }}
                                            </div>
                                            <small class="d-block fw-bold text-dark">Rata-rata Nilai</small>
                                            <small class="text-muted">{{ number_format($s->rata_nilai, 1) }}/100</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Tugas -->
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-check-fill text-success me-2" style="font-size: 1.8rem;"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ $s->total_tugas_terkumpul }}</h6>
                                                    <small class="text-muted">Tugas Selesai</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tugas Tertunda -->
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-hourglass-split text-warning me-2" style="font-size: 1.8rem;"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ $s->tugas_tertunda }}</h6>
                                                    <small class="text-muted">Tugas Tertunda</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="row g-2 mt-2">
                                    <div class="col-6">
                                        <a href="{{ route('orangtua.anak.jadwal', $s->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="bi bi-calendar-week"></i> Jadwal
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('orangtua.anak.rapor', $s->id) }}" class="btn btn-outline-success btn-sm w-100">
                                            <i class="bi bi-file-earmark-text"></i> Rapor
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-3">Belum ada data anak terdaftar</p>
                        <a href="{{ route('orangtua.paket-belajar') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Daftarkan Anak
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pengumuman & Aktivitas -->
<div class="row">
    <!-- Pengumuman Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0">
            <div class="card-header bg-gradient text-dark d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h5 class="mb-0"><i class="bi bi-megaphone-fill"></i> Pengumuman Terbaru</h5>
                <a href="{{ route('orangtua.pengumuman') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-right-circle"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @forelse($pengumuman as $p)
                <div class="announcement-card p-3 mb-3 rounded">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0 fw-bold">{{ $p->judul }}</h6>
                        <span class="badge bg-{{ $p->target_badge_color }}">{{ $p->target_label }}</span>
                    </div>
                    <p class="text-muted mb-2 small">{{ Str::limit(strip_tags($p->isi), 120) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> {{ $p->tanggal_publikasi_formatted }}
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ $p->creator->username ?? 'Admin' }}
                        </small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-megaphone" style="font-size: 3rem; color: #cbd5e1;"></i>
                    <p class="text-muted mt-2">Belum ada pengumuman terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Aktivitas Terkini -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0">
            <div class="card-header bg-gradient text-dark" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h5 class="mb-0"><i class="bi bi-activity"></i> Info Penting</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @if($transaksiPending > 0)
                    <div class="timeline-item">
                        <div class="timeline-dot bg-warning"></div>
                        <div>
                            <small class="text-muted">Transaksi</small>
                            <p class="mb-1 fw-bold">{{ $transaksiPending }} transaksi pending</p>
                            <a href="{{ route('orangtua.transaksi') }}" class="small text-primary">Lihat detail →</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($feedbackBelumDibalas > 0)
                    <div class="timeline-item">
                        <div class="timeline-dot bg-info"></div>
                        <div>
                            <small class="text-muted">Feedback</small>
                            <p class="mb-1 fw-bold">{{ $feedbackBelumDibalas }} feedback menunggu balasan</p>
                            <a href="{{ route('orangtua.feedback') }}" class="small text-primary">Lihat detail →</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($totalAnak > 0)
                    <div class="timeline-item">
                        <div class="timeline-dot bg-success"></div>
                        <div>
                            <small class="text-muted">Siswa</small>
                            <p class="mb-1 fw-bold">{{ $totalAnak }} anak terdaftar</p>
                            <a href="{{ route('orangtua.anak') }}" class="small text-primary">Monitor progress →</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($transaksiPending === 0 && $feedbackBelumDibalas === 0 && $totalAnak === 0)
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle" style="font-size: 3rem; color: #10b981;"></i>
                        <p class="text-muted mt-2">Semua berjalan lancar!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="card border-0 mt-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white text-center">
                <i class="bi bi-headset" style="font-size: 2.5rem;"></i>
                <h6 class="mt-3 mb-2">Butuh Bantuan?</h6>
                <p class="small mb-3 opacity-90">Tim kami siap membantu Anda</p>
                <a href="{{ route('orangtua.feedback') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-chat-dots"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Animate statistics on page load
    $('.stat-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate-fade-in');
    });
    
    // Animate child cards
    $('.child-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.15) + 's');
        $(this).addClass('animate-fade-in');
    });
});
</script>
@endpush