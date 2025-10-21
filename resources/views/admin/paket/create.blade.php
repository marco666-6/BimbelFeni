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

<div class="card">
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
                        <label for="durasi" class="form-label">Durasi (bulan) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                               id="durasi" name="durasi" value="{{ old('durasi') }}" min="1" required>
                        @error('durasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="komentar" class="form-label">Komentar / Catatan</label>
                <textarea class="form-control @error('komentar') is-invalid @enderror" 
                          id="komentar" name="komentar" rows="3">{{ old('komentar') }}</textarea>
                @error('komentar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection