@extends('layouts.app')

@section('title', 'Edit Buku - Admin Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Kelola Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
            </ol>
        </nav> -->
        <h2 class="fw-bold"><i class="fas fa-edit me-2"></i>Edit Buku</h2>
        <p class="text-muted">Edit informasi buku "{{ $book->title }}"</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-pastel-orange">
                <h5 class="mb-0">Informasi Buku</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="author" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" value="{{ old('author', $book->author) }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (old('category_id', $book->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $book->price) }}" min="0" step="100" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- 🔴 UPDATE: GANTI name="image" JADI name="cover" -->
                            <label for="cover" class="form-label fw-semibold">Cover Buku</label>
                            <input type="file" class="form-control @error('cover') is-invalid @enderror" 
                                   id="cover" name="cover" accept="image/*">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Kosongkan jika tidak ingin mengubah cover</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi Buku</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Update Buku
                        </button>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="button" class="btn btn-outline-danger ms-auto" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Current Book Info -->
        <div class="card">
            <div class="card-header bg-pastel-green">
                <h5 class="mb-0">Informasi Saat Ini</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <!-- 🔴 UPDATE: TAMPILKAN COVER DARI DATABASE -->
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" 
                             class="img-fluid rounded" style="max-height: 200px;">
                    @else
                        <img src="https://via.placeholder.com/200x250?text=No+Cover" 
                             class="img-fluid rounded" alt="No Cover" style="max-height: 200px;">
                    @endif
                </div>
                
                <table class="table table-sm">
                    <tr>
                        <td><strong>Judul:</strong></td>
                        <td>{{ $book->title }}</td>
                    </tr>
                    <tr>
                        <td><strong>Penulis:</strong></td>
                        <td>{{ $book->author }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori:</strong></td>
                        <td>{{ $book->category->name ?? 'Tidak ada kategori' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga:</strong></td>
                        <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Stok:</strong></td>
                        <td>
                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->stock }} buku
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ditambahkan:</strong></td>
                        <td>{{ $book->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Preview New Cover -->
        <div class="card mt-4">
            <div class="card-header bg-pastel-pink">
                <h5 class="mb-0">Preview Cover Baru</h5>
            </div>
            <div class="card-body text-center">
                <!-- 🔴 UPDATE: PREVIEW COVER DARI DATABASE -->
                <img id="imagePreview" 
                     src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/200x250?text=Preview+Cover' }}" 
                     class="img-fluid rounded" alt="Preview Cover" style="max-height: 250px;">
                <p class="text-muted small mt-2">Preview cover baru akan muncul di sini</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header bg-pastel-purple">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                        <i class="fas fa-eye me-2"></i>Lihat di Toko
                    </a>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus me-2"></i>Tambah Buku Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku <strong>"{{ $book->title }}"</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan. Semua data buku akan dihapus permanen.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// 🔴 UPDATE: GANTI 'image' JADI 'cover'
document.getElementById('cover').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('imagePreview').src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
});

// Price formatting
document.getElementById('price').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});

// Auto-save description length
document.getElementById('description').addEventListener('input', function(e) {
    const charCount = this.value.length;
    document.getElementById('charCount').textContent = charCount + ' karakter';
});
</script>
@endsection