{{-- resources/views/admin/orangtua/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Orang Tua - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Orang Tua</h1>
    <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Orang Tua</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Nama</th>
                        <td>{{ $orangTua->nama_orang_tua }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $orangTua->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $orangTua->user->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $orangTua->user->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hubungan</th>
                        <td>{{ $orangTua->hubungan }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $orangTua->pekerjaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Statistik</strong>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary">{{ $orangTua->getTotalSiswa() }}</h4>
                        <small>Total Siswa</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success">{{ $orangTua->getSiswaAktif() }}</h4>
                        <small>Siswa Aktif</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-info">{{ $orangTua->getPendaftaranMenunggu() }}</h4>
                        <small>Pendaftaran Menunggu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Daftar Siswa --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Daftar Siswa</strong>
    </div>
    <div class="card-body">
        @if($orangTua->siswa->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Jenjang/Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orangTua->siswa as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</td>
                                <td>
                                    @if($siswa->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.siswa.show', $siswa->id_siswa) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted mb-0">Belum ada siswa</p>
        @endif
    </div>
</div>

{{-- Riwayat Pendaftaran --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Riwayat Pendaftaran</strong>
    </div>
    <div class="card-body">
        @if($orangTua->pendaftaran->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Paket</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orangTua->pendaftaran as $index => $pendaftaran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pendaftaran->getTanggalDaftarFormatted() }}</td>
                                <td>{{ $pendaftaran->paketBelajar->nama_paket }}</td>
                                <td>
                                    @if($pendaftaran->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($pendaftaran->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted mb-0">Belum ada pendaftaran</p>
        @endif
    </div>
</div>

{{-- Riwayat Transaksi --}}
<div class="card mb-4">
    <div class="card-header">
        <strong>Riwayat Transaksi</strong>
    </div>
    <div class="card-body">
        @if($orangTua->transaksi->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orangTua->transaksi as $index => $transaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaksi->getTanggalBayarFormatted() }}</td>
                                <td>{{ $transaksi->getFormattedJumlah() }}</td>
                                <td>
                                    @if($transaksi->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($transaksi->status == 'diverifikasi')
                                        <span class="badge bg-success">Diverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <strong>Total Pembayaran Terverifikasi: {{ $orangTua->getTotalBayarVerifikasi() > 0 ? 'Rp ' . number_format($orangTua->getTotalBayarVerifikasi(), 0, ',', '.') : 'Rp 0' }}</strong>
            </div>
        @else
            <p class="text-center text-muted mb-0">Belum ada transaksi</p>
        @endif
    </div>
</div>
@endsection