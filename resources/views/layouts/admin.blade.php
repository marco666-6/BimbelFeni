<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - SIDES')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4e73df;
            --sidebar-bg: #2c3e50;
            --topbar-height: 60px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        #wrapper {
            display: flex;
        }
        
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        
        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }
        
        #sidebar .sidebar-brand {
            padding: 1rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        #sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }
        
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left: 3px solid var(--primary-color);
        }
        
        #sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        #content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        
        #content-wrapper.full-width {
            margin-left: 0;
        }
        
        .topbar {
            height: var(--topbar-height);
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: bold;
        }
        
        .stat-card {
            border-left: 4px solid;
        }
        
        .stat-card.primary { border-left-color: #4e73df; }
        .stat-card.success { border-left-color: #1cc88a; }
        .stat-card.warning { border-left-color: #f6c23e; }
        .stat-card.danger { border-left-color: #e74a3b; }
        .stat-card.info { border-left-color: #36b9cc; }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .badge {
            padding: 0.35rem 0.6rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #sidebar.active {
                margin-left: 0;
            }
            
            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i> SIDES Admin
            </div>
            <nav class="nav flex-column mt-3">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('admin.paket.index') }}" class="nav-link {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-box"></i> Paket Belajar
                </a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-clipboard-list"></i> Pendaftaran
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-user-graduate"></i> Siswa
                </a>
                <a href="{{ route('admin.orangtua.index') }}" class="nav-link {{ request()->routeIs('admin.orangtua.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-users"></i> Orang Tua
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-calendar"></i> Jadwal & Materi
                </a>
                <a href="{{ route('admin.transaksi.index') }}" class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-money-bill"></i> Transaksi
                </a>
                <a href="{{ route('admin.informasi.index') }}" class="nav-link {{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-bell"></i> Informasi
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-file-alt"></i> Laporan
                </a>
                <a href="{{ route('admin.statistik') }}" class="nav-link {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-chart-bar"></i> Statistik
                </a>
                <hr class="bg-white">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-fw fa-home"></i> Ke Website
                </a>
            </nav>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Topbar -->
            <nav class="topbar d-flex align-items-center justify-content-between px-4">
                <button class="btn btn-link" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid p-4">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="text-center py-3 bg-light mt-4">
                <div class="container">
                    <span class="text-muted">&copy; {{ date('Y') }} SIDES - Bimbel Oriana Enilin</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content-wrapper').classList.toggle('full-width');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>