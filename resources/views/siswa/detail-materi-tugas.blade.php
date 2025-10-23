<!-- View: siswa/detail-materi-tugas.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Detail ' . $materiTugas->tipe_label)
@section('page-title', 'Detail ' . $materiTugas->tipe_label)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header bg-{{ $materiTugas->tipe_badge_color }} text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <span class="badge bg-light text-{{ $materiTugas->tipe_badge_color }}">
                            {{ $materiTugas->tipe_label }}
                        </span>
                        {{ $materiTugas->judul }}
                    </h5>
                    <a href="{{ route('siswa.materi-tugas') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><i class="bi bi-book text-primary"></i> Mata Pelajaran:</strong><br>
                            {{ $materiTugas->mata_pelajaran }}
                        </p>
                        <p class="mb-2">
                            <strong><i class="bi bi-layers text-info"></i> Jenjang:</strong><br>
                            {{ $materiTugas->jenjang }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        @if($materiTugas->isTugas() && $materiTugas->deadline)
                        <p class="mb-2">
                            <strong><i class="bi bi-clock text-warning"></i> Deadline:</strong><br>
                            <span class="text-{{ $materiTugas->isDeadlinePassed() ? 'danger' : 'success' }}">
                                {{ $materiTugas->deadline_formatted }}
                            </span>
                            <br>
                            <small class="text-muted">{{ $materiTugas->sisa_waktu_deadline }}</small>
                        </p>
                        @endif
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><i class="bi bi-text-paragraph text-secondary"></i> Deskripsi</h6>
                <p>{!! nl2br(e($materiTugas->deskripsi)) !!}</p>

                @if($materiTugas->file_path)
                <hr>
                <h6 class="mb-3"><i class="bi bi-file-earmark text-success"></i> File Lampiran</h6>
                <a href="{{ route('siswa.materi-tugas.download', $materiTugas->id) }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Download File
                </a>
                @endif
            </div>
        </div>

        <!-- Form Kumpulkan Tugas -->
        @if($materiTugas->isTugas())
            @if($pengumpulan)
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Tugas Sudah Dikumpulkan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Tanggal Pengumpulan:</strong><br>
                                    {{ $pengumpulan->tanggal_pengumpulan_formatted }}
                                </p>
                                <p class="mb-2">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-{{ $pengumpulan->status_badge_color }}">
                                        {{ $pengumpulan->status_label }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                @if($pengumpulan->nilai)
                                <p class="mb-2">
                                    <strong>Nilai:</strong><br>
                                    <h3 class="text-primary">{{ $pengumpulan->nilai }}</h3>
                                    <span class="badge bg-{{ $pengumpulan->status_badge_color }}">
                                        Grade: {{ $pengumpulan->grade_label }}
                                    </span>
                                </p>
                                @endif
                            </div>
                        </div>

                        @if($pengumpulan->feedback_guru)
                        <hr>
                        <div class="alert alert-info mb-0">
                            <strong><i class="bi bi-chat-left-text"></i> Feedback Guru:</strong>
                            <p class="mb-0 mt-2">{{ $pengumpulan->feedback_guru }}</p>
                        </div>
                        @endif

                        @if($pengumpulan->file_path)
                        <hr>
                        <a href="{{ $pengumpulan->file_url }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark"></i> Lihat File Yang Dikumpulkan
                        </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-upload"></i> Kumpulkan Tugas</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('siswa.tugas.kumpulkan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="materi_tugas_id" value="{{ $materiTugas->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Upload File Tugas <span class="text-danger">*</span></label>
                                <input type="file" name="file_tugas" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</small>
                            </div>

                            @if($materiTugas->isDeadlinePassed())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i> 
                                <strong>Peringatan:</strong> Deadline sudah terlewat. Tugas yang dikumpulkan akan ditandai terlambat.
                            </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Kumpulkan Tugas
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection