<!-- View: admin/siswa.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 fw-bold">Data Siswa</h5>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSiswaModal">
                    <i class="bi bi-plus-circle"></i> Tambah Siswa
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h5 class="fw-bold mb-0"><i class="bi bi-person-badge"></i> Daftar Siswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Jenjang</th>
                        <th>Kelas</th>
                        <th>Orang Tua</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $s->nama_lengkap }}</strong></td>
                        <td>{{ $s->user->email }}</td>
                        <td><span class="badge bg-{{ $s->jenjang == 'SD' ? 'primary' : 'success' }}">{{ $s->jenjang }}</span></td>
                        <td>{{ $s->kelas }}</td>
                        <td>{{ $s->orangTua->nama_lengkap }}</td>
                        <td><span class="badge bg-{{ $s->user->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($s->user->status) }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSiswaModal{{ $s->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.siswa.delete', $s->id) }}" method="POST" id="delete-form-{{ $s->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $s->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada data siswa</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($siswa as $s)
<!-- Edit Modal -->
<div class="modal fade" id="editSiswaModal{{ $s->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.siswa.update', $s->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Orang Tua *</label>
                        <select class="form-select" name="orangtua_id" required>
                            @foreach($orangTua as $ot)
                            <option value="{{ $ot->id }}" {{ $s->orangtua_id == $ot->id ? 'selected' : '' }}>
                                {{ $ot->nama_lengkap }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" name="nama_lengkap" value="{{ $s->nama_lengkap }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir *</label>
                                <input type="date" class="form-control" name="tanggal_lahir" value="{{ $s->tanggal_lahir->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenjang *</label>
                                <select class="form-select" name="jenjang" required>
                                    <option value="SD" {{ $s->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ $s->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kelas *</label>
                                <input type="text" class="form-control" name="kelas" value="{{ $s->kelas }}" required>
                            </div>
                        </div>
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

<!-- Add Siswa Modal -->
<div class="modal fade" id="addSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih User *</label>
                        <select class="form-select" name="user_id" required>
                            <option value="">Pilih User (Role: Siswa)</option>
                            @foreach($usersSiswa as $user)
                            <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orang Tua *</label>
                        <select class="form-select" name="orangtua_id" required>
                            <option value="">Pilih Orang Tua</option>
                            @foreach($orangTua as $ot)
                            <option value="{{ $ot->id }}">{{ $ot->nama_lengkap }}</option>
                            @endforeach
                        </select>
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
                                <label class="form-label">Tanggal Lahir *</label>
                                <input type="date" class="form-control" name="tanggal_lahir" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenjang *</label>
                                <select class="form-select" name="jenjang" required>
                                    <option value="">Pilih Jenjang</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kelas *</label>
                                <input type="text" class="form-control" name="kelas" placeholder="Contoh: 5A" required>
                            </div>
                        </div>
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