{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    <div class="text-muted">{{ now()->format('l, d F Y') }}</div>
</div>

{{-- Statistik Cards --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_siswa'] }}</div>
                        <small class="text-success">{{ $stats['siswa_aktif'] }} aktif</small>
                    </div>
                    <div class="text-primary" style="font-size: 2rem;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Orang Tua</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_orangtua'] }}</div>
                    </div>
                    <div class="text-success" style="font-size: 2rem;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendaftaran Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pendaftaran_menunggu'] }}</div>
                    </div>
                    <div class="text-warning" style="font-size: 2rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Transaksi Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['transaksi_menunggu'] }}</div>
                    </div>
                    <div class="text-danger" style="font-size: 2rem;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info Cards --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Paket Belajar</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_paket'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Materi</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_materi'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Tugas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tugas'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Siswa SD</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $siswaByJenjang['SD'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Pendaftaran Terbaru --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list"></i> Pendaftaran Terbaru</span>
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($pendaftaranTerbaru->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($pendaftaranTerbaru as $pendaftaran)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $pendaftaran->orangTua->user->name }}</h6>
                                        <small class="text-muted">
                                            {{ $pendaftaran->paketBelajar->nama_paket }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-calendar"></i> {{ $pendaftaran->getTanggalDaftarFormatted() }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($pendaftaran->status == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($pendaftaran->status == 'diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted mb-0">Belum ada pendaftaran</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-money-bill"></i> Transaksi Terbaru</span>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($transaksiTerbaru->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($transaksiTerbaru as $transaksi)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $transaksi->orangTua->user->name }}</h6>
                                        <small class="text-muted">
                                            {{ $transaksi->siswa->nama_siswa ?? '-' }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-calendar"></i> {{ $transaksi->getTanggalBayarFormatted() }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <strong>{{ $transaksi->getFormattedJumlah() }}</strong>
                                        <br>
                                        @if($transaksi->status == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($transaksi->status == 'diverifikasi')
                                            <span class="badge bg-success">Diverifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted mb-0">Belum ada transaksi</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Chart Siswa --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> Distribusi Siswa per Jenjang
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h4 class="text-primary">{{ $siswaByJenjang['SD'] }}</h4>
                        <p>Siswa SD</p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-success">{{ $siswaByJenjang['SMP'] }}</h4>
                        <p>Siswa SMP</p>
                    </div>
                </div>
                <div class="progress" style="height: 30px;">
                    @php
                        $total = $siswaByJenjang['SD'] + $siswaByJenjang['SMP'];
                        $persenSD = $total > 0 ? ($siswaByJenjang['SD'] / $total) * 100 : 0;
                        $persenSMP = $total > 0 ? ($siswaByJenjang['SMP'] / $total) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $persenSD }}%" aria-valuenow="{{ $persenSD }}" aria-valuemin="0" aria-valuemax="100">
                        SD ({{ number_format($persenSD, 1) }}%)
                    </div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenSMP }}%" aria-valuenow="{{ $persenSMP }}" aria-valuemin="0" aria-valuemax="100">
                        SMP ({{ number_format($persenSMP, 1) }}%)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection