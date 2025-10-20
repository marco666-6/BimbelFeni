@extends('layouts.ortusiswa')

@section('title', 'Detail Informasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-bell"></i> Detail Informasi</h2>
    <a href="{{ route('siswa.informasi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-{{ $informasi->jenis === 'pengumuman' ? 'primary' : 'warning' }} text-white">
                <i class="fas fa-{{ $informasi->jenis === 'pengumuman' ? 'bullhorn' : 'bell' }}"></i>
                {{ ucfirst($informasi->jenis) }}
            </div>
            <div class="card-body">
                <h3 class="mb-4">{{ $informasi->judul }}</h3>
                
                <div class="mb-4">
                    <div class="border-start border-{{ $informasi->jenis === 'pengumuman' ? 'primary' : 'warning' }} border-3 ps-3">
                        <p style="white-space: pre-wrap; line-height: 1.8;">{{ $informasi->isi }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-muted small">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fas fa-calendar"></i> 
                            <strong>Tanggal:</strong> {{ $informasi->created_at->format('d M Y') }}
                        </div>
                        <div class="col-md-6">
                            <i class="fas fa-clock"></i> 
                            <strong>Waktu:</strong> {{ $informasi->created_at->format('H:i') }} WIB
                        </div>
                    </div>
                    <div class="mt-2">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Dipublikasikan:</strong> {{ $informasi->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-tag text-{{ $informasi->jenis === 'pengumuman' ? 'primary' : 'warning' }}"></i>
                        <strong>Jenis:</strong><br>
                        <span class="badge bg-{{ $informasi->jenis === 'pengumuman' ? 'primary' : 'warning' }} mt-1">
                            {{ ucfirst($informasi->jenis) }}
                        </span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-calendar text-primary"></i>
                        <strong>Tanggal:</strong><br>
                        <span class="text-muted">{{ $informasi->created_at->format('d F Y') }}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-clock text-primary"></i>
                        <strong>Waktu:</strong><br>
                        <span class="text-muted">{{ $informasi->created_at->format('H:i') }} WIB</span>
                    </li>
                </ul>
            </div>
        </div>
        
        @if($informasi->jenis === 'pengumuman')
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-lightbulb"></i> Tips
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        Pastikan untuk selalu membaca pengumuman secara berkala agar tidak ketinggalan informasi penting dari sekolah.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection