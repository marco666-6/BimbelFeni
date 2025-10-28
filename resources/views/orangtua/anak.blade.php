<!-- View: orangtua/anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Data Anak')
@section('page-title', 'Data Anak')

@push('styles')
<style>
    .filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        overflow: hidden;
    }
    
    .filter-chip {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .filter-chip:hover,
    .filter-chip.active {
        background: white;
        color: var(--primary-blue);
        border-color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .child-card-enhanced {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .child-card-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .child-card-enhanced:hover {
        border-color: var(--primary-blue);
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
    }
    
    .child-card-enhanced:hover::before {
        transform: scaleX(1);
    }
    
    .profile-image-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
    }
    
    .profile-image-wrapper::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        z-index: -1;
    }
    
    .profile-image-wrapper img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
    }
    
    .stat-mini-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .stat-mini-card:hover {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-color: var(--primary-blue);
        transform: translateY(-3px);
    }
    
    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    .progress-circle-wrapper {
        position: relative;
        width: 70px;
        height: 70px;
    }
    
    .progress-ring {
        transform: rotate(-90deg);
    }
    
    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s ease;
    }
    
    .action-button {
        transition: all 0.3s ease;
        border-radius: 12px;
        font-weight: 600;
        padding: 0.7rem 1.2rem;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .transaction-badge {
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .search-box {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }
    
    .empty-state {
        padding: 4rem 2rem;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
    }
    
    .sort-dropdown {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }
    
    .sort-dropdown:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card filter-card border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h4 class="text-white mb-2"><i class="bi bi-people-fill"></i> Monitoring Anak</h4>
                        <p class="text-white opacity-90 mb-0">Pantau perkembangan dan prestasi anak Anda</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-inline-block bg-white bg-opacity-25 rounded-3 px-4 py-2">
                            <span class="text-white fw-bold">Total: {{ $siswa->count() }} Anak</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-lg-5">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute" style="left: 1.5rem; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                            <input type="text" id="searchInput" class="form-control search-box ps-5" placeholder="Cari nama anak...">
                        </div>
                    </div>
                    
                    <!-- Filter by Jenjang -->
                    <div class="col-lg-3">
                        <select id="filterJenjang" class="form-select sort-dropdown">
                            <option value="">Semua Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                        </select>
                    </div>
                    
                    <!-- Sort by -->
                    <div class="col-lg-4">
                        <select id="sortBy" class="form-select sort-dropdown">
                            <option value="nama_asc">Nama (A-Z)</option>
                            <option value="nama_desc">Nama (Z-A)</option>
                            <option value="nilai_desc">Nilai Tertinggi</option>
                            <option value="nilai_asc">Nilai Terendah</option>
                            <option value="kehadiran_desc">Kehadiran Tertinggi</option>
                            <option value="kehadiran_asc">Kehadiran Terendah</option>
                        </select>
                    </div>
                </div>
                
                <!-- Quick Filter Chips -->
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <span class="text-dark filter-chip active" data-filter="all">
                        <i class="bi bi-grid-fill"></i> Semua
                    </span>
                    <span class="text-dark filter-chip" data-filter="aktif">
                        <i class="bi bi-check-circle"></i> Aktif
                    </span>
                    <span class="text-dark filter-chip" data-filter="nilai-tinggi">
                        <i class="bi bi-star-fill"></i> Nilai Tinggi (≥80)
                    </span>
                    <span class="text-dark filter-chip" data-filter="perlu-perhatian">
                        <i class="bi bi-exclamation-triangle"></i> Perlu Perhatian
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Children Cards -->
<div class="row" id="childrenContainer">
    @forelse($siswa as $s)
    <div class="col-xl-6 mb-4 child-item animate-fade-in" 
         data-nama="{{ strtolower($s->nama_lengkap) }}"
         data-jenjang="{{ $s->jenjang }}"
         data-status="{{ $s->user->status }}"
         data-nilai="{{ $s->rata_nilai }}"
         data-kehadiran="{{ $s->persentase_kehadiran }}">
        <div class="card child-card-enhanced h-100">
            <div class="card-body p-4">
                <!-- Header with Profile -->
                <div class="d-flex align-items-start mb-4">
                    <div class="profile-image-wrapper me-3">
                        <img src="{{ $s->user->foto_profil_url }}" alt="Foto {{ $s->nama_lengkap }}">
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-2 fw-bold">{{ $s->nama_lengkap }}</h5>
                        <p class="text-muted mb-2 small">
                            <i class="bi bi-envelope-fill"></i> {{ $s->user->email }}
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-book"></i> {{ $s->jenjang }}
                            </span>
                            <span class="badge bg-secondary">
                                <i class="bi bi-mortarboard"></i> Kelas {{ $s->kelas }}
                            </span>
                            <span class="badge bg-info">
                                <i class="bi bi-calendar-heart"></i> {{ $s->usia }} tahun
                            </span>
                            <span class="badge bg-{{ $s->user->isAktif() ? 'success' : 'danger' }}">
                                <i class="bi bi-{{ $s->user->isAktif() ? 'check-circle' : 'x-circle' }}"></i> 
                                {{ ucfirst($s->user->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="row g-3 mb-4">
                    <!-- Kehadiran -->
                    <div class="col-6">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
                                    <i class="bi bi-calendar-check text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Kehadiran</small>
                                    <h5 class="mb-0 fw-bold">{{ number_format($s->persentase_kehadiran, 0) }}%</h5>
                                    <small class="text-muted">{{ $s->kehadiran()->hadir()->count() }}/{{ $s->kehadiran()->count() }}</small>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar {{ $s->persentase_kehadiran >= 80 ? 'bg-success' : ($s->persentase_kehadiran >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                     style="width: {{ $s->persentase_kehadiran }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nilai -->
                    <div class="col-6">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                                    <i class="bi bi-trophy-fill text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Rata-rata Nilai</small>
                                    <h5 class="mb-0 fw-bold text-primary">{{ number_format($s->rata_nilai, 1) }}</h5>
                                    <small class="text-muted">
                                        @php
                                            $nilai = $s->rata_nilai;
                                            $grade = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : ($nilai >= 60 ? 'D' : 'E')));
                                        @endphp
                                        Grade: <strong>{{ $grade }}</strong>
                                    </small>
                                </div>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ min($s->rata_nilai, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tugas Selesai -->
                    <div class="col-6">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                                    <i class="bi bi-file-earmark-check-fill text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tugas Selesai</small>
                                    <h5 class="mb-0 fw-bold text-success">{{ $s->total_tugas_terkumpul }}</h5>
                                    <small class="text-muted">Terkumpul</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tugas Tertunda -->
                    <div class="col-6">
                        <div class="stat-mini-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                                    <i class="bi bi-hourglass-split text-danger"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tugas Tertunda</small>
                                    <h5 class="mb-0 fw-bold text-danger">{{ $s->tugas_tertunda }}</h5>
                                    <small class="text-muted">Belum selesai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Info -->
                @php
                    $lastTransaction = $s->transaksi()->latest('tanggal_transaksi')->first();
                @endphp
                @if($lastTransaction)
                <div class="mb-4 p-3 rounded" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-receipt"></i> Transaksi Terakhir
                            </small>
                            <strong class="text-dark">{{ $lastTransaction->paketBelajar->nama_paket }}</strong>
                            <small class="text-muted d-block">{{ $lastTransaction->tanggal_transaksi->locale('id')->diffForHumans() }}</small>
                        </div>
                        <span class="transaction-badge bg-{{ $lastTransaction->status_badge_color }}">
                            {{ $lastTransaction->status_label }}
                        </span>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.anak.detail', $s->id) }}" class="btn btn-primary action-button">
                        <i class="bi bi-eye-fill"></i> Lihat Perkembangan Detail
                    </a>
                    <div class="row g-2">
                        <div class="col-4">
                            <a href="{{ route('orangtua.anak.jadwal', $s->id) }}" class="btn btn-outline-info action-button w-100" title="Lihat Jadwal">
                                <i class="bi bi-calendar-week"></i>
                                <span class="d-none d-lg-inline ms-1">Jadwal</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('orangtua.anak.rapor', $s->id) }}" class="btn btn-outline-success action-button w-100" title="Lihat Rapor">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="d-none d-lg-inline ms-1">Rapor</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('orangtua.anak.log-activity', $s->id) }}" class="btn btn-outline-secondary action-button w-100" title="Log Activity">
                                <i class="bi bi-activity"></i>
                                <span class="d-none d-lg-inline ms-1">Activity</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body empty-state text-center">
                <i class="bi bi-inbox"></i>
                <h5 class="mt-3 text-muted">Belum Ada Data Anak</h5>
                <p class="text-muted mb-4">Anda belum memiliki anak yang terdaftar di sistem</p>
                <a href="{{ route('orangtua.paket-belajar') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Daftarkan Anak Sekarang
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- No Results Message -->
<div id="noResults" class="row d-none">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body empty-state text-center">
                <i class="bi bi-search"></i>
                <h5 class="mt-3 text-muted">Tidak Ada Hasil</h5>
                <p class="text-muted mb-0">Tidak ditemukan anak yang sesuai dengan filter Anda</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $childItems = $('.child-item');
    const $noResults = $('#noResults');
    const $searchInput = $('#searchInput');
    const $filterJenjang = $('#filterJenjang');
    const $sortBy = $('#sortBy');
    const $filterChips = $('.filter-chip');
    
    let currentFilter = 'all';
    
    // Animate cards on load
    $('.child-item').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Filter Chips
    $filterChips.on('click', function() {
        $filterChips.removeClass('active');
        $(this).addClass('active');
        currentFilter = $(this).data('filter');
        applyFilters();
    });
    
    // Search
    $searchInput.on('keyup', debounce(function() {
        applyFilters();
    }, 300));
    
    // Filter Jenjang
    $filterJenjang.on('change', function() {
        applyFilters();
    });
    
    // Sort
    $sortBy.on('change', function() {
        sortChildren();
    });
    
    function applyFilters() {
        const searchTerm = $searchInput.val().toLowerCase();
        const jenjang = $filterJenjang.val();
        let visibleCount = 0;
        
        $childItems.each(function() {
            const $item = $(this);
            const nama = $item.data('nama');
            const itemJenjang = $item.data('jenjang');
            const status = $item.data('status');
            const nilai = parseFloat($item.data('nilai'));
            const kehadiran = parseFloat($item.data('kehadiran'));
            
            let show = true;
            
            // Search filter
            if (searchTerm && !nama.includes(searchTerm)) {
                show = false;
            }
            
            // Jenjang filter
            if (jenjang && itemJenjang !== jenjang) {
                show = false;
            }
            
            // Quick filter
            if (currentFilter === 'aktif' && status !== 'aktif') {
                show = false;
            } else if (currentFilter === 'nilai-tinggi' && nilai < 80) {
                show = false;
            } else if (currentFilter === 'perlu-perhatian' && (nilai >= 70 && kehadiran >= 70)) {
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
        if (visibleCount === 0) {
            $noResults.removeClass('d-none');
        } else {
            $noResults.addClass('d-none');
        }
    }
    
    function sortChildren() {
        const sortValue = $sortBy.val();
        const $container = $('#childrenContainer');
        const $items = $childItems.get();
        
        $items.sort(function(a, b) {
            const $a = $(a);
            const $b = $(b);
            
            switch(sortValue) {
                case 'nama_asc':
                    return $a.data('nama').localeCompare($b.data('nama'));
                case 'nama_desc':
                    return $b.data('nama').localeCompare($a.data('nama'));
                case 'nilai_desc':
                    return parseFloat($b.data('nilai')) - parseFloat($a.data('nilai'));
                case 'nilai_asc':
                    return parseFloat($a.data('nilai')) - parseFloat($b.data('nilai'));
                case 'kehadiran_desc':
                    return parseFloat($b.data('kehadiran')) - parseFloat($a.data('kehadiran'));
                case 'kehadiran_asc':
                    return parseFloat($a.data('kehadiran')) - parseFloat($b.data('kehadiran'));
                default:
                    return 0;
            }
        });
        
        $.each($items, function(index, item) {
            $container.append(item);
        });
        
        // Re-animate
        $('.child-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.05) + 's');
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
    
    // Tooltip initialization
    $('[title]').tooltip();
});
</script>
@endpush