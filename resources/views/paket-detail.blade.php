@extends('layouts.app')

@section('title', $paket->nama_paket . ' - Bimbel Oriana Enilin')

@section('content')
<!-- Page Header -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">{{ $paket->nama_paket }}</h1>
        <p class="lead">Detail lengkap paket bimbingan belajar</p>
    </div>
</section>

<!-- Package Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold mb-0">{{ $paket->nama_paket }}</h2>
                            <span class="badge bg-primary fs-5">{{ $paket->getFormattedHarga() }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Deskripsi Paket</h5>
                            <p class="text-muted">{{ $paket->deskripsi }}</p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt fa-2x text-primary me-3"></i>
                                            <div>
                                                <small class="text-muted">Durasi Paket</small>
                                                <h5 class="fw-bold mb-0">{{ $paket->durasi }} Bulan</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                                            <div>
                                                <small class="text-muted">Harga per Bulan</small>
                                                <h5 class="fw-bold mb-0">{{ $paket->getFormattedHargaBulanan() }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($paket->komentar)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> {{ $paket->komentar }}
                        </div>
                        @endif

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Fasilitas yang Didapatkan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Materi pembelajaran lengkap</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Bimbingan dari pengajar berpengalaman</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Kelas kecil maksimal 10-12 siswa</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Evaluasi berkala dan laporan progres</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Akses sistem SIDES online</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Konsultasi dengan orang tua</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Bank soal dan latihan</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                        <span>Persiapan ujian sekolah</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Mata Pelajaran</h5>
                            <div class="row g-2">
                                <div class="col-auto">
                                    <span class="badge bg-primary">Matematika</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary">Bahasa Indonesia</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary">Bahasa Inggris</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary">IPA</span>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-primary">IPS</span>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">* Mata pelajaran dapat disesuaikan dengan kebutuhan siswa</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Price Card -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 80px; z-index: 1;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary mb-0">{{ $paket->getFormattedHarga() }}</h3>
                            <small class="text-muted">untuk {{ $paket->durasi }} bulan</small>
                        </div>

                        <div class="d-grid gap-2">
                            @auth
                                @if(Auth::user()->role === 'orang_tua')
                                    <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus"></i> Daftar Paket Ini
                                    </a>
                                @else
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-home"></i> Kembali ke Beranda
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            @endauth
                            <a href="{{ route('whatsapp') }}" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i> Tanya Via WhatsApp
                            </a>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <h6 class="fw-bold mb-3">Butuh Bantuan?</h6>
                            <p class="small text-muted mb-2">
                                <i class="fas fa-phone text-primary me-1"></i> +62 812-3456-7890
                            </p>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-envelope text-primary me-1"></i> info@bimbelorianaenilin.com
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-info"></i> Informasi Penting
                        </h6>
                        <ul class="small text-muted ps-3 mb-0">
                            <li class="mb-2">Pendaftaran akan diverifikasi oleh admin dalam 1x24 jam</li>
                            <li class="mb-2">Pembayaran dapat dilakukan setelah pendaftaran disetujui</li>
                            <li class="mb-2">Jadwal belajar akan diatur sesuai kesepakatan</li>
                            <li class="mb-0">Orang tua dapat memantau progres melalui sistem SIDES</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Apa Kata Mereka?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted">"Sistem SIDES sangat membantu saya memantau perkembangan anak. Pengajarnya juga sangat sabar dan profesional."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Ibu Sarah</h6>
                                <small class="text-muted">Orang Tua Siswa SD</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted">"Anak saya jadi lebih semangat belajar. Nilai-nilainya meningkat signifikan setelah ikut bimbel ini."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-user text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Bapak Ahmad</h6>
                                <small class="text-muted">Orang Tua Siswa SMP</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted">"Pelayanan sangat memuaskan. Komunikasi dengan pengajar dan admin juga sangat responsif."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Ibu Rina</h6>
                                <small class="text-muted">Orang Tua Siswa SD</small>
                            </div>
                        </div>
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
        <p class="lead mb-4">Daftarkan anak Anda sekarang dan mulai perjalanan menuju prestasi terbaik!</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endguest
    </div>
</section>
@endsection