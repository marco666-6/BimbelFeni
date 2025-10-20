@extends('layouts.ortusiswa')

@section('title', 'Laporan Perkembangan - ' . $siswa->nama_siswa)

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        @if($siswa->user->foto_profil)
                            <img src="{{ asset($siswa->user->foto_profil) }}" alt="{{ $siswa->nama_siswa }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <h3 class="mb-2">{{ $siswa->nama_siswa }}</h3>
                        <p class="mb-0">{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                        <p class="mb-0">Laporan Perkembangan Belajar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card primary">
            <div class="card-body text-center">
                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                <h4 class="mb-0">{{ $stats['total_materi'] }}</h4>
                <small class="text-muted">Total Materi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h4 class="mb-0">{{ $stats['tugas_selesai'] }}</h4>
                <small class="text-muted">Tugas Selesai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h4 class="mb-0">{{ $stats['tugas_pending'] }}</h4>
                <small class="text-muted">Tugas Pending</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card danger">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-circle fa-2x text-danger mb-2"></i>
                <h4 class="mb-0">{{ $stats['tugas_terlambat'] }}</h4>
                <small class="text-muted">Tugas Terlambat</small>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Nilai Rata-rata</h6>
                <h2 class="text-primary mb-0">{{ $stats['nilai_rata'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Nilai Tertinggi</h6>
                <h2 class="text-success mb-0">{{ $stats['nilai_tertinggi'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Nilai Terendah</h6>
                <h2 class="text-danger mb-0">{{ $stats['nilai_terendah'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Riwayat Nilai Tugas</h5>
            </div>
            <div class="card-body">
                @if($jadwalsWithNilai->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Judul Tugas</th>
                                <th>Jenis</th>
                                <th>Nilai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalsWithNilai as $index => $jadwal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
                                <td>
                                    <strong>{{ $jadwal->judul }}</strong>
                                    @if($jadwal->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($jadwal->deskripsi, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->jenis === 'materi')
                                        <span class="badge bg-info">Materi</span>
                                    @else
                                        <span class="badge bg-warning">Tugas</span>
                                    @endif
                                </td>
                                <td>
                                    <h5 class="mb-0">
                                        @if($jadwal->nilai >= 80)
                                            <span class="badge bg-success">{{ $jadwal->nilai }}</span>
                                        @elseif($jadwal->nilai >= 60)
                                            <span class="badge bg-warning">{{ $jadwal->nilai }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $jadwal->nilai }}</span>
                                        @endif
                                    </h5>
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
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Nilai</h5>
                    <p class="text-muted">Nilai tugas akan muncul di sini setelah guru memberikan penilaian</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6><i class="fas fa-info-circle"></i> Keterangan Nilai</h6>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <span class="badge bg-success">80 - 100</span> Sangat Baik
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-warning">60 - 79</span> Cukup Baik
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-danger">0 - 59</span> Perlu Peningkatan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection