@extends('layouts.app')

@section('title', 'Login - Bimbel Oriana Enilin')

@push('styles')
<style>
    .login-container {
        min-height: calc(100vh - 200px);
    }
    .login-card {
        max-width: 500px;
        margin: 0 auto;
    }
    .password-toggle {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<section class="login-container d-flex align-items-center py-5">
    <div class="container">
        <div class="login-card">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                        </div>
                        <h2 class="fw-bold">Selamat Datang</h2>
                        <p class="text-muted">Masuk ke akun Anda</p>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="nama@email.com"
                                       required 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password"
                                       required>
                                <span class="input-group-text bg-light password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye text-muted" id="toggleIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">
                                    Daftar Sekarang
                                </a>
                            </p>
                        </div>
                    </form>
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
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
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
</script>
@endpush
@endsection