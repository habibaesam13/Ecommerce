<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get or create a cart for a user (with items + products eager loaded).
     */
    public function getUserCart(int $userId): Cart
    {
        return Cart::with(['items.product'])
            ->firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Add item to cart.
     */
    public function addItemToCart(int $userId, int $productId, int $quantity): array
    {
        $product = Product::findOrFail($productId);

        if ($quantity > $product->stock) {
            return ['success' => false, 'message' => 'Quantity exceeds available stock.'];
        }

        return DB::transaction(function () use ($userId, $product, $quantity) {
            $cart = $this->getUserCart($userId);

            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                // $newQuantity = $cartItem->quantity + $quantity;

                if ($quantity > $product->stock) {
                    return ['success' => false, 'message' => 'Total quantity exceeds available stock.'];
                }

                $cartItem->update([
                    'quantity' => $quantity,
                    'price'    => $product->final_price,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $product->final_price,
                ]);
            }

            $product->decrement('stock', $quantity);

            return ['success' => true, 'message' => 'Product added to cart successfully.'];
        });
    }

    /**
     * Update item quantity in cart.
     */
    public function updateItemQuantity(int $userId, int $productId, int $quantity): array
    {
        $product = Product::findOrFail($productId);

        $cart = $this->getUserCart($userId);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        // Allow updating if quantity is within available stock + current cart item
        if ($quantity > $product->stock) {
            return ['success' => false, 'message' => 'Requested quantity exceeds available stock.'];
        }

        return DB::transaction(function () use ($cartItem, $product, $quantity) {
            $oldQuantity = $cartItem->quantity;

            $cartItem->update([
                'quantity' => $quantity,
                'price'    => $product->final_price,
            ]);

            $diff = $quantity - $oldQuantity;

            if ($diff > 0) {
                $product->decrement('stock', $diff);
            } elseif ($diff < 0) {
                $product->increment('stock', abs($diff));
            }

            return ['success' => true, 'message' => 'Cart updated successfully.'];
        });
    }

    /**
     * Remove item from cart.
     */
    public function removeItemFromCart(int $userId, int $productId): array
    {
        $cart = $this->getUserCart($userId);
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        return DB::transaction(function () use ($cartItem, $productId) {
            $product = Product::find($productId);

            if ($product) {
                $product->increment('stock', $cartItem->quantity);
            }

            $cartItem->delete();

            return ['success' => true, 'message' => 'Item removed from cart.'];
        });
    }

    /**
     * Clear the whole cart.
     */
    public function clearCart(int $userId): array
    {
        $cart = $this->getUserCart($userId);

        return DB::transaction(function () use ($cart) {
            foreach ($cart->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $cart->items()->delete();

            return ['success' => true, 'message' => 'Cart cleared successfully.'];
        });
    }

    /**
     * Get the quantity of a cart item.
     */
    private function getCartItemQuantity(int $userId, int $productId): int
    {
        $cart = $this->getUserCart($userId);

        return $cart->items()
            ->where('product_id', $productId)
            ->value('quantity') ?? 0;
    }
}
