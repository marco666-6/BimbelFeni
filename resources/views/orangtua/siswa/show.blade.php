@extends('layouts.ortusiswa')

@section('title', 'Detail Siswa - ' . $siswa->nama_siswa)

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($siswa->user->foto_profil)
                        <img src="{{ asset($siswa->user->foto_profil) }}" alt="{{ $siswa->nama_siswa }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 3.5rem;">
                            {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <h4 class="mb-2">{{ $siswa->nama_siswa }}</h4>
                
                <div class="mb-3">
                    @if($siswa->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Non-Aktif</span>
                    @endif
                </div>

                <div class="text-start">
                    <p class="mb-2"><i class="fas fa-envelope text-primary"></i> {{ $siswa->user->email }}</p>
                    @if($siswa->user->telepon)
                    <p class="mb-2"><i class="fas fa-phone text-primary"></i> {{ $siswa->user->telepon }}</p>
                    @endif
                    <p class="mb-2"><i class="fas fa-school text-primary"></i> {{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                    <p class="mb-2"><i class="fas fa-birthday-cake text-primary"></i> {{ $siswa->getTanggalLahirFormatted() }} ({{ $siswa->getUmur() }} tahun)</p>
                    @if($siswa->user->alamat)
                    <p class="mb-0"><i class="fas fa-map-marker-alt text-primary"></i> {{ $siswa->user->alamat }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-chart-bar"></i> Statistik Belajar</h6>
                <div class="mb-2">
                    <small class="text-muted">Nilai Rata-rata</small>
                    <h4 class="text-primary mb-0">{{ $stats['nilai_rata'] ?? 0 }}</h4>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Materi:</span>
                    <strong>{{ $stats['total_materi'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tugas Selesai:</span>
                    <strong class="text-success">{{ $stats['tugas_selesai'] }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tugas Pending:</span>
                    <strong class="text-warning">{{ $stats['tugas_pending'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar"></i> Jadwal Terbaru</h5>
            </div>
            <div class="card-body">
                @if($jadwalTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalTerbaru as $jadwal)
                            <tr>
                                <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
                                <td>{{ $jadwal->judul }}</td>
                                <td>
                                    @if($jadwal->jenis === 'materi')
                                        <span class="badge bg-info">Materi</span>
                                    @else
                                        <span class="badge bg-warning">Tugas</span>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($jadwal->status === 'terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada jadwal</p>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-2x mb-2"></i>
                        <h5>{{ $stats['total_materi'] }}</h5>
                        <small>Total Materi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                        <h5>{{ $stats['tugas_selesai'] }}</h5>
                        <small>Tugas Selesai</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h5>{{ $stats['tugas_pending'] }}</h5>
                        <small>Tugas Pending</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-link"></i> Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.laporan-anak', $siswa->id_siswa) }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-line"></i> Lihat Laporan Lengkap
                    </a>
                    <a href="{{ route('orangtua.jadwal.index', ['siswa_id' => $siswa->id_siswa]) }}" class="btn btn-outline-info">
                        <i class="fas fa-calendar"></i> Lihat Semua Jadwal
                    </a>
                    <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-money-bill"></i> Upload Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection