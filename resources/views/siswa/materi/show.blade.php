@extends('layouts.ortusiswa')

@section('title', 'Detail Materi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-book"></i> Detail Materi</h2>
    <a href="{{ route('siswa.materi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle"></i> Informasi Materi
            </div>
            <div class="card-body">
                <h4 class="mb-4">{{ $materi->judul }}</h4>
                
                @if($materi->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted">Deskripsi:</h6>
                        <div class="border-start border-primary border-3 ps-3">
                            <p style="white-space: pre-wrap;">{{ $materi->deskripsi }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <p class="mb-1 text-muted small">Tanggal</p>
                            <p class="mb-0">
                                <i class="fas fa-calendar text-primary"></i> 
                                <strong>{{ $materi->getTanggalAwalFormatted() }}</strong>
                            </p>
                        </div>
                    </div>
                    @if($materi->durasi)
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <p class="mb-1 text-muted small">Durasi</p>
                                <p class="mb-0">
                                    <i class="fas fa-hourglass-half text-primary"></i> 
                                    <strong>{{ $materi->getDurasiFormatted() }}</strong>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($materi->file)
                    <div class="alert alert-info">
                        <i class="fas fa-file-pdf"></i> File materi tersedia untuk diunduh
                    </div>
                    <a href="{{ route('siswa.materi.download', $materi->id_jadwal_materi) }}" class="btn btn-success btn-lg">
                        <i class="fas fa-download"></i> Download Materi
                    </a>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Belum ada file materi yang diunggah
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Ringkasan
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-tag text-primary"></i>
                        <strong>Jenis:</strong>
                        <span class="badge bg-primary ms-1">Materi</span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-calendar text-primary"></i>
                        <strong>Tanggal:</strong><br>
                        <span class="text-muted">{{ $materi->getTanggalAwalFormatted() }}</span>
                    </li>
                    @if($materi->durasi)
                        <li class="mb-3">
                            <i class="fas fa-hourglass-half text-primary"></i>
                            <strong>Durasi:</strong><br>
                            <span class="text-muted">{{ $materi->getDurasiFormatted() }}</span>
                        </li>
                    @endif
                    <li class="mb-3">
                        <i class="fas fa-file text-primary"></i>
                        <strong>File:</strong><br>
                        <span class="text-muted">{{ $materi->file ? 'Tersedia' : 'Tidak ada' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <i class="fas fa-lightbulb"></i> Tips Belajar
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Baca materi dengan teliti</li>
                    <li>Catat poin-poin penting</li>
                    <li>Jika ada yang tidak dipahami, tanyakan ke guru</li>
                    <li>Latih dengan mengerjakan soal</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection