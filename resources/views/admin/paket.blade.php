<!-- View: admin/paket.blade.php -->
@extends('layouts.admin')
@section('title', 'Kelola Paket Belajar')
@section('page-title', 'Kelola Paket Belajar')
@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaketModal">
            <i class="bi bi-plus-circle"></i> Tambah Paket
        </button>
    </div>
</div>

<div class="row g-4">
    @forelse($paket as $p)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-{{ $p->status == 'tersedia' ? 'success' : 'secondary' }} text-white">
                <h5 class="mb-0">{{ $p->nama_paket }}</h5>
            </div>
            <div class="card-body">
                <h3 class="fw-bold text-primary">{{ $p->harga_formatted }}</h3>
                <p class="text-muted mb-3">Durasi: {{ $p->durasi_bulan }} bulan</p>
                <p class="text-muted">{{ $p->deskripsi }}</p>
                <div class="mb-2">
                    <span class="badge bg-info">{{ $p->jenjang }}</span>
                    <span class="badge bg-{{ $p->status == 'tersedia' ? 'success' : 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $p->status)) }}</span>
                </div>
                <small class="text-muted"><i class="bi bi-cart"></i> {{ $p->transaksi_count }} transaksi</small>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('admin.paket.delete', $p->id) }}" method="POST" id="del-{{ $p->id }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('del-{{ $p->id }}')"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.paket.update', $p->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5 class="modal-title fw-bold">Edit Paket</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label">Nama Paket *</label><input type="text" class="form-control" name="nama_paket" value="{{ $p->nama_paket }}" required></div>
                            <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea class="form-control" name="deskripsi" rows="3" required>{{ $p->deskripsi }}</textarea></div>
                            <div class="row">
                                <div class="col-md-6"><div class="mb-3"><label class="form-label">Harga *</label><input type="number" class="form-control" name="harga" value="{{ $p->harga }}" required></div></div>
                                <div class="col-md-6"><div class="mb-3"><label class="form-label">Durasi (bulan) *</label><input type="number" class="form-control" name="durasi_bulan" value="{{ $p->durasi_bulan }}" required></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3"><label class="form-label">Jenjang *</label>
                                        <select class="form-select" name="jenjang" required>
                                            <option value="SD" {{ $p->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ $p->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SD & SMP" {{ $p->jenjang == 'SD & SMP' ? 'selected' : '' }}>SD & SMP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3"><label class="form-label">Status *</label>
                                        <select class="form-select" name="status" required>
                                            <option value="tersedia" {{ $p->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="tidak_tersedia" {{ $p->status == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12"><div class="text-center py-5 text-muted"><i class="bi bi-box-seam" style="font-size: 5rem;"></i><p class="mt-3">Belum ada paket belajar</p></div></div>
    @endforelse
</div>

<div class="modal fade" id="addPaketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.paket.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Paket Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Paket *</label><input type="text" class="form-control" name="nama_paket" required></div>
                    <div class="mb-3"><label class="form-label">Deskripsi *</label><textarea class="form-control" name="deskripsi" rows="3" required></textarea></div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label class="form-label">Harga *</label><input type="number" class="form-control" name="harga" required></div></div>
                        <div class="col-md-6"><div class="mb-3"><label class="form-label">Durasi (bulan) *</label><input type="number" class="form-control" name="durasi_bulan" required></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label class="form-label">Jenjang *</label><select class="form-select" name="jenjang" required><option value="">Pilih</option><option value="SD">SD</option><option value="SMP">SMP</option><option value="SD & SMP">SD & SMP</option></select></div></div>
                        <div class="col-md-6"><div class="mb-3"><label class="form-label">Status *</label><select class="form-select" name="status" required><option value="tersedia">Tersedia</option><option value="tidak_tersedia">Tidak Tersedia</option></select></div></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endsection