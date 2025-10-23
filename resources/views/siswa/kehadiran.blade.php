<!-- View: siswa/kehadiran.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Kehadiran')
@section('page-title', 'Kehadiran Saya')

@section('content')
<div class="container-fluid">
    <!-- Statistik Kehadiran -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Pertemuan</h6>
                            <h3 class="mb-0">{{ $totalKehadiran }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Hadir</h6>
                            <h3 class="mb-0">{{ $totalHadir }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Sakit/Izin</h6>
                            <h3 class="mb-0">{{ $totalSakit + $totalIzin }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Alpha</h6>
                            <h3 class="mb-0">{{ $totalAlpha }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Persentase Kehadiran -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-pie-chart text-primary"></i> Persentase Kehadiran
                    </h5>
                    <div class="progress" style="height: 30px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $persentaseHadir }}%;" 
                             aria-valuenow="{{ $persentaseHadir }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            <strong>{{ $persentaseHadir }}%</strong>
                        </div>
                    </div>
                    <p class="text-muted mt-2 mb-0">
                        <i class="bi bi-info-circle"></i> 
                        Anda hadir {{ $totalHadir }} dari {{ $totalKehadiran }} pertemuan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Kehadiran -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-data"></i> Riwayat Kehadiran
            </h5>
        </div>
        <div class="card-body">
            @if($kehadiran->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada data kehadiran</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="25%">Mata Pelajaran</th>
                                <th width="15%">Guru</th>
                                <th width="10%">Jam</th>
                                <th width="15%">Status</th>
                                <th width="15%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kehadiran as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="bi bi-calendar3 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pertemuan)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                </td>
                                <td>
                                    <strong>{{ $item->jadwal->mata_pelajaran }}</strong>
                                </td>
                                <td>{{ $item->jadwal->nama_guru }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->jadwal->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($item->jadwal->jam_selesai)->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($item->status == 'hadir')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Hadir
                                        </span>
                                    @elseif($item->status == 'sakit')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-bandaid"></i> Sakit
                                        </span>
                                    @elseif($item->status == 'izin')
                                        <span class="badge bg-info">
                                            <i class="bi bi-file-text"></i> Izin
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Alpha
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->keterangan)
                                        <small class="text-muted">{{ $item->keterangan }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f0ad4e 0%, #ec971f 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #d9534f 0%, #c9302c 100%);
    }
</style>
@endpush
@endsection