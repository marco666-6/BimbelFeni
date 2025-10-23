<!-- View: orangtua/transaksi.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-credit-card text-primary"></i> Riwayat Transaksi Pembayaran</h5>
            </div>
            <div class="card-body">
                @if($transaksi->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada riwayat transaksi.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Nama Anak</th>
                                    <th>Paket</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $t)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $t->kode_transaksi }}</strong>
                                    </td>
                                    <td>{{ $t->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <i class="bi bi-person text-secondary me-1"></i>
                                        {{ $t->siswa->nama_lengkap }}
                                    </td>
                                    <td>{{ $t->paketBelajar->nama_paket }}</td>
                                    <td>
                                        <strong>{{ $t->total_pembayaran_formatted }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $t->status_badge_color }}">
                                            {{ $t->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="showDetailModal({{ $t->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Statistik -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="mb-0 text-primary">{{ $transaksi->count() }}</h4>
                                    <small class="text-muted">Total Transaksi</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="mb-0 text-warning">{{ $transaksi->where('status_verifikasi', 'pending')->count() }}</h4>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="mb-0 text-success">{{ $transaksi->where('status_verifikasi', 'verified')->count() }}</h4>
                                    <small class="text-muted">Verified</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="mb-0 text-danger">{{ $transaksi->where('status_verifikasi', 'rejected')->count() }}</h4>
                                    <small class="text-muted">Rejected</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showDetailModal(id) {
        const transaksi = @json($transaksi);
        const detail = transaksi.find(t => t.id === id);
        
        if (!detail) return;
        
        let html = `
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Kode Transaksi:</strong><br>
                    <span class="text-primary">${detail.kode_transaksi}</span>
                </div>
                <div class="col-md-6">
                    <strong>Tanggal:</strong><br>
                    ${new Date(detail.tanggal_transaksi).toLocaleString('id-ID')}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Nama Anak:</strong><br>
                    ${detail.siswa.nama_lengkap}
                </div>
                <div class="col-md-6">
                    <strong>Paket:</strong><br>
                    ${detail.paket_belajar.nama_paket}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Total Pembayaran:</strong><br>
                    <h4 class="text-success">${detail.total_pembayaran_formatted}</h4>
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong><br>
                    <span class="badge bg-${detail.status_badge_color}">${detail.status_label}</span>
                </div>
            </div>
        `;
        
        if (detail.catatan_admin) {
            html += `
                <div class="alert alert-info">
                    <strong><i class="bi bi-info-circle"></i> Catatan Admin:</strong><br>
                    ${detail.catatan_admin}
                </div>
            `;
        }
        
        if (detail.bukti_pembayaran_url) {
            html += `
                <div class="mt-3">
                    <strong>Bukti Pembayaran:</strong><br>
                    <img src="${detail.bukti_pembayaran_url}" class="img-fluid rounded mt-2" style="max-height: 400px;">
                </div>
            `;
        }
        
        $('#detailContent').html(html);
        $('#detailModal').modal('show');
    }
</script>
@endpush
@endsection