<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // ✅ HAPUS CONSTRUCTOR atau PERBAIKI
    public function __construct()
    {
        // Middleware hanya untuk method admin saja
        $this->middleware(['auth', 'admin'])->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy', 'adminShow'
        ]);
        
        // Method show() untuk user TANPA middleware
    }

    /**
     * Display a listing of the books (Admin).
     */
    public function index()
    {
        $books = Book::with('category')->get();
        $categories = Category::all();
        
        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book (Admin).
     */
    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.books.create', compact('categories'));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Error loading create form');
        }
    }

    /**
     * Store a newly created book in storage (Admin).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('cover')) {
                $validated['cover'] = $request->file('cover')->store('book-covers', 'public');
            }

            Book::create($validated);

            return redirect()->route('admin.books.index')
                ->with('success', 'Buku berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating book')
                ->withInput();
        }
    }

    /**
     * Display the specified book (Public View - untuk User).
     */
    public function show($id)
    {
        try {
            $book = Book::with('category')->findOrFail($id);
            return view('books.show', compact('book'));
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Buku tidak ditemukan');
        }
    }

    /**
     * Display the specified book for admin (Admin View).
     */
    public function adminShow(Book $book)
    {
        try {
            $book->load('category');
            return view('admin.books.show', compact('book'));
        } catch (\Exception $e) {
            Log::error('Error in adminShow: ' . $e->getMessage());
            return redirect()->route('admin.books.index')
                ->with('error', 'Buku tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified book (Admin).
     */
    public function edit(Book $book)
    {
        try {
            $categories = Category::all();
            return view('admin.books.edit', compact('book', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Error loading edit form');
        }
    }

    /**
     * Update the specified book in storage (Admin).
     */
    public function update(Request $request, Book $book)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' 
            ]);

            if ($request->hasFile('cover')) {
                if ($book->cover) {
                    Storage::disk('public')->delete($book->cover);
                }
                $validated['cover'] = $request->file('cover')->store('book-covers', 'public');
            }

            $book->update($validated);

            return redirect()->route('admin.books.index')
                ->with('success', 'Buku berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating book')
                ->withInput();
        }
    }

    /**
     * Remove the specified book from storage (Admin).
     */
    public function destroy(Book $book)
    {
        try {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            
            $book->delete();
            return redirect()->route('admin.books.index')
                ->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Error deleting book');
        }
    }
}