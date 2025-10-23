<!-- View: home/tentang.blade.php -->
@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<!-- Page Header -->
<div class="hero-section text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Tentang Kami</h1>
        <p class="lead">Mengenal lebih dekat Bimbel Oriana Enilin</p>
    </div>
</div>

<!-- About Content -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="{{ asset('images/about-illustration.svg') }}" alt="About" class="img-fluid" 
                     onerror="this.src='{{ asset('images/no-image.png') }}'">
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold mb-4">Bimbel Oriana Enilin</h2>
                <p class="text-muted">
                    {!! nl2br(e($settings->tentang ?? 'Bimbel Oriana Enilin merupakan lembaga bimbingan belajar yang berada di kota Batam, Kepulauan Riau, yang telah beroperasi selama 5 tahun dengan puluhan siswa aktif dan beberapa tenaga pengajar berpengalaman.')) !!}
                </p>
                <p class="text-muted">
                    Kami menyediakan program pembelajaran untuk siswa SD dan SMP dengan bimbingan untuk semua mata pelajaran sesuai kurikulum yang berlaku. Dengan sistem SIDES (Student Information and Development Evaluation System), kami memberikan layanan monitoring perkembangan siswa secara real-time.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Visi Kami</h3>
                        <p class="text-muted">
                            Menjadi lembaga bimbingan belajar terdepan yang mengintegrasikan teknologi digital untuk memberikan layanan pendidikan berkualitas dan meningkatkan prestasi siswa secara optimal.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Misi Kami</h3>
                        <ul class="text-muted">
                            <li class="mb-2">Memberikan pembelajaran berkualitas dengan tenaga pengajar berpengalaman</li>
                            <li class="mb-2">Mengintegrasikan teknologi untuk monitoring perkembangan siswa</li>
                            <li class="mb-2">Membangun komunikasi efektif antara guru, siswa, dan orang tua</li>
                            <li>Meningkatkan prestasi akademik siswa secara konsisten</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Nilai-Nilai Kami</h2>
        <div class="row g-4 mt-4">
            <div class="col-md-3">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Kualitas</h5>
                        <p class="text-muted small">Memberikan layanan pendidikan terbaik</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-heart-fill text-danger"></i>
                        </div>
                        <h5 class="fw-bold">Kepedulian</h5>
                        <p class="text-muted small">Peduli terhadap perkembangan setiap siswa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Inovasi</h5>
                        <p class="text-muted small">Menggunakan teknologi untuk efisiensi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-shield-check text-success"></i>
                        </div>
                        <h5 class="fw-bold">Integritas</h5>
                        <p class="text-muted small">Berkomitmen pada transparansi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="bi bi-clock-history" style="font-size: 3rem;"></i>
                </div>
                <h2 class="fw-bold">5+</h2>
                <p>Tahun Berpengalaman</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                </div>
                <h2 class="fw-bold">100+</h2>
                <p>Siswa Aktif</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="bi bi-person-badge" style="font-size: 3rem;"></i>
                </div>
                <h2 class="fw-bold">10+</h2>
                <p>Tenaga Pengajar</p>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="bi bi-trophy-fill" style="font-size: 3rem;"></i>
                </div>
                <h2 class="fw-bold">95%</h2>
                <p>Tingkat Kepuasan</p>
            </div>
        </div>
    </div>
</section>
@endsection