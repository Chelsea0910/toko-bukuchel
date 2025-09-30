@extends('layouts.app')

@section('title', 'Pesanan Saya - Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold"><i class="fas fa-clipboard-list me-2"></i>Pesanan Saya</h2>
        <p class="text-muted">Kelola dan lacak pesanan Anda</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <!-- <div class="card-header bg-pastel-blue">
                <h5 class="mb-0">Filter Pesanan</h5>
            </div> -->
            <!-- <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select class="form-select" onchange="filterOrders('status', this.value)">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" class="form-control" placeholder="Dari Tanggal" onchange="filterOrders('from_date', this.value)">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" class="form-control" placeholder="Sampai Tanggal" onchange="filterOrders('to_date', this.value)">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control" placeholder="Cari ID Pesanan..." onkeyup="filterOrders('search', this.value)">
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

@if($orders->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Metode Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="fw-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $order->orderItems->count() }} item</td>
                                <td class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'completed') bg-success
                                        @elseif($order->status == 'processing') bg-warning
                                        @elseif($order->status == 'pending') bg-info
                                        @else bg-danger
                                        @endif">
                                        <i class="fas 
                                            @if($order->status == 'completed') fa-check-circle
                                            @elseif($order->status == 'processing') fa-cog
                                            @elseif($order->status == 'pending') fa-clock
                                            @else fa-times-circle
                                            @endif me-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $order->payment_method ?: 'Belum dipilih' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status == 'pending')
                                    <!-- <a href="{{ route('user.payments.create', $order) }}" class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-money-bill"></i>
                                    </a> -->
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card text-center py-5">
            <div class="card-body">
                <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                <h3 class="text-muted">Belum Ada Pesanan</h3>
                <p class="text-muted mb-4">Mulai berbelanja dan temukan buku favorit Anda!</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@section('scripts')
<script>
function filterOrders(type, value) {
    const url = new URL(window.location.href);
    url.searchParams.set(type, value);
    window.location.href = url.toString();
}
</script>
@endsection
@endsection