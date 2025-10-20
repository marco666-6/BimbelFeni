@extends('layouts.ortusiswa')

@section('title', 'Laporan Kemajuan Belajar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-chart-line"></i> Laporan Kemajuan Belajar</h2>
    <a href="{{ route('siswa.nilai.index') }}" class="btn btn-secondary">
        <i class="fas fa-star"></i> Lihat Semua Nilai
    </a>
</div>

<!-- Summary Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="text-muted small">Total Materi</div>
                <h2 class="mb-0">{{ $stats['total_materi'] }}</h2>
                <small class="text-muted">materi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-muted small">Tugas Selesai</div>
                <h2 class="mb-0">{{ $stats['tugas_selesai'] }}</h2>
                <small class="text-muted">tugas</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="text-muted small">Tugas Pending</div>
                <h2 class="mb-0">{{ $stats['tugas_pending'] }}</h2>
                <small class="text-muted">tugas</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="text-muted small">Tugas Terlambat</div>
                <h2 class="mb-0">{{ $stats['tugas_terlambat'] }}</h2>
                <small class="text-muted">tugas</small>
            </div>
        </div>
    </div>
</div>

<!-- Nilai Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Nilai Rata-rata</h6>
                <h1 class="display-4 mb-0 text-info">{{ $stats['nilai_rata'] }}</h1>
                <p class="text-muted">dari 100</p>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $stats['nilai_rata'] }}%" aria-valuenow="{{ $stats['nilai_rata'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Nilai Tertinggi</h6>
                <h1 class="display-4 mb-0 text-success">{{ $stats['nilai_tertinggi'] }}</h1>
                <p class="text-muted">dari 100</p>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $stats['nilai_tertinggi'] }}%" aria-valuenow="{{ $stats['nilai_tertinggi'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Nilai Terendah</h6>
                <h1 class="display-4 mb-0 text-warning">{{ $stats['nilai_terendah'] }}</h1>
                <p class="text-muted">dari 100</p>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stats['nilai_terendah'] }}%" aria-valuenow="{{ $stats['nilai_terendah'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Perkembangan Nilai -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-line"></i> Grafik Perkembangan Nilai (6 Bulan Terakhir)
    </div>
    <div class="card-body">
        <canvas id="nilaiChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Tugas Terbaru dengan Nilai -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> 10 Tugas Terbaru dengan Nilai
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Tugas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugasDinilai as $index => $tugas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $tugas->judul }}</strong>
                            </td>
                            <td>
                                <small>{{ $tugas->getTanggalAwalFormatted() }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $tugas->status === 'selesai' ? 'success' : ($tugas->status === 'terlambat' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($tugas->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $tugas->nilai >= 80 ? 'success' : ($tugas->nilai >= 60 ? 'warning' : 'danger') }}" style="font-size: 1rem;">
                                    {{ $tugas->nilai }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.tugas.show', $tugas->id_jadwal_materi) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada tugas yang dinilai</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Motivasi -->
@if($stats['nilai_rata'] > 0)
    <div class="card mt-4">
        <div class="card-body">
            <div class="text-center">
                @if($stats['nilai_rata'] >= 80)
                    <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                    <h4 class="text-success">Luar Biasa!</h4>
                    <p class="text-muted">Pertahankan prestasi yang sangat baik ini. Terus tingkatkan kemampuanmu!</p>
                @elseif($stats['nilai_rata'] >= 70)
                    <i class="fas fa-smile fa-3x text-primary mb-3"></i>
                    <h4 class="text-primary">Bagus!</h4>
                    <p class="text-muted">Kamu sudah belajar dengan baik. Tetap semangat untuk mencapai yang lebih tinggi!</p>
                @elseif($stats['nilai_rata'] >= 60)
                    <i class="fas fa-hand-peace fa-3x text-warning mb-3"></i>
                    <h4 class="text-warning">Cukup Baik!</h4>
                    <p class="text-muted">Tingkatkan lagi usahamu. Jangan menyerah, kamu pasti bisa lebih baik lagi!</p>
                @else
                    <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                    <h4 class="text-danger">Tetap Semangat!</h4>
                    <p class="text-muted">Jangan berkecil hati. Terus belajar dengan giat, hasil yang baik akan mengikuti!</p>
                @endif
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('nilaiChart').getContext('2d');
    const nilaiData = @json($nilaiPerBulan);
    
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Object.keys(nilaiData),
            datasets: [{
                label: 'Nilai Rata-rata',
                data: Object.values(nilaiData),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Nilai: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush