<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko BukuChel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-book-open me-2"></i>Toko BukuChel
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#katalog">
                            <i class="fas fa-book me-1"></i>Katalog
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-crown me-1"></i>Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.books.index') }}"><i class="fas fa-book me-2"></i>Kelola Buku</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="fas fa-tags me-2"></i>Kelola Kategori</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fas fa-clipboard-list me-2"></i>Kelola Pesanan</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/users') }}"><i class="fas fa-users me-2"></i>Kelola User</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-user me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.cart.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Keranjang
                                    @if(Auth::user()->carts()->count() > 0)
                                        <span class="badge bg-danger ms-1">{{ Auth::user()->carts()->count() }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.orders.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Pesanan
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-warning ms-1">Admin</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-store me-2"></i>Kunjungi Toko
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Checkout Pesanan</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="text-pastel-blue mb-4">Detail Pesanan</h5>
                            
                            @foreach($cartItems as $item)
                            <div class="row align-items-center mb-3 border-bottom pb-3">
                                <div class="col-md-2">
                                    @if($item->book->cover_ur)
                                        <img src="{{ asset('storage/' . $item->book->cover_url) }}" 
                                             alt="{{ $item->book->title }}" 
                                             class="img-fluid rounded book-image" style="height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light-blue rounded d-flex align-items-center justify-content-center" 
                                             style="height: 80px; width: 60px;">
                                            <i class="fas fa-book text-pastel-purple fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-1">{{ $item->book->title }}</h6>
                                    <small class="text-muted">Penulis: {{ $item->book->author }}</small>
                                    <br>
                                    <small class="text-muted">Harga: Rp {{ number_format($item->book->price, 0, ',', '.') }}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="fw-bold">Qty: {{ $item->quantity }}</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="fw-bold text-pastel-purple">Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach

                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-md-8">
                                    <strong class="fs-5">Total Item: {{ $cartItems->sum('quantity') }} buku</strong>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h4 class="text-pastel-purple">Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Informasi Pengiriman & Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.orders.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="shipping_address" class="form-label fw-bold">Alamat Lengkap Pengiriman *</label>
                                    <textarea name="shipping_address" id="shipping_address" 
                                              class="form-control @error('shipping_address') is-invalid @enderror" 
                                              rows="4" 
                                              placeholder="Masukkan alamat lengkap termasuk nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, dan kode pos"
                                              required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Metode Pembayaran</h6>
                                    <p class="mb-0">Pembayaran dilakukan secara <strong>COD (Cash on Delivery)</strong> ketika pesanan diterima.</p>
                                </div>
                                <input type="hidden" name="payment_method" value="cod">
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="{{ route('user.cart.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check me-2"></i>Buat Pesanan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Checkout</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-shipping-fast me-2"></i>Proses Pengiriman</h6>
                                <small>Pesanan akan diproses dalam 1-2 hari kerja setelah pembayaran dikonfirmasi.</small>
                            </div>
                            
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
                                <small>Pastikan alamat pengiriman sudah benar. Perubahan alamat setelah pesanan dibuat mungkin tidak dapat diproses.</small>
                            </div>

                            <div class="alert alert-success">
                                <h6><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</h6>
                                <small>
                                    <strong>Transfer Bank:</strong> BCA 123-456-7890 (Toko BukuChel)<br>
                                    <strong>COD:</strong> Bayar ketika barang diterima
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-book-open me-2"></i>Toko BukuChel</h5>
                    <p>Tempat terbaik untuk menemukan buku-buku berkualitas dengan harga terjangkau. Kami menyediakan berbagai genre buku untuk semua kalangan.</p>
                    <div class="social-links">
                        <a href="#" class="text-dark me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-dark text-decoration-none"><i class="fas fa-arrow-right me-2"></i>Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#katalog" class="text-dark text-decoration-none"><i class="fas fa-arrow-right me-2"></i>Katalog Buku</a></li>
                        <li class="mb-2"><a href="#" class="text-dark text-decoration-none"><i class="fas fa-arrow-right me-2"></i>Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-dark text-decoration-none"><i class="fas fa-arrow-right me-2"></i>Kontak</a></li>
                        <li class="mb-2"><a href="#" class="text-dark text-decoration-none"><i class="fas fa-arrow-right me-2"></i>Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-2"></i> Jl. Buku No. 123, Jakarta 12345</li>
                        <li class="mb-3"><i class="fas fa-phone me-2"></i> +62 123 456 7890</li>
                        <li class="mb-3"><i class="fas fa-envelope me-2"></i> info@tokobukuchel.com</li>
                        <li class="mb-3"><i class="fas fa-clock me-2"></i> Senin - Minggu: 08:00 - 22:00</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Toko BukuChel. All rights reserved. | Developed with <i class="fas fa-heart text-danger"></i> by Tim BukuChel</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto dismiss alerts setelah 5 detik
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Smooth scrolling untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Active nav link highlighting
            const currentLocation = window.location.href;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.href === currentLocation) {
                    link.classList.add('active');
                    link.style.background = 'rgba(255,255,255,0.3)';
                }
            });
        });
    </script>
</body>
</html>