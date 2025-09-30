@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold"><i class="fas fa-clipboard-list me-2"></i>Kelola Pesanan</h2>
        <p class="text-muted">Kelola semua pesanan pelanggan</p>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-blue h-100">
            <div class="card-body text-center p-3">
                <h3 class="stat-number">{{ App\Models\Order::count() }}</h3>
                <p class="mb-0 fw-semibold">Total Pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-purple h-100">
            <div class="card-body text-center p-3">
                <h3 class="stat-number">{{ App\Models\Order::where('status', 'pending')->count() }}</h3>
                <p class="mb-0 fw-semibold">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-pink h-100">
            <div class="card-body text-center p-3">
                <h3 class="stat-number">{{ App\Models\Order::where('status', 'processing')->count() }}</h3>
                <p class="mb-0 fw-semibold">Processing</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-pastel-blue h-100">
            <div class="card-body text-center p-3">
                <h3 class="stat-number">{{ App\Models\Order::where('status', 'completed')->count() }}</h3>
                <p class="mb-0 fw-semibold">Completed</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<!-- <div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
                        <input type="text" class="form-control" placeholder="Cari ID/ Customer..." onkeyup="filterOrders('search', this.value)">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Metode Bayar</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $order->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </td>
                                <td class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'completed') bg-success
                                        @elseif($order->status == 'processing') bg-warning
                                        @elseif($order->status == 'pending') bg-info
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $order->payment_method ?: 'Belum dipilih' }}</span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- <button type="button" class="btn btn-sm btn-outline-warning"  -->
                                                <!-- data-bs-toggle="modal" data-bs-target="#statusModal"
                                                data-order-id="{{ $order->id }}"
                                                data-order-status="{{ $order->status }}"
                                                title="Ubah Status"> -->
                                            <!-- <i class="fas fa-edit"></i> -->
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada pesanan</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- PERBAIKAN PAGINATION -->
            @if($orders->hasPages())
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-pastel-blue">
                <h5 class="modal-title">Ubah Status Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Pesanan</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* PERBAIKAN PAGINATION */
.pagination {
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
.pagination .page-link i.fas {
    font-size: 0.6rem !important;
}
</style>

@section('scripts')
<script>
function filterOrders(type, value) {
    const url = new URL(window.location.href);
    url.searchParams.set(type, value);
    window.location.href = url.toString();
}

// Status Modal
const statusModal = document.getElementById('statusModal');
statusModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const orderId = button.getAttribute('data-order-id');
    const orderStatus = button.getAttribute('data-order-status');
    
    document.getElementById('status').value = orderStatus;
    
    const form = document.getElementById('statusForm');
    form.action = `/admin/orders/${orderId}`;});
</script>

@endsection
@endsection