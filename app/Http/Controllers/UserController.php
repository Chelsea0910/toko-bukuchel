<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('orderItems.book')->orderBy('created_at', 'desc')->paginate(5);
        
        return view('user.dashboard', compact('orders'));
    }
}