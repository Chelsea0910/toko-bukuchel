@extends('layouts.app')

@section('title', 'Pembayaran Pesanan #' . $order->id . ' - Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.show', $order) }}">Detail Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
            </ol>
        </nav>
        <h2 class="fw-bold"><i class="fas fa-money-bill-wave me-2"></i>Pembayaran Pesanan</h2>
        <p class="text-muted">Lakukan pembayaran untuk pesanan #{{ $order->id }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-pastel-blue">
                <h5 class="mb-0">Detail Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Informasi Pesanan</h6>
                        <p><strong>ID Pesanan:</strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Metode Pembayaran</h6>
                        <p><strong>Metode:</strong> {{ $order->payment_method }}</p>
                        <p><strong>Batas Waktu:</strong> {{ now()->addHours(24)->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-pastel-purple">
                <h5 class="mb-0">Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.store', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="payment_proof" class="form-label fw-semibold">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" 
                               id="payment_proof" name="payment_proof" accept="image/*" required>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format: JPG, PNG, GIF. Maks: 2MB. Pastikan bukti pembayaran jelas terbaca.
                        </div>
                    </div>

                    <div class="mb-4 text-center">
                        <img id="paymentProofPreview" src="https://via.placeholder.com/400x200?text=Preview+Bukti+Pembayaran" 
                             class="img-fluid rounded border" alt="Preview Bukti Pembayaran" style="max-height: 300px;">
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Instruksi Pembayaran:</h6>
                        <ul class="mb-0">
                            <li>Lakukan transfer sesuai total pembayaran</li>
                            <li>Upload bukti transfer yang jelas terbaca</li>
                            <li>Pembayaran akan diverifikasi dalam 1x24 jam</li>
                            <li>Hubungi customer service jika ada kendala</li>
                        </ul>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-pastel-pink">
                <h5 class="mb-0">Rekening Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="bank-account">
                    <div class="text-center mb-4">
                        <i class="fas fa-university fa-3x text-pastel-blue mb-3"></i>
                        <h5>Bank BCA</h5>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Nomor Rekening:</span>
                        <strong>1234 5678 9012 3456</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Atas Nama:</span>
                        <strong>Toko BukuChel</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Cabang:</span>
                        <strong>Jakarta Pusat</strong>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Gunakan nomor rekening di atas untuk transfer pembayaran</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light-blue">
                <h5 class="mb-0">Detail Pesanan</h5>
            </div>
            <div class="card-body">
                @foreach($order->orderItems as $item)
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                        <h6 class="mb-1">{{ Str::limit($item->book->title, 30) }}</h6>
                        <small class="text-muted">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                    <strong class="text-primary">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong>
                </div>
                @endforeach
                
                <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                    <strong>Total:</strong>
                    <strong class="text-primary fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Payment proof preview
document.getElementById('payment_proof').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('paymentProofPreview').src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
});
</script>

<style>
.bank-account {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 15px;
    border: 2px dashed var(--pastel-blue);
}
</style>
@endsection
@endsection