<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $userId = auth()->id();
        $cart = $this->cartService->getUserCart($userId);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, int $productId)
    {
        $userId = auth()->id();
        $quantity = (int) $request->input('quantity', 1);

        try {
            $this->cartService->addItemToCart($userId, $productId, $quantity);
            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function update(Request $request, int $productId)
    {
        $userId = auth()->id();
        $quantity = (int) $request->input('quantity', 1);

        try {
            $this->cartService->updateItemQuantity($userId, $productId, $quantity);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function delete(int $productId)
    {
        $userId = auth()->id();

        try {
            $this->cartService->removeItemFromCart($userId, $productId);
            return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
