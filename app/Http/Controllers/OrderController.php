<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('user')->except(['adminIndex', 'updateStatus', 'adminShow']);
        $this->middleware('admin')->only(['adminIndex', 'updateStatus', 'adminShow']);
    }

    // Menampilkan daftar pesanan (admin)
    public function adminIndex()
    {
        $orders = Order::with('user', 'orderItems.book.category')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan (admin)
    public function adminShow(Order $order)
    {
        $order->load('orderItems.book.category', 'user');
        return view('admin.orders.show', compact('order'));
    }

    // Menampilkan daftar pesanan (user)
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.book.category')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    // Menampilkan form checkout (halaman pembuatan pesanan)
    public function create()
    {
        try {
            // 🔴 PERBAIKAN: Load relation yang lengkap untuk gambar
            $cartItems = Auth::user()->carts()->with(['book.category'])->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('user.cart.index')
                    ->with('error', 'Keranjang belanja kosong!');
            }
            
            // Hitung total
            $subtotal = $cartItems->sum(function($item) {
                return $item->book->price * $item->quantity;
            });
            
            $shipping = 0; // Gratis ongkir
            $total = $subtotal + $shipping;
            $totalItems = $cartItems->sum('quantity');
            
            // 🔴 PERBAIKAN: Validasi stok sebelum checkout
            $outOfStockItems = [];
            foreach ($cartItems as $item) {
                if ($item->book->stock < $item->quantity) {
                    $outOfStockItems[] = [
                        'book' => $item->book,
                        'requested' => $item->quantity,
                        'available' => $item->book->stock
                    ];
                }
            }
            
            if (!empty($outOfStockItems)) {
                return redirect()->route('user.cart.index')
                    ->with('error', 'Beberapa buku stok tidak mencukupi. Silakan periksa keranjang Anda.');
            }
            
            return view('user.orders.create', compact('cartItems', 'subtotal', 'total', 'totalItems', 'shipping'));
            
        } catch (\Exception $e) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Error loading checkout page: ' . $e->getMessage());
        }
    }

    // Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat pesanannya sendiri
        if (Auth::user()->isUser() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        // 🔴 PERBAIKAN: Load relation yang lengkap untuk gambar
        $order->load('orderItems.book.category', 'user');
        return view('user.orders.show', compact('order'));
    }

    // Membuat pesanan baru (checkout)
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            // 🔴 PERBAIKAN: Load relation yang lengkap
            $cartItems = $user->carts()->with(['book.category'])->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang belanja kosong!');
            }

            // Validasi stok sebelum membuat order
            foreach ($cartItems as $cartItem) {
                if ($cartItem->book->stock < $cartItem->quantity) {
                    return redirect()->route('user.cart.index')
                        ->with('error', 'Stok buku "' . $cartItem->book->title . '" tidak mencukupi. Stok tersedia: ' . $cartItem->book->stock);
                }
            }

            // Hitung total harga
            $subtotal = $cartItems->sum(function ($item) {
                return $item->book->price * $item->quantity;
            });
            
            $shipping = 0;
            $total = $subtotal + $shipping;

            // Buat pesanan - HANYA COD
            $order = $user->orders()->create([
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => 'cod', // SELALU COD
                'shipping_address' => $request->shipping_address,
            ]);

            // Tambahkan item pesanan
            foreach ($cartItems as $cartItem) {
                $order->orderItems()->create([
                    'book_id' => $cartItem->book_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->book->price,
                    'book_title' => $cartItem->book->title, // Simpan judul untuk backup
                    'book_author' => $cartItem->book->author, // Simpen author untuk backup
                ]);

                // Kurangi stok buku
                $book = $cartItem->book;
                $book->stock -= $cartItem->quantity;
                $book->save();
            }

            // Kosongkan keranjang
            $user->carts()->delete();

            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // Update status pesanan (admin)
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $oldStatus = $order->status;
            $order->update([
                'status' => $request->status,
            ]);

            // Jika status cancelled, kembalikan stok
            if ($oldStatus !== 'cancelled' && $request->status === 'cancelled') {
                foreach ($order->orderItems as $item) {
                    $book = Book::find($item->book_id);
                    if ($book) {
                        $book->stock += $item->quantity;
                        $book->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getOrderStats()
    {
        try {
            $user = Auth::user();
            
            $totalOrders = $user->orders()->count();
            $pendingOrders = $user->orders()->where('status', 'pending')->count();
            $completedOrders = $user->orders()->where('status', 'completed')->count();
            
            return [
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'completed_orders' => $completedOrders,
            ];
            
        } catch (\Exception $e) {
            return [
                'total_orders' => 0,
                'pending_orders' => 0,
                'completed_orders' => 0,
            ];
        }
    }
}