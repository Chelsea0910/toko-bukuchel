@extends('layouts.app')

@section('title', $book->title . ' - Toko BukuChel')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <!-- <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}#katalog">Katalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav> -->

    <!-- USER/GUEST VIEW -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x400?text=No+Cover' }}" 
                         alt="{{ $book->title }}" 
                         class="book-cover img-fluid mb-4"
                         style="max-height: 400px; object-fit: cover;">
                    
                    <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                        <span class="badge bg-pastel-purple text-dark">
                            <i class="fas fa-tag me-1"></i>{{ $book->category->name }}
                        </span>
                        <span class="badge {{ $book->stock > 0 ? 'bg-pastel-green' : 'bg-pastel-orange' }} text-dark">
                            <i class="fas fa-{{ $book->stock > 0 ? 'check' : 'times' }} me-1"></i>
                            {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-pastel-blue">
                    <h3 class="mb-0">{{ $book->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="fas fa-user-edit me-2 text-pastel-purple"></i>
                            <strong>Oleh:</strong> {{ $book->author }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <h2 class="text-success">Rp {{ number_format($book->price, 0, ',', '.') }}</h2>
                    </div>
                    
                    <div class="card bg-light-blue mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3 text-dark">
                                <i class="fas fa-file-alt me-2 text-pastel-purple"></i>Deskripsi Buku
                            </h5>
                            <p class="mb-0" style="line-height: 1.8;">
                                {{ $book->description ?: 'Deskripsi belum tersedia untuk buku ini.' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-header bg-pastel-green">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Stok</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Stok:</strong> {{ $book->stock }} buku</p>
                                    <p class="mb-0"><strong>Status:</strong> 
                                        <span class="badge {{ $book->stock > 0 ? 'bg-pastel-green' : 'bg-pastel-orange' }} text-dark">
                                            {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-header bg-pastel-purple">
                                    <h6 class="mb-0"><i class="fas fa-list-alt me-2"></i>Informasi Lain</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Kategori:</strong> {{ $book->category->name }}</p>
                                    <p class="mb-1"><strong>ID Buku:</strong> #{{ $book->id }}</p>
                                    <p class="mb-0"><strong>Ditambahkan:</strong> {{ \Carbon\Carbon::parse($book->created_at)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons d-flex gap-3 flex-wrap">
                        @if($book->stock > 0)
                            @auth
                                @if(Auth::user()->isUser())
                                    <form action="{{ route('user.cart.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Beli
                                </a>
                            @endauth
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-times me-2"></i>Stok Habis
                            </button>
                        @endif
                        
                        <a href="{{ url('/') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection