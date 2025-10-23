<!-- View: home/index.blade.php -->
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">
            Selamat Datang di Bimbel Oriana Enilin
        </h1>
        <p class="lead mb-5 animate__animated animate__fadeInUp">
            Lembaga bimbingan belajar terpercaya untuk siswa SD dan SMP di Batam
        </p>
        <div class="animate__animated animate__fadeInUp animate__delay-1s">
            <a href="{{ route('paket') }}" class="btn btn-light btn-lg px-5 py-3 me-3">
                <i class="bi bi-book"></i> Lihat Paket Belajar
            </a>
            <a href="{{ route('kontak') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                <i class="bi bi-telephone"></i> Hubungi Kami
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Mengapa Memilih Kami?</h2>
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h4 class="fw-bold">Pengajar Berpengalaman</h4>
                    <p class="text-muted">Tenaga pengajar profesional dan berpengalaman dalam bidangnya</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h4 class="fw-bold">Sistem Digital Terintegrasi</h4>
                    <p class="text-muted">Monitoring perkembangan siswa secara real-time melalui sistem SIDES</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4 class="fw-bold">Hasil Terbukti</h4>
                    <p class="text-muted">Metode pembelajaran yang terbukti efektif meningkatkan prestasi siswa</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paket Belajar Section -->
@if($paketBelajar->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title">Paket Belajar Kami</h2>
        <div class="row g-4 mt-4">
            @foreach($paketBelajar->take(3) as $paket)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-bold mb-0">{{ $paket->nama_paket }}</h5>
                            <span class="badge bg-primary">{{ $paket->jenjang }}</span>
                        </div>
                        <p class="text-muted">{{ Str::limit($paket->deskripsi, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <h4 class="text-primary mb-0">{{ $paket->harga_formatted }}</h4>
                                <small class="text-muted">/ {{ $paket->durasi_bulan }} bulan</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('paket') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-info-circle"></i> Detail Paket
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('paket') }}" class="btn btn-primary btn-lg px-5">
                Lihat Semua Paket <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Pengumuman Section -->
@if($pengumuman->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Pengumuman Terbaru</h2>
        <div class="row g-4 mt-4">
            @foreach($pengumuman as $item)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title fw-bold">
                                    <i class="bi bi-megaphone text-primary"></i> {{ $item->judul }}
                                </h5>
                                <p class="text-muted mb-2">{{ Str::limit($item->isi, 200) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $item->tanggal_publikasi_formatted }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $item->target_badge_color }}">{{ $item->target_label }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Siap Meningkatkan Prestasi Belajar?</h2>
        <p class="lead mb-4">Bergabunglah dengan Bimbel Oriana Enilin dan rasakan perbedaannya!</p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-person-plus"></i> Daftar Sekarang
        </a>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush