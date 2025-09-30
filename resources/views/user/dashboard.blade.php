@extends('layouts.app')

@section('title', 'Dashboard User - Toko BukuChel')

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">Dashboard User</h2>
            <span class="badge bg-pastel-blue fs-6">Member sejak: {{ Auth::user()->created_at->format('d M Y') }}</span>
        </div>
        <p class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}! Kelola aktivitas belanja Anda di sini.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-blue h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-shopping-cart fa-3x text-pastel-blue"></i>
                </div>
                <h3 class="stat-number">{{ Auth::user()->carts()->count() }}</h3>
                <p class="mb-0 fw-semibold">Item di Keranjang</p>
                <small class="text-muted">Buku yang sedang Anda pertimbangkan</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-purple h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-clipboard-list fa-3x text-pastel-purple"></i>
                </div>
                <h3 class="stat-number">{{ Auth::user()->orders()->count() }}</h3>
                <p class="mb-0 fw-semibold">Total Pesanan</p>
                <small class="text-muted">Semua pesanan yang pernah dibuat</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-light-pink h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-check-circle fa-3x text-pastel-pink"></i>
                </div>
                <h3 class="stat-number">{{ Auth::user()->orders()->where('status', 'completed')->count() }}</h3>
                <p class="mb-0 fw-semibold">Pesanan Selesai</p>
                <small class="text-muted">Pesanan yang sudah dikirim</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card bg-pastel-blue h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <i class="fas fa-star fa-3x text-white"></i>
                </div>
                <h3 class="stat-number">{{ Auth::user()->orders()->where('status', 'pending')->count() }}</h3>
                <p class="mb-0 fw-semibold">Pesanan Pending</p>
                <small class="text-muted">Menunggu konfirmasi</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-pastel-blue">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <br>
                            Belanja Buku
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('user.cart.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <br>
                            Keranjang Saya
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                            <br>
                            Pesanan Saya
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-user-circle fa-2x mb-2"></i>
                            <br>
                            Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-pastel-purple d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Pesanan Terbaru</h5>
                <a href="{{ route('user.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Tanggal</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->take(5) as $order)
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
                                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada pesanan</h5>
                        <p class="text-muted">Mulai berbelanja dan temukan buku favorit Anda!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection