@extends('layouts.ortusiswa')

@section('title', 'Detail Paket - ' . $paket->nama_paket)

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.paket.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $paket->nama_paket }}</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Deskripsi Paket</h5>
                <p style="white-space: pre-line;">{{ $paket->deskripsi }}</p>

                @if($paket->komentar)
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> Catatan Penting</h6>
                    <p class="mb-0">{{ $paket->komentar }}</p>
                </div>
                @endif

                <div class="mt-4">
                    <h5 class="mb-3">Statistik Paket</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                    <h5 class="mb-0">{{ $paket->getTotalPendaftar() }}</h5>
                                    <small class="text-muted">Total Pendaftar</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                                    <h5 class="mb-0">{{ $paket->getPendaftarDiterima() }}</h5>
                                    <small class="text-muted">Diterima</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                    <h5 class="mb-0">{{ $paket->getPendaftarMenunggu() }}</h5>
                                    <small class="text-muted">Menunggu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Informasi Harga</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="text-primary mb-0">{{ $paket->getFormattedHarga() }}</h2>
                    <p class="text-muted">untuk {{ $paket->durasi }} bulan</p>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga per Bulan:</span>
                        <strong>{{ $paket->getFormattedHargaBulanan() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Durasi Program:</span>
                        <strong>{{ $paket->durasi }} Bulan</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Pembayaran:</span>
                        <strong class="text-primary">{{ $paket->getFormattedHarga() }}</strong>
                    </div>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.pendaftaran.create', ['paket' => $paket->id_paket]) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> Daftar Sekarang
                    </a>
                    <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i> Tanya Admin
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-shield-alt"></i> Keuntungan Bergabung</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Materi pembelajaran lengkap</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Tugas dan evaluasi terstruktur</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Monitoring kemajuan real-time</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Konsultasi dengan pengajar</li>
                    <li class="mb-2"><i class="fas fa-check text-success"></i> Laporan perkembangan rutin</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection