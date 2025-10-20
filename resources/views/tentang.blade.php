@extends('layouts.app')

@section('title', 'Tentang Kami - Bimbel Oriana Enilin')

@section('content')
<!-- Page Header -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Tentang Kami</h1>
        <p class="lead">Bimbingan belajar terpercaya sejak 5 tahun lalu</p>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Bimbel Oriana Enilin</h2>
                <p class="text-muted">
                    Bimbel Oriana Enilin adalah lembaga bimbingan belajar yang telah berdiri sejak 5 tahun yang lalu di Batam, Kepulauan Riau. 
                    Kami berfokus pada pendidikan berkualitas untuk siswa SD dan SMP dengan pendekatan pembelajaran yang personal dan efektif.
                </p>
                <p class="text-muted">
                    Dengan puluhan siswa aktif dan tenaga pengajar yang berpengalaman, kami berkomitmen untuk membantu siswa mencapai 
                    prestasi terbaik mereka melalui metode pembelajaran yang menyenangkan dan sistematis.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/no-image.png') }}" alt="Tentang Kami" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-eye fa-2x text-primary me-3"></i>
                            <h3 class="fw-bold mb-0">Visi</h3>
                        </div>
                        <p class="text-muted">
                            Menjadi lembaga bimbingan belajar terdepan di Batam yang menghasilkan siswa-siswa berprestasi 
                            dengan karakter yang kuat dan siap menghadapi tantangan masa depan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-bullseye fa-2x text-success me-3"></i>
                            <h3 class="fw-bold mb-0">Misi</h3>
                        </div>
                        <ul class="text-muted">
                            <li>Memberikan pendidikan berkualitas dengan metode pembelajaran yang efektif</li>
                            <li>Mengembangkan potensi setiap siswa secara maksimal</li>
                            <li>Membangun karakter dan kepercayaan diri siswa</li>
                            <li>Menjalin komunikasi yang baik dengan orang tua</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Keunggulan Kami</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold">Pengajar Berkualitas</h5>
                    <p class="text-muted">Tenaga pengajar berpengalaman dan kompeten</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-book-reader fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Kurikulum Terkini</h5>
                    <p class="text-muted">Materi sesuai kurikulum pendidikan nasional</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold">Monitoring Berkala</h5>
                    <p class="text-muted">Pemantauan perkembangan siswa secara rutin</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold">Komunikasi Aktif</h5>
                    <p class="text-muted">Koordinasi intensif dengan orang tua</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Program Pembelajaran</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-child fa-2x text-primary"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Program SD</h4>
                        </div>
                        <p class="text-muted">
                            Bimbingan belajar untuk siswa SD kelas 1-6 dengan pendekatan yang menyenangkan dan mudah dipahami. 
                            Mencakup semua mata pelajaran inti seperti Matematika, IPA, Bahasa Indonesia, dan Bahasa Inggris.
                        </p>
                        <ul class="text-muted">
                            <li>Kelas kecil (maksimal 10 siswa)</li>
                            <li>Materi sesuai kurikulum nasional</li>
                            <li>Latihan soal dan pembahasan</li>
                            <li>Persiapan ujian sekolah</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-user-graduate fa-2x text-success"></i>
                            </div>
                            <h4 class="fw-bold mb-0">Program SMP</h4>
                        </div>
                        <p class="text-muted">
                            Bimbingan belajar untuk siswa SMP kelas 7-9 dengan fokus pada pemahaman konsep dan penyelesaian soal. 
                            Mencakup semua mata pelajaran dengan penekanan pada persiapan ujian.
                        </p>
                        <ul class="text-muted">
                            <li>Kelas kecil (maksimal 12 siswa)</li>
                            <li>Pembahasan materi mendalam</li>
                            <li>Try out dan simulasi ujian</li>
                            <li>Persiapan ujian nasional</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sistem SIDES Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 bg-primary text-white shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">SIDES</h3>
                        <h5 class="mb-3">Student Information and Development Evaluation System</h5>
                        <p>
                            Sistem informasi modern yang memungkinkan orang tua dan siswa untuk memantau perkembangan belajar secara real-time, 
                            mengakses materi pembelajaran, dan berkomunikasi dengan pengajar.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4">Fitur SIDES</h3>
                <div class="d-flex mb-3">
                    <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold">Monitoring Real-time</h6>
                        <p class="text-muted">Pantau perkembangan belajar anak kapan saja</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold">Akses Materi Digital</h6>
                        <p class="text-muted">Materi pembelajaran dapat diunduh dan dipelajari</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold">Laporan Berkala</h6>
                        <p class="text-muted">Laporan perkembangan siswa secara terstruktur</p>
                    </div>
                </div>
                <div class="d-flex">
                    <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold">Komunikasi Terintegrasi</h6>
                        <p class="text-muted">Hubungi pengajar melalui WhatsApp dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Bergabung dengan Kami</h2>
        <p class="lead mb-4">Daftarkan anak Anda sekarang dan rasakan perbedaan kualitas pendidikan kami!</p>
        <div class="d-flex justify-content-center gap-3">
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            @endguest
            <a href="{{ route('kontak') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-envelope"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection