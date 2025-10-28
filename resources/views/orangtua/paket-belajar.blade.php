<!-- View: orangtua/paket-belajar.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Paket Belajar')
@section('page-title', 'Paket Belajar')

@push('styles')
<style>
    .hero-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 25px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    
    .info-card {
        background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
        border-left: 5px solid var(--primary-blue);
        border-radius: 15px;
    }
    
    .pricing-card {
        border-radius: 25px;
        border: 3px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        background: white;
    }
    
    .pricing-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    
    .pricing-card:hover {
        transform: translateY(-15px) scale(1.03);
        border-color: var(--primary-blue);
        box-shadow: 0 25px 50px rgba(37, 99, 235, 0.2);
    }
    
    .pricing-card:hover::before {
        transform: scaleX(1);
    }
    
    .pricing-card.recommended {
        border-color: #10b981;
        background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
    }
    
    .pricing-card.recommended::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        transform: scaleX(1);
    }
    
    .pricing-card.recommended .card-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .recommended-badge {
        position: absolute;
        top: 20px;
        right: -35px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-weight: 700;
        font-size: 0.75rem;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        z-index: 10;
    }
    
    .price-tag {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .feature-list li {
        padding: 0.7rem 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .feature-list li:last-child {
        border-bottom: none;
    }
    
    .feature-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    
    .cta-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .cta-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .cta-button:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    .cta-button span {
        position: relative;
        z-index: 1;
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }
    
    .filter-tabs {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .filter-tab {
        background: #f8fafc;
        border: 2px solid transparent;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #64748b;
    }
    
    .filter-tab:hover,
    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .modal-content {
        border-radius: 25px;
    }
    
    .modal-header {
        border-radius: 25px 25px 0 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .form-control-custom {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-custom:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }
    
    .file-upload-wrapper {
        position: relative;
        border: 3px dashed #cbd5e1;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .file-upload-wrapper:hover {
        border-color: var(--primary-blue);
        background: #f8fafc;
    }
    
    .file-upload-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .bank-info-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 5px solid #f59e0b;
        border-radius: 15px;
    }
    
    .empty-state-paket {
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-state-paket i {
        font-size: 5rem;
        color: #cbd5e1;
    }
    
    .duration-badge {
        background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card hero-banner border-0 text-white">
            <div class="card-body p-5" style="position: relative; z-index: 2;">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold mb-3">🎓 Paket Belajar Premium</h1>
                        <p class="lead mb-4 opacity-90">
                            Pilih paket belajar terbaik untuk masa depan cerah anak Anda. 
                            Investasi terbaik adalah investasi pendidikan!
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="bg-white bg-opacity-25 rounded-3 px-4 py-2">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span class="fw-bold">Pengajar Berpengalaman</span>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-3 px-4 py-2">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span class="fw-bold">Materi Lengkap</span>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-3 px-4 py-2">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span class="fw-bold">Monitoring Progress</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <i class="bi bi-mortarboard-fill" style="font-size: 8rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card info-card border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="bi bi-info-circle-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Cara Pembelian Paket</h5>
                        <ol class="mb-0 ps-3">
                            <li>Pilih paket belajar yang sesuai dengan jenjang anak Anda</li>
                            <li>Klik tombol "Beli Paket" dan pilih anak yang akan mengikuti program</li>
                            <li>Transfer pembayaran ke rekening yang tertera</li>
                            <li>Upload bukti transfer untuk verifikasi admin</li>
                            <li>Tunggu konfirmasi dari admin (maksimal 1x24 jam)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <div class="filter-tabs">
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <button class="filter-tab active" data-filter="all">
                    <i class="bi bi-grid-fill"></i> Semua Paket
                </button>
                <button class="filter-tab" data-filter="sd">
                    <i class="bi bi-book"></i> Paket SD
                </button>
                <button class="filter-tab" data-filter="smp">
                    <i class="bi bi-journal-text"></i> Paket SMP
                </button>
                <button class="filter-tab" data-filter="kombo">
                    <i class="bi bi-stars"></i> Paket Kombo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Paket SD -->
<div class="paket-section" data-jenjang="sd">
    @if($paketSD->isNotEmpty())
    <h3 class="section-title">
        <i class="bi bi-mortarboard-fill text-primary"></i> Paket SD
    </h3>
    <div class="row mb-5">
        @foreach($paketSD as $paket)
        <div class="col-lg-4 col-md-6 mb-4 animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
            <div class="card pricing-card h-100">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="price-tag">{{ $paket->harga_formatted }}</div>
                        <div class="duration-badge mt-3">
                            <i class="bi bi-calendar-check"></i>
                            <span>{{ $paket->durasi_bulan }} Bulan</span>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">{{ $paket->deskripsi }}</p>
                    
                    <ul class="feature-list list-unstyled mb-4">
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Pembelajaran interaktif & menyenangkan</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Tutor berpengalaman khusus SD</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Materi sesuai kurikulum sekolah</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Laporan perkembangan berkala</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Konsultasi dengan orang tua</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <button class="btn cta-button w-100 text-white" 
                            onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                        <span><i class="bi bi-cart-plus"></i> Beli Paket Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Paket SMP -->
<div class="paket-section" data-jenjang="smp">
    @if($paketSMP->isNotEmpty())
    <h3 class="section-title">
        <i class="bi bi-journal-text text-info"></i> Paket SMP
    </h3>
    <div class="row mb-5">
        @foreach($paketSMP as $paket)
        <div class="col-lg-4 col-md-6 mb-4 animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
            <div class="card pricing-card h-100">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                    <h5 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="price-tag" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $paket->harga_formatted }}
                        </div>
                        <div class="duration-badge mt-3" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                            <i class="bi bi-calendar-check"></i>
                            <span>{{ $paket->durasi_bulan }} Bulan</span>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">{{ $paket->deskripsi }}</p>
                    
                    <ul class="feature-list list-unstyled mb-4">
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Persiapan ujian sekolah & UN</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Tutor spesialis mata pelajaran</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Bank soal lengkap & try out</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Evaluasi rutin & remedial</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Bimbingan motivasi belajar</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <button class="btn cta-button w-100 text-white" 
                            style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);"
                            onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                        <span><i class="bi bi-cart-plus"></i> Beli Paket Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Paket Kombo -->
<div class="paket-section" data-jenjang="kombo">
    @if($paketKombo->isNotEmpty())
    <h3 class="section-title">
        <i class="bi bi-stars text-success"></i> Paket Kombo (SD & SMP)
        <span class="badge bg-warning text-dark ms-2">
            <i class="bi bi-star-fill"></i> Best Value
        </span>
    </h3>
    <div class="row mb-5">
        @foreach($paketKombo as $paket)
        <div class="col-lg-4 col-md-6 mb-4 animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
            <div class="card pricing-card recommended h-100">
                <div class="recommended-badge">RECOMMENDED</div>
                <div class="card-header text-white text-center py-4">
                    <h5 class="mb-0 fw-bold">{{ $paket->nama_paket }}</h5>
                    <small><i class="bi bi-star-fill"></i> Paket Terfavorit</small>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="price-tag" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $paket->harga_formatted }}
                        </div>
                        <div class="duration-badge mt-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="bi bi-calendar-check"></i>
                            <span>{{ $paket->durasi_bulan }} Bulan</span>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-4">{{ $paket->deskripsi }}</p>
                    
                    <ul class="feature-list list-unstyled mb-4">
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Cocok untuk keluarga multi-jenjang</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Harga lebih hemat & ekonomis</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Akses penuh SD & SMP</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Prioritas layanan customer care</span>
                        </li>
                        <li>
                            <span class="feature-icon"><i class="bi bi-check"></i></span>
                            <span>Bonus sesi konsultasi ekstra</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    <button class="btn cta-button w-100 text-white" 
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);"
                            onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                        <span><i class="bi bi-cart-plus"></i> Beli Paket Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Empty State (if no packages) -->
@if($paketSD->isEmpty() && $paketSMP->isEmpty() && $paketKombo->isEmpty())
<div class="row">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body empty-state-paket">
                <i class="bi bi-inbox"></i>
                <h4 class="mt-3 text-muted">Paket Belum Tersedia</h4>
                <p class="text-muted">Saat ini belum ada paket belajar yang tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

<!-- Modal Beli Paket -->
<div class="modal fade" id="beliModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('orangtua.paket-belajar.beli') }}" method="POST" enctype="multipart/form-data" id="beliForm">
                @csrf
                <div class="modal-header text-white border-0">
                    <div>
                        <h4 class="modal-title mb-1">
                            <i class="bi bi-cart-check-fill"></i> Checkout Paket Belajar
                        </h4>
                        <small class="opacity-90">Lengkapi data untuk pembelian paket</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="paket_id" id="paket_id">
                    
                    <!-- Paket Info -->
                    <div class="card mb-4" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%); border: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="text-muted small mb-1">Paket yang Dipilih</label>
                                    <h5 class="mb-2 fw-bold" id="paket_name"></h5>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <label class="text-muted small mb-1">Total Pembayaran</label>
                                    <h4 class="mb-0 text-primary fw-bold" id="paket_price"></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Anak -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-person-fill text-primary"></i> Pilih Anak 
                            <span class="text-danger">*</span>
                        </label>
                        <select name="siswa_id" class="form-select form-control-custom" id="siswa_select" required>
                            <option value="">-- Pilih Anak yang Akan Mengikuti Paket --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}" data-jenjang="{{ $s->jenjang }}">
                                {{ $s->nama_lengkap }} - {{ $s->jenjang }} (Kelas {{ $s->kelas }})
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Pilih anak yang akan mengikuti program paket ini
                        </small>
                    </div>

                    <!-- Bank Info -->
                    <div class="card bank-info-card border-0 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-bank"></i> Informasi Rekening Pembayaran
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Nama Bank</small>
                                    <strong>Bank Mandiri</strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">No. Rekening</small>
                                    <strong>1234567890</strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted d-block">Atas Nama</small>
                                    <strong>Bimbel Oriana</strong>
                                </div>
                            </div>
                            <div class="alert alert-warning mb-0 mt-3">
                                <small>
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Harap transfer <strong>SESUAI JUMLAH</strong> total pembayaran di atas
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Bukti -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-cloud-upload-fill text-primary"></i> Bukti Pembayaran 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="bukti_pembayaran" id="bukti_file" accept="image/*" required>
                            <div class="file-upload-content">
                                <i class="bi bi-cloud-arrow-up" style="font-size: 3rem; color: #94a3b8;"></i>
                                <h6 class="mt-3 mb-2">Klik atau drag & drop file di sini</h6>
                                <small class="text-muted">Format: JPG, PNG, JPEG (Maksimal 2MB)</small>
                                <div class="mt-3" id="file-preview"></div>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> File Anda aman dan terenkripsi
                        </small>
                    </div>

                    <!-- Additional Notes -->
                    <div class="card border-0" style="background: #f8fafc;">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-lightbulb text-warning"></i> Tips Upload Bukti Transfer
                            </h6>
                            <ul class="mb-0 small text-muted ps-3">
                                <li>Pastikan foto bukti transfer jelas dan dapat dibaca</li>
                                <li>Sertakan informasi nominal, tanggal, dan nomor referensi</li>
                                <li>Verifikasi akan diproses maksimal 1x24 jam</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Submit Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let paketJenjang = '';
    
    // Filter Tabs
    $('.filter-tab').on('click', function() {
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('filter');
        
        if (filter === 'all') {
            $('.paket-section').fadeIn();
        } else {
            $('.paket-section').hide();
            $(`.paket-section[data-jenjang="${filter}"]`).fadeIn();
        }
    });
    
    // File Upload Preview
    $('#bukti_file').on('change', function(e) {
        const file = e.target.files[0];
        const $preview = $('#file-preview');
        
        if (file) {
            // Validate size
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB',
                    confirmButtonColor: '#2563eb'
                });
                $(this).val('');
                return;
            }
            
            // Validate type
            if (!file.type.match('image.*')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Salah',
                    text: 'Hanya file gambar (JPG, PNG) yang diperbolehkan',
                    confirmButtonColor: '#2563eb'
                });
                $(this).val('');
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $preview.html(`
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle"></i> 
                        <strong>${file.name}</strong> (${(file.size / 1024).toFixed(2)} KB)
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Form Validation
    $('#beliForm').on('submit', function(e) {
        const siswaId = $('#siswa_select').val();
        const buktiFile = $('#bukti_file')[0].files[0];
        
        if (!siswaId) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Anak',
                text: 'Silakan pilih anak yang akan mengikuti paket',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }
        
        if (!buktiFile) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Upload Bukti',
                text: 'Silakan upload bukti pembayaran',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }
        
        // Show loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });
    
    // Animate cards on load
    $('.pricing-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
});

function showBeliModal(id, name, price, jenjang) {
    paketJenjang = jenjang;
    $('#paket_id').val(id);
    $('#paket_name').text(name);
    $('#paket_price').text(price);
    
    // Clear previous selections
    $('#siswa_select').val('');
    $('#bukti_file').val('');
    $('#file-preview').html('');
    
    // Filter siswa berdasarkan jenjang paket
    filterSiswaByJenjang(jenjang);
    
    $('#beliModal').modal('show');
}

function filterSiswaByJenjang(jenjang) {
    const select = document.getElementById('siswa_select');
    const options = select.querySelectorAll('option');
    
    let hasVisibleOptions = false;
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
            return;
        }
        
        const siswaJenjang = option.getAttribute('data-jenjang');
        
        // Jika paket untuk SD & SMP, tampilkan semua
        if (jenjang === 'SD & SMP') {
            option.style.display = 'block';
            hasVisibleOptions = true;
        } else {
            // Tampilkan hanya yang sesuai jenjang
            if (siswaJenjang === jenjang) {
                option.style.display = 'block';
                hasVisibleOptions = true;
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    // Show alert if no matching students
    if (!hasVisibleOptions) {
        Swal.fire({
            icon: 'info',
            title: 'Tidak Ada Anak yang Sesuai',
            text: `Anda belum memiliki anak terdaftar di jenjang ${jenjang}. Silakan daftarkan anak terlebih dahulu.`,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'OK'
        });
        $('#beliModal').modal('hide');
    }
    
    // Reset pilihan
    select.value = '';
}

// Smooth scroll animation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endpush