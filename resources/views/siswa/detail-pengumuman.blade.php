<!-- View: siswa/detail-pengumuman.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Detail Pengumuman')
@section('page-title', 'Detail Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('siswa.pengumuman') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-megaphone"></i> {{ $pengumuman->judul }}
                        </h4>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-tag"></i> {{ $pengumuman->target_label }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info Pengumuman -->
                    <div class="border-bottom pb-3 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1">
                                    <i class="bi bi-calendar3 text-primary"></i>
                                    <strong>Tanggal Publikasi:</strong>
                                </p>
                                <p class="text-muted">
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->locale('id')->isoFormat('dddd, DD MMMM YYYY - HH:mm') }} WIB
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1">
                                    <i class="bi bi-person text-primary"></i>
                                    <strong>Dibuat oleh:</strong>
                                </p>
                                <p class="text-muted">
                                    {{ $pengumuman->creator->username ?? 'Admin' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Isi Pengumuman -->
                    <div class="pengumuman-content">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        <i class="bi bi-info-circle"></i> 
                        Pengumuman ini ditujukan untuk <strong>{{ $pengumuman->target_label }}</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pengumuman-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #333;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }
</style>
@endpush
@endsection