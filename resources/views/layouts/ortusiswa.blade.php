<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIDES Bimbel Oriana Enilin</title>
    
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
            --primary-blue: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --secondary-blue: #0ea5e9;
            --accent-cyan: #06b6d4;
            --gradient-primary: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            --gradient-secondary: linear-gradient(135deg, #1e40af 0%, #06b6d4 100%);
            --gradient-sidebar: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar { 
            min-height: 100vh;
            background: var(--gradient-sidebar);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .brand-logo { 
            color: #fff;
            font-weight: 700;
            font-size: 1.3rem;
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .brand-logo i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .brand-logo .small {
            font-size: 0.85rem;
            opacity: 0.8;
            font-weight: 500;
        }
        
        .sidebar .nav-link { 
            color: rgba(255, 255, 255, 0.8);
            padding: 0.9rem 1.2rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
        }
        
        .sidebar .nav-link:hover { 
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            border-left-color: #fff;
            padding-left: 1.5rem;
        }
        
        .sidebar .nav-link.active { 
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            border-left-color: #fff;
            font-weight: 600;
        }
        
        .sidebar .nav-link i { 
            margin-right: 0.7rem;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar .nav-link .badge {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Main Content */
        .main-content { 
            background: #f8fafc;
            min-height: 100vh;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }
        
        /* Top Navbar */
        .navbar-custom { 
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-custom .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            border: 2px solid transparent;
        }
        
        .profile-dropdown:hover {
            background: var(--gradient-primary);
            border-color: var(--primary-blue);
        }
        
        .profile-dropdown:hover .profile-name {
            color: #fff;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .profile-name {
            font-weight: 600;
            color: #1e293b;
            transition: color 0.3s ease;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.7rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            color: var(--primary-blue);
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
            width: 20px;
        }
        
        /* Card Styles */
        .card { 
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border-radius: 20px;
            transition: all 0.3s ease;
            background: #fff;
            margin-bottom: 1.5rem;
        }
        
        .card:hover { 
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.15);
        }
        
        .stat-card {
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Button Styles */
        .btn-primary { 
            background: var(--gradient-primary);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            background: var(--gradient-secondary);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            border-color: transparent;
            color: #fff;
            transform: translateY(-2px);
        }
        
        /* Badge Styles */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }
        
        .bg-primary {
            background: var(--gradient-primary) !important;
        }
        
        .bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }
        
        .bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }
        
        .bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }
        
        .bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        }
        
        /* Progress Bar */
        .progress {
            height: 10px;
            border-radius: 10px;
            background: #e2e8f0;
        }
        
        .progress-bar {
            border-radius: 10px;
        }
        
        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }
        
        /* List Group */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        
        .list-group-item:hover {
            background: #f8fafc;
            padding-left: 1.5rem;
        }
        
        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            background: var(--gradient-primary);
            color: #fff;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
            border: none;
        }
        
        .modal-title {
            font-weight: 700;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            border: none;
            padding: 1rem 2rem 1.5rem;
        }
        
        .btn-close {
            filter: brightness(0) invert(1);
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
        }
        
        /* Content Padding */
        .content-wrapper {
            padding: 2rem;
        }
        
        /* Gradient Cards */
        .bg-gradient-primary {
            background: var(--gradient-primary) !important;
        }
        
        .bg-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .bg-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        .bg-gradient > * {
            position: relative;
            z-index: 1;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .navbar-custom {
                padding: 1rem;
            }
            
            .content-wrapper {
                padding: 1rem;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="brand-logo">
                <i class="bi bi-mortarboard-fill"></i>
                <div>SIDES</div>
                <div class="small">{{ auth()->user()->isSiswa() ? 'Siswa' : 'Orang Tua' }}</div>
            </div>
            
            <nav class="nav flex-column">
                @if(auth()->user()->isOrangTua())
                    <a href="{{ route('orangtua.dashboard') }}" class="nav-link {{ request()->routeIs('orangtua.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('orangtua.anak') }}" class="nav-link {{ request()->routeIs('orangtua.anak*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Data Anak
                    </a>
                    <a href="{{ route('orangtua.paket-belajar') }}" class="nav-link {{ request()->routeIs('orangtua.paket-belajar') ? 'active' : '' }}">
                        <i class="bi bi-box-seam-fill"></i> Paket Belajar
                    </a>
                    <a href="{{ route('orangtua.transaksi') }}" class="nav-link {{ request()->routeIs('orangtua.transaksi') ? 'active' : '' }}">
                        <i class="bi bi-credit-card-fill"></i> Transaksi
                    </a>
                    <a href="{{ route('orangtua.feedback') }}" class="nav-link {{ request()->routeIs('orangtua.feedback') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text-fill"></i> Feedback
                    </a>
                    <a href="{{ route('orangtua.pengumuman') }}" class="nav-link {{ request()->routeIs('orangtua.pengumuman') ? 'active' : '' }}">
                        <i class="bi bi-megaphone-fill"></i> Pengumuman
                    </a>
                    <a href="{{ route('orangtua.notifikasi') }}" class="nav-link {{ request()->routeIs('orangtua.notifikasi') ? 'active' : '' }}">
                        <i class="bi bi-bell-fill"></i> Notifikasi
                        @if(auth()->user()->unread_notifications_count > 0)
                            <span class="badge bg-danger">{{ auth()->user()->unread_notifications_count }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.materi-tugas') }}" class="nav-link {{ request()->routeIs('siswa.materi-tugas*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i> Materi & Tugas
                    </a>
                    <a href="{{ route('siswa.jadwal') }}" class="nav-link {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                        <i class="bi bi-calendar-week-fill"></i> Jadwal
                    </a>
                    <a href="{{ route('siswa.nilai') }}" class="nav-link {{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">
                        <i class="bi bi-award-fill"></i> Nilai
                    </a>
                    <a href="{{ route('siswa.rapor') }}" class="nav-link {{ request()->routeIs('siswa.rapor') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text-fill"></i> Rapor
                    </a>
                    <a href="{{ route('siswa.kehadiran') }}" class="nav-link {{ request()->routeIs('siswa.kehadiran') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check-fill"></i> Kehadiran
                    </a>
                    <a href="{{ route('siswa.pengumuman') }}" class="nav-link {{ request()->routeIs('siswa.pengumuman*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone-fill"></i> Pengumuman
                    </a>
                    <a href="{{ route('siswa.notifikasi') }}" class="nav-link {{ request()->routeIs('siswa.notifikasi') ? 'active' : '' }}">
                        <i class="bi bi-bell-fill"></i> Notifikasi
                        @if(auth()->user()->unread_notifications_count > 0)
                            <span class="badge bg-danger">{{ auth()->user()->unread_notifications_count }}</span>
                        @endif
                    </a>
                @endif
                
                <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 1rem 0;"></div>
                <a href="{{ auth()->user()->isOrangTua() ? route('orangtua.profile') : route('siswa.profile') }}" class="nav-link">
                    <i class="bi bi-person-fill"></i> Profil
                </a>
                
                <div style="height: 2rem;"></div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-custom">
                <div class="container-fluid px-0">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    
                    <div class="dropdown">
                        <button class="profile-dropdown border-0 bg-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->foto_profil_url }}" alt="Profile" class="profile-img">
                            <span class="profile-name d-none d-md-inline">{{ auth()->user()->username }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="bi bi-globe"></i> Lihat Website
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ auth()->user()->isOrangTua() ? route('orangtua.profile') : route('siswa.profile') }}">
                                    <i class="bi bi-person-circle"></i> Profil Saya
                                </a>
                            </li>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    
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
                timer: 2000,
                iconColor: '#2563eb',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif
        
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        @endif
        
        // Confirm Action
        function confirmAction(message = 'Apakah Anda yakin?') {
            return Swal.fire({
                title: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>