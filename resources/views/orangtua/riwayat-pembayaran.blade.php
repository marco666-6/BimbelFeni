@extends('layouts.ortusiswa')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Riwayat Pembayaran</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2">Total Pembayaran Terverifikasi</h6>
                        <h3 class="mb-0">{{ 'Rp ' . number_format($total_bayar, 0, ',', '.') }}</h3>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Transaksi</h5>
            </div>
            <div class="card-body">
                @if($transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaksi->getTanggalBayarFormatted() }}</td>
                                <td>{{ $transaksi->siswa->nama_siswa ?? '-' }}</td>
                                <td><strong>{{ $transaksi->getFormattedJumlah() }}</strong></td>
                                <td>
                                    @if($transaksi->status === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($transaksi->status === 'diverifikasi')
                                        <span class="badge bg-success">Diverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('orangtua.transaksi.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="3" class="text-end"><strong>Total Terverifikasi:</strong></td>
                                <td colspan="4"><strong class="text-success">{{ 'Rp ' . number_format($total_bayar, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Riwayat Pembayaran</h5>
                    <p class="text-muted">Riwayat pembayaran Anda akan muncul di sini</p>
                    <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Bukti Bayar
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($transaksis->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6><i class="fas fa-info-circle"></i> Keterangan Status</h6>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <span class="badge bg-warning">Menunggu</span> - Sedang dalam proses verifikasi
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-success">Diverifikasi</span> - Pembayaran telah dikonfirmasi
                    </div>
                    <div class="col-md-4">
                        <span class="badge bg-danger">Ditolak</span> - Pembayaran tidak dapat diverifikasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection