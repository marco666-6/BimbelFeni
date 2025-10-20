@extends('layouts.ortusiswa')

@section('title', 'Detail Jadwal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-calendar-alt"></i> Detail Jadwal</h2>
    <a href="{{ route('siswa.jadwal.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Jadwal
            </div>
            <div class="card-body">
                <h4 class="mb-3">
                    {{ $jadwal->judul }}
                    <span class="badge bg-{{ $jadwal->jenis === 'materi' ? 'primary' : 'warning' }} ms-2">
                        {{ ucfirst($jadwal->jenis) }}
                    </span>
                </h4>
                
                @if($jadwal->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted">Deskripsi:</h6>
                        <p style="white-space: pre-wrap;">{{ $jadwal->deskripsi }}</p>
                    </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Tanggal:</strong></p>
                        <p class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $jadwal->getTanggalAwalFormatted() }}
                        </p>
                    </div>
                    @if($jadwal->durasi)
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Durasi:</strong></p>
                            <p class="text-muted">
                                <i class="fas fa-hourglass-half"></i> {{ $jadwal->getDurasiFormatted() }}
                            </p>
                        </div>
                    @endif
                </div>
                
                @if($jadwal->deadline)
                    <div class="mb-3">
                        <p class="mb-2"><strong>Deadline:</strong></p>
                        <p class="text-muted">
                            <i class="fas fa-clock"></i> {{ $jadwal->getDeadlineFormatted() }}
                            @if($jadwal->getHariTersisaUntilDeadline() !== null)
                                <span class="badge bg-{{ $jadwal->getHariTersisaUntilDeadline() < 2 ? 'danger' : 'warning' }} ms-2">
                                    @if($jadwal->getHariTersisaUntilDeadline() < 0)
                                        Terlambat {{ abs($jadwal->getHariTersisaUntilDeadline()) }} hari
                                    @else
                                        {{ $jadwal->getHariTersisaUntilDeadline() }} hari lagi
                                    @endif
                                </span>
                            @endif
                        </p>
                    </div>
                @endif
                
                @if($jadwal->status)
                    <div class="mb-3">
                        <p class="mb-2"><strong>Status:</strong></p>
                        <span class="badge bg-{{ $jadwal->status === 'selesai' ? 'success' : ($jadwal->status === 'terlambat' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($jadwal->status) }}
                        </span>
                    </div>
                @endif
                
                @if($jadwal->file)
                    <div class="mb-3">
                        <p class="mb-2"><strong>File:</strong></p>
                        <div class="d-flex gap-2">
                            @if($jadwal->jenis === 'materi')
                                <a href="{{ route('siswa.materi.download', $jadwal->id_jadwal_materi) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download Materi
                                </a>
                            @else
                                <a href="{{ route('siswa.tugas.download', $jadwal->id_jadwal_materi) }}" class="btn btn-success">
                                    <i class="fas fa-download"></i> Download Tugas
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        @if($jadwal->jenis === 'tugas' && $jadwal->status !== 'selesai' && $jadwal->status !== 'terlambat')
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-upload"></i> Kumpulkan Tugas
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.tugas.upload', $jadwal->id_jadwal_materi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Upload File Jawaban <span class="text-danger">*</span></label>
                            <input type="file" name="file_jawaban" class="form-control" accept=".pdf,.doc,.docx,.zip,.rar" required>
                            <small class="text-muted">Format: PDF, DOC, DOCX, ZIP, RAR. Maksimal 10MB</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-upload"></i> Kumpulkan Tugas
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-md-4">
        @if($jadwal->nilai)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-star"></i> Nilai
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 mb-0">{{ $jadwal->nilai }}</h1>
                    <p class="text-muted">dari 100</p>
                </div>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-tag text-muted"></i>
                        <strong>Jenis:</strong> {{ ucfirst($jadwal->jenis) }}
                    </li>
                    @if($jadwal->status)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-muted"></i>
                            <strong>Status:</strong> {{ ucfirst($jadwal->status) }}
                        </li>
                    @endif
                    <li class="mb-2">
                        <i class="fas fa-calendar text-muted"></i>
                        <strong>Tanggal:</strong> {{ $jadwal->getTanggalAwalFormatted() }}
                    </li>
                    @if($jadwal->deadline)
                        <li class="mb-2">
                            <i class="fas fa-clock text-muted"></i>
                            <strong>Deadline:</strong> {{ $jadwal->getDeadlineFormatted() }}
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection