<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(Request $request, int $productId)
    {
        $userId = auth()->id();
        $quantity = (int) $request->input('quantity', 1);

        $result = $this->cartService->addItemToCart($userId, $productId, $quantity);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, int $productId)
    {
        $userId = auth()->id();
        $quantity = (int) $request->input('quantity', 1);

        $result = $this->cartService->updateItemQuantity($userId, $productId, $quantity);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function delete(int $productId)
    {
        $userId = auth()->id();

        $result = $this->cartService->removeItemFromCart($userId, $productId);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }

    public function index()
    {
        $userId = auth()->id();
        $cart = $this->cartService->getUserCart($userId);

        return view('cart.index', compact('cart'));
    }
}
