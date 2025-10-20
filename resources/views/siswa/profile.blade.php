@extends('layouts.ortusiswa')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="fas fa-user-circle"></i> Profil Saya</h2>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->foto_profil)
                        <img src="{{ asset($user->foto_profil) }}" alt="Foto Profil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px; font-size: 3rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ ucfirst($user->role) }}</p>
                <span class="badge bg-{{ $siswa->status === 'aktif' ? 'success' : 'secondary' }}">
                    Status: {{ ucfirst($siswa->status) }}
                </span>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Siswa
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-school text-primary"></i>
                        <strong>Jenjang:</strong> {{ $siswa->jenjang }}
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-graduation-cap text-primary"></i>
                        <strong>Kelas:</strong> {{ $siswa->kelas }}
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-birthday-cake text-primary"></i>
                        <strong>Tanggal Lahir:</strong><br>
                        {{ $siswa->getTanggalLahirFormatted() }}
                    </li>
                    @if($siswa->getUmur())
                        <li class="mb-2">
                            <i class="fas fa-calendar text-primary"></i>
                            <strong>Umur:</strong> {{ $siswa->getUmur() }} tahun
                        </li>
                    @endif
                    <li class="mb-2">
                        <i class="fas fa-user-friends text-primary"></i>
                        <strong>Orang Tua:</strong><br>
                        {{ $siswa->orangTua->nama_orang_tua ?? '-' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Edit Profile Form -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Edit Profil
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" 
                                   id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $user->name) }}" required>
                            @error('nama_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" value="{{ old('telepon', $user->telepon) }}">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control @error('foto_profil') is-invalid @enderror" 
                                   id="foto_profil" name="foto_profil" accept="image/jpeg,image/png,image/jpg">
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPEG, PNG, JPG (Maks. 2MB)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Statistik Belajar
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card primary p-3 rounded">
                            <h4 class="mb-0">{{ $siswa->getMateriCount() }}</h4>
                            <small class="text-muted">Total Materi</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card success p-3 rounded">
                            <h4 class="mb-0">{{ $siswa->getTugasSelesai() }}</h4>
                            <small class="text-muted">Tugas Selesai</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card warning p-3 rounded">
                            <h4 class="mb-0">{{ $siswa->getTugasPending() }}</h4>
                            <small class="text-muted">Tugas Pending</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card info p-3 rounded">
                            <h4 class="mb-0">{{ round($siswa->getNilaiRataRata(), 2) ?? 0 }}</h4>
                            <small class="text-muted">Nilai Rata-rata</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-key"></i> Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection