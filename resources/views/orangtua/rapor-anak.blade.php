<!-- View: orangtua/rapor-anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Rapor ' . $siswa->nama_lengkap)
@section('page-title', 'Rapor - ' . $siswa->nama_lengkap)

@push('styles')
<style>
    .rapor-header-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .rapor-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }
    
    .student-profile-card {
        background: white;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .student-profile-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }
    
    .student-avatar-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
    }
    
    .student-avatar-wrapper::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        z-index: -1;
    }
    
    .student-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .period-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .section-card {
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 1.5rem;
        background: white;
        transition: all 0.3s ease;
    }
    
    .section-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
    }
    
    .section-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        padding: 1.2rem 1.5rem;
        border-bottom: 2px solid #bfdbfe;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    .icon-attendance {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .icon-grades {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .stat-box {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
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
        right: 0;
        height: 4px;
    }
    
    .stat-box.stat-primary::before {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .stat-box.stat-success::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }
    
    .stat-box.stat-warning::before {
        background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
    }
    
    .stat-box.stat-danger::before {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-blue);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .table-enhanced {
        margin: 0;
    }
    
    .table-enhanced thead {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
    }
    
    .table-enhanced thead th {
        font-weight: 600;
        color: #475569;
        padding: 1rem;
        border: none;
    }
    
    .table-enhanced tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-enhanced tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        transform: scale(1.01);
    }
    
    .table-enhanced tbody td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .grade-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .grade-A {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .grade-B {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .grade-C {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .grade-D {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .grade-E {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
    }
    
    .progress-ring {
        transform: rotate(-90deg);
    }
    
    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s ease;
    }
    
    .chart-wrapper {
        position: relative;
        height: 300px;
    }
    
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 15px;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    
    .back-button {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        color: #64748b;
    }
    
    .back-button:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-color: var(--primary-blue);
        color: var(--primary-blue);
        transform: translateX(-5px);
    }
    
    .download-button {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 12px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .download-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    .performance-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .performance-excellent {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .performance-good {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }
    
    .performance-average {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .performance-poor {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .attendance-calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .calendar-day {
        aspect-ratio: 1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .calendar-day:hover {
        transform: scale(1.1);
    }
    
    .day-present {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .day-absent {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .day-excused {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
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
    }
    
    .filter-tab:hover {
        border-color: #4facfe;
        color: #4facfe;
        transform: translateY(-2px);
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card rapor-header-card border-0">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="student-avatar-wrapper">
                            <img src="{{ $siswa->user->foto_profil_url }}" 
                                 alt="{{ $siswa->nama_lengkap }}" 
                                 class="student-avatar">
                        </div>
                        <div class="text-white">
                            <h4 class="mb-1 fw-bold">📋 Rapor Siswa</h4>
                            <h5 class="mb-1">{{ $siswa->nama_lengkap }}</h5>
                            <p class="mb-0 opacity-90">
                                <i class="bi bi-mortarboard-fill"></i> 
                                {{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="download-button">
                            <i class="bi bi-download"></i> Download PDF
                        </button>
                        <a href="{{ route('orangtua.anak') }}" class="back-button">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Period & Performance Overview -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="student-profile-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-range text-primary"></i> Periode Laporan
                    </h6>
                    <span class="period-badge">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->isoFormat('MMMM YYYY') }}
                    </span>
                </div>
                
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-badge text-primary"></i>
                            <div>
                                <small class="text-muted d-block">NIS</small>
                                <strong>{{ $siswa->id }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cake text-primary"></i>
                            <div>
                                <small class="text-muted d-block">Usia</small>
                                <strong>{{ $siswa->usia }} tahun</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="student-profile-card h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h6 class="mb-3 fw-bold text-center">
                    <i class="bi bi-graph-up text-success"></i> Performa Keseluruhan
                </h6>
                @php
                    $avgScore = $siswa->rata_nilai;
                    $performance = $avgScore >= 85 ? 'excellent' : ($avgScore >= 75 ? 'good' : ($avgScore >= 60 ? 'average' : 'poor'));
                    $performanceText = $avgScore >= 85 ? 'Sangat Baik' : ($avgScore >= 75 ? 'Baik' : ($avgScore >= 60 ? 'Cukup' : 'Perlu Perbaikan'));
                    $performanceIcon = $avgScore >= 85 ? 'emoji-smile' : ($avgScore >= 75 ? 'emoji-neutral' : ($avgScore >= 60 ? 'emoji-frown' : 'emoji-dizzy'));
                @endphp
                <div class="text-center">
                    <div class="performance-indicator performance-{{ $performance }} d-inline-flex mx-auto">
                        <i class="bi bi-{{ $performanceIcon }}"></i>
                        <span>{{ $performanceText }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Section -->
<div class="section-card animate-fade-in">
    <div class="section-header">
        <h5 class="section-title">
            <div class="section-icon icon-attendance">
                <i class="bi bi-clipboard-check-fill text-white"></i>
            </div>
            Rekapitulasi Kehadiran
        </h5>
    </div>
    <div class="card-body p-4">
        @if($kehadiranBulanIni->isEmpty())
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <h6 class="text-muted mt-3">Belum Ada Data Kehadiran</h6>
                <p class="text-muted mb-0">Data kehadiran untuk bulan ini belum tersedia</p>
            </div>
        @else
            @php
                $totalPertemuan = $kehadiranBulanIni->count();
                $totalHadir = $kehadiranBulanIni->where('status', 'hadir')->count();
                $totalSakitIzin = $kehadiranBulanIni->whereIn('status', ['sakit', 'izin'])->count();
                $totalAlpha = $kehadiranBulanIni->where('status', 'alpha')->count();
                $persentaseHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 1) : 0;
            @endphp
            
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-primary">
                        <div class="stat-value text-primary">{{ $totalPertemuan }}</div>
                        <div class="stat-label">Total Pertemuan</div>
                        <div class="mt-2">
                            <i class="bi bi-calendar-week text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-success">
                        <div class="stat-value text-success">{{ $totalHadir }}</div>
                        <div class="stat-label">Hadir</div>
                        <div class="mt-2">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                        <small class="text-success fw-bold mt-1 d-block">{{ $persentaseHadir }}%</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-warning">
                        <div class="stat-value text-warning">{{ $totalSakitIzin }}</div>
                        <div class="stat-label">Sakit / Izin</div>
                        <div class="mt-2">
                            <i class="bi bi-bandaid text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-danger">
                        <div class="stat-value text-danger">{{ $totalAlpha }}</div>
                        <div class="stat-label">Alpha</div>
                        <div class="mt-2">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <div class="filter-tab active" data-filter="all">
                    <i class="bi bi-grid"></i> Semua
                </div>
                <div class="filter-tab" data-filter="hadir">
                    <i class="bi bi-check-circle"></i> Hadir
                </div>
                <div class="filter-tab" data-filter="sakit">
                    <i class="bi bi-bandaid"></i> Sakit/Izin
                </div>
                <div class="filter-tab" data-filter="alpha">
                    <i class="bi bi-x-circle"></i> Alpha
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-responsive">
                <table class="table table-enhanced">
                    <thead>
                        <tr>
                            <th><i class="bi bi-calendar3"></i> Tanggal</th>
                            <th><i class="bi bi-book"></i> Mata Pelajaran</th>
                            <th><i class="bi bi-check-square"></i> Status</th>
                            <th><i class="bi bi-chat-left-text"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        @foreach($kehadiranBulanIni as $k)
                        <tr class="attendance-row" data-status="{{ $k->status }}">
                            <td>
                                <strong>{{ $k->tanggal_pertemuan->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $k->jadwal->mata_pelajaran }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $k->status_badge_color }} px-3 py-2">
                                    <i class="bi bi-{{ $k->status === 'hadir' ? 'check-circle' : ($k->status === 'alpha' ? 'x-circle' : 'exclamation-circle') }}"></i>
                                    {{ $k->status_label }}
                                </span>
                            </td>
                            <td>
                                <em class="text-muted">{{ $k->keterangan ?: 'Tidak ada keterangan' }}</em>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Grades Section -->
<div class="section-card animate-fade-in" style="animation-delay: 0.1s;">
    <div class="section-header">
        <h5 class="section-title">
            <div class="section-icon icon-grades">
                <i class="bi bi-award-fill text-white"></i>
            </div>
            Rekapitulasi Nilai Tugas
        </h5>
    </div>
    <div class="card-body p-4">
        @if($nilaiTugasBulanIni->isEmpty())
            <div class="empty-state">
                <i class="bi bi-clipboard-x"></i>
                <h6 class="text-muted mt-3">Belum Ada Nilai Tugas</h6>
                <p class="text-muted mb-0">Nilai tugas untuk bulan ini belum tersedia</p>
            </div>
        @else
            @php
                $rataNilai = $nilaiTugasBulanIni->avg('nilai');
                $nilaiTertinggi = $nilaiTugasBulanIni->max('nilai');
                $nilaiTerendah = $nilaiTugasBulanIni->min('nilai');
                $totalTugas = $nilaiTugasBulanIni->count();
            @endphp

            <!-- Grade Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-primary">
                        <div class="stat-value text-primary">{{ number_format($rataNilai, 1) }}</div>
                        <div class="stat-label">Rata-rata Nilai</div>
                        <div class="mt-2">
                            <i class="bi bi-graph-up text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-success">
                        <div class="stat-value text-success">{{ $nilaiTertinggi }}</div>
                        <div class="stat-label">Nilai Tertinggi</div>
                        <div class="mt-2">
                            <i class="bi bi-trophy-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-danger">
                        <div class="stat-value text-danger">{{ $nilaiTerendah }}</div>
                        <div class="stat-label">Nilai Terendah</div>
                        <div class="mt-2">
                            <i class="bi bi-arrow-down-circle-fill text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-box stat-warning">
                        <div class="stat-value text-warning">{{ $totalTugas }}</div>
                        <div class="stat-label">Total Tugas</div>
                        <div class="mt-2">
                            <i class="bi bi-file-earmark-text-fill text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grades Table -->
            <div class="table-responsive">
                <table class="table table-enhanced">
                    <thead>
                        <tr>
                            <th><i class="bi bi-calendar3"></i> Tanggal</th>
                            <th><i class="bi bi-book"></i> Mata Pelajaran</th>
                            <th><i class="bi bi-file-text"></i> Judul Tugas</th>
                            <th width="10%"><i class="bi bi-award"></i> Nilai</th>
                            <th><i class="bi bi-star"></i> Grade</th>
                            <th><i class="bi bi-chat-left-quote"></i> Feedback Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilaiTugasBulanIni as $n)
                        <tr>
                            <td>
                                <strong>{{ $n->tanggal_pengumpulan->locale('id')->isoFormat('D MMM Y') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $n->materiTugas->mata_pelajaran }}</span>
                            </td>
                            <td>
                                <strong class="text-dark">{{ $n->materiTugas->judul }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <strong class="text-primary" style="font-size: 1.3rem;">{{ $n->nilai }}</strong>
                                </div>
                            </td>
                            <td>
                                @php
                                    $gradeClass = 'grade-' . substr($n->grade_label, 0, 1);
                                @endphp
                                <div class="grade-badge {{ $gradeClass }}">
                                    {{ $n->grade_label }}
                                </div>
                            </td>
                            <td>
                                @if($n->feedback_guru)
                                    <div class="p-2 rounded" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);">
                                        <small class="text-dark">{{ $n->feedback_guru }}</small>
                                    </div>
                                @else
                                    <em class="text-muted">Belum ada feedback</em>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grade Distribution -->
            <div class="mt-4 p-4 rounded" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);">
                <h6 class="mb-3 fw-bold">
                    <i class="bi bi-pie-chart text-primary"></i> Distribusi Grade
                </h6>
                <div class="row g-3">
                    @php
                        $gradeA = $nilaiTugasBulanIni->filter(fn($n) => $n->nilai >= 90)->count();
                        $gradeB = $nilaiTugasBulanIni->filter(fn($n) => $n->nilai >= 75 && $n->nilai < 90)->count();
                        $gradeC = $nilaiTugasBulanIni->filter(fn($n) => $n->nilai >= 60 && $n->nilai < 75)->count();
                        $gradeD = $nilaiTugasBulanIni->filter(fn($n) => $n->nilai >= 50 && $n->nilai < 60)->count();
                        $gradeE = $nilaiTugasBulanIni->filter(fn($n) => $n->nilai < 50)->count();
                    @endphp
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="grade-badge grade-A mb-2 mx-auto">A</div>
                            <strong class="d-block">{{ $gradeA }}</strong>
                            <small class="text-muted">≥ 90</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="grade-badge grade-B mb-2 mx-auto">B</div>
                            <strong class="d-block">{{ $gradeB }}</strong>
                            <small class="text-muted">75-89</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="grade-badge grade-C mb-2 mx-auto">C</div>
                            <strong class="d-block">{{ $gradeC }}</strong>
                            <small class="text-muted">60-74</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="grade-badge grade-D mb-2 mx-auto">D</div>
                            <strong class="d-block">{{ $gradeD }}</strong>
                            <small class="text-muted">50-59</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="grade-badge grade-E mb-2 mx-auto">E</div>
                            <strong class="d-block">{{ $gradeE }}</strong>
                            <small class="text-muted">< 50</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="text-center">
                            <div class="stat-box stat-primary p-3">
                                <strong style="font-size: 1.5rem;">{{ $totalTugas }}</strong>
                                <small class="d-block text-muted">Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Summary & Recommendations -->
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-body p-4">
                <h6 class="mb-3 fw-bold">
                    <i class="bi bi-lightbulb text-warning"></i> Catatan & Rekomendasi
                </h6>
                <div class="p-3 rounded" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    @if($siswa->rata_nilai >= 85)
                        <p class="mb-2"><strong>Prestasi Sangat Baik! 🎉</strong></p>
                        <small class="text-dark">
                            Siswa menunjukkan performa yang sangat baik. Pertahankan konsistensi belajar dan terus tingkatkan kemampuan.
                        </small>
                    @elseif($siswa->rata_nilai >= 75)
                        <p class="mb-2"><strong>Prestasi Baik! 👍</strong></p>
                        <small class="text-dark">
                            Siswa menunjukkan performa yang baik. Tingkatkan lagi dengan fokus pada mata pelajaran yang masih lemah.
                        </small>
                    @elseif($siswa->rata_nilai >= 60)
                        <p class="mb-2"><strong>Performa Cukup ⚠️</strong></p>
                        <small class="text-dark">
                            Siswa perlu meningkatkan usaha belajar. Disarankan untuk lebih aktif bertanya dan mengerjakan latihan tambahan.
                        </small>
                    @else
                        <p class="mb-2"><strong>Perlu Perhatian Khusus! ⚠️</strong></p>
                        <small class="text-dark">
                            Siswa memerlukan bimbingan ekstra. Orang tua dan guru perlu bekerja sama untuk membantu peningkatan prestasi.
                        </small>
                    @endif
                </div>
                
                @if(!$kehadiranBulanIni->isEmpty())
                    @php
                        $persentaseHadir = $kehadiranBulanIni->count() > 0 
                            ? round(($kehadiranBulanIni->where('status', 'hadir')->count() / $kehadiranBulanIni->count()) * 100, 1) 
                            : 0;
                    @endphp
                    @if($persentaseHadir < 80)
                        <div class="mt-3 p-3 rounded" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                            <p class="mb-1"><strong><i class="bi bi-exclamation-triangle"></i> Perhatian Kehadiran</strong></p>
                            <small class="text-dark">
                                Tingkat kehadiran {{ $persentaseHadir }}% masih di bawah standar. Kehadiran yang konsisten sangat penting untuk prestasi akademik.
                            </small>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-body p-4">
                <h6 class="mb-3 fw-bold">
                    <i class="bi bi-graph-up-arrow text-success"></i> Ringkasan Performa
                </h6>
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-award text-warning"></i> Rata-rata Nilai</span>
                        <strong class="text-primary">{{ number_format($siswa->rata_nilai, 1) }}</strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-clipboard-check text-success"></i> Kehadiran</span>
                        <strong class="text-success">{{ $siswa->persentase_kehadiran }}%</strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-check text-info"></i> Tugas Selesai</span>
                        <strong class="text-info">{{ $siswa->total_tugas_terkumpul }}</strong>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-hourglass-split text-danger"></i> Tugas Tertunda</span>
                        <strong class="text-danger">{{ $siswa->tugas_tertunda }}</strong>
                    </div>
                </div>
                
                <div class="mt-3 p-3 rounded" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <small class="text-dark">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Tips:</strong> Komunikasi rutin antara orang tua dan guru dapat membantu meningkatkan prestasi siswa.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Attendance filter
    const $filterTabs = $('.filter-tab');
    const $attendanceRows = $('.attendance-row');
    
    $filterTabs.on('click', function() {
        $filterTabs.removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('filter');
        
        $attendanceRows.each(function() {
            const status = $(this).data('status');
            
            if (filter === 'all') {
                $(this).show();
            } else if (filter === 'hadir' && status === 'hadir') {
                $(this).show();
            } else if (filter === 'sakit' && (status === 'sakit' || status === 'izin')) {
                $(this).show();
            } else if (filter === 'alpha' && status === 'alpha') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Download PDF (placeholder)
    $('.download-button').on('click', function() {
        Swal.fire({
            icon: 'info',
            title: 'Download Rapor',
            text: 'Fitur download PDF sedang dalam pengembangan',
            confirmButtonColor: '#10b981'
        });
    });
    
    // Animate stats on scroll
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'all 0.5s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.stat-box').forEach(box => {
        observer.observe(box);
    });
    
    // Add tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush