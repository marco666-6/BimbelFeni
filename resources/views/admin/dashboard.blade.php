@extends('layouts.admin')

@section('title', 'Dashboard Admin - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt"></i> {{ date('l, d F Y') }}
    </div>
</div>

<!-- Stats Cards Row -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_siswa'] }}</div>
                    </div>
                    <div class="text-primary" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="mt-2 text-xs">
                    <span class="text-success">{{ $stats['siswa_aktif'] }}</span> siswa aktif
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
                    <div class="text-success" style="font-size: 2rem; opacity: 0.3;">
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
                    <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
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
                    <div class="text-danger" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Paket Belajar</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_paket'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Materi</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_materi'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Tugas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tugas'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Siswa SD</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $siswaByJenjang['SD'] }}</div>
                <small class="text-muted">SMP: {{ $siswaByJenjang['SMP'] }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Pendaftaran Terbaru -->
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
                                        {{ $pendaftaran->paketBelajar->nama_paket }} - 
                                        <span class="badge badge-{{ $pendaftaran->status === 'menunggu' ? 'warning' : ($pendaftaran->status === 'diterima' ? 'success' : 'danger') }}">
                                            {{ ucfirst($pendaftaran->status) }}
                                        </span>
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> {{ $pendaftaran->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Belum ada pendaftaran</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
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
                                        {{ $transaksi->getFormattedJumlah() }} - 
                                        <span class="badge badge-{{ $transaksi->getStatusBadge() }}">
                                            {{ ucfirst($transaksi->status) }}
                                        </span>
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> {{ $transaksi->tanggal_bayar->format('d M Y') }}
                                    </small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.transaksi.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                            <br>Tambah Siswa
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.paket.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <br>Tambah Paket
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-info btn-block">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                            <br>Buat Jadwal/Materi
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.informasi.create') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-bell fa-2x mb-2"></i>
                            <br>Buat Pengumuman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection