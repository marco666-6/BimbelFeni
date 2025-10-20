@extends('layouts.ortusiswa')

@section('title', 'Detail Tugas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-tasks"></i> Detail Tugas</h2>
    <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Informasi Tugas -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <i class="fas fa-info-circle"></i> Informasi Tugas
            </div>
            <div class="card-body">
                <h4 class="mb-3">
                    {{ $tugas->judul }}
                    @if($tugas->status)
                        <span class="badge bg-{{ $tugas->status === 'selesai' ? 'success' : ($tugas->status === 'terlambat' ? 'danger' : 'warning') }}">
                            {{ ucfirst($tugas->status) }}
                        </span>
                    @endif
                </h4>
                
                @if($tugas->deskripsi)
                    <div class="mb-4">
                        <h6 class="text-muted">Deskripsi:</h6>
                        <div class="border-start border-warning border-3 ps-3">
                            <p style="white-space: pre-wrap;">{{ $tugas->deskripsi }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <p class="mb-1 text-muted small">Tanggal Diberikan</p>
                            <p class="mb-0">
                                <i class="fas fa-calendar text-warning"></i> 
                                <strong>{{ $tugas->getTanggalAwalFormatted() }}</strong>
                            </p>
                        </div>
                    </div>
                    @if($tugas->deadline)
                        <div class="col-md-6">
                            <div class="border rounded p-3 {{ $tugas->isOverdue() && !$tugas->isSelesai() ? 'border-danger' : '' }}">
                                <p class="mb-1 text-muted small">Deadline</p>
                                <p class="mb-0 {{ $tugas->isOverdue() && !$tugas->isSelesai() ? 'text-danger' : '' }}">
                                    <i class="fas fa-clock"></i> 
                                    <strong>{{ $tugas->getDeadlineFormatted() }}</strong>
                                </p>
                                @if($tugas->getHariTersisaUntilDeadline() !== null && !$tugas->isSelesai())
                                    <small class="text-{{ $tugas->getHariTersisaUntilDeadline() < 0 ? 'danger' : 'warning' }}">
                                        @if($tugas->getHariTersisaUntilDeadline() < 0)
                                            Terlambat {{ abs($tugas->getHariTersisaUntilDeadline()) }} hari
                                        @else
                                            {{ $tugas->getHariTersisaUntilDeadline() }} hari lagi
                                        @endif
                                    </small>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($tugas->file)
                    <div class="mb-3">
                        <h6 class="text-muted">File Soal:</h6>
                        <a href="{{ route('siswa.tugas.download', $tugas->id_jadwal_materi) }}" class="btn btn-info">
                            <i class="fas fa-download"></i> Download Soal Tugas
                        </a>
                    </div>
                @endif
                
                @if($tugas->nilai)
                    <div class="alert alert-success">
                        <h5 class="mb-0">
                            <i class="fas fa-star"></i> Nilai: <strong>{{ $tugas->nilai }}</strong>
                        </h5>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Form Upload Tugas -->
        @if($tugas->status !== 'selesai' && $tugas->status !== 'terlambat')
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-upload"></i> Kumpulkan Tugas
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.tugas.upload', $tugas->id_jadwal_materi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @if($tugas->isOverdue())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <strong>Perhatian:</strong> Tugas ini sudah melewati deadline. Pengumpulan akan ditandai sebagai terlambat.
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="form-label">Upload File Jawaban <span class="text-danger">*</span></label>
                            <input type="file" name="file_jawaban" class="form-control" accept=".pdf,.doc,.docx,.zip,.rar" required>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Format yang diterima: PDF, DOC, DOCX, ZIP, RAR. Maksimal ukuran: 10MB
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan jika ada hal yang perlu disampaikan kepada guru..."></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb"></i> 
                            <strong>Tips:</strong> Pastikan file sudah benar sebelum dikirim. Periksa kembali jawaban Anda.
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-upload"></i> Kumpulkan Tugas
                        </button>
                    </form>
                </div>
            </div>
        @elseif($tugas->status === 'selesai')
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> 
                <strong>Tugas sudah dikumpulkan!</strong> Silakan tunggu penilaian dari guru.
            </div>
        @elseif($tugas->status === 'terlambat')
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Tugas dikumpulkan terlambat.</strong> Nilai mungkin terpengaruh.
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        @if($tugas->nilai)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-star"></i> Nilai
                </div>
                <div class="card-body text-center">
                    <h1 class="display-3 mb-0 text-success">{{ $tugas->nilai }}</h1>
                    <p class="text-muted mb-0">dari 100</p>
                </div>
            </div>
        @endif
        
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Status Tugas
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-warning"></i>
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $tugas->status === 'selesai' ? 'success' : ($tugas->status === 'terlambat' ? 'danger' : 'warning') }}">
                            {{ ucfirst($tugas->status ?? 'Pending') }}
                        </span>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-calendar text-warning"></i>
                        <strong>Diberikan:</strong><br>
                        <span class="text-muted">{{ $tugas->getTanggalAwalFormatted() }}</span>
                    </li>
                    @if($tugas->deadline)
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning"></i>
                            <strong>Deadline:</strong><br>
                            <span class="text-muted">{{ $tugas->getDeadlineFormatted() }}</span>
                        </li>
                    @endif
                    @if($tugas->file)
                        <li class="mb-3">
                            <i class="fas fa-file text-warning"></i>
                            <strong>File Soal:</strong><br>
                            <span class="text-success">Tersedia</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-lightbulb"></i> Tips Mengerjakan
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li class="mb-2">Baca soal dengan teliti</li>
                    <li class="mb-2">Kerjakan sesuai instruksi</li>
                    <li class="mb-2">Periksa jawaban sebelum dikumpulkan</li>
                    <li class="mb-2">Kumpulkan sebelum deadline</li>
                    <li>Tanyakan jika ada yang tidak jelas</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection