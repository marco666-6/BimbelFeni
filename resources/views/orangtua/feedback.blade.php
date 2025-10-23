<!-- View: orangtua/feedback.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Feedback')
@section('page-title', 'Feedback')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Form Kirim Feedback -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-chat-left-text"></i> Kirim Feedback</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.feedback.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Anak <span class="text-danger">*</span></label>
                        <select name="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Anak --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Feedback <span class="text-danger">*</span></label>
                        <textarea name="isi_feedback" class="form-control" rows="5" placeholder="Tulis feedback atau tanggapan Anda..." required></textarea>
                        <small class="text-muted">Sampaikan feedback mengenai perkembangan atau kendala anak Anda</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send"></i> Kirim Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Riwayat Feedback -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-chat-dots text-primary"></i> Riwayat Feedback</h5>
            </div>
            <div class="card-body">
                @if($feedback->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada feedback yang dikirim.
                    </div>
                @else
                    @foreach($feedback as $f)
                    <div class="card mb-3 border-start border-4 border-{{ $f->isBaru() ? 'warning' : 'success' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bi bi-person text-primary"></i> 
                                        {{ $f->siswa->nama_lengkap }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 
                                        {{ $f->tanggal_feedback_formatted }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $f->status_badge_color }}">
                                    {{ $f->status_label }}
                                </span>
                            </div>

                            <div class="alert alert-light mb-2">
                                <strong>Feedback Anda:</strong>
                                <p class="mb-0 mt-2">{{ $f->isi_feedback }}</p>
                            </div>

                            @if($f->isSudahDibalas())
                                <div class="alert alert-success mb-0">
                                    <strong><i class="bi bi-reply-fill"></i> Balasan Admin:</strong>
                                    <p class="mb-0 mt-2">{{ $f->balasan_admin }}</p>
                                </div>
                            @else
                                <small class="text-muted">
                                    <i class="bi bi-hourglass-split"></i> Menunggu balasan dari admin
                                </small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection