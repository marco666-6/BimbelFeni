@extends('layouts.ortusiswa')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Dashboard Orang Tua</h1>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anak</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_anak'] }}</div>
                    </div>
                    <div class="text-primary" style="font-size: 2rem;">
                        <i class="fas fa-child"></i>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Anak Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['anak_aktif'] }}</div>
                    </div>
                    <div class="text-success" style="font-size: 2rem;">
                        <i class="fas fa-user-check"></i>
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
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transaksi Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['transaksi_menunggu'] }}</div>
                    </div>
                    <div class="text-info" style="font-size: 2rem;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Daftar Anak -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-children"></i> Daftar Anak</span>
                <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Daftar Baru
                </a>
            </div>
            <div class="card-body">
                @if($siswas->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($siswas as $siswa)
                        <a href="{{ route('orangtua.siswa.show', $siswa->id_siswa) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $siswa->nama_siswa }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-school"></i> {{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}
                                    </small>
                                </div>
                                <div>
                                    @if($siswa->status === 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada anak terdaftar</p>
                        <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Daftarkan Anak
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pengumuman Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-bell"></i> Pengumuman Terbaru</span>
                <a href="{{ route('orangtua.informasi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($pengumuman->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($pengumuman as $info)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">{{ $info->judul }}</h6>
                                <small class="text-muted">{{ $info->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-muted">{{ Str::limit($info->isi, 100) }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pengumuman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-receipt"></i> Transaksi Terbaru</span>
                <div>
                    <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-upload"></i> Upload Bukti
                    </a>
                    <a href="{{ route('orangtua.riwayat-pembayaran') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($transaksiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->tanggal_bayar->format('d M Y') }}</td>
                                    <td>{{ $transaksi->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $transaksi->getFormattedJumlah() }}</td>
                                    <td>
                                        @if($transaksi->status === 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($transaksi->status === 'diverifikasi')
                                            <span class="badge bg-success">Diverifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('orangtua.transaksi.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('orangtua.paket.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <p class="mb-0">Lihat Paket</p>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('orangtua.jadwal.index') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-calendar fa-2x mb-2"></i>
                            <p class="mb-0">Jadwal Belajar</p>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('orangtua.feedback.create') }}" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-comment fa-2x mb-2"></i>
                            <p class="mb-0">Kirim Feedback</p>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="fab fa-whatsapp fa-2x mb-2"></i>
                            <p class="mb-0">Hubungi Admin</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection