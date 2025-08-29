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
     * Add item to cart (with row lock to avoid race conditions).
     */
    public function addItemToCart(int $userId, int $productId, int $quantity): array
    {
        return DB::transaction(function () use ($userId, $productId, $quantity) {
            // Lock product row so only one user can modify stock at a time
            $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();

            if ($quantity > $product->stock) {
                return ['success' => false, 'message' => 'Quantity exceeds available stock.'];
            }

            $cart = $this->getUserCart($userId);
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                
                $newQuantity = $cartItem->quantity + $quantity;

                if ($newQuantity > $product->stock + $cartItem->quantity) {
                    return ['success' => false, 'message' => 'Total quantity exceeds available stock.'];
                }

                // Adjust stock difference
                $diff = $newQuantity - $cartItem->quantity;
                if ($diff > 0) {
                    $product->decrement('stock', $diff);
                } elseif ($diff < 0) {
                    $product->increment('stock', abs($diff));
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price'    => $product->final_price,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'price'      => $product->final_price,
                ]);

                $product->decrement('stock', $quantity);
            }

            return ['success' => true, 'message' => 'Product added to cart successfully.'];
        });
    }

    /**
     * Update item quantity in cart.
     */
    public function updateItemQuantity(int $userId, int $productId, int $quantity): array
    {
        return DB::transaction(function () use ($userId, $productId, $quantity) {
            $cart = $this->getUserCart($userId);
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                return ['success' => false, 'message' => 'Item not found in cart.'];
            }

            // Lock product row
            $product = Product::where('id', $productId)->lockForUpdate()->firstOrFail();

            $oldQuantity = $cartItem->quantity;

            // Check stock considering current reserved amount
            if ($quantity > ($product->stock + $oldQuantity)) {
                return ['success' => false, 'message' => 'Requested quantity exceeds available stock.'];
            }

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
        return DB::transaction(function () use ($userId, $productId) {
            $cart = $this->getUserCart($userId);
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                return ['success' => false, 'message' => 'Item not found in cart.'];
            }

            // Lock product row
            $product = Product::where('id', $productId)->lockForUpdate()->first();

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
        return DB::transaction(function () use ($userId) {
            $cart = $this->getUserCart($userId);

            foreach ($cart->items as $item) {
                if ($item->product) {
                    // Lock each product before increment
                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
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
