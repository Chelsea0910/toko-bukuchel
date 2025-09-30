@extends('layouts.app')

@section('title', 'Register - Toko BukuChel')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg">
            <div class="card-header bg-pastel-purple text-center py-4">
                <h3 class="fw-bold mb-0"><i class="fas fa-user-plus me-2"></i>Daftar Akun Baru</h3>
                <p class="text-muted mb-0">Bergabunglah dengan komunitas pembaca kami</p>
            </div>
            <div class="card-body p-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-pastel-purple">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap Anda" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-pastel-purple">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-pastel-purple">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Minimal 8 karakter</div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-pastel-purple">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Konfirmasi password" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" required id="terms">
                            <label class="form-check-label" for="terms">
                                Saya menyetujui <a href="#" class="text-decoration-none">Syarat & Ketentuan</a> dan <a href="#" class="text-decoration-none">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-2">Sudah punya akun?</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection