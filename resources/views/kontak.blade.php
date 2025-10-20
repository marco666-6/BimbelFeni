@extends('layouts.app')

@section('title', 'Kontak - Bimbel Oriana Enilin')

@section('content')
<!-- Page Header -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Hubungi Kami</h1>
        <p class="lead">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami!</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Kirim Pesan</h3>
                        <form action="{{ route('kontak.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subjek" class="form-label">Subjek <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subjek') is-invalid @enderror" 
                                       id="subjek" name="subjek" value="{{ old('subjek') }}" required>
                                @error('subjek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror" 
                                          id="pesan" name="pesan" rows="6" required>{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                        
                        <div class="d-flex mb-4">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Alamat</h6>
                                <p class="text-muted mb-0">Batam, Kepulauan Riau, Indonesia</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-phone fa-2x text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Telepon</h6>
                                <p class="text-muted mb-0">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-envelope fa-2x text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Email</h6>
                                <p class="text-muted mb-0">info@bimbelorianaenilin.com</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Jam Operasional</h6>
                                <p class="text-muted mb-1">Senin - Jumat: 13:00 - 20:00</p>
                                <p class="text-muted mb-0">Sabtu: 09:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Card -->
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body p-4 text-center">
                        <i class="fab fa-whatsapp fa-4x mb-3"></i>
                        <h5 class="fw-bold mb-3">Hubungi Via WhatsApp</h5>
                        <p class="mb-4">Dapatkan respons cepat melalui WhatsApp kami</p>
                        <a href="{{ route('whatsapp') }}" class="btn btn-light">
                            <i class="fab fa-whatsapp"></i> Chat Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Pertanyaan yang Sering Diajukan</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara mendaftar di Bimbel Oriana Enilin?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat mendaftar melalui website dengan klik tombol "Daftar" di menu utama. 
                                Setelah mengisi formulir pendaftaran, admin kami akan menghubungi Anda untuk proses selanjutnya.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apa saja program yang tersedia?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami menyediakan program bimbingan belajar untuk siswa SD (kelas 1-6) dan SMP (kelas 7-9) 
                                dengan berbagai pilihan paket sesuai kebutuhan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Berapa biaya bimbingan belajar?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Biaya bervariasi tergantung paket yang dipilih. Silakan lihat halaman "Paket Belajar" 
                                atau hubungi kami untuk informasi lebih detail.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Bagaimana sistem pembelajaran dilakukan?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pembelajaran dilakukan secara offline di tempat kami dengan kelas kecil untuk memastikan 
                                setiap siswa mendapat perhatian maksimal. Materi dan tugas juga dapat diakses melalui sistem online SIDES.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                Bagaimana cara memantau perkembangan anak?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Orang tua dapat memantau perkembangan anak melalui sistem SIDES (Student Information and Development Evaluation System) 
                                yang dapat diakses kapan saja. Laporan perkembangan juga akan dikirimkan secara berkala.
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
        <h2 class="fw-bold mb-4">Masih Ada Pertanyaan?</h2>
        <p class="lead mb-4">Hubungi kami sekarang dan kami akan dengan senang hati membantu Anda!</p>
        <a href="{{ route('whatsapp') }}" class="btn btn-light btn-lg">
            <i class="fab fa-whatsapp"></i> Chat Via WhatsApp
        </a>
    </div>
</section>
@endsection