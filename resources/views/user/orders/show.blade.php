@extends('layouts.app')

@section('title', 'Detail Pesanan - Toko BukuChel')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fas fa-receipt me-2"></i>Detail Pesanan</h2>
            <p class="text-muted">Informasi lengkap pesanan Anda</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pesanan #{{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Status Pesanan</h6>
                            <span class="badge 
                                @if($order->status == 'completed') bg-success
                                @elseif($order->status == 'processing') bg-primary
                                @elseif($order->status == 'pending') bg-warning
                                @elseif($order->status == 'cancelled') bg-danger
                                @else bg-secondary @endif fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6>Tanggal Pesanan</h6>
                            <p class="mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <h6>Item Pesanan</h6>
                    
                    @if($order->orderItems && $order->orderItems->count() > 0)
                        @foreach($order->orderItems as $item)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Gambar Buku -->
                                    <div class="col-md-2">
                                        @if($item->book && $item->book->cover)
                                            <img src="{{ asset('storage/' . $item->book->cover) }}" 
                                                 alt="{{ $item->book->title }}" 
                                                 class="img-fluid rounded"
                                                 style="height: 120px; width: auto; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="height: 120px; width: 80px;">
                                                <i class="fas fa-book fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $item->book->title ?? 'Buku Tidak Ditemukan' }}</h5>
                                        <p class="text-muted">by {{ $item->book->author ?? 'Penulis Tidak Diketahui' }}</p>
                                        <p class="h5 text-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <p class="mb-0"><strong>Qty:</strong> {{ $item->quantity }}</p>
                                    </div>
                                    
                                    <div class="col-md-2 text-end">
                                        <p class="h5">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada item dalam pesanan ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Alamat Pengiriman</h6>
                            <p class="text-muted">{{ $order->shipping_address ?? 'Alamat penngiriman tidak tersedia' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Metode Pembayaran</h6>
                            <p class="text-muted">
                                <span class="badge bg-info text-uppercase">{{ $order->payment_method ?? 'cod' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalItems = $order->orderItems ? $order->orderItems->sum('quantity') : 0;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $totalItems }} items):</span>
                        <span class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim:</span>
                        <span class="fw-bold">Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($order->status == 'pending')
                    <div class="alert alert-warning">
                        <small>
                            <i class="fas fa-clock me-1"></i>
                            <strong>Menunggu Konfirmasi:</strong> Pesanan Anda sedang diproses
                        </small>
                    </div>
                    @elseif($order->status == 'processing')
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-truck me-1"></i>
                            <strong>Sedang Diproses:</strong> Pesanan akan segera dikirim
                        </small>
                    </div>
                    @elseif($order->status == 'completed')
                    <div class="alert alert-success">
                        <small>
                            <i class="fas fa-check me-1"></i>
                            <strong>Selesai:</strong> Pesanan telah selesai
                        </small>
                    </div>
                    @elseif($order->status == 'cancelled')
                    <div class="alert alert-danger">
                        <small>
                            <i class="fas fa-times me-1"></i>
                            <strong>Dibatalkan:</strong> Pesanan telah dibatalkan
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-book me-2"></i>Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
}

.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

/* Tambahan styling untuk tampilan yang lebih baik */
.book-image-container {
    height: 120px;
    width: 80px;
    overflow: hidden;
    border-radius: 8px;
}

.book-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
}
</style>
@endsection