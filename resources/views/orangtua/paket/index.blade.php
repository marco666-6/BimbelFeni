@extends('layouts.ortusiswa')

@section('title', 'Paket Belajar')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Paket Belajar</h1>
    </div>
</div>

<div class="row">
    @forelse($pakets as $paket)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $paket->nama_paket }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ Str::limit($paket->deskripsi, 150) }}</p>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Harga:</span>
                        <strong class="text-primary">{{ $paket->getFormattedHarga() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Durasi:</span>
                        <strong>{{ $paket->durasi }} bulan</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Per Bulan:</span>
                        <strong>{{ $paket->getFormattedHargaBulanan() }}</strong>
                    </div>
                </div>

                @if($paket->komentar)
                <div class="alert alert-info mb-3">
                    <small><i class="fas fa-info-circle"></i> {{ $paket->komentar }}</small>
                </div>
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.paket.show', $paket->id_paket) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('orangtua.pendaftaran.create', ['paket' => $paket->id_paket]) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Daftar Paket Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Paket Tersedia</h5>
                <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h5><i class="fas fa-question-circle"></i> Butuh Bantuan Memilih?</h5>
                <p class="mb-3">Tim kami siap membantu Anda memilih paket yang sesuai dengan kebutuhan anak Anda.</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection