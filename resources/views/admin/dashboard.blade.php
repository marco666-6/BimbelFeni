<!-- View: admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Siswa</h6>
                        <h2 class="fw-bold mb-0">{{ $totalSiswa }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-people-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Orang Tua</h6>
                        <h2 class="fw-bold mb-0">{{ $totalOrangTua }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-person-heart" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Paket</h6>
                        <h2 class="fw-bold mb-0">{{ $totalPaket }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-box-seam" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Transaksi Pending</h6>
                        <h2 class="fw-bold mb-0">{{ $transaksiPending }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Feedback Baru</h5>
                    <span class="badge bg-danger">{{ $feedbackBaru }}</span>
                </div>
                <p class="text-muted mb-0">Ada {{ $feedbackBaru }} feedback baru yang perlu ditindaklanjuti</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Verifikasi Pembayaran</h5>
                    <span class="badge bg-warning">{{ $transaksiPending }}</span>
                </div>
                <p class="text-muted mb-0">Ada {{ $transaksiPending }} pembayaran menunggu verifikasi</p>
            </div>
        </div>
    </div>
</div>

<!-- Tables -->
<div class="row g-4">
    <!-- Recent Transaksi -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-credit-card text-primary"></i> Transaksi Terbaru</h5>
                    <a href="{{ route('admin.transaksi') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body">
                @if($recentTransaksi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Siswa</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransaksi as $transaksi)
                                <tr>
                                    <td><small>{{ $transaksi->kode_transaksi }}</small></td>
                                    <td>{{ $transaksi->siswa->nama_lengkap }}</td>
                                    <td><strong>{{ $transaksi->total_pembayaran_formatted }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $transaksi->status_badge_color }}">
                                            {{ $transaksi->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Feedback -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-chat-left-text text-success"></i> Feedback Terbaru</h5>
                    <a href="{{ route('admin.feedback') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body">
                @if($recentFeedback->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentFeedback as $feedback)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $feedback->siswa->nama_lengkap }}</h6>
                                    <p class="mb-1 text-muted small">{{ Str::limit($feedback->isi_feedback, 80) }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> {{ $feedback->tanggal_feedback_formatted }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $feedback->status_badge_color }}">
                                    {{ $feedback->status_label }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2">Belum ada feedback</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection