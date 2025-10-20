@extends('layouts.ortusiswa')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Profil Saya</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->foto_profil)
                        <img src="{{ asset($user->foto_profil) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 3.5rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h4 class="mb-2">{{ $orangTua->nama_orang_tua }}</h4>
                <p class="text-muted mb-2">{{ ucfirst($orangTua->hubungan) }}</p>
                @if($orangTua->pekerjaan)
                <p class="text-muted mb-0"><i class="fas fa-briefcase"></i> {{ $orangTua->pekerjaan }}</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-info-circle"></i> Informasi Akun</h6>
                <div class="mb-2">
                    <small class="text-muted">Role:</small>
                    <p class="mb-0"><span class="badge bg-primary">Orang Tua</span></p>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Bergabung Sejak:</small>
                    <p class="mb-0">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_orang_tua" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_orang_tua" id="nama_orang_tua" class="form-control @error('nama_orang_tua') is-invalid @enderror" value="{{ old('nama_orang_tua', $orangTua->nama_orang_tua) }}" required>
                        @error('nama_orang_tua')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $user->telepon) }}" placeholder="08xx-xxxx-xxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hubungan" class="form-label">Hubungan dengan Siswa <span class="text-danger">*</span></label>
                            <select name="hubungan" id="hubungan" class="form-select @error('hubungan') is-invalid @enderror" required>
                                <option value="ayah" {{ old('hubungan', $orangTua->hubungan) == 'ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="ibu" {{ old('hubungan', $orangTua->hubungan) == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="wali" {{ old('hubungan', $orangTua->hubungan) == 'wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                            @error('hubungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan', $orangTua->pekerjaan) }}" placeholder="Contoh: Karyawan Swasta">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_profil" class="form-label">Foto Profil</label>
                        <input type="file" name="foto_profil" id="foto_profil" class="form-control @error('foto_profil') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        @error('foto_profil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-key"></i> Ubah Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection