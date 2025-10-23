<!-- View: siswa/jadwal.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Jadwal Pembelajaran')
@section('page-title', 'Jadwal Pembelajaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar-week text-primary"></i> Jadwal Mingguan</h5>
            </div>
            <div class="card-body">
                @if($jadwal->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada jadwal pembelajaran.
                    </div>
                @else
                    <!-- Jadwal per Hari -->
                    @php
                        $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    @endphp

                    @foreach($hariUrutan as $hari)
                        @if($jadwalGrouped->has($hari))
                        <div class="mb-4">
                            <h5 class="mb-3 text-primary">
                                <i class="bi bi-calendar-day"></i> {{ $hari }}
                                @if(now()->locale('id')->dayName == $hari)
                                    <span class="badge bg-success ms-2">Hari Ini</span>
                                @endif
                            </h5>
                            
                            <div class="row">
                                @foreach($jadwalGrouped[$hari]->sortBy('jam_mulai') as $j)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 shadow-sm {{ $j->isToday() ? 'border-success' : '' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0">{{ $j->mata_pelajaran }}</h6>
                                                <span class="badge bg-primary">{{ $j->jam_formatted }}</span>
                                            </div>
                                            
                                            <hr>
                                            
                                            <p class="mb-1">
                                                <i class="bi bi-person text-secondary"></i>
                                                <strong>Guru:</strong> {{ $j->nama_guru }}
                                            </p>
                                            
                                            @if($j->ruangan)
                                            <p class="mb-1">
                                                <i class="bi bi-door-open text-warning"></i>
                                                <strong>Ruangan:</strong> {{ $j->ruangan }}
                                            </p>
                                            @endif
                                            
                                            <p class="mb-0">
                                                <i class="bi bi-clock text-info"></i>
                                                <strong>Durasi:</strong> {{ $j->durasi_menit }} menit
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <!-- Statistik -->
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-primary">{{ $jadwal->count() }}</h3>
                                    <small class="text-muted">Total Jadwal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-success">{{ $jadwal->unique('mata_pelajaran')->count() }}</h3>
                                    <small class="text-muted">Mata Pelajaran</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-info">{{ $jadwal->sum('durasi_menit') }}</h3>
                                    <small class="text-muted">Total Menit/Minggu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection