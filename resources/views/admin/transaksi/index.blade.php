{{-- resources/views/admin/transaksi/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Transaksi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaksi Pembayaran</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Orang Tua</th>
                        <th>Siswa</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaksi->getTanggalBayarFormatted() }}</td>
                            <td>
                                <strong>{{ $transaksi->orangTua->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $transaksi->orangTua->user->email }}</small>
                            </td>
                            <td>{{ $transaksi->siswa->nama_siswa ?? '-' }}</td>
                            <td><strong>{{ $transaksi->getFormattedJumlah() }}</strong></td>
                            <td>
                                @if($transaksi->status == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($transaksi->status == 'diverifikasi')
                                    <span class="badge bg-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.transaksi.show', $transaksi->id_transaksi) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection