<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toko BukuChel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
       :root {
            --pastel-blue: #a7d0e8;
            --pastel-purple: #d8c3e6;
            --pastel-pink: #ffd1dc;
            --pastel-green: #c8e6c9;
            --pastel-orange: #ffccbc;
            --light-blue: #e6f2ff;
            --light-purple: #f0e6ff;
            --light-pink: #ffe6ee;
            --light-green: #f1f8e9;
            --light-orange: #fff3e0;
            --dark-blue: #2c3e50;
            --dark-purple: #6c5ce7;
            --dark-pink: #e84393;
        }
        
        body {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--light-pink) 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-purple) 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark-blue) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-blue) !important;
            transition: all 0.3s ease;
            margin: 0 10px;
            padding: 8px 15px !important;
            border-radius: 20px;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
            color: var(--dark-purple) !important;
            background: rgba(255,255,255,0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-purple) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            color: var(--dark-blue);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--pastel-purple) 0%, var(--pastel-pink) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--pastel-blue);
            color: var(--pastel-blue);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--pastel-blue);
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-purple) 100%);
            border: none;
            padding: 20px;
            font-weight: 600;
            color: var(--dark-blue);
        }
        
        .bg-pastel-blue { background: var(--pastel-blue) !important; }
        .bg-pastel-purple { background: var(--pastel-purple) !important; }
        .bg-pastel-pink { background: var(--pastel-pink) !important; }
        .bg-pastel-green { background: var(--pastel-green) !important; }
        .bg-pastel-orange { background: var(--pastel-orange) !important; }
        .bg-light-blue { background: var(--light-blue) !important; }
        .bg-light-purple { background: var(--light-purple) !important; }
        .bg-light-pink { background: var(--light-pink) !important; }
        .bg-light-green { background: var(--light-green) !important; }
        .bg-light-orange { background: var(--light-orange) !important; }
        
        .text-pastel-blue { color: var(--pastel-blue) !important; }
        .text-pastel-purple { color: var(--pastel-purple) !important; }
        .text-pastel-pink { color: var(--pastel-pink) !important; }
        
        .badge-primary {
            background: linear-gradient(135deg, var(--pastel-blue) 0%, var(--pastel-purple) 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .form-control {
            border: 2px solid var(--pastel-blue);
            border-radius: 15px;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--pastel-purple);
            box-shadow: 0 0 0 0.2rem rgba(216, 195, 230, 0.25);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--pastel-purple) 0%, var(--pastel-pink) 100%);
            color: var(--dark-blue);
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(167, 208, 232, 0.9) 0%, rgba(216, 195, 230, 0.9) 100%);
            padding: 80px 0;
            border-radius: 30px;
            margin: 40px 0;
        }
        
        .book-image {
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .book-image:hover {
            transform: scale(1.05);
        }
        
        .stat-card {
            text-align: center;
            padding: 30px;
            border-radius: 20px;
            margin: 15px 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--pastel-purple);
        }
        
        
        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: var(--light-blue);
            color: var(--dark-blue);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 0;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .nav-link {
                margin: 5px 0;
                text-align: center;
            }
        }
        
        /* TAMBAHAN UNTUK ADMIN */
        .sidebar {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--dark-purple) 100%);
            min-height: 100vh;
            color: white;
        }
        
        .sidebar .nav-link {
            color: white !important;
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .admin-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4><i class="fas fa-crown me-2"></i>Admin Panel</h4>
                        <small>Toko BukuChel</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}" 
                               href="{{ route('admin.books.index') }}">
                                <i class="fas fa-book me-2"></i>Kelola Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                               href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags me-2"></i>Kelola Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                               href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-clipboard-list me-2"></i>Kelola Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-2"></i>Kelola User
                            </a>
                        </li>
                    </ul>
                    
                    <div class="mt-4 p-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-light w-100 mb-2">
                            <i class="fas fa-store me-2"></i>Kembali ke Toko
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 admin-content">
                <!-- Top Navigation -->
                <nav class="navbar navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-store me-2"></i>Kunjungi Toko
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="py-4">
                    @include('partials.alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript untuk admin layout
        document.addEventListener('DOMContentLoaded', function() {
            // Auto dismiss alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Toggle sidebar di mobile
            const sidebarToggle = document.querySelector('.navbar-toggler');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('show');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>