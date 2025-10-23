<!-- View: home/kontak.blade.php -->
@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<!-- Page Header -->
<div class="hero-section text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Hubungi Kami</h1>
        <p class="lead">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami!</p>
    </div>
</div>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                        
                        <!-- Alamat -->
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="font-size: 2rem;">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Alamat</h5>
                                    <p class="text-muted mb-0">{{ $settings->alamat ?? 'Batam, Kepulauan Riau' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="font-size: 2rem;">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Telepon</h5>
                                    <p class="text-muted mb-0">{{ $settings->no_telepon ?? '+62 812-3456-7890' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="font-size: 2rem;">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Email</h5>
                                    <p class="text-muted mb-0">{{ $settings->email ?? 'info@bimbeloriana.com' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="font-size: 2rem;">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Jam Operasional</h5>
                                    <p class="text-muted mb-1">Senin - Jumat: 08.00 - 20.00 WIB</p>
                                    <p class="text-muted mb-0">Sabtu: 08.00 - 17.00 WIB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-5">
                            <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-lg">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success btn-lg">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-lg">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <!-- <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Kirim Pesan</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap *</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="Masukkan nama Anda" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email *</label>
                                    <input type="email" class="form-control form-control-lg" placeholder="email@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Telepon *</label>
                                    <input type="tel" class="form-control form-control-lg" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Subjek</label>
                                    <select class="form-select form-select-lg">
                                        <option selected>Pilih subjek...</option>
                                        <option>Informasi Pendaftaran</option>
                                        <option>Informasi Paket Belajar</option>
                                        <option>Keluhan/Saran</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pesan *</label>
                                    <textarea class="form-control" rows="6" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-send"></i> Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="alert alert-info mt-4" role="alert">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Catatan:</strong> Untuk pendaftaran atau konsultasi lebih lanjut, silakan login terlebih dahulu atau hubungi kami langsung melalui WhatsApp.
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title mb-5">Lokasi Kami</h2>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div style="width: 100%; height: 450px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                    <div class="text-white text-center">
                        <i class="bi bi-map" style="font-size: 5rem;"></i>
                        <h4 class="mt-3">Peta Lokasi</h4>
                        <p>Batam, Kepulauan Riau</p>
                        <small>Embed Google Maps di sini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Butuh Informasi Lebih Lanjut?</h2>
        <p class="lead mb-4">Tim kami siap membantu Anda!</p>
        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-light btn-lg px-5">
            <i class="bi bi-whatsapp"></i> Chat WhatsApp
        </a>
    </div>
</section>
@endsection