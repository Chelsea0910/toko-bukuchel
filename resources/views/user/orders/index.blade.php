@extends('layouts.app')

@section('title', 'Pesanan Saya - Toko BukuChel')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fas fa-clipboard-list me-2"></i>Pesanan Saya</h2>
            <p class="text-muted">Riwayat dan status pesanan Anda</p>
        </div>
    </div>

    @if($orders->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Pesanan ({{ $orders->count() }})</h5>
                </div>
                <div class="card-body">
                    @foreach($orders as $order)
                    <div class="row align-items-center mb-4 pb-4 border-bottom">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-receipt fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">#{{ $order->order_number }}</h6>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <span class="badge 
                                @if($order->status == 'completed') bg-success
                                @elseif($order->status == 'processing') bg-primary
                                @elseif($order->status == 'pending') bg-warning
                                @elseif($order->status == 'cancelled') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="mb-0 mt-1 small text-muted">
                                {{ $order->orderItems->sum('quantity') }} items
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p class="fw-bold text-primary mb-1">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                            <small class="text-muted">
                                {{ ucfirst($order->payment_method) }}
                            </small>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            @if($order->status == 'pending')
                            <!-- <a href="{{ route('user.payments.create', $order) }}" class="btn btn-sm btn-primary ms-1">
                                <i class="fas fa-credit-card me-1"></i>Bayar
                            </a> -->
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- PERBAIKAN PAGINATION -->
                    <!-- @if($orders->hasPages())
                    <div class="row mt-4">
                        <div class="col-12">
                            {{ $orders->links() }}
                        </div>
                    </div>
                    @endif -->
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum Ada Pesanan</h4>
                    <p class="text-muted">Mulai berbelanja dan buat pesanan pertama Anda</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-book me-2"></i>Jelajahi Buku
                    </a>
                    <a href="{{ route('user.cart.index') }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-shopping-cart me-2"></i>Lihat Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
}

.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

/* PERBAIKAN PAGINATION */
/* .pagination {
    justify-content: center;
}

.pagination .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

/* PERBAIKAN UKURAN TANDA PANAH */
/* .pagination .page-link i.fas {
    font-size: 0.6rem !important;
} */ */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto update status jika ada real-time updates
    console.log('Order page loaded');
});
</script>
@endsection