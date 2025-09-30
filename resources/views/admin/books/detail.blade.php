@extends('layouts.app')

@section('title', 'Detail Buku - Admin Toko BukuChel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Kelola Buku</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Buku</li>
                </ol>
            </nav> -->
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-book me-2"></i>Detail Buku - Admin
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" 
                                         alt="{{ $book->title }}" 
                                         class="img-fluid rounded shadow" 
                                         style="max-height: 400px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="height: 400px; width: 100%;">
                                        <div class="text-muted">
                                            <i class="fas fa-book fa-3x mb-3"></i>
                                            <p>No Cover</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <div class="d-grid gap-2">
                                    <span class="badge bg-info fs-6 p-2">
                                        <i class="fas fa-tag me-1"></i>{{ $book->category->name }}
                                    </span>
                                    <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-6 p-2">
                                        <i class="fas fa-{{ $book->stock > 0 ? 'check' : 'times' }} me-1"></i>
                                        {{ $book->stock > 0 ? 'Stok: ' . $book->stock : 'Stok Habis' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h2 class="text-primary">{{ $book->title }}</h2>
                            <p class="text-muted fs-5">
                                <i class="fas fa-user-edit me-2"></i><strong>Penulis:</strong> {{ $book->author }}
                            </p>
                            
                            <div class="mb-4">
                                <h3 class="text-success">Rp {{ number_format($book->price, 0, ',', '.') }}</h3>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="fw-bold text-primary">
                                    <i class="fas fa-file-alt me-2"></i>Deskripsi Buku
                                </h5>
                                <div class="border rounded p-3 bg-light">
                                    {{ $book->description ?: 'Deskripsi belum tersedia untuk buku ini.' }}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Stok</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-2"><strong>Stok Tersedia:</strong> {{ $book->stock }} buku</p>
                                            <p class="mb-0"><strong>Status:</strong> 
                                                <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="fas fa-database me-2"></i>Data Sistem</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1"><strong>ID Buku:</strong> #{{ $book->id }}</p>
                                            <p class="mb-1"><strong>Kategori:</strong> {{ $book->category->name }}</p>
                                            <p class="mb-1"><strong>Dibuat:</strong> {{ $book->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="mb-0"><strong>Diupdate:</strong> {{ $book->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Buku
                        </a>
                        <div class="btn-group">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Buku
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Hapus buku {{ $book->title }}?')">
                                    <i class="fas fa-trash me-2"></i>Hapus Buku
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection