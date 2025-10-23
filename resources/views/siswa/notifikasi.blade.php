<!-- View: siswa/notifikasi.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-bell"></i> Daftar Notifikasi
                    </h5>
                    @if($notifikasi->where('dibaca', false)->count() > 0)
                        <form action="{{ route('siswa.notifikasi.read-all') }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-light">
                                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($notifikasi->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">Tidak ada notifikasi</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($notifikasi as $item)
                            <div class="list-group-item {{ $item->dibaca ? '' : 'bg-light' }} notif-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            @if($item->tipe == 'pengumuman')
                                                <i class="bi bi-megaphone-fill text-info me-2"></i>
                                            @elseif($item->tipe == 'jadwal')
                                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                            @elseif($item->tipe == 'tugas')
                                                <i class="bi bi-file-text text-warning me-2"></i>
                                            @else
                                                <i class="bi bi-bell-fill text-success me-2"></i>
                                            @endif
                                            
                                            <h6 class="mb-0 {{ $item->dibaca ? 'text-muted' : 'fw-bold' }}">
                                                {{ $item->judul }}
                                            </h6>
                                            
                                            @if(!$item->dibaca)
                                                <span class="badge bg-primary ms-2">Baru</span>
                                            @endif
                                        </div>
                                        
                                        <p class="mb-2 {{ $item->dibaca ? 'text-muted' : '' }}">
                                            {{ $item->pesan }}
                                        </p>
                                        
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> 
                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    <div class="ms-3">
                                        @if(!$item->dibaca)
                                            <form action="{{ route('siswa.notifikasi.read', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai dibaca">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($notifikasi->hasPages())
                            <div class="card-footer">
                                {{ $notifikasi->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .notif-item {
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
    }
    .notif-item:hover {
        background-color: #f8f9fa !important;
        border-left-color: #0d6efd;
    }
</style>
@endpush
@endsection