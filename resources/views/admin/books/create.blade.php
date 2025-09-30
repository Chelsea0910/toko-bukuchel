@extends('layouts.app')

@section('title', 'Tambah Buku Baru - Admin Toko BukuChel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Kelola Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Buku Baru</li>
            </ol>
        </nav> -->
        <h2 class="fw-bold"><i class="fas fa-plus me-2"></i>Tambah Buku Baru</h2>
        <p class="text-muted">Tambahkan buku baru ke koleksi toko</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-pastel-blue">
                <h5 class="mb-0">Informasi Buku</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="author" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" value="{{ old('author') }}" required>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                   id="price" name="price" value="{{ old('price') }}" min="0" step="100" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- 🔴 INPUT COVER YANG DITAMBAHIN -->
                            <label for="cover" class="form-label fw-semibold">Cover Buku</label>
                            <input type="file" class="form-control @error('cover') is-invalid @enderror" 
                                   id="cover" name="cover" accept="image/*">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Format: JPG, PNG, JPEG. Maks: 2MB</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi Buku</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" checked>
                            <label class="form-check-label fw-semibold" for="is_available">
                                Buku tersedia untuk dijual
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Buku
                        </button>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-pastel-purple">
                <h5 class="mb-0">Tips</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Tips Menambah Buku:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Gunakan judul yang jelas dan deskriptif</li>
                        <li>Pastikan harga sesuai dengan market</li>
                        <li>Upload cover buku yang menarik</li>
                        <li>Periksa stok secara berkala</li>
                        <li>Gunakan deskripsi yang informatif</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-pastel-pink">
                <h5 class="mb-0">Preview Cover</h5>
            </div>
            <div class="card-body text-center">
                <img id="imagePreview" src="https://via.placeholder.com/200x250?text=Preview+Cover" 
                     class="img-fluid rounded" alt="Preview Cover" style="max-height: 250px;">
                <p class="text-muted small mt-2">Preview akan muncul di sini</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-pastel-green">
                <h5 class="mb-0">Statistik Buku</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <h4 class="text-primary">{{ \App\Models\Book::count() }}</h4>
                        <small class="text-muted">Total Buku di Sistem</small>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-success">{{ \App\Models\Category::count() }}</h4>
                        <small class="text-muted">Total Kategori</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Image preview - 🔴 UPDATE ID MENJADI 'cover'
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

// Character count for description
document.getElementById('description').addEventListener('input', function(e) {
    const charCount = this.value.length;
    if (!document.getElementById('charCount')) {
        const counter = document.createElement('div');
        counter.id = 'charCount';
        counter.className = 'form-text';
        this.parentNode.appendChild(counter);
    }
    document.getElementById('charCount').textContent = charCount + ' karakter';
});
</script>
@endsection