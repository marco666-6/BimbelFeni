<!-- View: orangtua/jadwal-anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Jadwal Anak')
@section('page-title', 'Jadwal Pembelajaran - ' . $siswa->nama_lengkap)

@push('styles')
<style>
    .student-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .student-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }
    
    .student-profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    
    .filter-section {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 20px;
        padding: 1.5rem;
        border: 2px solid #e2e8f0;
    }
    
    .day-filter-chip {
        background: white;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 0.6rem 1.3rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .day-filter-chip:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .day-filter-chip.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .day-filter-chip.today-chip {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-color: transparent;
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        50% {
            box-shadow: 0 5px 25px rgba(16, 185, 129, 0.6);
        }
    }
    
    .schedule-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        background: white;
    }
    
    .schedule-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .schedule-card:hover {
        border-color: var(--primary-blue);
        transform: translateX(8px);
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.15);
    }
    
    .schedule-card:hover::before {
        transform: scaleY(1);
    }
    
    .schedule-card.today-schedule {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-color: #10b981;
    }
    
    .schedule-card.today-schedule::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transform: scaleY(1);
    }
    
    .subject-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .time-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid #fbbf24;
    }
    
    .duration-badge {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 2px solid #60a5fa;
    }
    
    .room-badge {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #9f1239;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 2px solid #f472b6;
    }
    
    .attendance-progress {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: #f1f5f9;
    }
    
    .attendance-progress::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        padding: 3px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
    }
    
    .stats-mini-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 18px;
        padding: 1.5rem;
        text-align: center;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stats-mini-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stats-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        border-color: var(--primary-blue);
    }
    
    .stats-mini-card:hover::before {
        opacity: 1;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 1rem;
    }
    
    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 6rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }
    
    .search-box {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.8rem 1.5rem;
        padding-left: 3rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .search-box:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    }
    
    .sort-dropdown {
        border-radius: 15px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .sort-dropdown:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    }
    
    .view-toggle-btn {
        padding: 0.7rem 1.2rem;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: white;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .view-toggle-btn:hover,
    .view-toggle-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    
    .timeline-view {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline-view::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
    
    .schedule-day-group {
        margin-bottom: 2rem;
    }
    
    .day-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.5s ease-out;
    }
    
    @media (max-width: 768px) {
        .day-filter-chip {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .stats-mini-card {
            margin-bottom: 1rem;
        }
        
        .schedule-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Student Header Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card student-header-card border-0 animate-fade-in">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="{{ $siswa->user->foto_profil_url }}" alt="{{ $siswa->nama_lengkap }}" class="student-profile-img">
                    </div>
                    <div class="col">
                        <h3 class="text-white mb-2 fw-bold">
                            <i class="bi bi-calendar-week-fill"></i> Jadwal Pembelajaran
                        </h3>
                        <h4 class="text-white mb-3">{{ $siswa->nama_lengkap }}</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-white text-dark px-3 py-2">
                                <i class="bi bi-mortarboard-fill text-primary"></i> {{ $siswa->jenjang }}
                            </span>
                            <span class="badge bg-white text-dark px-3 py-2">
                                <i class="bi bi-trophy-fill text-warning"></i> Kelas {{ $siswa->kelas }}
                            </span>
                            <span class="badge bg-white text-dark px-3 py-2">
                                <i class="bi bi-calendar-heart-fill text-danger"></i> {{ $siswa->usia }} Tahun
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('orangtua.anak') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($jadwal->isEmpty())
    <!-- Empty State -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 animate-fade-in">
                <div class="card-body empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <h4 class="text-muted mb-3">Belum Ada Jadwal</h4>
                    <p class="text-muted mb-4">Jadwal pembelajaran untuk {{ $siswa->nama_lengkap }} belum tersedia.<br>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    <a href="{{ route('orangtua.anak') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Data Anak
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="stats-mini-card animate-fade-in">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-calendar-check text-white"></i>
                </div>
                <h3 class="mb-1 fw-bold text-primary">{{ $jadwal->count() }}</h3>
                <small class="text-muted fw-semibold">Total Jadwal</small>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stats-mini-card animate-fade-in" style="animation-delay: 0.1s;">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-book text-white"></i>
                </div>
                <h3 class="mb-1 fw-bold text-danger">{{ $jadwal->unique('mata_pelajaran')->count() }}</h3>
                <small class="text-muted fw-semibold">Mata Pelajaran</small>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stats-mini-card animate-fade-in" style="animation-delay: 0.2s;">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="bi bi-clock-history text-white"></i>
                </div>
                <h3 class="mb-1 fw-bold text-info">{{ $jadwal->sum('durasi_menit') }}</h3>
                <small class="text-muted fw-semibold">Menit/Minggu</small>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="stats-mini-card animate-fade-in" style="animation-delay: 0.3s;">
                <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="bi bi-people text-white"></i>
                </div>
                <h3 class="mb-1 fw-bold text-success">{{ $jadwal->unique('nama_guru')->count() }}</h3>
                <small class="text-muted fw-semibold">Guru Pengajar</small>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-section animate-fade-in">
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute" style="left: 1.5rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.1rem;"></i>
                            <input type="text" id="searchInput" class="form-control search-box" placeholder="Cari mata pelajaran atau guru...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <select id="sortBy" class="form-select sort-dropdown">
                            <option value="hari">Urutkan: Hari</option>
                            <option value="waktu">Urutkan: Waktu</option>
                            <option value="mapel">Urutkan: Mata Pelajaran</option>
                            <option value="durasi">Urutkan: Durasi</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex gap-2">
                            <button class="btn view-toggle-btn active flex-fill" data-view="list">
                                <i class="bi bi-list-ul"></i> List
                            </button>
                            <button class="btn view-toggle-btn flex-fill" data-view="timeline">
                                <i class="bi bi-diagram-3"></i> Timeline
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Day Filter Chips -->
                <div class="d-flex flex-wrap gap-2">
                    <button class="day-filter-chip active" data-day="all">
                        <i class="bi bi-grid-fill"></i> Semua Hari
                    </button>
                    @php
                        $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $hariIni = now()->locale('id')->dayName;
                    @endphp
                    @foreach($hariUrutan as $hari)
                        @if($jadwal->where('hari', $hari)->count() > 0)
                            <button class="day-filter-chip {{ $hari === $hariIni ? 'today-chip' : '' }}" data-day="{{ $hari }}">
                                <i class="bi bi-calendar-day"></i> 
                                {{ $hari }}
                                @if($hari === $hariIni)
                                    <i class="bi bi-stars"></i>
                                @endif
                                <span class="badge bg-white text-dark ms-1">{{ $jadwal->where('hari', $hari)->count() }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule List View -->
    <div id="listView" class="row">
        @php
            $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $jadwalSorted = $jadwal->sortBy(function($item) use ($hariUrutan) {
                return array_search($item->hari, $hariUrutan);
            })->sortBy('jam_mulai');
        @endphp
        
        @foreach($jadwalSorted as $j)
        <div class="col-lg-6 mb-4 schedule-item animate-fade-in" 
             data-day="{{ $j->hari }}"
             data-mapel="{{ strtolower($j->mata_pelajaran) }}"
             data-guru="{{ strtolower($j->nama_guru) }}"
             data-waktu="{{ $j->jam_mulai }}"
             data-durasi="{{ $j->durasi_menit }}">
            <div class="card schedule-card {{ $j->isToday() ? 'today-schedule' : '' }} h-100">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex align-items-start mb-3">
                        <div class="subject-icon me-3">
                            <i class="bi bi-book-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-2 fw-bold">{{ $j->mata_pelajaran }}</h5>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-secondary">
                                    <i class="bi bi-calendar-day"></i> {{ $j->hari }}
                                </span>
                                @if($j->isToday())
                                    <span class="badge bg-success">
                                        <i class="bi bi-stars"></i> Hari Ini
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($j->total_pertemuan > 0)
                            <div class="attendance-progress">
                                <div class="text-center">
                                    <strong class="d-block text-success" style="font-size: 1.1rem;">{{ $j->persentase_kehadiran }}%</strong>
                                    <small class="text-muted" style="font-size: 0.7rem;">Hadir</small>
                                </div>
                            </div>
                        @else
                            <span class="badge bg-info">Baru</span>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-person-circle text-primary me-2" style="font-size: 1.2rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pengajar</small>
                                <strong>{{ $j->nama_guru }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Time & Room Info -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="time-badge">
                            <i class="bi bi-clock-fill"></i>
                            {{ $j->jam_formatted }}
                        </span>
                        <span class="duration-badge">
                            <i class="bi bi-hourglass-split"></i>
                            {{ $j->durasi_menit }} menit
                        </span>
                        @if($j->ruangan)
                            <span class="room-badge">
                                <i class="bi bi-door-open-fill"></i>
                                {{ $j->ruangan }}
                            </span>
                        @endif
                    </div>

                    <!-- Stats Footer -->
                    @if($j->total_pertemuan > 0)
                        <div class="mt-3 pt-3" style="border-top: 2px dashed #e2e8f0;">
                            <div class="row text-center">
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1">Total Pertemuan</small>
                                    <strong class="text-primary">{{ $j->total_pertemuan }}x</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1">Kehadiran</small>
                                    <strong class="text-success">{{ $j->kehadiran()->hadir()->count() }}x</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Timeline View (Initially Hidden) -->
    <div id="timelineView" class="d-none">
        @php
            $jadwalByDay = $jadwal->groupBy('hari')->sortBy(function($group, $hari) use ($hariUrutan) {
                return array_search($hari, $hariUrutan);
            });
        @endphp
        
        @foreach($jadwalByDay as $hari => $jadwalHari)
            <div class="schedule-day-group schedule-item animate-fade-in" data-day="{{ $hari }}">
                <div class="day-header">
                    <i class="bi bi-calendar-day-fill"></i>
                    {{ $hari }}
                    @if($hari === $hariIni)
                        <span class="badge bg-white text-success ms-2">
                            <i class="bi bi-stars"></i> Hari Ini
                        </span>
                    @endif
                    <span class="badge bg-white bg-opacity-25 ms-auto">{{ $jadwalHari->count() }} jadwal</span>
                </div>
                
                <div class="timeline-view">
                    @foreach($jadwalHari->sortBy('jam_mulai') as $j)
                        <div class="schedule-item mb-3" 
                             data-day="{{ $j->hari }}"
                             data-mapel="{{ strtolower($j->mata_pelajaran) }}"
                             data-guru="{{ strtolower($j->nama_guru) }}">
                            <div class="card schedule-card {{ $j->isToday() ? 'today-schedule' : '' }}">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="subject-icon" style="width: 50px; height: 50px;">
                                                <i class="bi bi-book-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-1 fw-bold">{{ $j->mata_pelajaran }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-person"></i> {{ $j->nama_guru }}
                                            </small>
                                        </div>
                                        <div class="col-auto text-end">
                                            <span class="time-badge d-inline-block mb-2">
                                                <i class="bi bi-clock-fill"></i>
                                                {{ $j->jam_formatted }}
                                            </span>
                                            <div>
                                                <span class="duration-badge me-1">
                                                    {{ $j->durasi_menit }} menit
                                                </span>
                                                @if($j->ruangan)
                                                    <span class="room-badge">
                                                        {{ $j->ruangan }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="row d-none">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body empty-state">
                    <i class="bi bi-search"></i>
                    <h5 class="mt-3 text-muted">Tidak Ada Hasil</h5>
                    <p class="text-muted mb-0">Tidak ditemukan jadwal yang sesuai dengan filter Anda</p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $scheduleItems = $('.schedule-item');
    const $noResults = $('#noResults');
    const $searchInput = $('#searchInput');
    const $sortBy = $('#sortBy');
    const $dayFilters = $('.day-filter-chip');
    const $viewToggles = $('.view-toggle-btn');
    const $listView = $('#listView');
    const $timelineView = $('#timelineView');
    
    let currentDay = 'all';
    let currentView = 'list';
    
    // Animate items on load
    $('.schedule-item').each(function(index) {
        $(this).css('animation-delay', (index * 0.05) + 's');
    });
    
    // Day Filter
    $dayFilters.on('click', function() {
        $dayFilters.removeClass('active');
        $(this).addClass('active');
        currentDay = $(this).data('day');
        applyFilters();
    });
    
    // Search
    $searchInput.on('keyup', debounce(function() {
        applyFilters();
    }, 300));
    
    // Sort
    $sortBy.on('change', function() {
        sortSchedules();
    });
    
    // View Toggle
    $viewToggles.on('click', function() {
        const view = $(this).data('view');
        
        $viewToggles.removeClass('active');
        $(this).addClass('active');
        
        if (view === 'list') {
            $timelineView.addClass('d-none');
            $listView.removeClass('d-none');
            currentView = 'list';
        } else {
            $listView.addClass('d-none');
            $timelineView.removeClass('d-none');
            currentView = 'timeline';
        }
        
        applyFilters();
    });
    
    function applyFilters() {
        const searchTerm = $searchInput.val().toLowerCase();
        let visibleCount = 0;
        
        const $items = currentView === 'list' 
            ? $listView.find('.schedule-item') 
            : $timelineView.find('.schedule-day-group');
        
        $items.each(function() {
            const $item = $(this);
            let show = true;
            
            if (currentView === 'list') {
                const day = $item.data('day');
                const mapel = $item.data('mapel');
                const guru = $item.data('guru');
                
                // Day filter
                if (currentDay !== 'all' && day !== currentDay) {
                    show = false;
                }
                
                // Search filter
                if (searchTerm && !mapel.includes(searchTerm) && !guru.includes(searchTerm)) {
                    show = false;
                }
            } else {
                // Timeline view - filter by day
                const day = $item.data('day');
                
                if (currentDay !== 'all' && day !== currentDay) {
                    show = false;
                } else if (searchTerm) {
                    // Search within this day's schedules
                    let hasMatch = false;
                    $item.find('.schedule-item').each(function() {
                        const mapel = $(this).data('mapel');
                        const guru = $(this).data('guru');
                        if (mapel.includes(searchTerm) || guru.includes(searchTerm)) {
                            hasMatch = true;
                            $(this).removeClass('d-none');
                        } else {
                            $(this).addClass('d-none');
                        }
                    });
                    show = hasMatch;
                }
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
            $listView.addClass('d-none');
            $timelineView.addClass('d-none');
        } else {
            $noResults.addClass('d-none');
            if (currentView === 'list') {
                $listView.removeClass('d-none');
            } else {
                $timelineView.removeClass('d-none');
            }
        }
    }
    
    function sortSchedules() {
        if (currentView !== 'list') return; // Only sort in list view
        
        const sortValue = $sortBy.val();
        const $container = $listView;
        const $items = $container.find('.schedule-item').get();
        
        $items.sort(function(a, b) {
            const $a = $(a);
            const $b = $(b);
            
            switch(sortValue) {
                case 'hari':
                    const hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    const indexA = hariUrutan.indexOf($a.data('day'));
                    const indexB = hariUrutan.indexOf($b.data('day'));
                    if (indexA !== indexB) return indexA - indexB;
                    // If same day, sort by time
                    return $a.data('waktu').localeCompare($b.data('waktu'));
                    
                case 'waktu':
                    return $a.data('waktu').localeCompare($b.data('waktu'));
                    
                case 'mapel':
                    return $a.data('mapel').localeCompare($b.data('mapel'));
                    
                case 'durasi':
                    return parseInt($b.data('durasi')) - parseInt($a.data('durasi'));
                    
                default:
                    return 0;
            }
        });
        
        $.each($items, function(index, item) {
            $container.append(item);
        });
        
        // Re-animate
        $('.schedule-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.03) + 's');
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
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Highlight today's chip on load
    const todayChip = $('.day-filter-chip.today-chip');
    if (todayChip.length > 0 && currentDay === 'all') {
        // Optional: Auto-select today on load
        // todayChip.click();
    }
    
    // Smooth scroll animations
    $(window).on('scroll', function() {
        $('.schedule-card').each(function() {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate-fade-in');
            }
        });
    });
    
    // Print functionality (bonus feature)
    window.printSchedule = function() {
        window.print();
    };
    
    // Export to calendar functionality placeholder
    window.exportToCalendar = function() {
        Swal.fire({
            icon: 'info',
            title: 'Fitur Export',
            text: 'Fitur export ke kalender akan segera tersedia!',
            confirmButtonText: 'OK',
            confirmButtonColor: '#667eea',
            customClass: {
                popup: 'rounded-4'
            }
        });
    };
});

// Print styles
const printStyles = `
    @media print {
        .sidebar, .navbar-custom, .btn, .filter-section, .view-toggle-btn {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
        .card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .schedule-card {
            border: 1px solid #000 !important;
            margin-bottom: 1rem !important;
        }
    }
`;

// Add print styles to document
const styleSheet = document.createElement("style");
styleSheet.textContent = printStyles;
document.head.appendChild(styleSheet);
</script>
@endpush