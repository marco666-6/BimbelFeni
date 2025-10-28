<!-- View: orangtua/pengumuman.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman & Informasi')

@push('styles')
<style>
    .announcement-header-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .announcement-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }
    
    .announcement-card {
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
        margin-bottom: 1.5rem;
        background: white;
    }
    
    .announcement-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        transition: all 0.3s ease;
    }
    
    .announcement-card.priority-high::before {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }
    
    .announcement-card.priority-normal::before {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .announcement-card.priority-low::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }
    
    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-blue);
    }
    
    .announcement-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        position: relative;
    }
    
    .announcement-icon-wrapper::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: inherit;
        opacity: 0.3;
        z-index: -1;
    }
    
    .icon-bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .icon-bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .icon-bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .icon-bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }
    
    .announcement-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .announcement-content {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 15px;
        padding: 1.5rem;
        line-height: 1.8;
        color: #334155;
        border: 2px solid #bfdbfe;
        position: relative;
    }
    
    .announcement-content::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 4rem;
        color: #bfdbfe;
        font-family: Georgia, serif;
        line-height: 1;
    }
    
    .meta-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.9rem;
    }
    
    .meta-item i {
        font-size: 1.1rem;
        color: #94a3b8;
    }
    
    .target-badge {
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .badge-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .badge-gradient-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }
    
    .badge-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
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
        border-color: #f093fb;
        color: #f093fb;
        transform: translateY(-2px);
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
    }
    
    .search-box {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1.5rem 0.7rem 3rem;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: #f093fb;
        box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.2);
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
    
    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 6rem;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
        min-width: 200px;
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
    
    .read-more-btn {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    
    .read-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
    }
    
    .content-preview {
        max-height: 150px;
        overflow: hidden;
        position: relative;
    }
    
    .content-preview.expanded {
        max-height: none;
    }
    
    .content-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        background: linear-gradient(to bottom, transparent, #e0f2fe);
    }
    
    .content-preview.expanded + .content-fade {
        display: none;
    }
    
    .new-badge {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        animation: pulse-new 2s infinite;
    }
    
    @keyframes pulse-new {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(0.95);
        }
    }
    
    .time-badge {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e2e8f0;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #64748b;
    }
    
    .sort-select {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }
    
    .sort-select:focus {
        border-color: #f093fb;
        box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.1);
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card announcement-header-card border-0">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h4 class="text-white mb-2">
                            <i class="bi bi-megaphone-fill"></i> Pengumuman & Informasi
                        </h4>
                        <p class="text-white opacity-90 mb-0">
                            Informasi terkini dan pengumuman penting untuk orang tua
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-row justify-content-md-end">
                            <div class="stat-card">
                                <div class="stat-icon icon-bg-primary">
                                    <i class="bi bi-bell-fill text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-dark">{{ $pengumuman->count() }}</strong>
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
                    id="searchAnnouncement" 
                    class="form-control search-box" 
                    placeholder="Cari pengumuman berdasarkan judul atau isi...">
            </div>
        </div>
        <div class="col-lg-4">
            <select id="sortBy" class="form-select sort-select">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="title_asc">Judul (A-Z)</option>
                <option value="title_desc">Judul (Z-A)</option>
            </select>
        </div>
    </div>
    
    <div class="filter-tabs">
        <div class="filter-tab active" data-filter="all">
            <i class="bi bi-grid-fill"></i>
            <span>Semua</span>
        </div>
        <div class="filter-tab" data-filter="semua">
            <i class="bi bi-people-fill"></i>
            <span>Untuk Semua</span>
        </div>
        <div class="filter-tab" data-filter="orangtua">
            <i class="bi bi-person-hearts"></i>
            <span>Untuk Orang Tua</span>
        </div>
        <div class="filter-tab" data-filter="recent">
            <i class="bi bi-clock-history"></i>
            <span>7 Hari Terakhir</span>
        </div>
    </div>
</div>

<!-- Announcements List -->
<div id="announcementContainer">
    @forelse($pengumuman as $index => $p)
    @php
        $isNew = $p->tanggal_publikasi->diffInDays(now()) <= 3;
        $iconClass = match($p->target) {
            'semua' => 'icon-bg-primary',
            'orangtua' => 'icon-bg-info',
            'siswa' => 'icon-bg-success',
            default => 'icon-bg-primary'
        };
        $priorityClass = $isNew ? 'priority-high' : 'priority-normal';
    @endphp
    <div class="announcement-card {{ $priorityClass }} animate-fade-in" 
         data-target="{{ $p->target }}"
         data-date="{{ $p->tanggal_publikasi->timestamp }}"
         data-title="{{ strtolower($p->judul) }}"
         data-content="{{ strtolower(strip_tags($p->isi)) }}"
         style="animation-delay: {{ $index * 0.1 }}s;">
        <div class="card-body p-4">
            <div class="row">
                <!-- Icon Section -->
                <div class="col-auto d-none d-md-block">
                    <div class="announcement-icon-wrapper {{ $iconClass }}">
                        <i class="bi bi-megaphone-fill text-white"></i>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="col">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <h5 class="announcement-title mb-0">{{ $p->judul }}</h5>
                                @if($isNew)
                                    <span class="new-badge">
                                        <i class="bi bi-star-fill"></i> BARU
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="target-badge badge-gradient-{{ $p->target_badge_color }}">
                                    <i class="bi bi-{{ $p->target === 'semua' ? 'people-fill' : ($p->target === 'orangtua' ? 'person-hearts' : 'mortarboard-fill') }}"></i>
                                    {{ $p->target_label }}
                                </span>
                                <span class="time-badge">
                                    <i class="bi bi-clock"></i>
                                    {{ $p->tanggal_publikasi->locale('id')->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="announcement-content">
                        <div class="content-preview" id="content-{{ $p->id }}">
                            {!! nl2br(e($p->isi)) !!}
                        </div>
                        @if(strlen($p->isi) > 300)
                            <div class="content-fade" id="fade-{{ $p->id }}"></div>
                            <button class="btn read-more-btn btn-sm" onclick="toggleContent({{ $p->id }})">
                                <i class="bi bi-chevron-down"></i>
                                <span id="btn-text-{{ $p->id }}">Baca Selengkapnya</span>
                            </button>
                        @endif
                    </div>

                    <!-- Meta Info -->
                    <div class="meta-info">
                        <div class="meta-item">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ $p->tanggal_publikasi_formatted }}</span>
                        </div>
                        @if($p->creator)
                        <div class="meta-item">
                            <i class="bi bi-person-badge"></i>
                            <span>{{ $p->creator->username }}</span>
                        </div>
                        @endif
                        <div class="meta-item">
                            <i class="bi bi-eye"></i>
                            <span>Pengumuman Resmi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-megaphone"></i>
        <h5 class="mt-4 text-muted">Belum Ada Pengumuman</h5>
        <p class="text-muted mb-0">
            Saat ini belum ada pengumuman yang dipublikasikan.<br>
            Pengumuman baru akan muncul di halaman ini.
        </p>
    </div>
    @endforelse
</div>

<!-- No Results Message -->
<div id="noResults" class="empty-state d-none">
    <i class="bi bi-search"></i>
    <h5 class="mt-4 text-muted">Tidak Ada Hasil</h5>
    <p class="text-muted mb-0">Tidak ditemukan pengumuman yang sesuai dengan pencarian Anda</p>
</div>
@endsection

@push('scripts')
<script>
// Toggle Read More
function toggleContent(id) {
    const content = document.getElementById(`content-${id}`);
    const fade = document.getElementById(`fade-${id}`);
    const btnText = document.getElementById(`btn-text-${id}`);
    const btn = event.target.closest('button');
    
    if (content.classList.contains('expanded')) {
        content.classList.remove('expanded');
        fade.style.display = 'block';
        btnText.textContent = 'Baca Selengkapnya';
        btn.innerHTML = '<i class="bi bi-chevron-down"></i> ' + btnText.outerHTML;
    } else {
        content.classList.add('expanded');
        fade.style.display = 'none';
        btnText.textContent = 'Tampilkan Lebih Sedikit';
        btn.innerHTML = '<i class="bi bi-chevron-up"></i> ' + btnText.outerHTML;
    }
}

$(document).ready(function() {
    const $announcementItems = $('.announcement-card');
    const $noResults = $('#noResults');
    const $searchInput = $('#searchAnnouncement');
    const $sortBy = $('#sortBy');
    const $filterTabs = $('.filter-tab');
    const $container = $('#announcementContainer');
    
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
    
    // Sort
    $sortBy.on('change', function() {
        sortAnnouncements();
    });
    
    function applyFilters() {
        const searchTerm = $searchInput.val().toLowerCase();
        let visibleCount = 0;
        const sevenDaysAgo = Date.now() / 1000 - (7 * 24 * 60 * 60);
        
        $announcementItems.each(function() {
            const $item = $(this);
            const target = $item.data('target');
            const date = $item.data('date');
            const title = $item.data('title');
            const content = $item.data('content');
            
            let show = true;
            
            // Search filter
            if (searchTerm && !title.includes(searchTerm) && !content.includes(searchTerm)) {
                show = false;
            }
            
            // Target filter
            if (currentFilter === 'semua' && target !== 'semua') {
                show = false;
            } else if (currentFilter === 'orangtua' && target !== 'orangtua') {
                show = false;
            } else if (currentFilter === 'recent' && date < sevenDaysAgo) {
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
        if (visibleCount === 0 && $announcementItems.length > 0) {
            $container.addClass('d-none');
            $noResults.removeClass('d-none');
        } else {
            $container.removeClass('d-none');
            $noResults.addClass('d-none');
        }
    }
    
    function sortAnnouncements() {
        const sortValue = $sortBy.val();
        const $items = $announcementItems.get();
        
        $items.sort(function(a, b) {
            const $a = $(a);
            const $b = $(b);
            
            switch(sortValue) {
                case 'newest':
                    return $b.data('date') - $a.data('date');
                case 'oldest':
                    return $a.data('date') - $b.data('date');
                case 'title_asc':
                    return $a.data('title').localeCompare($b.data('title'));
                case 'title_desc':
                    return $b.data('title').localeCompare($a.data('title'));
                default:
                    return 0;
            }
        });
        
        $.each($items, function(index, item) {
            $container.append(item);
            $(item).css('animation-delay', (index * 0.05) + 's');
        });
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
});
</script>
@endpush