@extends('layouts.app')

@section('title', 'Kelola Buku - Admin Toko BukuChel')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold"><i class="fas fa-book me-2"></i>Kelola Buku</h2>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Buku
                </a>
            </div>
            <p class="text-muted">Kelola koleksi buku toko Anda</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>{{ $books->count() }}</h4>
                    <p>Total Buku</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>{{ $categories->count() }}</h4>
                    <p>Total Kategori</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>{{ $books->where('stock', '>', 0)->count() }}</h4>
                    <p>Buku Tersedia</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>{{ $books->where('stock', 0)->count() }}</h4>
                    <p>Stok Habis</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Buku ({{ $books->count() }} buku)</h5>
                </div>
                <div class="card-body">
                    @if($books->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($book->cover)
                                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 80px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $book->title }}</strong>
                                        @if($book->description)
                                        <br><small class="text-muted">{{ Str::limit($book->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $book->category->name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $book->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- TOMBOL DETAIL - YANG INI YANG HILANG -->
                                            <a href="{{ route('admin.books.show', $book->id) }}" 
                                               class="btn btn-info" 
                                               title="Detail Buku">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- TOMBOL EDIT -->
                                            <!-- <a href="{{ route('admin.books.edit', $book) }}" 
                                               class="btn btn-warning" 
                                               title="Edit Buku">
                                                <i class="fas fa-edit"></i>
                                            </a> -->
                                            
                                            <!-- TOMBOL DELETE -->
                                            <!-- <form action="{{ route('admin.books.destroy', $book) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus Buku">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> -->
                                            <!-- ✅ UNTUK USER -->
                                            <!-- <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary w-100 mb-2">
                                                <i class="fas fa-eye me-2"></i>Detail Buku
                                            </a> -->
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada buku</h4>
                        <p class="text-muted">Mulai dengan menambahkan buku pertama Anda</p>
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Buku Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-responsive {
    max-height: 70vh;
    overflow-y: auto;
}

/* Sticky header untuk tabel panjang */
.table thead th {
    position: sticky;
    top: 0;
    background-color: #f8f9fa;
    z-index: 10;
    border-bottom: 2px solid #dee2e6;
}

/* Hover effect untuk rows */
.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.03);
}

/* Styling untuk tombol aksi */
.btn-group .btn {
    border-radius: 4px;
    margin: 1px;
}

/* Responsive table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .img-thumbnail {
        width: 40px !important;
        height: 60px !important;
    }
}
</style>

<!-- SweetAlert untuk konfirmasi delete -->
@section('scripts')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

<script>
// Konfirmasi delete dengan SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[onsubmit]');
    
    deleteForms.forEach(form => {
        form.onsubmit = function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Buku?',
                text: "Data buku akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        };
    });
});
</script>
@endsection
@endsection