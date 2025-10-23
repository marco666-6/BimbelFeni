<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - Bimbel Oriana Enilin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #fff !important; }
        .navbar-custom .nav-link:hover { opacity: 0.8; }
        .hero-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 100px 0; }
        .card { border: none; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-radius: 15px; transition: transform 0.3s; }
        .card:hover { transform: translateY(-10px); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-primary:hover { opacity: 0.9; }
        .footer { background: #2c3e50; color: #fff; padding: 40px 0; margin-top: 60px; }
        .feature-icon { font-size: 3rem; color: #667eea; }
        .section-title { font-weight: bold; margin-bottom: 2rem; position: relative; padding-bottom: 15px; }
        .section-title:after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background: #667eea; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill"></i> Bimbel Oriana Enilin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'fw-bold' : '' }}" href="{{ route('tentang') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('paket') ? 'fw-bold' : '' }}" href="{{ route('paket') }}">Paket Belajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'fw-bold' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary px-3 ms-2" href="{{ 
                                auth()->user()->isAdmin() ? route('admin.dashboard') : 
                                (auth()->user()->isOrangTua() ? route('orangtua.dashboard') : route('siswa.dashboard'))
                            }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary px-3 ms-2" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    @yield('content')
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-mortarboard-fill"></i> Bimbel Oriana Enilin</h5>
                    <p class="text-white-50">Lembaga bimbingan belajar terpercaya untuk siswa SD dan SMP di Batam, Kepulauan Riau.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Menu Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('tentang') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('paket') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Paket Belajar</a></li>
                        <li class="mb-2"><a href="{{ route('kontak') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <p class="text-white-50"><i class="bi bi-geo-alt-fill"></i> Batam, Kepulauan Riau</p>
                    <p class="text-white-50"><i class="bi bi-telephone-fill"></i> +62 812-3456-7890</p>
                    <p class="text-white-50"><i class="bi bi-envelope-fill"></i> info@bimbeloriana.com</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; {{ date('Y') }} Bimbel Oriana Enilin - SIDES (Student Information and Development Evaluation System). All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Alert Handler
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonText: 'OK'
            });
        @endif
        
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>