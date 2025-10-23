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
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 0.8rem 1.2rem; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .nav-link i { margin-right: 0.5rem; }
        .main-content { background: #f8f9fa; min-height: 100vh; }
        .navbar-custom { background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card { border: none; box-shadow: 0 0 20px rgba(0,0,0,0.05); border-radius: 10px; }
        .badge-notif { position: absolute; top: -5px; right: -5px; }
        .brand-logo { color: #fff; font-weight: bold; font-size: 1.2rem; padding: 1rem; }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 col-lg-2 px-0 sidebar">
                <div class="brand-logo text-center border-bottom border-secondary pb-3">
                    <i class="bi bi-mortarboard-fill"></i> SIDES Admin
                </div>
                
                <nav class="nav flex-column mt-3">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">MANAJEMEN USER</div>
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <a href="{{ route('admin.orangtua') }}" class="nav-link {{ request()->routeIs('admin.orangtua') ? 'active' : '' }}">
                        <i class="bi bi-person-heart"></i> Orang Tua
                    </a>
                    <a href="{{ route('admin.siswa') }}" class="nav-link {{ request()->routeIs('admin.siswa') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> Siswa
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">AKADEMIK</div>
                    <a href="{{ route('admin.paket') }}" class="nav-link {{ request()->routeIs('admin.paket') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Paket Belajar
                    </a>
                    <a href="{{ route('admin.jadwal') }}" class="nav-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }}">
                        <i class="bi bi-calendar-week"></i> Jadwal
                    </a>
                    <a href="{{ route('admin.kehadiran') }}" class="nav-link {{ request()->routeIs('admin.kehadiran') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i> Kehadiran
                    </a>
                    <a href="{{ route('admin.materi-tugas') }}" class="nav-link {{ request()->routeIs('admin.materi-tugas') ? 'active' : '' }}">
                        <i class="bi bi-book"></i> Materi & Tugas
                    </a>
                    <a href="{{ route('admin.pengumpulan-tugas') }}" class="nav-link {{ request()->routeIs('admin.pengumpulan-tugas') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-arrow-up"></i> Pengumpulan Tugas
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">KEUANGAN</div>
                    <a href="{{ route('admin.transaksi') }}" class="nav-link {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i> Transaksi
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">KOMUNIKASI</div>
                    <a href="{{ route('admin.feedback') }}" class="nav-link {{ request()->routeIs('admin.feedback') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i> Feedback
                    </a>
                    <a href="{{ route('admin.pengumuman') }}" class="nav-link {{ request()->routeIs('admin.pengumuman') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> Pengumuman
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">LAPORAN</div>
                    <a href="{{ route('admin.laporan-siswa') }}" class="nav-link {{ request()->routeIs('admin.laporan-siswa*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph"></i> Laporan Siswa
                    </a>
                    
                    <div class="px-3 mt-3 mb-2 text-white-50 small">PENGATURAN</div>
                    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 col-lg-10 px-0 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
                        
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                    <img src="{{ auth()->user()->foto_profil_url }}" alt="Profile" class="rounded-circle me-2" width="35" height="35">
                                    <span class="text-dark">{{ auth()->user()->username }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="p-4">
                    @yield('content')
                </div>
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
        
        // Confirm Delete
        function confirmDelete(formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>