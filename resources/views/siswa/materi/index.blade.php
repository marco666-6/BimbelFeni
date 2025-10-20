@extends('layouts.ortusiswa')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-book"></i> Materi Pembelajaran</h2>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Daftar Materi ({{ $materis->count() }})
    </div>
    <div class="card-body">
        @forelse($materis as $materi)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-2">
                                <i class="fas fa-book text-primary"></i>
                                {{ $materi->judul }}
                            </h5>
                            
                            @if($materi->deskripsi)
                                <p class="card-text text-muted mb-2">{{ Str::limit($materi->deskripsi, 200) }}</p>
                            @endif
                            
                            <div class="text-muted small">
                                <i class="fas fa-calendar"></i> {{ $materi->getTanggalAwalFormatted() }}
                                @if($materi->durasi)
                                    <span class="ms-3">
                                        <i class="fas fa-hourglass-half"></i> {{ $materi->getDurasiFormatted() }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <a href="{{ route('siswa.materi.show', $materi->id_jadwal_materi) }}" class="btn btn-primary mb-2">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            
                            @if($materi->file)
                                <a href="{{ route('siswa.materi.download', $materi->id_jadwal_materi) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada materi pembelajaran</p>
            </div>
        @endforelse
    </div>
</div>
@endsection