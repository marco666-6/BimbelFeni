<!-- View: home/paket.blade.php -->
@extends('layouts.app')

@section('title', 'Paket Belajar')

@section('content')
<!-- Page Header -->
<div class="hero-section text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Paket Belajar</h1>
        <p class="lead">Pilih paket belajar yang sesuai dengan kebutuhan Anda</p>
    </div>
</div>

<!-- Info Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                    </div>
                    <h5 class="fw-bold">Materi Lengkap</h5>
                    <p class="text-muted small">Semua mata pelajaran sesuai kurikulum</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-person-check-fill text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Guru Berpengalaman</h5>
                    <p class="text-muted small">Tenaga pengajar profesional</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-graph-up text-warning"></i>
                    </div>
                    <h5 class="fw-bold">Monitoring Real-time</h5>
                    <p class="text-muted small">Pantau perkembangan siswa kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paket SD -->
@if($paketSD->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Paket Belajar SD</h2>
        <div class="row g-4 mt-4">
            @foreach($paketSD as $paket)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary mb-0">{{ $paket->harga_formatted }}</h2>
                            <small class="text-muted">/ {{ $paket->durasi_bulan }} bulan</small>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted">{{ $paket->deskripsi }}</p>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Semua mata pelajaran
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Materi lengkap
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Evaluasi berkala
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Laporan perkembangan
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Akses sistem SIDES
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-cart-plus"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Paket SMP -->
@if($paketSMP->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title">Paket Belajar SMP</h2>
        <div class="row g-4 mt-4">
            @foreach($paketSMP as $paket)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-success mb-0">{{ $paket->harga_formatted }}</h2>
                            <small class="text-muted">/ {{ $paket->durasi_bulan }} bulan</small>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted">{{ $paket->deskripsi }}</p>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Semua mata pelajaran
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Materi lengkap
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Evaluasi berkala
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Laporan perkembangan
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Akses sistem SIDES
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <a href="{{ route('login') }}" class="btn btn-success w-100 btn-lg">
                            <i class="bi bi-cart-plus"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Paket Kombo -->
@if($paketKombo->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Paket Kombo SD & SMP</h2>
        <div class="row g-4 mt-4 justify-content-center">
            @foreach($paketKombo as $paket)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg">
                    <div class="card-header bg-gradient text-white text-center py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <span class="badge bg-warning text-dark mb-2">TERPOPULER</span>
                        <h4 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-0" style="color: #667eea;">{{ $paket->harga_formatted }}</h2>
                            <small class="text-muted">/ {{ $paket->durasi_bulan }} bulan</small>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted">{{ $paket->deskripsi }}</p>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Untuk SD & SMP
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Semua mata pelajaran
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Materi lengkap
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Evaluasi berkala
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Laporan perkembangan
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success"></i> 
                                Akses sistem SIDES
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <a href="{{ route('login') }}" class="btn btn-lg w-100 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-cart-plus"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title">Keunggulan Bimbel Oriana Enilin</h2>
        <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="feature-icon me-3">
                        <i class="bi bi-award-fill text-warning"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Pengajar Berkualitas</h5>
                        <p class="text-muted">Tenaga pengajar berpengalaman dan kompeten di bidangnya</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="feature-icon me-3">
                        <i class="bi bi-laptop text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Sistem Digital</h5>
                        <p class="text-muted">Monitoring perkembangan siswa secara real-time melalui SIDES</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="feature-icon me-3">
                        <i class="bi bi-book-fill text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Materi Lengkap</h5>
                        <p class="text-muted">Materi pembelajaran sesuai kurikulum terbaru</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="feature-icon me-3">
                        <i class="bi bi-chat-dots-fill text-info"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Komunikasi Efektif</h5>
                        <p class="text-muted">Koordinasi yang baik antara guru, siswa, dan orang tua</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Siap Bergabung?</h2>
        <p class="lead mb-4">Login dan pilih paket belajar yang sesuai untuk anak Anda!</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
        </a>
    </div>
</section>
@endsection