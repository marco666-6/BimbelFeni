<!-- View: orangtua/anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Data Anak')
@section('page-title', 'Data Anak')

@section('content')
<div class="row">
    @forelse($siswa as $s)
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <img src="{{ $s->user->foto_profil_url }}" alt="Foto" class="rounded-circle me-3" width="80" height="80">
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $s->nama_lengkap }}</h5>
                        <p class="text-muted mb-2">
                            <i class="bi bi-envelope"></i> {{ $s->user->email }}
                        </p>
                        <div>
                            <span class="badge bg-info">{{ $s->jenjang }}</span>
                            <span class="badge bg-secondary">Kelas {{ $s->kelas }}</span>
                            <span class="badge bg-{{ $s->user->isAktif() ? 'success' : 'danger' }}">
                                {{ $s->user->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted d-block">Kehadiran</small>
                                <div class="progress mt-1" style="height: 20px;">
                                    <div class="progress-bar {{ $s->persentase_kehadiran >= 80 ? 'bg-success' : ($s->persentase_kehadiran >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                         style="width: {{ $s->persentase_kehadiran }}%">
                                        {{ $s->persentase_kehadiran }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted d-block">Rata-rata Nilai</small>
                                <h4 class="mb-0 text-primary">{{ number_format($s->rata_nilai, 1) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted d-block">Tugas Terkumpul</small>
                                <h5 class="mb-0 text-success">{{ $s->total_tugas_terkumpul }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted d-block">Tugas Tertunda</small>
                                <h5 class="mb-0 text-danger">{{ $s->tugas_tertunda }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.anak.detail', $s->id) }}" class="btn btn-primary">
                        <i class="bi bi-eye"></i> Lihat Perkembangan Detail
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('orangtua.anak.jadwal', $s->id) }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-calendar-week"></i> Jadwal
                        </a>
                        <a href="{{ route('orangtua.anak.rapor', $s->id) }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-text"></i> Rapor
                        </a>
                        <a href="{{ route('orangtua.anak.log-activity', $s->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-activity"></i> Log Activity
                        </a>
                    </div>
                </div>

                <!-- Latest Transactions -->
                @php
                    $lastTransaction = $s->transaksi()->latest('tanggal_transaksi')->first();
                @endphp
                @if($lastTransaction)
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted d-block mb-1">Transaksi Terakhir:</small>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">{{ $lastTransaction->paketBelajar->nama_paket }}</span>
                        <span class="badge bg-{{ $lastTransaction->status_badge_color }}">
                            {{ $lastTransaction->status_label }}
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">Belum ada data anak terdaftar</p>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection