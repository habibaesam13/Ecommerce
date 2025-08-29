<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder($paymentMethod)
    {
        return DB::transaction(function () use ($paymentMethod) {
            $cart = Auth::user()->cart;

            if (!$cart || $cart->items->isEmpty()) {
                throw new \Exception("Cart is empty");
            }

            $items = $cart->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name'       => $item->product->name,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->price * $item->quantity,
                ];
            })->toArray();

            $order = Order::create([
                'user_id' => Auth::id(),
                'total'   => $cart->total, // use accessor from Cart model
                'status'  => 'pending',
                'items'   => json_encode($items),
                'payment_method' => $paymentMethod,
            ]);

            foreach ($cart->items as $cartItem) {
                $order->orderItems()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();
            return $order;
        });
    }

     public function updateOrder($orderId, $data)
    {
        return DB::transaction(function () use ($orderId, $data) {
            $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
                foreach ($order->orderItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }

            $order->update([
                'status' => $data['status'] ?? $order->status,
            ]);

            return $order;
        });
    }
    public function deleteOrder($orderId)
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->delete();
            return true;
        });
    }

    public function getUserOrders()
    {
        return Order::where('user_id', Auth::id())->latest()->get();
    }
}
