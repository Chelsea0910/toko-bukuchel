@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko BukuChel')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h2>
            <p class="text-muted">Review buku yang akan Anda beli</p>
        </div>
    </div>

    @if($cartItems->count() > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Item Keranjang ({{ $cartItems->count() }})</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="row align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ $item->book->image ? asset('storage/' . $item->book->image) : 'https://via.placeholder.com/100x120?text=No+Image' }}" 
                                 class="img-fluid rounded" alt="{{ $item->book->title }}">
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold">{{ $item->book->title }}</h6>
                            <p class="text-muted mb-1">by {{ $item->book->author }}</p>
                            <span class="badge bg-secondary">{{ $item->book->category->name ?? 'No Category' }}</span>
                        </div>
                        <div class="col-md-2">
                            <p class="fw-bold text-primary">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('user.cart.update', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                       min="1" max="10" class="form-control form-control-sm">
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('user.cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Hapus dari keranjang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Belanja</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $cartItems->sum('quantity') }} items):</span>
                        <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- PERBAIKAN: Ganti route yang error -->
                    <!-- Option 1: Gunakan route checkout jika ada -->
                    <a href="{{ route('user.orders.create') }}" class="btn btn-primary">                       
                         <i class="fas fa-credit-card me-2"></i>Lanjut ke Pembayaran
                    </a>
                    
                    <form action="{{ route('user.cart.clear') }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('Kosongkan seluruh keranjang?')">
                            <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Keranjang Belanja Kosong</h4>
                    <p class="text-muted">Tambahkan buku ke keranjang untuk mulai berbelanja</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-book me-2"></i>Jelajahi Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Script untuk auto update quantity -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto update quantity ketika diubah
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endsection