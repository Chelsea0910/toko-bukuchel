<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Pastikan middleware 'admin' sudah ada
    }

    // Dashboard admin - HAPUS method index() yang redundant
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        return view('admin.dashboard', compact(
            'totalBooks', 
            'totalCategories', 
            'pendingOrders', 
            'completedOrders'
        ));
    }

    // 🔴 TAMBAHKAN method users() jika route membutuhkannya
public function users()
{
    $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
}
}