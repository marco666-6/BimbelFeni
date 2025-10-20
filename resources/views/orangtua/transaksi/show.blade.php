@extends('layouts.ortusiswa')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.transaksi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Detail Transaksi</h5>
                @if($transaksi->status === 'menunggu')
                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                @elseif($transaksi->status === 'diverifikasi')
                    <span class="badge bg-success">Diverifikasi</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Tanggal Pembayaran:</strong>
                        <p>{{ $transaksi->getTanggalBayarFormatted() }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nama Siswa:</strong>
                        <p>{{ $transaksi->siswa->nama_siswa ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jumlah Pembayaran:</strong>
                        <p class="text-primary"><h4>{{ $transaksi->getFormattedJumlah() }}</h4></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            @if($transaksi->status === 'menunggu')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($transaksi->status === 'diverifikasi')
                                <span class="badge bg-success">Diverifikasi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </p>
                    </div>
                    @if($transaksi->keterangan)
                    <div class="col-12">
                        <strong>Keterangan:</strong>
                        <p>{{ $transaksi->keterangan }}</p>
                    </div>
                    @endif
                </div>

                <hr>

                <h6 class="mb-3">Bukti Pembayaran</h6>
                @if($transaksi->bukti_bayar_path)
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $transaksi->bukti_bayar_path) }}" alt="Bukti Pembayaran" class="img-fluid" style="max-height: 500px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div class="d-grid">
                    <a href="{{ asset('storage/' . $transaksi->bukti_bayar_path) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-download"></i> Lihat Bukti Pembayaran
                    </a>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Bukti pembayaran tidak tersedia
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($transaksi->status === 'menunggu')
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-clock"></i> Menunggu Verifikasi</h6>
                <p>Pembayaran Anda sedang dalam proses verifikasi oleh admin.</p>
                <small>Estimasi: 1-2 hari kerja</small>
            </div>
        </div>
        @elseif($transaksi->status === 'diverifikasi')
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-check-circle"></i> Pembayaran Terverifikasi</h6>
                <p>Pembayaran Anda telah diverifikasi dan tercatat dalam sistem.</p>
                @if($transaksi->diverifikasi_pada)
                <small>Diverifikasi pada: {{ date('d M Y H:i', strtotime($transaksi->diverifikasi_pada)) }}</small>
                @endif
            </div>
        </div>
        @else
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-times-circle"></i> Pembayaran Ditolak</h6>
                <p>Maaf, pembayaran Anda tidak dapat diverifikasi.</p>
                @if($transaksi->keterangan)
                <p><strong>Alasan:</strong> {{ $transaksi->keterangan }}</p>
                @endif
                <hr class="bg-white">
                <p class="mb-0">Silakan upload ulang bukti pembayaran yang benar atau hubungi admin.</p>
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-info-circle"></i> Informasi</h6>
                <ul class="mb-0">
                    <li class="mb-2">ID Transaksi: #{{ $transaksi->id_transaksi }}</li>
                    <li class="mb-2">Dibuat: {{ $transaksi->created_at->format('d M Y H:i') }}</li>
                    @if($transaksi->updated_at != $transaksi->created_at)
                    <li>Diupdate: {{ $transaksi->updated_at->format('d M Y H:i') }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-question-circle"></i> Butuh Bantuan?</h6>
                <p class="mb-3">Hubungi admin untuk informasi lebih lanjut</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success w-100">
                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection