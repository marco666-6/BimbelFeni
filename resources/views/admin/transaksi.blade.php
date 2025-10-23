<!-- View: admin/transaksi.blade.php -->
@extends('layouts.admin')
@section('title', 'Transaksi')
@section('page-title', 'Transaksi & Pembayaran')
@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.transaksi') }}">
            <div class="input-group">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ $status == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <span class="input-group-text"><i class="bi bi-funnel"></i></span>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom"><h5 class="fw-bold mb-0"><i class="bi bi-credit-card"></i> Daftar Transaksi</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Kode</th><th>Tanggal</th><th>Orang Tua</th><th>Siswa</th><th>Paket</th><th>Total</th><th>Bukti</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td><small><strong>{{ $t->kode_transaksi }}</strong></small></td>
                        <td><small>{{ $t->tanggal_transaksi->format('d/m/Y') }}</small></td>
                        <td>{{ $t->orangTua->nama_lengkap }}</td>
                        <td>{{ $t->siswa->nama_lengkap }}</td>
                        <td><small>{{ $t->paketBelajar->nama_paket }}</small></td>
                        <td><strong>{{ $t->total_pembayaran_formatted }}</strong></td>
                        <td>
                            @if($t->bukti_pembayaran)
                            <a href="{{ $t->bukti_pembayaran_url }}" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-image"></i></a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><span class="badge bg-{{ $t->status_badge_color }}">{{ $t->status_label }}</span></td>
                        <td>
                            @if($t->isPending())
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $t->id }}"><i class="bi bi-check-circle"></i></button>
                            @endif
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="verifyModal{{ $t->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.transaksi.verifikasi', $t->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h5 class="modal-title fw-bold">Verifikasi Pembayaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-3"><label class="form-label">Status Verifikasi *</label>
                                            <select class="form-select" name="status_verifikasi" required>
                                                <option value="verified">Terima (Verified)</option>
                                                <option value="rejected">Tolak (Rejected)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3"><label class="form-label">Catatan</label><textarea class="form-control" name="catatan_admin" rows="3"></textarea></div>
                                        <div class="alert alert-info"><strong>Info:</strong><br>- Siswa: {{ $t->siswa->nama_lengkap }}<br>- Paket: {{ $t->paketBelajar->nama_paket }}<br>- Total: {{ $t->total_pembayaran_formatted }}</div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Proses</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size: 3rem;"></i><p class="mt-2">Belum ada transaksi</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection