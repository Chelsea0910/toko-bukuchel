@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - Toko BukuChel')

@section('content')
<!-- <div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.orders.index') }}">Pesanan Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Pesanan #{{ $order->id }}</li>
            </ol>
        </nav>
    </div>
</div> -->

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Pesanan</h5>
                <span class="badge 
                    @if($order->status == 'completed') bg-success
                    @elseif($order->status == 'processing') bg-warning
                    @elseif($order->status == 'pending') bg-info
                    @else bg-danger
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Informasi Pesanan</h6>
                        <p><strong>ID Pesanan:</strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge 
                                @if($order->status == 'completed') bg-success
                                @elseif($order->status == 'processing') bg-warning
                                @elseif($order->status == 'pending') bg-info
                                @else bg-danger
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Informasi Pembayaran</h6>
                        <p><strong>Metode Pembayaran:</strong> 
                            <span class="badge bg-success">COD (Cash on Delivery)</span>
                        </p>
                        <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p><strong>Status Pembayaran:</strong> 
                            <span class="badge bg-warning">Bayar saat diterima</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Item Pesanan ({{ $order->orderItems->count() }})</h5>
            </div>
            <div class="card-body">
                @foreach($order->orderItems as $item)
                <div class="row align-items-center mb-3 pb-3 border-bottom">
                    <div class="col-md-2">
                        <img src="{{ $item->book->image ? asset('storage/' . $item->book->image) : 'https://via.placeholder.com/60x80?text=No+Image' }}" 
                             class="img-fluid rounded" alt="{{ $item->book->title }}">
                    </div>
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-1">{{ $item->book->title }}</h6>
                        <p class="text-muted small mb-1">Oleh: {{ $item->book->author }}</p>
                        <span class="badge bg-secondary small">{{ $item->book->category->name ?? 'No Category' }}</span>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-0">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-0">Qty: {{ $item->quantity }}</p>
                    </div>
                    <div class="col-md-2 text-end">
                        <p class="fw-bold text-primary mb-0">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Pengiriman:</span>
                    <span class="text-success">Gratis</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Pajak:</span>
                    <span>Termasuk</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Total:</span>
                    <span class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>

                <!-- INFO COD -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-truck me-2"></i>Pembayaran COD</h6>
                    <p class="mb-0 small">Bayar langsung ketika pesanan diterima. Tidak perlu transfer.</p>
                </div>
            </div>
        </div>

        <!-- HAPUS BAGIAN PAYMENT PROOF KARENA COD -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Informasi COD</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6><i class="fas fa-info-circle me-2"></i>Penting!</h6>
                    <ul class="mb-0 small">
                        <li>Siapkan uang tunai sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></li>
                        <li>Bayar ketika paket diterima</li>
                        <li>Periksa kondisi buku sebelum membayar</li>
                        <li>Terima struk dari kurir</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Status Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item active">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="timeline-text">
                                <h6>Pesanan Dibuat</h6>
                                <p class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'processing' || $order->status == 'completed' ? 'active' : '' }}">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="timeline-text">
                                <h6>Sedang Diproses</h6>
                                @if($order->status == 'processing' || $order->status == 'completed')
                                <p class="text-muted small">Pesanan sedang dipersiapkan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="timeline-text">
                                <h6>Dikirim</h6>
                                @if($order->status == 'completed')
                                <p class="text-muted small">Pesanan sedang dikirim</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                        <div class="timeline-content">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-text">
                                <h6>Selesai & Dibayar</h6>
                                @if($order->status == 'completed')
                                <p class="text-muted small">Pesanan telah selesai dan dibayar</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 3rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item.active::before {
    background-color: #0d6efd;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.timeline-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background-color: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.timeline-item.active .timeline-icon {
    background-color: #0d6efd;
    color: white;
}

.timeline-text {
    flex: 1;
}
</style>
@endsection