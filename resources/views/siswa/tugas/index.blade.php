@extends('layouts.ortusiswa')

@section('title', 'Daftar Tugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-tasks"></i> Daftar Tugas</h2>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tugas Pending</div>
                        <h3 class="mb-0">{{ $tugas->where('status', 'pending')->count() }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tugas Selesai</div>
                        <h3 class="mb-0">{{ $tugas->where('status', 'selesai')->count() }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tugas Terlambat</div>
                        <h3 class="mb-0">{{ $tugas->where('status', 'terlambat')->count() }}</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('siswa.tugas.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tugas List -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Tugas ({{ $tugas->count() }})
    </div>
    <div class="card-body">
        @forelse($tugas as $item)
            <div class="card mb-3 {{ $item->isOverdue() && !$item->isSelesai() ? 'border-danger' : '' }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title mb-2">
                                <i class="fas fa-tasks text-warning"></i>
                                {{ $item->judul }}
                                @if($item->status)
                                    <span class="badge bg-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'terlambat' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                @endif
                                @if($item->nilai)
                                    <span class="badge bg-info">
                                        <i class="fas fa-star"></i> {{ $item->nilai }}
                                    </span>
                                @endif
                            </h5>
                            
                            @if($item->deskripsi)
                                <p class="card-text text-muted mb-2">{{ Str::limit($item->deskripsi, 150) }}</p>
                            @endif
                            
                            <div class="text-muted small mb-2">
                                <i class="fas fa-calendar"></i> Diberikan: {{ $item->getTanggalAwalFormatted() }}
                                @if($item->deadline)
                                    <span class="ms-3 {{ $item->isOverdue() && !$item->isSelesai() ? 'text-danger fw-bold' : '' }}">
                                        <i class="fas fa-clock"></i> Deadline: {{ $item->getDeadlineFormatted() }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($item->deadline && $item->getHariTersisaUntilDeadline() !== null && !$item->isSelesai())
                                <div>
                                    <span class="badge bg-{{ $item->getHariTersisaUntilDeadline() < 0 ? 'danger' : ($item->getHariTersisaUntilDeadline() < 2 ? 'warning' : 'info') }}">
                                        @if($item->getHariTersisaUntilDeadline() < 0)
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat {{ abs($item->getHariTersisaUntilDeadline()) }} hari
                                        @elseif($item->getHariTersisaUntilDeadline() == 0)
                                            <i class="fas fa-exclamation-circle"></i> Deadline hari ini!
                                        @else
                                            <i class="fas fa-hourglass-half"></i> {{ $item->getHariTersisaUntilDeadline() }} hari lagi
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4 text-end d-flex flex-column justify-content-center gap-2">
                            <a href="{{ route('siswa.tugas.show', $item->id_jadwal_materi) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            
                            @if($item->file)
                                <a href="{{ route('siswa.tugas.download', $item->id_jadwal_materi) }}" class="btn btn-info">
                                    <i class="fas fa-download"></i> Download Soal
                                </a>
                            @endif
                            
                            @if($item->status !== 'selesai' && $item->status !== 'terlambat')
                                <a href="{{ route('siswa.tugas.show', $item->id_jadwal_materi) }}" class="btn btn-warning">
                                    <i class="fas fa-upload"></i> Kumpulkan
                                </a>
                            @elseif($item->status === 'selesai')
                                <button class="btn btn-success" disabled>
                                    <i class="fas fa-check"></i> Sudah Dikumpulkan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada tugas</p>
            </div>
        @endforelse
    </div>
</div>
@endsection