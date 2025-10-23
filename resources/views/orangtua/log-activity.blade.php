<!-- View: orangtua/log-activity.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas - ' . $siswa->nama_lengkap)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Info Siswa -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ $siswa->user->foto_profil_url }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-circle" width="60" height="60">
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $siswa->nama_lengkap }}</h5>
                        <p class="text-muted mb-0">{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('orangtua.anak') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log Activity -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-activity text-primary"></i> Riwayat Aktivitas</h5>
            </div>
            <div class="card-body">
                @if($logs->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada aktivitas yang tercatat.
                    </div>
                @else
                    <div class="timeline">
                        @foreach($logs as $log)
                        <div class="timeline-item mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="rounded-circle bg-{{ $log->badge_color }} text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="bi bi-{{ $log->icon }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="card border-start border-4 border-{{ $log->badge_color }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $log->deskripsi }}</h6>
                                                    <p class="text-muted mb-0 small">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $log->waktu_formatted }}
                                                        <span class="ms-2 text-primary">{{ $log->waktu_relative }}</span>
                                                    </p>
                                                    @if($log->ip_address)
                                                        <p class="text-muted mb-0 small mt-1">
                                                            <i class="bi bi-geo-alt me-1"></i>
                                                            IP: {{ $log->ip_address }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <span class="badge bg-{{ $log->badge_color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $log->jenis_aktivitas)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-item {
        position: relative;
    }
</style>
@endpush
@endsection