<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - {{ $settings->nama_website ?? 'Bimbel Oriana Enilin' }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Existing */
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --secondary-blue: #0ea5e9;
            --accent-cyan: #06b6d4;
            --gradient-primary: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            --gradient-secondary: linear-gradient(135deg, #1e40af 0%, #06b6d4 100%);
            --gradient-hero: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);

            /* New Color Variables */
            --info-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;

            --gradient-info: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: #f8fafc;
        }
        
        /* Navbar Styles */
        .navbar-custom { 
            background: rgba(30, 64, 175, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-custom.scrolled {
            background: rgba(30, 64, 175, 0.98);
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-custom .navbar-brand { 
            color: #fff !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .navbar-custom .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-custom .nav-link { 
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fff;
            transition: width 0.3s ease;
        }
        
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.fw-bold::after {
            width: 100%;
        }
        
        .navbar-custom .nav-link:hover { 
            color: #fff;
        }
        
        .btn-navbar-login {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff !important;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-navbar-login:hover {
            background: #fff;
            color: black !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }
        
        /* Hero Section */
        .hero-section { 
            background: var(--gradient-hero);
            color: #fff;
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 1;
        }
        
        /* Card Styles */
        .card { 
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            background: #fff;
        }
        
        .card:hover { 
            transform: translateY(-15px);
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.2);
        }
        
        .card-header {
            border: none;
            background: var(--gradient-primary);
            padding: 1.5rem;
        }
        
        .card-footer {
            border: none;
            background: transparent;
            padding: 1.5rem;
        }
        
        /* Button Styles */
        .btn-primary { 
            background: var(--gradient-primary);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            background: var(--gradient-secondary);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            border-color: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }
        
        .btn-light {
            background: #fff;
            color: var(--primary-blue);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }
        
        .btn-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.5);
            color: var(--primary-dark);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: #fff;
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background: #fff;
            color: var(--primary-blue);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        /* ======================================================
        SOLID BUTTONS
        ====================================================== */
        .btn-info {
            background: var(--gradient-info);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }
        .btn-info:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }

        .btn-success {
            background: var(--gradient-success);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-success:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #059669, #6ee7b7);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .btn-warning {
            background: var(--gradient-warning);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        .btn-warning:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #d97706, #facc15);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
        }

        .btn-danger {
            background: var(--gradient-danger);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        .btn-danger:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #dc2626, #fca5a5);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
        }

        /* ======================================================
        OUTLINE BUTTONS
        ====================================================== */
        .btn-outline-info {
            border: 2px solid var(--info-color);
            color: var(--info-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-info:hover {
            background: var(--gradient-info);
            border-color: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.3);
        }

        .btn-outline-success {
            border: 2px solid var(--success-color);
            color: var(--success-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-success:hover {
            background: var(--gradient-success);
            border-color: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-outline-warning {
            border: 2px solid var(--warning-color);
            color: var(--warning-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-warning:hover {
            background: var(--gradient-warning);
            border-color: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
        }

        .btn-outline-danger {
            border: 2px solid var(--danger-color);
            color: var(--danger-color);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-danger:hover {
            background: var(--gradient-danger);
            border-color: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }
        
        /* Badge Styles */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .bg-primary {
            background: var(--gradient-primary) !important;
        }
        
        /* Footer Styles */
        .footer { 
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            padding: 60px 0 20px;
            margin-top: 80px;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }
        
        .footer h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer a {
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--secondary-blue) !important;
            padding-left: 5px;
        }
        
        /* Feature Icon */
        .feature-icon { 
            font-size: 3.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Section Title */
        .section-title { 
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 20px;
            font-size: 2.5rem;
            color: #1e293b;
        }
        
        .section-title::after { 
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }
        
        /* Background Utilities */
        .bg-light {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%) !important;
        }
        
        .bg-primary-section {
            background: var(--gradient-primary) !important;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0 60px;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .feature-icon {
                font-size: 2.5rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>{{ $settings->nama_website ?? 'Bimbel Oriana Enilin' }}</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
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
                        <li class="nav-item ms-2">
                            <a class="nav-link btn-navbar-login" href="{{ 
                                auth()->user()->isAdmin() ? route('admin.dashboard') : 
                                (auth()->user()->isOrangTua() ? route('orangtua.dashboard') : route('siswa.dashboard'))
                            }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="nav-link btn-navbar-login" href="{{ route('login') }}">
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
                    <h5><i class="bi bi-mortarboard-fill"></i> {{ $settings->nama_website ?? 'Bimbel Oriana Enilin' }}</h5>
                    <p class="text-white-50">{{ $settings->tentang ?? 'Lembaga bimbingan belajar terpercaya untuk siswa SD dan SMP di Batam, Kepulauan Riau.' }}</p>
                    <div class="mt-4">
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Menu Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('tentang') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('paket') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Paket Belajar</a></li>
                        <li class="mb-2"><a href="{{ route('kontak') }}" class="text-white-50 text-decoration-none"><i class="bi bi-chevron-right"></i> Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Hubungi Kami</h5>
                    <p class="text-white-50"><i class="bi bi-geo-alt-fill text-primary"></i> {{ $settings->alamat ?? 'Batam, Kepulauan Riau' }}</p>
                    <p class="text-white-50"><i class="bi bi-telephone-fill text-primary"></i> {{ $settings->no_telepon ?? '+62 812-3456-7890' }}</p>
                    <p class="text-white-50"><i class="bi bi-envelope-fill text-primary"></i> {{ $settings->email ?? 'info@bimbeloriana.com' }}</p>
                    @if($settings->nama_bank && $settings->nomor_rekening)
                    <p class="text-white-50"><i class="bi bi-bank text-primary"></i> {{ $settings->nama_bank }} - {{ $settings->nomor_rekening }} a.n. {{ $settings->atas_nama }}</p>
                    @endif
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $settings->nama_website ?? 'Bimbel Oriana Enilin' }} - SIDES (Student Information and Development Evaluation System). All Rights Reserved.</p>
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
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
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
                timer: 2000,
                background: '#fff',
                iconColor: '#2563eb'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2563eb'
            });
        @endif
        
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2563eb'
            });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>