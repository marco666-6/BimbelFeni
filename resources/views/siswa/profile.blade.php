<!-- View: siswa/profile.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profil Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $user->foto_profil_url }}" 
                         alt="Foto Profil" 
                         class="rounded-circle mb-3" 
                         width="150" 
                         height="150"
                         style="object-fit: cover; border: 5px solid #e9ecef;">
                    
                    <h4 class="mb-1">{{ $siswa->nama_lengkap }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-around mb-3">
                        <div>
                            <h5 class="mb-0 text-primary">{{ $siswa->jenjang }}</h5>
                            <small class="text-muted">Jenjang</small>
                        </div>
                        <div class="vr"></div>
                        <div>
                            <h5 class="mb-0 text-primary">{{ $siswa->kelas }}</h5>
                            <small class="text-muted">Kelas</small>
                        </div>
                        <div class="vr"></div>
                        <div>
                            <h5 class="mb-0 text-primary">{{ $siswa->usia }} Tahun</h5>
                            <small class="text-muted">Usia</small>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <small>Status: <strong class="text-uppercase">{{ $user->status }}</strong></small>
                    </div>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-person"></i> Informasi Orang Tua</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Nama</td>
                            <td class="text-end"><strong>{{ $siswa->orangTua->nama_lengkap }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. Telepon</td>
                            <td class="text-end"><strong>{{ $siswa->orangTua->no_telepon }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pekerjaan</td>
                            <td class="text-end"><strong>{{ $siswa->orangTua->pekerjaan ?? '-' }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" 
                                   class="form-control @error('foto_profil') is-invalid @enderror" 
                                   name="foto_profil" 
                                   accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Data Akun -->
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="bi bi-person-badge"></i> Data Akun
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       name="username" 
                                       value="{{ old('username', $user->username) }}" 
                                       required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="bi bi-lock"></i> Ubah Password
                        </h6>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <small>Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password">
                                <small class="text-muted">Minimal 6 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       name="password_confirmation">
                            </div>
                        </div>

                        <!-- Data Siswa -->
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="bi bi-person"></i> Data Siswa
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" 
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}" 
                                       required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenjang</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $siswa->jenjang }}" 
                                       disabled>
                                <small class="text-muted">Tidak dapat diubah</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kelas') is-invalid @enderror" 
                                       name="kelas" 
                                       value="{{ old('kelas', $siswa->kelas) }}" 
                                       placeholder="Contoh: 7A, 8B"
                                       required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
@endsection