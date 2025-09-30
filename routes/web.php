<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Halaman Home & Katalog Buku
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes - DETAIL BUKU UNTUK USER
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// User Routes
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    // Dashboard User
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Keranjang Belanja
  Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('store');
    Route::put('/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});
    
    // Pesanan
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/', [OrderController::class, 'store'])->name('store');
    });
    
    // Pembayaran
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/{order}/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/{order}/process', [PaymentController::class, 'store'])->name('store');
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    
    // Kelola Buku - GUNAKAN ROUTE YANG BERBEDA UNTUK ADMIN
  Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/create', [BookController::class, 'create'])->name('create');
    Route::post('/', [BookController::class, 'store'])->name('store');
    
    
    // ✅ TARUH SHOW DI ATAS dan PAKAI PATH YANG BERBEDA
   Route::get('/{book}', [BookController::class, 'adminShow'])->name('show');
    
  Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
});
    // Kelola Kategori
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Kelola Pesanan
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'adminIndex'])->name('index');
        Route::get('/{order}', [OrderController::class, 'adminShow'])->name('show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });
});