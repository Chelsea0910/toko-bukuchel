<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    // Menampilkan form pembayaran
    public function create(Order $order)
    {
        // Pastikan user hanya bisa membayar pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payments.create', compact('order'));
    }

    // Menyimpan bukti pembayaran
    public function store(Request $request, Order $order)
    {
        // Pastikan user hanya bisa membayar pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan bukti pembayaran
        $imagePath = $request->file('payment_proof')->store('payments', 'public');

        // Buat atau update pembayaran
        $payment = $order->payment()->firstOrNew();
        $payment->amount = $order->total_price;
        $payment->payment_proof = $imagePath;
        $payment->save();

        return redirect()->route('orders.show', $order)->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}