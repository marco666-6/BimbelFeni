@extends('layouts.ortusiswa')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
            <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Bukti Bayar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($transaksis->count() > 0)
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
                            @foreach($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->getTanggalBayarFormatted() }}</td>
                                <td>{{ $transaksi->siswa->nama_siswa ?? '-' }}</td>
                                <td><strong>{{ $transaksi->getFormattedJumlah() }}</strong></td>
                                <td>
                                    @if($transaksi->status === 'menunggu')
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    @elseif($transaksi->status === 'diverifikasi')
                                        <span class="badge bg-success">Diverifikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('orangtua.transaksi.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Transaksi</h5>
                    <p class="text-muted">Upload bukti pembayaran untuk memulai</p>
                    <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Bukti Bayar
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection