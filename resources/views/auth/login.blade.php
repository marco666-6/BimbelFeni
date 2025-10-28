<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bimbel Oriana Enilin</title>
    
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
            --gradient-hero: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-hero);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            height: 90vh;
            max-height: 650px;
            position: relative;
            z-index: 1;
            padding: 0 20px;
        }
        
        .back-link {
            position: absolute;
            top: -100px;
            left: 25%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-size: 0.9rem;
        }
        
        .back-link:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateX(-50%) translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .login-card {
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            background: white;
            height: 100%;
            display: flex;
            animation: fadeInUp 0.8s ease-out;
        }
        
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
        
        .login-left {
            flex: 1;
            background: var(--gradient-primary);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .login-left > * {
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            font-size: 5rem;
            margin-bottom: 30px;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .login-left h2 {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 15px;
        }
        
        .login-left p {
            font-size: 0.95rem;
            opacity: 0.95;
            line-height: 1.6;
        }
        
        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }
        
        .login-right h4 {
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .login-right > p {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within {
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.15);
        }
        
        .input-group-text {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            border: none;
            color: var(--primary-blue);
            padding: 10px 12px;
            font-size: 1rem;
        }
        
        .form-control {
            border: none;
            padding: 10px 12px;
            font-size: 0.95rem;
            background: #fff;
        }
        
        .form-control:focus {
            box-shadow: none;
            background: #fff;
        }
        
        .btn-toggle-password {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            border: none;
            color: var(--primary-blue);
            padding: 10px 12px;
            transition: all 0.3s ease;
        }
        
        .btn-toggle-password:hover {
            color: var(--primary-dark);
        }
        
        .btn-login {
            background: var(--gradient-primary);
            border: none;
            padding: 12px;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            background: var(--gradient-secondary);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .divider span {
            padding: 0 10px;
            color: #94a3b8;
            font-size: 0.85rem;
        }
        
        .info-box {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }
        
        .info-box p {
            margin-bottom: 8px;
            color: #64748b;
            font-size: 0.85rem;
        }
        
        .info-box strong {
            color: #1e293b;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
            font-size: 0.9rem;
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }
        
        .text-danger {
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .login-wrapper {
                max-height: none;
                height: auto;
                max-width: 500px;
            }
            
            .back-link {
                position: static;
                transform: none;
                display: inline-block;
                margin-bottom: 20px;
            }
            
            .login-card {
                flex-direction: column;
                height: auto;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .logo-icon {
                font-size: 3.5rem;
                margin-bottom: 20px;
            }
            
            .login-left h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }
            
            .login-left p {
                font-size: 0.85rem;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
        
        @media (max-width: 576px) {
            .login-wrapper {
                padding: 0 15px;
            }
            
            .login-left {
                padding: 30px 20px;
            }
            
            .login-right {
                padding: 30px 20px;
            }
            
            .logo-icon {
                font-size: 3rem;
            }
            
            .login-left h2 {
                font-size: 1.3rem;
            }
        }
        
        /* Hide scrollbar but keep functionality */
        .login-right::-webkit-scrollbar {
            width: 6px;
        }
        
        .login-right::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .login-right::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        
        .login-right::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Login Card -->
        <div class="login-card">

            <!-- Left Side - Branding -->
            <div class="login-left">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
                <div class="logo-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h2>Bimbel Oriana Enilin</h2>
                <p>SIDES - Student Information and Development Evaluation System</p>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-right">
                <h4 class="fw-bold">Login ke Akun Anda</h4>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="email@example.com"
                                   required 
                                   autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Masukkan password"
                                   required
                                   id="password">
                            <button class="btn btn-toggle-password" type="button" id="togglePassword">
                                <i class="bi bi-eye-fill" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>Belum punya akun?</span>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <p class="mb-2">
                        <strong>Hubungi admin untuk pendaftaran</strong>
                    </p>
                    <a href="{{ route('kontak') }}" class="btn btn-outline-primary">
                        <i class="bi bi-telephone-fill me-1"></i>Hubungi Admin
                    </a>
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

        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
        
        // Alert Handler with custom styling
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000,
                background: '#fff',
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
    </script>
</body>
</html>