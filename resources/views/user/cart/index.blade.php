@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko BukuChel')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h2>
        </div>
    </div>

    @if($cartItems->count() > 0)
    <div class="row">
        <div class="col-lg-8">
            <!-- Daftar Item Keranjang -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Item Keranjang ({{ $cartItems->count() }})</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="cart-item border-bottom pb-3 mb-3">
                        <div class="row align-items-center">
                            <!-- Gambar Buku -->
                            <div class="col-md-2">
                                @if($item->book->cover)
                                    <img src="{{ asset('storage/' . $item->book->cover) }}" 
                                         alt="{{ $item->book->title }}" 
                                         class="img-fluid rounded shadow-sm"
                                         style="height: 120px; width: auto; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="height: 120px; width: 80px;">
                                        <i class="fas fa-book fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Informasi Buku -->
                            <div class="col-md-6">
                                <h5 class="card-title">{{ $item->book->title }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-user me-1"></i>by {{ $item->book->author }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>{{ $item->book->category->name ?? 'No Category' }}
                                </p>
                                <p class="h5 text-primary mb-0">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                            </div>
                            
                            <!-- Quantity -->
                            <div class="col-md-2">
                                <form action="{{ route('user.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="form-label"><strong>Qty:</strong></label>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                           min="1" max="10" class="form-control form-control-sm">
                                    <button type="submit" class="btn btn-sm btn-outline-primary mt-1 w-100">Update</button>
                                </form>
                            </div>
                            
                            <!-- Hapus Item -->
                            <div class="col-md-2 text-center">
                                <form action="{{ route('user.cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus buku dari keranjang?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                
                                <!-- Subtotal -->
                                <p class="mt-2 mb-0">
                                    <strong>Subtotal:</strong><br>
                                    <span class="h6 text-success">
                                        Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Tombol Kosongkan Keranjang -->
                    <div class="text-end">
                        <form action="{{ route('user.cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('Kosongkan seluruh keranjang?')">
                                <i class="fas fa-trash me-1"></i>Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ringkasan Belanja -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ringkasan Belanja</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal ({{ $cartItems->count() }} items):</span>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Ongkos Kirim:</span>
                        <strong>Gratis</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Total:</span>
                        <span class="h4 text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Tombol Checkout -->
                    <a href="{{ route('user.orders.create') }}" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-credit-card me-2"></i>Lanjut ke Pembayaran
                    </a>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Keranjang Kosong -->
    <div class="row">
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Keranjang Belanja Kosong</h4>
                    <p class="text-muted mb-4">Yuk, tambahkan buku favorit Anda ke keranjang!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-book me-2"></i>Jelajahi Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection