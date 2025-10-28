<!-- View: orangtua/transaksi.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@push('styles')
<style>
    .stats-row {
        margin-bottom: 2rem;
    }
    
    .stat-box {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }
    
    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        border-color: var(--primary-blue);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    
    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }
    
    .search-input {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1.5rem 0.7rem 3rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }
    
    .search-wrapper {
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
    }
    
    .status-filter-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        border: 2px solid #e2e8f0;
        background: white;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .status-filter-btn:hover,
    .status-filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }
    
    .transaction-card {
        background: white;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    
    .transaction-card:hover {
        border-color: var(--primary-blue);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.12);
        transform: translateX(5px);
    }
    
    .transaction-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .transaction-card:hover::before {
        opacity: 1;
    }
    
    .transaction-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--primary-blue);
        font-size: 1.1rem;
    }
    
    .status-badge-custom {
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .detail-button {
        border-radius: 12px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .detail-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
    }
    
    .modal-detail-section {
        background: #f8fafc;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .modal-detail-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modal-detail-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .proof-image-wrapper {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .proof-image-wrapper:hover {
        transform: scale(1.02);
    }
    
    .timeline-indicator {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .price-highlight {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .info-row {
        display: flex;
        align-items: start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-icon {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<!-- Statistics Row -->
<div class="row stats-row">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-receipt"></i>
            </div>
            <h3 class="mb-1 fw-bold">{{ $transaksi->count() }}</h3>
            <small class="text-muted">Total Transaksi</small>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white;">
                <i class="bi bi-clock-history"></i>
            </div>
            <h3 class="mb-1 fw-bold text-warning">{{ $transaksi->where('status_verifikasi', 'pending')->count() }}</h3>
            <small class="text-muted">Menunggu Verifikasi</small>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3 class="mb-1 fw-bold text-success">{{ $transaksi->where('status_verifikasi', 'verified')->count() }}</h3>
            <small class="text-muted">Terverifikasi</small>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-box">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
                <i class="bi bi-x-circle"></i>
            </div>
            <h3 class="mb-1 fw-bold text-danger">{{ $transaksi->where('status_verifikasi', 'rejected')->count() }}</h3>
            <small class="text-muted">Ditolak</small>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <div class="search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari kode transaksi, nama anak, atau paket...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                <button class="status-filter-btn active" data-status="all">
                    <i class="bi bi-grid-fill"></i> Semua
                </button>
                <button class="status-filter-btn" data-status="pending">
                    <i class="bi bi-clock"></i> Pending
                </button>
                <button class="status-filter-btn" data-status="verified">
                    <i class="bi bi-check-circle"></i> Verified
                </button>
                <button class="status-filter-btn" data-status="rejected">
                    <i class="bi bi-x-circle"></i> Rejected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Transaction List -->
<div class="row">
    <div class="col-12">
        @if($transaksi->isEmpty())
        <div class="card border-0">
            <div class="card-body empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="mt-3 text-muted">Belum Ada Transaksi</h4>
                <p class="text-muted mb-4">Anda belum memiliki riwayat transaksi pembayaran</p>
                <a href="{{ route('orangtua.paket-belajar') }}" class="btn btn-primary">
                    <i class="bi bi-cart-plus"></i> Beli Paket Sekarang
                </a>
            </div>
        </div>
        @else
        <div id="transactionContainer">
            @foreach($transaksi as $t)
            <div class="transaction-card p-4 position-relative animate-fade-in" 
                 data-search="{{ strtolower($t->kode_transaksi . ' ' . $t->siswa->nama_lengkap . ' ' . $t->paketBelajar->nama_paket) }}"
                 data-status="{{ $t->status_verifikasi }}"
                 style="animation-delay: {{ $loop->index * 0.05 }}s;">
                
                <div class="row align-items-center">
                    <!-- Timeline Indicator -->
                    <div class="col-auto d-none d-md-block">
                        <div class="timeline-indicator" 
                             style="background: linear-gradient(135deg, 
                                @if($t->status_verifikasi === 'verified') #10b981 0%, #059669 100%
                                @elseif($t->status_verifikasi === 'pending') #fbbf24 0%, #f59e0b 100%
                                @else #ef4444 0%, #dc2626 100%
                                @endif); color: white;">
                            <i class="bi bi-{{ $t->status_verifikasi === 'verified' ? 'check-circle-fill' : ($t->status_verifikasi === 'pending' ? 'clock-fill' : 'x-circle-fill') }}"></i>
                        </div>
                    </div>
                    
                    <!-- Transaction Info -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="transaction-code mb-2">{{ $t->kode_transaksi }}</div>
                        <div class="small text-muted">
                            <i class="bi bi-calendar3"></i> 
                            {{ $t->tanggal_transaksi->locale('id')->isoFormat('DD MMMM YYYY') }}
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-clock"></i> 
                            {{ $t->tanggal_transaksi->format('H:i') }} WIB
                        </div>
                    </div>
                    
                    <!-- Student & Package Info -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="mb-2">
                            <div class="small text-muted mb-1">Nama Anak</div>
                            <div class="fw-bold">
                                <i class="bi bi-person-fill text-primary"></i> 
                                {{ $t->siswa->nama_lengkap }}
                            </div>
                        </div>
                        <div>
                            <div class="small text-muted mb-1">Paket</div>
                            <div class="fw-semibold">
                                <i class="bi bi-box-seam text-info"></i> 
                                {{ $t->paketBelajar->nama_paket }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price & Status -->
                    <div class="col-md-3 mb-3 mb-md-0 text-md-center">
                        <div class="fw-bold mb-2" style="font-size: 1.3rem; color: #10b981;">
                            {{ $t->total_pembayaran_formatted }}
                        </div>
                        <span class="status-badge-custom bg-{{ $t->status_badge_color }}">
                            <i class="bi bi-{{ $t->status_verifikasi === 'verified' ? 'check-circle-fill' : ($t->status_verifikasi === 'pending' ? 'clock-fill' : 'x-circle-fill') }}"></i>
                            {{ $t->status_label }}
                        </span>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="col-md-1 text-md-end">
                        <button class="btn btn-primary detail-button" onclick="showDetailModal({{ $t->id }})" title="Lihat Detail">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- No Results -->
        <div id="noResults" class="card border-0 d-none">
            <div class="card-body empty-state">
                <i class="bi bi-search"></i>
                <h5 class="mt-3 text-muted">Tidak Ada Hasil</h5>
                <p class="text-muted mb-0">Tidak ditemukan transaksi yang sesuai dengan pencarian Anda</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 25px;">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 25px 25px 0 0;">
                <div>
                    <h4 class="modal-title mb-1">
                        <i class="bi bi-receipt-cutoff"></i> Detail Transaksi
                    </h4>
                    <small class="opacity-90">Informasi lengkap pembayaran</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body p-4" id="detailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('keyup', function() {
        filterTransactions();
    });
    
    // Status filter
    $('.status-filter-btn').on('click', function() {
        $('.status-filter-btn').removeClass('active');
        $(this).addClass('active');
        filterTransactions();
    });
    
    function filterTransactions() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const statusFilter = $('.status-filter-btn.active').data('status');
        let visibleCount = 0;
        
        $('.transaction-card').each(function() {
            const $card = $(this);
            const searchData = $card.data('search');
            const status = $card.data('status');
            
            let show = true;
            
            // Search filter
            if (searchTerm && !searchData.includes(searchTerm)) {
                show = false;
            }
            
            // Status filter
            if (statusFilter !== 'all' && status !== statusFilter) {
                show = false;
            }
            
            if (show) {
                $card.removeClass('d-none').addClass('animate-fade-in');
                visibleCount++;
            } else {
                $card.addClass('d-none');
            }
        });
        
        // Show/hide no results
        if (visibleCount === 0) {
            $('#noResults').removeClass('d-none');
        } else {
            $('#noResults').addClass('d-none');
        }
    }
    
    // Animate cards on load
    $('.transaction-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.05) + 's');
    });
});

function showDetailModal(id) {
    const transaksi = @json($transaksi);
    const detail = transaksi.find(t => t.id === id);
    
    if (!detail) return;
    
    const statusColor = detail.status_verifikasi === 'verified' ? 'success' : (detail.status_verifikasi === 'pending' ? 'warning' : 'danger');
    const statusIcon = detail.status_verifikasi === 'verified' ? 'check-circle-fill' : (detail.status_verifikasi === 'pending' ? 'clock-fill' : 'x-circle-fill');
    
    let html = `
        <div class="row">
            <div class="col-lg-8">
                <!-- Transaction Info -->
                <div class="modal-detail-section">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary"></i> Informasi Transaksi</h6>
                    
                    <div class="info-row">
                        <div class="info-icon" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                            <i class="bi bi-hash text-primary"></i>
                        </div>
                        <div>
                            <div class="modal-detail-label">Kode Transaksi</div>
                            <div class="modal-detail-value" style="font-family: 'Courier New', monospace;">${detail.kode_transaksi}</div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <i class="bi bi-calendar-event text-warning"></i>
                        </div>
                        <div>
                            <div class="modal-detail-label">Tanggal Transaksi</div>
                            <div class="modal-detail-value">${new Date(detail.tanggal_transaksi).toLocaleString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</div>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                            <i class="bi bi-person-fill text-success"></i>
                        </div>
                        <div>
                            <div class="modal-detail-label">Nama Anak</div>
                            <div class="modal-detail-value">${detail.siswa.nama_lengkap}</div>
                            <small class="text-muted">${detail.siswa.jenjang} - Kelas ${detail.siswa.kelas}</small>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                            <i class="bi bi-box-seam text-info"></i>
                        </div>
                        <div>
                            <div class="modal-detail-label">Paket Belajar</div>
                            <div class="modal-detail-value">${detail.paket_belajar.nama_paket}</div>
                            <small class="text-muted">${detail.paket_belajar.durasi_bulan} Bulan</small>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Info -->
                <div class="modal-detail-section" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 5px solid #10b981;">
                    <h6 class="fw-bold mb-3"><i class="bi bi-credit-card text-success"></i> Informasi Pembayaran</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="modal-detail-label">Total Pembayaran</div>
                            <div class="price-highlight">${detail.total_pembayaran_formatted}</div>
                        </div>
                        <div class="text-end">
                            <div class="modal-detail-label">Status</div>
                            <span class="badge bg-${statusColor}" style="font-size: 1rem; padding: 0.6rem 1.5rem;">
                                <i class="bi bi-${statusIcon}"></i> ${detail.status_label}
                            </span>
                        </div>
                    </div>
                </div>
    `;
    
    if (detail.catatan_admin) {
        html += `
            <div class="alert alert-info border-0" style="border-radius: 15px;">
                <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text"></i> Catatan Admin</h6>
                <p class="mb-0">${detail.catatan_admin}</p>
            </div>
        `;
    }
    
    html += `</div>`;
    
    // Bukti Pembayaran
    if (detail.bukti_pembayaran_url) {
        html += `
            <div class="col-lg-4">
                <div class="modal-detail-section h-100">
                    <h6 class="fw-bold mb-3"><i class="bi bi-image text-primary"></i> Bukti Pembayaran</h6>
                    <div class="proof-image-wrapper" onclick="window.open('${detail.bukti_pembayaran_url}', '_blank')">
                        <img src="${detail.bukti_pembayaran_url}" class="img-fluid" alt="Bukti Pembayaran" style="border-radius: 15px;">
                    </div>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="bi bi-zoom-in"></i> Klik untuk memperbesar
                    </small>
                </div>
            </div>
        `;
    }
    
    html += `</div>`;
    
    $('#detailContent').html(html);
    $('#detailModal').modal('show');
}
</script>
@endpush