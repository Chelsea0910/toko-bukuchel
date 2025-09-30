@extends('layouts.app')

@section('title', 'Dashboard Admin - Toko BukuChel')

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold"><i class="fas fa-crown me-2"></i>Dashboard Admin</h2>
            <span class="badge bg-pastel-blue fs-6">Admin sejak: {{ Auth::user()->created_at->format('d M Y') }}</span>
        </div>
        <p class="text-muted">Selamat datang, {{ Auth::user()->name }}! Kelola toko buku Anda dari sini.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-blue h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-book fa-3x text-pastel-blue"></i>
                </div>
                <h3 class="stat-number">{{ $totalBooks }}</h3>
                <p class="mb-0 fw-semibold">Total Buku</p>
                <small class="text-muted">Semua buku dalam sistem</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-purple h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-tags fa-3x text-pastel-purple"></i>
                </div>
                <h3 class="stat-number">{{ $totalCategories }}</h3>
                <p class="mb-0 fw-semibold">Kategori</p>
                <small class="text-muted">Jumlah kategori buku</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-pink h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-clipboard-list fa-3x text-pastel-pink"></i>
                </div>
                <h3 class="stat-number">{{ $pendingOrders }}</h3>
                <p class="mb-0 fw-semibold">Pesanan Pending</p>
                <small class="text-muted">Menunggu konfirmasi</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-pastel-blue h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-check-circle fa-3x text-white"></i>
                </div>
                <h3 class="stat-number">{{ $completedOrders }}</h3>
                <p class="mb-0 fw-semibold">Pesanan Selesai</p>
                <small class="text-muted">Pesanan yang sudah dikirim</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<!-- <div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-pastel-blue">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Akses Cepat Admin</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <br>
                            Kelola Buku
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-tags fa-2x mb-2"></i>
                            <br>
                            Kelola Kategori
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                            <br>
                            Kelola Pesanan
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-store fa-2x mb-2"></i>
                            <br>
                            Lihat Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Recent Orders & Stats -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header bg-pastel-purple d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Pesanan Terbaru</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @php
                    $recentOrders = App\Models\Order::with('user')->latest()->take(5)->get();
                @endphp
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="fw-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->user->name }}</td>
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
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-clipboard-list fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Low Stock Alert -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Peringatan Stok Rendah</h5>
            </div>
            <div class="card-body">
                @php
                    $lowStockBooks = App\Models\Book::where('stock', '<=', 5)->where('stock', '>', 0)->get();
                    $outOfStockBooks = App\Models\Book::where('stock', 0)->get();
                @endphp
                
                @if($lowStockBooks->count() > 0)
                    <div class="alert alert-warning mb-3">
                        <strong>Stok Rendah (≤ 5):</strong> {{ $lowStockBooks->count() }} buku
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockBooks->take(3) as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td><span class="badge bg-warning">{{ $book->stock }}</span></td>
                                        <td>{{ $book->category->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($outOfStockBooks->count() > 0)
                    <div class="alert alert-danger mt-3">
                        <strong>Stok Habis:</strong> {{ $outOfStockBooks->count() }} buku
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outOfStockBooks->take(3) as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td><span class="badge bg-danger">{{ $book->stock }}</span></td>
                                        <td>{{ $book->category->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($lowStockBooks->count() == 0 && $outOfStockBooks->count() == 0)
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-success mb-0">Semua stok buku dalam kondisi baik</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Order Statistics Chart
    const ctx = document.getElementById('orderStatsChart').getContext('2d');
    const orderStatsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    {{ App\Models\Order::where('status', 'pending')->count() }},
                    {{ App\Models\Order::where('status', 'processing')->count() }},
                    {{ App\Models\Order::where('status', 'completed')->count() }},
                    {{ App\Models\Order::where('status', 'cancelled')->count() }}
                ],
                backgroundColor: [
                    '#0dcaf0', // pending - info
                    '#ffc107', // processing - warning
                    '#198754', // completed - success
                    '#dc3545'  // cancelled - danger
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>
@endsection
@endsection