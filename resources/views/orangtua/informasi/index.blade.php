@extends('layouts.ortusiswa')

@section('title', 'Informasi & Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Informasi & Pengumuman</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($informasis->count() > 0)
                <div class="list-group">
                    @foreach($informasis as $info)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    @if($info->jenis === 'pengumuman')
                                        <span class="badge bg-primary me-2">Pengumuman</span>
                                    @else
                                        <span class="badge bg-info me-2">Notifikasi</span>
                                    @endif
                                    <h5 class="mb-0">{{ $info->judul }}</h5>
                                </div>
                                <p class="mb-2">{{ $info->isi }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $info->created_at->diffForHumans() }}
                                    @if($info->siswa)
                                        | <i class="fas fa-user"></i> Untuk: {{ $info->siswa->nama_siswa }}
                                    @else
                                        | <i class="fas fa-users"></i> Untuk: Semua
                                    @endif
                                </small>
                            </div>
                            @if($info->jenis === 'pengumuman')
                                <i class="fas fa-bullhorn fa-2x text-primary ms-3"></i>
                            @else
                                <i class="fas fa-bell fa-2x text-info ms-3"></i>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Informasi</h5>
                    <p class="text-muted">Informasi dan pengumuman akan muncul di sini</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($informasis->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6><i class="fas fa-info-circle"></i> Keterangan</h6>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <span class="badge bg-primary">Pengumuman</span> - Informasi umum dari bimbel
                    </div>
                    <div class="col-md-6">
                        <span class="badge bg-info">Notifikasi</span> - Pemberitahuan khusus untuk Anda
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection