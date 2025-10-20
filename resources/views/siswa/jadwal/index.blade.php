@extends('layouts.ortusiswa')

@section('title', 'Jadwal Pertemuan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-calendar-alt"></i> Jadwal Pertemuan</h2>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('siswa.jadwal.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="materi" {{ request('jenis') === 'materi' ? 'selected' : '' }}>Materi</option>
                    <option value="tugas" {{ request('jenis') === 'tugas' ? 'selected' : '' }}>Tugas</option>
                </select>
            </div>
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
                <a href="{{ route('siswa.jadwal.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Jadwal List -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Jadwal ({{ $jadwals->count() }})
    </div>
    <div class="card-body">
        @forelse($jadwals as $jadwal)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title mb-2">
                                {{ $jadwal->judul }}
                                <span class="badge bg-{{ $jadwal->jenis === 'materi' ? 'primary' : 'warning' }} ms-2">
                                    {{ ucfirst($jadwal->jenis) }}
                                </span>
                                @if($jadwal->status)
                                    <span class="badge bg-{{ $jadwal->status === 'selesai' ? 'success' : ($jadwal->status === 'terlambat' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($jadwal->status) }}
                                    </span>
                                @endif
                            </h5>
                            
                            @if($jadwal->deskripsi)
                                <p class="card-text text-muted mb-2">{{ Str::limit($jadwal->deskripsi, 150) }}</p>
                            @endif
                            
                            <div class="text-muted small">
                                <i class="fas fa-calendar"></i> {{ $jadwal->getTanggalAwalFormatted() }}
                                @if($jadwal->durasi)
                                    <span class="ms-3"><i class="fas fa-hourglass-half"></i> {{ $jadwal->getDurasiFormatted() }}</span>
                                @endif
                                @if($jadwal->deadline)
                                    <span class="ms-3"><i class="fas fa-clock"></i> Deadline: {{ $jadwal->getDeadlineFormatted() }}</span>
                                @endif
                            </div>
                            
                            @if($jadwal->nilai)
                                <div class="mt-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-star"></i> Nilai: {{ $jadwal->nilai }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end d-flex flex-column justify-content-center">
                            <a href="{{ route('siswa.jadwal.show', $jadwal->id_jadwal_materi) }}" class="btn btn-primary mb-2">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            
                            @if($jadwal->jenis === 'materi' && $jadwal->file)
                                <a href="{{ route('siswa.materi.download', $jadwal->id_jadwal_materi) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download Materi
                                </a>
                            @elseif($jadwal->jenis === 'tugas')
                                @if($jadwal->status !== 'selesai')
                                    <a href="{{ route('siswa.tugas.show', $jadwal->id_jadwal_materi) }}" class="btn btn-warning">
                                        <i class="fas fa-upload"></i> Kumpulkan Tugas
                                    </a>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-check"></i> Sudah Dikumpulkan
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada jadwal pertemuan</p>
            </div>
        @endforelse
    </div>
</div>
@endsection