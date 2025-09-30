@extends('layouts.app')

@section('title', 'Detail Pesanan - Toko BukuChel')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fas fa-receipt me-2"></i>Detail Pesanan</h2>
            <p class="text-muted">Informasi lengkap pesanan pelanggan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">#{{ $order->order_number }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Status Pesanan</h6>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h6>Pelanggan</h6>
                            <p class="mb-0 fw-bold">{{ $order->user->name }}</p>
                            <p class="mb-0 text-muted">{{ $order->user->email }}</p>
                            <p class="mb-0 text-muted small">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <h6 class="mb-3">Item Pesanan</h6>
                    @foreach($order->orderItems as $item)
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
                            <p class="fw-bold text-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-2">
                            <span class="fw-bold">Qty: {{ $item->quantity }}</span>
                        </div>
                        <div class="col-md-2">
                            <p class="fw-bold text-primary">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Alamat Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $order->orderItems->sum('quantity') }} items):</span>
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
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Metode Pembayaran:</span>
                        <span class="fw-bold">COD</span>
                    </div>
                    
                    <div class="alert 
                        @if($order->status == 'pending') alert-warning
                        @elseif($order->status == 'processing') alert-info
                        @elseif($order->status == 'completed') alert-success
                        @elseif($order->status == 'cancelled') alert-danger
                        @else alert-secondary @endif">
                        <small>
                            <i class="fas 
                                @if($order->status == 'pending') fa-clock
                                @elseif($order->status == 'processing') fa-truck
                                @elseif($order->status == 'completed') fa-check
                                @elseif($order->status == 'cancelled') fa-times
                                @else fa-info @endif me-1"></i>
                            <strong>Status: {{ ucfirst($order->status) }}</strong>
                        </small>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
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

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.alert {
    border: none;
    border-left: 4px solid;
}
</style>
@endsection