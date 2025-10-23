<!-- View: orangtua/profile.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Card Foto Profil -->
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ $user->foto_profil_url }}" alt="Foto Profil" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                <h5>{{ $user->username }}</h5>
                <p class="text-muted mb-0">{{ $orangTua->nama_lengkap }}</p>
                <span class="badge bg-primary mt-2">Orang Tua</span>
            </div>
        </div>

        <!-- Info Singkat -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-info-circle text-primary"></i> Informasi</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-envelope text-secondary"></i>
                        <strong>Email:</strong><br>
                        <span class="ms-4">{{ $user->email }}</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone text-secondary"></i>
                        <strong>No. Telepon:</strong><br>
                        <span class="ms-4">{{ $orangTua->no_telepon }}</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-briefcase text-secondary"></i>
                        <strong>Pekerjaan:</strong><br>
                        <span class="ms-4">{{ $orangTua->pekerjaan ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Form Edit Profil -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pencil-square text-primary"></i> Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h6 class="mb-3 text-primary">Informasi Akun</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto_profil" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                    </div>

                    <hr>

                    <h6 class="mb-3 text-primary">Informasi Personal</h6>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ $orangTua->nama_lengkap }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ $orangTua->no_telepon }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ $orangTua->pekerjaan }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ $orangTua->alamat }}</textarea>
                    </div>

                    <hr>

                    <h6 class="mb-3 text-primary">Ubah Password</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection