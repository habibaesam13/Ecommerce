<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
    }

    public function show(Order $order, Request $request)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        // Order should have client_secret (created in OrderService)
        if (empty($order->client_secret)) {
            return redirect()->route('cart.index')->with('error', 'Payment not initialized for this order.');
        }

        return view('checkout.show', compact('order'));
    }
}
