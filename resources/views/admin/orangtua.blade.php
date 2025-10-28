<!-- View: admin/orangtua.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Orang Tua')
@section('page-title', 'Kelola Orang Tua')

@section('content')
<!-- Add Button -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">Data Orang Tua</h5>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrangTuaModal">
                    <i class="bi bi-plus-circle"></i> Tambah Orang Tua
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Orang Tua Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h5 class="fw-bold mb-0"><i class="bi bi-person-heart"></i> Daftar Orang Tua</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Pekerjaan</th>
                        <th>Jumlah Anak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orangTua as $index => $ot)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $ot->nama_lengkap }}</strong></td>
                        <td>{{ $ot->user->email }}</td>
                        <td>{{ $ot->no_telepon }}</td>
                        <td>{{ $ot->pekerjaan ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $ot->total_anak }} anak</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                    data-bs-target="#editOrangTuaModal{{ $ot->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.orangtua.delete', $ot->id) }}" method="POST" 
                                  id="delete-form-{{ $ot->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete('delete-form-{{ $ot->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada data orang tua</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($orangTua as $ot)
<div class="modal fade" id="editOrangTuaModal{{ $ot->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.orangtua.update', $ot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Orang Tua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control" name="nama_lengkap"
                                   value="{{ $ot->nama_lengkap }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon *</label>
                            <input type="text" class="form-control" name="no_telepon"
                                   value="{{ $ot->no_telepon }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat *</label>
                        <textarea class="form-control" name="alamat" rows="3" required>{{ $ot->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" value="{{ $ot->pekerjaan }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Add Orang Tua Modal -->
<div class="modal fade" id="addOrangTuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.orangtua.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Orang Tua Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih User *</label>
                        <select class="form-select" name="user_id" required>
                            <option value="">Pilih User (Role: Orang Tua)</option>
                            @foreach($usersOrangTua as $user)
                            <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya user dengan role Orang Tua yang belum memiliki profil</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" name="nama_lengkap" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. Telepon *</label>
                                <input type="text" class="form-control" name="no_telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat *</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection