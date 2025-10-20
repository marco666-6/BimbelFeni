{{-- resources/views/admin/paket/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Paket Belajar - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Paket Belajar</h1>
    <a href="{{ route('admin.paket.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Paket
    </a>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-box"></i> Daftar Paket Belajar
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Harga/Bulan</th>
                        <th>Pendaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $index => $paket)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $paket->nama_paket }}</strong>
                                @if($paket->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($paket->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $paket->getFormattedHarga() }}</td>
                            <td>{{ $paket->durasi }} bulan</td>
                            <td>{{ $paket->getFormattedHargaBulanan() }}</td>
                            <td>
                                <span class="badge bg-info">{{ $paket->pendaftaran_count }} siswa</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.paket.edit', $paket->id_paket) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.paket.destroy', $paket->id_paket) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada paket belajar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/admin/paket/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Paket Belajar - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Paket Belajar</h1>
    <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus"></i> Form Tambah Paket
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paket.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                               id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" required>
                        @error('nama_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" name="harga" value="{{ old('harga') }}" min="0" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="durasi" class="form-label">Durasi (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                                       id="durasi" name="durasi" value="{{ old('durasi') }}" min="1" required>
                                @error('durasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar/Catatan</label>
                        <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                  id="komentar" name="komentar" rows="3">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi
            </div>
            <div class="card-body">
                <p class="text-muted small">
                    <i class="fas fa-lightbulb"></i> <strong>Tips:</strong>
                </p>
                <ul class="small text-muted">
                    <li>Nama paket harus jelas dan menarik</li>
                    <li>Deskripsi jelaskan manfaat paket</li>
                    <li>Harga dalam rupiah penuh</li>
                    <li>Durasi dalam bulan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/admin/paket/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Paket Belajar - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Paket Belajar</h1>
    <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Form Edit Paket
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paket.update', $paket->id_paket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                               id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                        @error('nama_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" name="harga" value="{{ old('harga', $paket->harga) }}" min="0" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="durasi" class="form-label">Durasi (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                                       id="durasi" name="durasi" value="{{ old('durasi', $paket->durasi) }}" min="1" required>
                                @error('durasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar/Catatan</label>
                        <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                  id="komentar" name="komentar" rows="3">{{ old('komentar', $paket->komentar) }}</textarea>
                        @error('komentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Statistik Paket
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Pendaftar</small>
                    <h4>{{ $paket->getTotalPendaftar() }} siswa</h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Pendaftar Diterima</small>
                    <h5 class="text-success">{{ $paket->getPendaftarDiterima() }}</h5>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Menunggu Persetujuan</small>
                    <h5 class="text-warning">{{ $paket->getPendaftarMenunggu() }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection