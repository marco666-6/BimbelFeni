<!-- View: siswa/nilai.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Nilai Tugas')
@section('page-title', 'Nilai Tugas')

@section('content')
<div class="row">
    <!-- Statistik Nilai -->
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-star fs-1 text-warning"></i>
                <h3 class="mt-2 mb-0">{{ number_format($rataNilai, 2) }}</h3>
                <small class="text-muted">Rata-rata Nilai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-arrow-up-circle fs-1 text-success"></i>
                <h3 class="mt-2 mb-0">{{ $nilaiTertinggi }}</h3>
                <small class="text-muted">Nilai Tertinggi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-arrow-down-circle fs-1 text-danger"></i>
                <h3 class="mt-2 mb-0">{{ $nilaiTerendah }}</h3>
                <small class="text-muted">Nilai Terendah</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clipboard-check fs-1 text-info"></i>
                <h3 class="mt-2 mb-0">{{ $totalDinilai }}</h3>
                <small class="text-muted">Tugas Dinilai</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-award text-primary"></i> Daftar Nilai Tugas</h5>
            </div>
            <div class="card-body">
                @if($pengumpulanTugas->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada tugas yang dikumpulkan.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Judul Tugas</th>
                                    <th width="10%">Nilai</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengumpulanTugas as $p)
                                <tr>
                                    <td>{{ $p->tanggal_pengumpulan->format('d/m/Y') }}</td>
                                    <td>{{ $p->materiTugas->mata_pelajaran }}</td>
                                    <td>{{ $p->materiTugas->judul }}</td>
                                    <td>
                                        @if($p->nilai)
                                            <strong class="text-primary">{{ $p->nilai }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->nilai)
                                            <span class="badge bg-{{ $p->status_badge_color }}">
                                                {{ $p->grade_label }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $p->status_badge_color }}">
                                            {{ $p->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($p->feedback_guru)
                                            <button class="btn btn-sm btn-info" onclick="showFeedback('{{ addslashes($p->feedback_guru) }}', '{{ $p->materiTugas->judul }}')">
                                                <i class="bi bi-chat-dots"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackTitle">Feedback Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="feedbackContent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showFeedback(feedback, judul) {
        $('#feedbackTitle').text('Feedback: ' + judul);
        $('#feedbackContent').html('<p>' + feedback + '</p>');
        $('#feedbackModal').modal('show');
    }
</script>
@endpush
@endsection