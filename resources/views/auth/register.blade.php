@extends('layouts.app')

@section('title', 'Daftar - Bimbel Oriana Enilin')

@push('styles')
<style>
    .register-container {
        min-height: calc(100vh - 200px);
    }
    .register-card {
        max-width: 700px;
        margin: 0 auto;
    }
    .password-toggle {
        cursor: pointer;
    }
    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .step-indicator .step {
        flex: 1;
        text-align: center;
        padding: 10px;
        position: relative;
    }
    .step-indicator .step::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background-color: #dee2e6;
        z-index: -1;
    }
    .step-indicator .step:first-child::before {
        display: none;
    }
    .step-indicator .step.active .step-number {
        background-color: var(--primary-color);
        color: white;
    }
    .step-indicator .step.completed .step-number {
        background-color: var(--success-color);
        color: white;
    }
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #dee2e6;
        color: #6c757d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
@endpush

@section('content')
<section class="register-container py-5">
    <div class="container">
        <div class="register-card">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user-plus fa-3x text-primary"></i>
                        </div>
                        <h2 class="fw-bold">Daftar Akun Baru</h2>
                        <p class="text-muted">Untuk Orang Tua/Wali Siswa</p>
                    </div>

                    <!-- Registration Form -->
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <!-- Informasi Pribadi -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-user-circle"></i> Informasi Pribadi
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="nama_orang_tua" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nama_orang_tua') is-invalid @enderror" 
                                           id="nama_orang_tua" 
                                           name="nama_orang_tua" 
                                           value="{{ old('nama_orang_tua') }}"
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    @error('nama_orang_tua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="hubungan" class="form-label">Hubungan dengan Siswa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('hubungan') is-invalid @enderror" 
                                            id="hubungan" 
                                            name="hubungan" 
                                            required>
                                        <option value="">Pilih hubungan</option>
                                        <option value="ayah" {{ old('hubungan') == 'ayah' ? 'selected' : '' }}>Ayah</option>
                                        <option value="ibu" {{ old('hubungan') == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="wali" {{ old('hubungan') == 'wali' ? 'selected' : '' }}>Wali</option>
                                    </select>
                                    @error('hubungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <input type="text" 
                                           class="form-control @error('pekerjaan') is-invalid @enderror" 
                                           id="pekerjaan" 
                                           name="pekerjaan" 
                                           value="{{ old('pekerjaan') }}"
                                           placeholder="Contoh: Wiraswasta">
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" 
                                           name="telepon" 
                                           value="{{ old('telepon') }}"
                                           placeholder="08xxxxxxxxxx"
                                           required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="nama@email.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" 
                                              name="alamat" 
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap"
                                              required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Akun -->
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-3">
                                <i class="fas fa-lock"></i> Keamanan Akun
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Minimal 6 karakter"
                                               required>
                                        <span class="input-group-text bg-light password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                            <i class="fas fa-eye text-muted" id="toggleIcon1"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Password minimal 6 karakter</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Ulangi password"
                                               required>
                                        <span class="input-group-text bg-light password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                            <i class="fas fa-eye text-muted" id="toggleIcon2"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya menyetujui <a href="#" class="text-primary">syarat dan ketentuan</a> yang berlaku
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card border-0 bg-light mt-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle text-info me-2 mt-1"></i>
                        <div>
                            <small class="text-muted">
                                <strong>Catatan:</strong> Setelah mendaftar, Anda dapat menambahkan data anak dan memilih paket belajar. 
                                Admin kami akan memverifikasi pendaftaran Anda dalam 1x24 jam.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Password strength indicator (optional)
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        let strength = 0;
        
        if (password.length >= 6) strength++;
        if (password.length >= 10) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        // You can add visual feedback here if needed
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }
        
        if (!document.getElementById('terms').checked) {
            e.preventDefault();
            alert('Anda harus menyetujui syarat dan ketentuan!');
            return false;
        }
    });
</script>
@endpush
@endsection