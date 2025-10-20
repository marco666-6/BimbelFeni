@extends('layouts.app')

@section('title', 'Beranda - Bimbel Oriana Enilin')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Selamat Datang di Bimbel Oriana Enilin</h1>
        <p class="lead mb-4">Bimbingan belajar terpercaya untuk siswa SD dan SMP di Batam</p>
        <div class="d-flex justify-content-center gap-3">
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            @else
                @if(Auth::user()->role === 'orang_tua')
                    <a href="{{ route('orangtua.dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @elseif(Auth::user()->role === 'siswa')
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @endif
            @endguest
            <a href="{{ route('whatsapp') }}" class="btn btn-success btn-lg">
                <i class="fab fa-whatsapp"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Mengapa Memilih Kami?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-chalkboard-teacher fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Pengajar Berpengalaman</h5>
                    <p class="text-muted">Tenaga pengajar profesional dan berpengalaman dalam bidangnya</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-laptop fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Sistem Online Terintegrasi</h5>
                    <p class="text-muted">Monitoring perkembangan siswa secara real-time dan mudah diakses</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-info"></i>
                    </div>
                    <h5 class="fw-bold">Kelas Kecil</h5>
                    <p class="text-muted">Perhatian maksimal untuk setiap siswa dengan kelas kecil</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paket Belajar Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Paket Belajar Kami</h2>
        <div class="row g-4">
            @forelse($paketBelajar as $paket)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">{{ $paket->nama_paket }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($paket->deskripsi, 100) }}</p>
                            <div class="mb-3">
                                <h4 class="text-success fw-bold">{{ $paket->getFormattedHarga() }}</h4>
                                <small class="text-muted">Durasi: {{ $paket->durasi }} bulan</small>
                            </div>
                            @if($paket->komentar)
                                <p class="text-muted small"><em>{{ $paket->komentar }}</em></p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('paket.detail', $paket->id_paket) }}" class="btn btn-primary w-100">
                                <i class="fas fa-info-circle"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Belum ada paket belajar tersedia
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Pengumuman Section -->
@if($pengumuman->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Pengumuman Terbaru</h2>
        <div class="row g-4">
            @foreach($pengumuman as $info)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-bullhorn text-warning me-2"></i>
                                <small class="text-muted">{{ $info->created_at->diffForHumans() }}</small>
                            </div>
                            <h5 class="card-title fw-bold">{{ $info->judul }}</h5>
                            <p class="card-text">{{ Str::limit($info->isi, 120) }}</p>
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
        <p class="lead mb-4">Bergabunglah dengan Bimbel Oriana Enilin sekarang dan rasakan perbedaannya!</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endguest
    </div>
</section>
@endsection