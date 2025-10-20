@extends('layouts.ortusiswa')

@section('title', 'Informasi & Pengumuman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-bell"></i> Informasi & Pengumuman</h2>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Informasi ({{ $informasis->count() }})
    </div>
    <div class="card-body">
        @forelse($informasis as $info)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-2">
                                <i class="fas fa-{{ $info->jenis === 'pengumuman' ? 'bullhorn' : 'bell' }} text-{{ $info->jenis === 'pengumuman' ? 'primary' : 'warning' }}"></i>
                                {{ $info->judul }}
                            </h5>
                            
                            <p class="card-text text-muted mb-2">
                                {{ Str::limit($info->isi, 200) }}
                            </p>
                            
                            <div class="d-flex gap-3 text-muted small">
                                <span>
                                    <i class="fas fa-clock"></i> {{ $info->created_at->diffForHumans() }}
                                </span>
                                <span>
                                    <i class="fas fa-calendar"></i> {{ $info->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="ms-3">
                            <span class="badge bg-{{ $info->jenis === 'pengumuman' ? 'primary' : 'warning' }} mb-2">
                                {{ ucfirst($info->jenis) }}
                            </span>
                            <br>
                            <a href="{{ route('siswa.informasi.show', $info->id_informasi) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Baca
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada informasi atau pengumuman</p>
            </div>
        @endforelse
    </div>
</div>
@endsection