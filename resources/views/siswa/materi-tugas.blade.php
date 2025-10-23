<!-- View: siswa/materi-tugas.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Materi & Tugas')
@section('page-title', 'Materi & Tugas')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('siswa.materi-tugas') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Filter Tipe</label>
                            <select name="tipe" class="form-select" onchange="this.form.submit()">
                                <option value="all" {{ $tipe == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="materi" {{ $tipe == 'materi' ? 'selected' : '' }}>Materi</option>
                                <option value="tugas" {{ $tipe == 'tugas' ? 'selected' : '' }}>Tugas</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Materi & Tugas -->
        @if($materiTugas->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada materi atau tugas.
            </div>
        @else
            <div class="row">
                @foreach($materiTugas as $mt)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-{{ $mt->tipe_badge_color }} text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-{{ $mt->tipe_badge_color }}">
                                    {{ $mt->tipe_label }}
                                </span>
                                <span class="badge bg-light text-dark">{{ $mt->mata_pelajaran }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $mt->judul }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($mt->deskripsi, 100) }}</p>
                            
                            @if($mt->isTugas())
                                @if($mt->deadline)
                                <div class="mb-2">
                                    <small class="text-{{ $mt->isDeadlinePassed() ? 'danger' : 'warning' }}">
                                        <i class="bi bi-clock"></i> 
                                        Deadline: {{ $mt->deadline_formatted }}
                                    </small>
                                </div>
                                @endif

                                @if(in_array($mt->id, $pengumpulanIds))
                                    <div class="alert alert-success py-2 mb-0">
                                        <i class="bi bi-check-circle"></i> Sudah Dikumpulkan
                                    </div>
                                @else
                                    <div class="alert alert-warning py-2 mb-0">
                                        <i class="bi bi-exclamation-triangle"></i> Belum Dikumpulkan
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('siswa.materi-tugas.detail', $mt->id) }}" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection