<!-- View: siswa/pengumuman.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-megaphone"></i> Daftar Pengumuman
                    </h5>
                </div>
                <div class="card-body">
                    @if($pengumuman->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">Belum ada pengumuman</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($pengumuman as $item)
                            <a href="{{ route('siswa.pengumuman.detail', $item->id) }}" 
                               class="list-group-item list-group-item-action pengumuman-item">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-megaphone-fill text-primary me-2"></i>
                                            <h5 class="mb-0">{{ $item->judul }}</h5>
                                        </div>
                                        <p class="mb-2 text-muted">
                                            {{ Str::limit(strip_tags($item->isi), 150) }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3"></i> 
                                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }}
                                        </small>
                                        <span class="badge bg-info ms-2">
                                            <i class="bi bi-tag"></i> {{ $item->target_label }}
                                        </span>
                                    </div>
                                    <div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pengumuman-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .pengumuman-item:hover {
        border-left-color: #0d6efd;
        background-color: #f8f9fa;
        transform: translateX(5px);
    }
</style>
@endpush
@endsection