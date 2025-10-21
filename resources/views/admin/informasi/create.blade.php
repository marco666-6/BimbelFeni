{{-- resources/views/admin/informasi/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Informasi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Informasi</h1>
    <a href="{{ route('admin.informasi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.informasi.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pengumuman" {{ old('jenis') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="notifikasi" {{ old('jenis') == 'notifikasi' ? 'selected' : '' }}>Notifikasi</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_siswa" class="form-label">Untuk Siswa (Opsional)</label>
                        <select class="form-select @error('id_siswa') is-invalid @enderror" id="id_siswa" name="id_siswa">
                            <option value="">Semua Siswa</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id_siswa }}" {{ old('id_siswa') == $siswa->id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_siswa }} ({{ $siswa->jenjang }} - {{ $siswa->kelas }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kosongkan jika untuk semua siswa</small>
                        @error('id_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                       id="judul" name="judul" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="isi" class="form-label">Isi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('isi') is-invalid @enderror" 
                          id="isi" name="isi" rows="6" required>{{ old('isi') }}</textarea>
                @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.informasi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection