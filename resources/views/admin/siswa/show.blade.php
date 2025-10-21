{{-- resources/views/admin/siswa/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Siswa - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Siswa</h1>
    <div>
        <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Materi</div>
                <div class="h5 mb-0 font-weight-bold">{{ $stats['total_materi'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tugas Selesai</div>
                <div class="h5 mb-0 font-weight-bold">{{ $stats['tugas_selesai'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tugas Pending</div>
                <div class="h5 mb-0 font-weight-bold">{{ $stats['tugas_pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nilai Rata-rata</div>
                <div class="h5 mb-0 font-weight-bold">{{ $stats['nilai_rata'] ? number_format($stats['nilai_rata'], 1) : '-' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Siswa</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Nama Siswa</th>
                        <td>{{ $siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $siswa->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $siswa->getTanggalLahirFormatted() }} ({{ $siswa->getUmur() }} tahun)</td>
                    </tr>
                    <tr>
                        <th>Jenjang</th>
                        <td>{{ $siswa->jenjang }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $siswa->kelas }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($siswa->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $siswa->user->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $siswa->user->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Orang Tua</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Nama Orang Tua</th>
                        <td>{{ $siswa->orangTua->nama_orang_tua }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $siswa->orangTua->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $siswa->orangTua->user->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hubungan</th>
                        <td>{{ $siswa->orangTua->hubungan }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $siswa->orangTua->pekerjaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Jadwal & Materi Terbaru</strong>
            </div>
            <div class="card-body">
                @if($siswa->jadwalMateri->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($siswa->jadwalMateri->take(5) as $jadwal)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1">{{ $jadwal->judul }}</h6>
                                        <small class="text-muted">
                                            <span class="badge {{ $jadwal->jenis == 'materi' ? 'bg-info' : 'bg-warning' }}">
                                                {{ ucfirst($jadwal->jenis) }}
                                            </span>
                                            {{ $jadwal->getTanggalAwalFormatted() }}
                                        </small>
                                    </div>
                                    @if($jadwal->nilai)
                                        <strong class="text-success">{{ $jadwal->nilai }}</strong>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted mb-0">Belum ada jadwal/materi</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Riwayat Transaksi</strong>
            </div>
            <div class="card-body">
                @if($siswa->transaksi->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($siswa->transaksi->take(5) as $transaksi)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $transaksi->getFormattedJumlah() }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $transaksi->getTanggalBayarFormatted() }}</small>
                                    </div>
                                    <div>
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
@endsection