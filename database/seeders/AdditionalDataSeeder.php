<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample carts for user
        $user = User::where('email', 'user@example.com')->first();
        
        if ($user) {
            // Create sample cart items
            Cart::create([
                'user_id' => $user->id,
                'book_id' => 1,
                'quantity' => 2
            ]);
            
            Cart::create([
                'user_id' => $user->id,
                'book_id' => 3,
                'quantity' => 1
            ]);

            // Create sample order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 245000,
                'status' => 'completed',
                'payment_method' => 'transfer_bank'
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => 1,
                'quantity' => 1,
                'price' => 85000
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => 2,
                'quantity' => 1,
                'price' => 95000
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => 5,
                'quantity' => 1,
                'price' => 65000
            ]);
        }

        $this->command->info('Sample cart and order data created successfully!');
    }
}