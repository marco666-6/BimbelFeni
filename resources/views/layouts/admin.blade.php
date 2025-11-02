<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SIDES Bimbel Oriana Enilin</title>
    
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
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar { 
            min-height: 100vh;
            height: 100vh; /* Add explicit height */
            background: var(--gradient-sidebar);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            overflow-y: auto; /* This was already there */
            overflow-x: hidden; /* Prevent horizontal scroll */
            display: flex;
            flex-direction: column;
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
            padding: 1.40rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .brand-logo i {
            font-size: 1.8rem;
        }
        
        .sidebar .nav-link { 
            color: rgba(255, 255, 255, 0.8);
            padding: 0.9rem 1.2rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
            font-size: 0.95rem;
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
        
        .sidebar-section-title {
            padding: 1rem 1.2rem 0.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
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
        }
        
        .card:hover { 
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.15);
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
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
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
        
        /* Table Styles */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            color: #1e293b;
            font-weight: 700;
            border: none;
            padding: 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
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
                <span>SIDES Admin</span>
            </div>
            
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                
                <div class="sidebar-section-title">Manajemen User</div>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Users
                </a>
                <a href="{{ route('admin.orangtua') }}" class="nav-link {{ request()->routeIs('admin.orangtua') ? 'active' : '' }}">
                    <i class="bi bi-person-heart"></i> Orang Tua
                </a>
                <a href="{{ route('admin.siswa') }}" class="nav-link {{ request()->routeIs('admin.siswa') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Siswa
                </a>
                
                <div class="sidebar-section-title">Akademik</div>
                <a href="{{ route('admin.paket') }}" class="nav-link {{ request()->routeIs('admin.paket') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i> Paket Belajar
                </a>
                <a href="{{ route('admin.jadwal') }}" class="nav-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week-fill"></i> Jadwal
                </a>
                <a href="{{ route('admin.kehadiran') }}" class="nav-link {{ request()->routeIs('admin.kehadiran') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check-fill"></i> Kehadiran
                </a>
                <a href="{{ route('admin.materi-tugas') }}" class="nav-link {{ request()->routeIs('admin.materi-tugas') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i> Materi & Tugas
                </a>
                <a href="{{ route('admin.pengumpulan-tugas') }}" class="nav-link {{ request()->routeIs('admin.pengumpulan-tugas') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i> Pengumpulan Tugas
                </a>
                
                <div class="sidebar-section-title">Keuangan</div>
                <a href="{{ route('admin.transaksi') }}" class="nav-link {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-fill"></i> Transaksi
                </a>
                
                <div class="sidebar-section-title">Komunikasi</div>
                <a href="{{ route('admin.feedback') }}" class="nav-link {{ request()->routeIs('admin.feedback') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text-fill"></i> Feedback
                </a>
                <a href="{{ route('admin.pengumuman') }}" class="nav-link {{ request()->routeIs('admin.pengumuman') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i> Pengumuman
                </a>
                
                <div class="sidebar-section-title">Laporan</div>
                <a href="{{ route('admin.laporan-siswa') }}" class="nav-link {{ request()->routeIs('admin.laporan-siswa*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Siswa
                </a>
                
                <div class="sidebar-section-title">Pengaturan</div>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Settings
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
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
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
        
        // Confirm Delete
        function confirmDelete(formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#2563eb',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
        
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>