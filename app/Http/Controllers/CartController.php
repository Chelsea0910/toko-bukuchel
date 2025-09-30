<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's cart items.
     */
    public function index()
    {
        try {
            // Ambil cart items user yang login dengan relasi book dan category
            $cartItems = Cart::with(['book.category'])
                ->where('user_id', Auth::id())
                ->get();
                
            // Hitung total
            $subtotal = 0;
            $totalItems = 0;
            
            foreach ($cartItems as $item) {
                $subtotal += $item->book->price * $item->quantity;
                $totalItems += $item->quantity;
            }
            
            $shipping = 0; // Gratis ongkir
            $total = $subtotal + $shipping;
            
            return view('user.cart.index', compact('cartItems', 'subtotal', 'total', 'totalItems', 'shipping'));
            
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Gagal memuat keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Add item to cart.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'book_id' => 'required|exists:books,id',
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            // Cek stok buku
            $book = Book::findOrFail($validated['book_id']);
            if ($book->stock < $validated['quantity']) {
                return redirect()->back()
                    ->with('error', 'Stok buku tidak mencukupi. Stok tersedia: ' . $book->stock);
            }

            // Cek apakah buku sudah ada di cart
            $existingCart = Cart::where('user_id', Auth::id())
                              ->where('book_id', $validated['book_id'])
                              ->first();

            if ($existingCart) {
                // Cek stok untuk quantity baru
                $newQuantity = $existingCart->quantity + $validated['quantity'];
                if ($book->stock < $newQuantity) {
                    return redirect()->back()
                        ->with('error', 'Stok tidak mencukupi untuk menambah quantity. Stok tersedia: ' . $book->stock);
                }

                // Update quantity jika sudah ada
                $existingCart->update([
                    'quantity' => $newQuantity
                ]);
                
                $message = 'Quantity buku berhasil ditambahkan!';
            } else {
                // Tambah baru jika belum ada
                Cart::create([
                    'user_id' => Auth::id(),
                    'book_id' => $validated['book_id'],
                    'quantity' => $validated['quantity']
                ]);
                
                $message = 'Buku berhasil ditambahkan ke keranjang!';
            }

            return redirect()->route('user.cart.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan buku ke keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cartItem)
    {
        try {
            // Pastikan user hanya bisa update cart miliknya sendiri
            if ($cartItem->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $request->validate([
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            // Cek stok buku
            $book = Book::findOrFail($cartItem->book_id);
            if ($book->stock < $request->quantity) {
                return redirect()->back()
                    ->with('error', 'Stok buku tidak mencukupi. Stok tersedia: ' . $book->stock);
            }

            $cartItem->update([
                'quantity' => $request->quantity
            ]);

            return redirect()->route('user.cart.index')
                ->with('success', 'Quantity berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cartItem)
    {
        try {
            // Pastikan user hanya bisa hapus cart miliknya sendiri
            if ($cartItem->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $bookTitle = $cartItem->book->title;
            $cartItem->delete();

            return redirect()->route('user.cart.index')
                ->with('success', 'Buku "' . $bookTitle . '" berhasil dihapus dari keranjang!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus buku dari keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Clear all cart items.
     */
    public function clear()
    {
        try {
            $cartCount = Cart::where('user_id', Auth::id())->count();
            
            if ($cartCount === 0) {
                return redirect()->route('user.cart.index')
                    ->with('info', 'Keranjang sudah kosong.');
            }

            Cart::where('user_id', Auth::id())->delete();

            return redirect()->route('user.cart.index')
                ->with('success', 'Semua item berhasil dihapus dari keranjang!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengosongkan keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Get cart count for navbar (AJAX)
     */
    public function getCartCount()
    {
        try {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            return response()->json(['count' => $cartCount]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Get cart summary for checkout page
     */
    public function getCartSummary()
    {
        try {
            $cartItems = Cart::with(['book'])
                ->where('user_id', Auth::id())
                ->get();
                
            $subtotal = 0;
            $totalItems = 0;
            
            foreach ($cartItems as $item) {
                $subtotal += $item->book->price * $item->quantity;
                $totalItems += $item->quantity;
            }
            
            $shipping = 0;
            $total = $subtotal + $shipping;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $cartItems,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'total_items' => $totalItems,
                    'shipping' => $shipping
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat summary keranjang'
            ]);
        }
    }

    /**
     * Check if cart is empty
     */
    private function isCartEmpty()
    {
        return Cart::where('user_id', Auth::id())->count() === 0;
    }

    /**
     * Validate cart before checkout
     */
    public function validateCart()
    {
        try {
            $cartItems = Cart::with(['book'])
                ->where('user_id', Auth::id())
                ->get();

            $errors = [];
            
            foreach ($cartItems as $item) {
                // Cek stok
                if ($item->book->stock < $item->quantity) {
                    $errors[] = 'Stok buku "' . $item->book->title . '" tidak mencukupi. Stok tersedia: ' . $item->book->stock;
                }
                
                // Cek jika buku sudah dihapus
                if (!$item->book) {
                    $errors[] = 'Buku "' . $item->book->title . '" tidak ditemukan.';
                }
            }

            if (!empty($errors)) {
                return [
                    'valid' => false,
                    'errors' => $errors
                ];
            }

            return [
                'valid' => true,
                'cartItems' => $cartItems
            ];
            
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'errors' => ['Terjadi kesalahan saat validasi keranjang.']
            ];
        }
    }
}