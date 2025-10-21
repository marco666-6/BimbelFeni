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

<div class="card">
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
                        <label for="durasi" class="form-label">Durasi (bulan) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                               id="durasi" name="durasi" value="{{ old('durasi', $paket->durasi) }}" min="1" required>
                        @error('durasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="komentar" class="form-label">Komentar / Catatan</label>
                <textarea class="form-control @error('komentar') is-invalid @enderror" 
                          id="komentar" name="komentar" rows="3">{{ old('komentar', $paket->komentar) }}</textarea>
                @error('komentar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection