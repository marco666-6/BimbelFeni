{{-- resources/views/admin/transaksi/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Transaksi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Transaksi</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">ID Transaksi</th>
                        <td>#{{ $transaksi->id_transaksi }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Bayar</th>
                        <td>{{ $transaksi->getTanggalBayarFormatted() }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td><strong class="text-primary">{{ $transaksi->getFormattedJumlah() }}</strong></td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    @if($transaksi->keterangan)
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $transaksi->keterangan }}</td>
                    </tr>
                    @endif
                    @if($transaksi->diverifikasi_pada)
                    <tr>
                        <th>Diverifikasi Pada</th>
                        <td>{{ \Carbon\Carbon::parse($transaksi->diverifikasi_pada)->format('d-m-Y') }}
</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pembayar</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Orang Tua</th>
                        <td>{{ $transaksi->orangTua->nama_orang_tua }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $transaksi->orangTua->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $transaksi->orangTua->user->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Siswa</th>
                        <td>{{ $transaksi->siswa->nama_siswa ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($transaksi->bukti_bayar_path)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Bukti Pembayaran</strong>
            </div>
            <div class="card-body text-center">
                <img src="{{ Storage::url($transaksi->bukti_bayar_path) }}" 
                     alt="Bukti Pembayaran" 
                     class="img-fluid" 
                     style="max-height: 500px;">
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        @if($transaksi->status == 'menunggu')
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <strong>Verifikasi Transaksi</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaksi.verify', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Verifikasi transaksi ini?')">
                        <i class="fas fa-check"></i> Verifikasi
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white">
                <strong>Tolak Transaksi</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaksi.reject', $transaksi->id_transaksi) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="keterangan_tolak" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="keterangan_tolak" name="keterangan" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak transaksi ini?')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection