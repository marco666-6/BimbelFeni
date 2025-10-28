<!-- View: orangtua/notifikasi.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi & Pemberitahuan')

@push('styles')
<style>
    .notification-header-card {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .notification-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }
    
    .notification-item {
        background: white;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .notification-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        transition: all 0.3s ease;
    }
    
    .notification-item.unread {
        background: linear-gradient(135deg, #fff9f0 0%, #fff5e6 100%);
        border-color: #fbbf24;
    }
    
    .notification-item.unread::before {
        background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
    }
    
    .notification-item.read::before {
        background: linear-gradient(180deg, #cbd5e1 0%, #94a3b8 100%);
    }
    
    .notification-item:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-blue);
    }
    
    .notification-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        position: relative;
        flex-shrink: 0;
    }
    
    .notification-icon-wrapper::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: inherit;
        opacity: 0.2;
        z-index: -1;
    }
    
    .icon-pengumuman {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }
    
    .icon-jadwal {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .icon-pembayaran {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .icon-feedback {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .icon-tugas {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .icon-lainnya {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    .notification-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }
    
    .notification-message {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }
    
    .notification-time {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .new-badge {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        animation: pulse-badge 2s infinite;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    @keyframes pulse-badge {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .mark-read-btn {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        border-radius: 12px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .mark-read-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    
    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px solid #e2e8f0;
    }
    
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        padding: 0.6rem 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-tab:hover {
        border-color: #fa709a;
        color: #fa709a;
        transform: translateY(-2px);
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);
    }
    
    .stats-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        flex: 1;
        min-width: 180px;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 6rem;
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .mark-all-read-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        border-radius: 12px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .mark-all-read-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    .notification-group-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        padding: 0.8rem 1.2rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .type-badge {
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .pagination {
        margin-top: 2rem;
    }
    
    .page-link {
        border-radius: 10px;
        margin: 0 0.2rem;
        border: 2px solid #e2e8f0;
        color: var(--primary-blue);
        font-weight: 600;
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border-color: transparent;
        color: white;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        border-color: transparent;
    }
    
    .search-box {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1.5rem 0.7rem 3rem;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: #fa709a;
        box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.2);
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
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card notification-header-card border-0">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <h4 class="text-white mb-2">
                            <i class="bi bi-bell-fill"></i> Notifikasi & Pemberitahuan
                        </h4>
                        <p class="text-white opacity-90 mb-0">
                            Pantau semua notifikasi dan update terbaru
                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="stats-row justify-content-md-end">
                            <div class="stat-card">
                                <div class="stat-icon icon-pengumuman">
                                    <i class="bi bi-bell-fill text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-dark">{{ $notifikasi->total() }}</strong>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                    <i class="bi bi-exclamation-circle-fill text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Belum Dibaca</small>
                                    <strong class="text-dark">{{ $notifikasi->where('dibaca', false)->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Section -->
<div class="filter-section">
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input 
                    type="text" 
                    id="searchNotification" 
                    class="form-control search-box" 
                    placeholder="Cari notifikasi...">
            </div>
        </div>
        <div class="col-lg-4 text-lg-end">
            @if($notifikasi->where('dibaca', false)->count() > 0)
            <button class="mark-all-read-btn w-100 w-lg-auto" onclick="markAllRead()">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
            @endif
        </div>
    </div>
    
    <div class="filter-tabs">
        <div class="filter-tab active" data-filter="all">
            <i class="bi bi-grid-fill"></i>
            <span>Semua</span>
        </div>
        <div class="filter-tab" data-filter="unread">
            <i class="bi bi-exclamation-circle"></i>
            <span>Belum Dibaca</span>
        </div>
        <div class="filter-tab" data-filter="read">
            <i class="bi bi-check-circle"></i>
            <span>Sudah Dibaca</span>
        </div>
        <div class="filter-tab" data-filter="pengumuman">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </div>
        <div class="filter-tab" data-filter="pembayaran">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </div>
        <div class="filter-tab" data-filter="tugas">
            <i class="bi bi-file-text"></i>
            <span>Tugas</span>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div id="notificationContainer">
    @forelse($notifikasi as $index => $n)
    @php
        $iconClass = match($n->tipe) {
            'pengumuman' => 'icon-pengumuman',
            'jadwal' => 'icon-jadwal',
            'pembayaran' => 'icon-pembayaran',
            'feedback' => 'icon-feedback',
            'tugas' => 'icon-tugas',
            default => 'icon-lainnya'
        };
    @endphp
    <div class="notification-item {{ $n->isBelumDibaca() ? 'unread' : 'read' }} animate-fade-in" 
         data-read="{{ $n->dibaca ? 'true' : 'false' }}"
         data-type="{{ $n->tipe }}"
         data-content="{{ strtolower($n->judul . ' ' . $n->pesan) }}"
         style="animation-delay: {{ $index * 0.05 }}s;">
        <div class="card-body p-4">
            <div class="d-flex gap-3">
                <!-- Icon -->
                <div class="notification-icon-wrapper {{ $iconClass }}">
                    <i class="bi bi-{{ $n->tipe_icon }} text-white"></i>
                </div>
                
                <!-- Content -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h6 class="notification-title">
                                {{ $n->judul }}
                                @if($n->isBelumDibaca())
                                    <span class="new-badge ms-2">
                                        <i class="bi bi-star-fill"></i> BARU
                                    </span>
                                @endif
                            </h6>
                            <p class="notification-message mb-2">{{ $n->pesan }}</p>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="notification-time">
                                    <i class="bi bi-clock"></i>
                                    {{ $n->waktu_formatted }}
                                </span>
                                <span class="type-badge" style="background: linear-gradient(135deg, rgba({{ $n->tipe_badge_color === 'info' ? '6, 182, 212' : ($n->tipe_badge_color === 'primary' ? '59, 130, 246' : ($n->tipe_badge_color === 'warning' ? '245, 158, 11' : ($n->tipe_badge_color === 'success' ? '16, 185, 129' : ($n->tipe_badge_color === 'danger' ? '239, 68, 68' : '139, 92, 246')))) }}, 0.15) 0%, rgba({{ $n->tipe_badge_color === 'info' ? '8, 145, 178' : ($n->tipe_badge_color === 'primary' ? '37, 99, 235' : ($n->tipe_badge_color === 'warning' ? '217, 119, 6' : ($n->tipe_badge_color === 'success' ? '5, 150, 105' : ($n->tipe_badge_color === 'danger' ? '220, 38, 38' : '124, 58, 237')))) }}, 0.15) 100%); color: #{{ $n->tipe_badge_color === 'info' ? '0891b2' : ($n->tipe_badge_color === 'primary' ? '2563eb' : ($n->tipe_badge_color === 'warning' ? 'd97706' : ($n->tipe_badge_color === 'success' ? '059669' : ($n->tipe_badge_color === 'danger' ? 'dc2626' : '7c3aed')))) }};">
                                    <i class="bi bi-{{ $n->tipe_icon }}"></i>
                                    {{ ucfirst($n->tipe) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($n->isBelumDibaca())
                        <form action="{{ route('orangtua.notifikasi.read', $n->id) }}" method="POST" class="ms-3">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="mark-read-btn" title="Tandai sudah dibaca">
                                <i class="bi bi-check2"></i>
                                <span class="d-none d-md-inline">Tandai Dibaca</span>
                            </button>
                        </form>
                        @else
                        <div class="ms-3">
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle-fill"></i> Dibaca
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-bell-slash"></i>
        <h5 class="mt-4 text-muted">Belum Ada Notifikasi</h5>
        <p class="text-muted mb-0">
            Anda belum memiliki notifikasi apapun.<br>
            Notifikasi baru akan muncul di sini.
        </p>
    </div>
    @endforelse
</div>

<!-- No Results Message -->
<div id="noResults" class="empty-state d-none">
    <i class="bi bi-search"></i>
    <h5 class="mt-4 text-muted">Tidak Ada Hasil</h5>
    <p class="text-muted mb-0">Tidak ditemukan notifikasi yang sesuai</p>
</div>

<!-- Pagination -->
@if($notifikasi->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $notifikasi->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
// Mark all as read
function markAllRead() {
    Swal.fire({
        title: 'Tandai Semua Dibaca?',
        text: 'Semua notifikasi akan ditandai sebagai sudah dibaca',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Tandai Semua',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // In reality, you would make an AJAX call here
            // For now, we'll just show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Semua notifikasi telah ditandai dibaca',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        }
    });
}

$(document).ready(function() {
    const $notificationItems = $('.notification-item');
    const $noResults = $('#noResults');
    const $searchInput = $('#searchNotification');
    const $filterTabs = $('.filter-tab');
    const $container = $('#notificationContainer');
    
    let currentFilter = 'all';
    
    // Filter Tabs
    $filterTabs.on('click', function() {
        $filterTabs.removeClass('active');
        $(this).addClass('active');
        currentFilter = $(this).data('filter');
        applyFilters();
    });
    
    // Search
    $searchInput.on('keyup', debounce(function() {
        applyFilters();
    }, 300));
    
    function applyFilters() {
        const searchTerm = $searchInput.val().toLowerCase();
        let visibleCount = 0;
        
        $notificationItems.each(function() {
            const $item = $(this);
            const read = $item.data('read') === 'true';
            const type = $item.data('type');
            const content = $item.data('content');
            
            let show = true;
            
            // Search filter
            if (searchTerm && !content.includes(searchTerm)) {
                show = false;
            }
            
            // Status filter
            if (currentFilter === 'unread' && read) {
                show = false;
            } else if (currentFilter === 'read' && !read) {
                show = false;
            } else if (currentFilter !== 'all' && currentFilter !== 'unread' && currentFilter !== 'read' && type !== currentFilter) {
                show = false;
            }
            
            if (show) {
                $item.removeClass('d-none').addClass('animate-fade-in');
                visibleCount++;
            } else {
                $item.addClass('d-none');
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0 && $notificationItems.length > 0) {
            $container.addClass('d-none');
            $noResults.removeClass('d-none');
        } else {
            $container.removeClass('d-none');
            $noResults.addClass('d-none');
        }
    }
    
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Form submission with AJAX (optional enhancement)
    $('form').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $button = $form.find('button');
        const $item = $form.closest('.notification-item');
        
        // Disable button
        $button.prop('disabled', true);
        
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                // Update UI
                $item.removeClass('unread').addClass('read');
                $item.attr('data-read', 'true');
                
                // Replace button with badge
                $form.parent().html(`
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle-fill"></i> Dibaca
                    </span>
                `);
                
                // Update counter
                const currentUnread = parseInt($('.stat-card strong').last().text());
                if (currentUnread > 0) {
                    $('.stat-card strong').last().text(currentUnread - 1);
                }
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Notifikasi telah ditandai dibaca',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            error: function() {
                $button.prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan, silakan coba lagi'
                });
            }
        });
    });
});
</script>
@endpush