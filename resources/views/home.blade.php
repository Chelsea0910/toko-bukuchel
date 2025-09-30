@extends('layouts.app')

@section('title', 'Toko BukuChel - Temukan Buku Impian Anda')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Temukan Dunia dalam Setiap Halaman</h1>
                <p class="lead mb-5">Jelajahi koleksi buku terbaik kami dengan berbagai genre dan kategori. Mulai petualangan membaca Anda hari ini!</p>
                <a href="#katalog" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-book-open me-2"></i>Jelajahi Katalog
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section id="katalog" class="mb-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Katalog Buku</h2>
                <p class="text-muted">Temukan buku yang sesuai dengan minat Anda</p>
            </div>
        </div>

        <!-- GABUNGKAN FORM SEARCH DAN FILTER -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('home') }}" method="GET" id="searchForm">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Cari Buku</label>
                                    <input type="text" name="search" id="search" class="form-control" 
                                           placeholder="Cari judul buku, penulis, atau kategori..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="category" class="form-label">Filter Kategori</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan Filter Aktif -->
        @if(request()->has('search') || request()->has('category'))
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        @if(request('category'))
                            @php
                                $selectedCategory = $categories->firstWhere('id', request('category'));
                            @endphp
                            @if($selectedCategory)
                                <span class="badge bg-secondary me-2">Kategori: {{ $selectedCategory->name }}</span>
                            @endif
                        @endif
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-times me-1"></i>Hapus Filter
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Books Grid - PERBAIKAN UTAMA DI SINI -->
        <div class="row g-4">
            @forelse($books as $book)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 book-card border-0 shadow-lg position-relative">
                        <!-- Badge Status Stok di pojok kanan atas -->
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas fa-{{ $book->stock > 0 ? 'check' : 'times' }} me-1"></i>
                                {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <!-- Cover Buku Portrait -->
                            <div class="text-center mb-3">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" 
                                         alt="{{ $book->title }}" 
                                         class="book-portrait-home"
                                         style="height: 220px; width: auto; max-width: 100%; object-fit: cover; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border: 1px solid #e0e0e0;">
                                @else
                                    <div class="book-portrait-placeholder-home d-flex align-items-center justify-content-center mx-auto" 
                                         style="height: 220px; width: 150px; max-width: 100%; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 2px dashed #bdc3c7; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
                                        <div class="text-muted text-center">
                                            <i class="fas fa-book fa-3x mb-2"></i>
                                            <p class="small mb-0">No Cover</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Informasi Buku -->
                            <h6 class="fw-bold mb-2 text-center" style="min-height: 3rem; display: flex; align-items: center; justify-content: center;">
                                {{ Str::limit($book->title, 50) }}
                            </h6>
                            
                            <p class="text-muted small mb-2 text-center">
                                <i class="fas fa-user me-1"></i>{{ Str::limit($book->author, 25) }}
                            </p>
                            
                            <!-- Kategori -->
                            <div class="mb-2 text-center">
                                <span class="badge bg-light text-dark border">
                                    <i class="fas fa-tag me-1"></i>{{ $book->category->name }}
                                </span>
                            </div>

                            <!-- Harga -->
                            <p class="fw-bold text-primary fs-5 mb-3 text-center">
                                Rp {{ number_format($book->price, 0, ',', '.') }}
                            </p>

                            <!-- Deskripsi Singkat -->
                            <p class="small text-muted mb-3 flex-grow-1 text-center">
                                {{ Str::limit($book->description, 80) }}
                            </p>

                            <!-- Tombol Aksi - PERBAIKAN: HILANGKAN DUPLIKAT -->
                            <div class="mt-auto">
                                <!-- Tombol Detail -->
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-eye me-2"></i>Detail Buku
                                </a>

                                <!-- Tombol Tambah Keranjang/Login -->
                                @auth
                                    @if(Auth::user()->isUser())
                                        <form action="{{ route('user.cart.store') }}" method="POST" class="mb-0">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-outline-primary w-100" 
                                                    {{ $book->stock == 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-cart-plus me-2"></i>
                                                {{ $book->stock > 0 ? 'Tambah Keranjang' : 'Stok Habis' }}
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login untuk Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak ada buku yang ditemukan</h4>
                            <p class="text-muted">
                                @if(request()->has('search') || request()->has('category'))
                                    Coba gunakan kata kunci pencarian yang berbeda atau lihat kategori lainnya.
                                @else
                                    Belum ada buku yang tersedia saat ini.
                                @endif
                            </p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i>Reset Pencarian
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="mb-5 py-4">
    <div class="container">
        <div class="row text-center mb-4">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Mengapa Memilih Toko BukuChel?</h2>
                <p class="text-muted lead">Kami menawarkan pengalaman berbelanja buku yang terbaik</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <!-- Card 1 - Pink Pastel -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast fa-2x text-pastel-pink"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Pengiriman Cepat</h5>
                        <p class="text-muted small mb-0">
                            Pengiriman ke seluruh Indonesia dengan layanan cepat dan aman
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 - Ungu Pastel -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-award fa-2x text-pastel-purple"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Buku Berkualitas</h5>
                        <p class="text-muted small mb-0">
                            Hanya menyediakan buku-buku original dan berkualitas tinggi
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 - Biru Pastel -->
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 text-center border-0 shadow-sm feature-card">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset fa-2x text-pastel-blue"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Dukungan Pelanggan</h5>
                        <p class="text-muted small mb-0">
                            Tim support siap membantu Anda 24/7 untuk semua kebutuhan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Warna Pastel */
:root {
    --pastel-pink: #ffb6c1;
    --pastel-purple: #d8bfd8;
    --pastel-blue: #b0e0e6;
    --pastel-pink-dark: #e6a2ad;
    --pastel-purple-dark: #c8a2c8;
    --pastel-blue-dark: #9bd1d9;
}

.text-pastel-pink {
    color: var(--pastel-pink) !important;
}

.text-pastel-purple {
    color: var(--pastel-purple) !important;
}

.text-pastel-blue {
    color: var(--pastel-blue) !important;
}

/* Styling untuk Feature Cards */
.feature-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    min-height: 220px;
    display: flex;
    align-items: center;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.feature-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

/* Background hover untuk masing-masing icon */
.feature-card:nth-child(1):hover .feature-icon {
    background: var(--pastel-pink);
}

.feature-card:nth-child(2):hover .feature-icon {
    background: var(--pastel-purple);
}

.feature-card:nth-child(3):hover .feature-icon {
    background: var(--pastel-blue);
}

/* Warna icon saat hover */
.feature-card:nth-child(1):hover .feature-icon i {
    color: white !important;
}

.feature-card:nth-child(2):hover .feature-icon i {
    color: white !important;
}

.feature-card:nth-child(3):hover .feature-icon i {
    color: white !important;
}

/* Border color berdasarkan card */
.feature-card:nth-child(1) {
    border-top: 3px solid var(--pastel-pink);
}

.feature-card:nth-child(2) {
    border-top: 3px solid var(--pastel-purple);
}

.feature-card:nth-child(3) {
    border-top: 3px solid var(--pastel-blue);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .feature-card {
        min-height: 200px;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
    }
    
    .feature-icon i {
        font-size: 1.5rem !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto submit form ketika kategori berubah
    document.getElementById('category').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });

    // Debounce search input
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    });

    // Animasi hover untuk kartu buku
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animasi hover untuk feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection