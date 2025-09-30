<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home dengan katalog buku
     */
    public function index(Request $request)
    {
        try {
            // Query dasar dengan eager loading
            $query = Book::with('category');

            // Filter berdasarkan kategori
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            
            // Search berdasarkan judul, penulis, atau kategori
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhereHas('category', function($categoryQuery) use ($search) {
                          $categoryQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            // **PERBAIKAN: Ganti is_available dengan stock > 0**
            $query->where('stock', '>', 0);

            // Sorting
            $sort = $request->get('sort', 'latest');
            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'title':
                    $query->orderBy('title', 'asc');
                    break;
                default: // latest
                    $query->latest();
                    break;
            }

            // **PERBAIKAN: Gunakan query yang sudah dibangun, bukan membuat query baru**
            $books = $query->paginate(50);
            $categories = Category::all();

            return view('home', compact('books', 'categories'));

        } catch (\Exception $e) {
            \Log::error('HomeController error: ' . $e->getMessage());
            
            // Fallback jika ada error
            $books = Book::with('category')
                        ->where('stock', '>', 0)
                        ->latest()
                        ->paginate(10);
            $categories = Category::all();
            
            return view('home', compact('books', 'categories'));
        }
    }
}