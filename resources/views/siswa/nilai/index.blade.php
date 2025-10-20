@extends('layouts.ortusiswa')

@section('title', 'Daftar Nilai')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-star"></i> Daftar Nilai</h2>
    <a href="{{ route('siswa.laporan-kemajuan') }}" class="btn btn-primary">
        <i class="fas fa-chart-line"></i> Lihat Laporan Kemajuan
    </a>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-muted small">Nilai Rata-rata</div>
                <h2 class="mb-0">{{ $stats['nilai_rata'] }}</h2>
                <small class="text-muted">dari 100</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-muted small">Nilai Tertinggi</div>
                <h2 class="mb-0">{{ $stats['nilai_tertinggi'] }}</h2>
                <small class="text-muted">dari 100</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="text-muted small">Nilai Terendah</div>
                <h2 class="mb-0">{{ $stats['nilai_terendah'] }}</h2>
                <small class="text-muted">dari 100</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="text-muted small">Total Tugas Dinilai</div>
                <h2 class="mb-0">{{ $stats['total_tugas_dinilai'] }}</h2>
                <small class="text-muted">tugas</small>
            </div>
        </div>
    </div>
</div>

<!-- Nilai List -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Riwayat Nilai
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Tugas</th>
                        <th>Tanggal</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais as $index => $nilai)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $nilai->judul }}</strong>
                                @if($nilai->deskripsi)
                                    <br>
                                    <small class="text-muted">{{ Str::limit(strip_tags($nilai->deskripsi), 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $nilai->getTanggalAwalFormatted() }}</small>
                            </td>
                            <td>
                                <h5 class="mb-0">
                                    <span class="badge bg-{{ $nilai->nilai >= 80 ? 'success' : ($nilai->nilai >= 60 ? 'warning' : 'danger') }}">
                                        {{ $nilai->nilai }}
                                    </span>
                                </h5>
                            </td>
                            <td>
                                <span class="badge bg-{{ $nilai->status === 'selesai' ? 'success' : ($nilai->status === 'terlambat' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($nilai->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.tugas.show', $nilai->id_jadwal_materi) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada nilai</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($nilais->count() > 0)
    <!-- Interpretasi Nilai -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-info-circle"></i> Interpretasi Nilai
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 border rounded">
                        <span class="badge bg-success mb-2">80 - 100</span>
                        <p class="mb-0 small">Sangat Baik</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 border rounded">
                        <span class="badge bg-primary mb-2">70 - 79</span>
                        <p class="mb-0 small">Baik</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 border rounded">
                        <span class="badge bg-warning mb-2">60 - 69</span>
                        <p class="mb-0 small">Cukup</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 border rounded">
                        <span class="badge bg-danger mb-2">0 - 59</span>
                        <p class="mb-0 small">Perlu Perbaikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection