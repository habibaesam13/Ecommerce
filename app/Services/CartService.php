<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    /**
     * Get or create a cart for user
     */
    public function getUserCart(int $userId)
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Add item to cart
     */
    public function addItemToCart(int $userId, int $productId, int $quantity)
    {
        $product = Product::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($quantity > $product->stock) {
            return ['success' => false, 'message' => 'Quantity exceeds available stock.'];
        }

        $cart = $this->getUserCart($userId);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                return ['success' => false, 'message' => 'Total quantity exceeds available stock.'];
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price'    => $product->final_price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity'   => $quantity,
                'price'      => $product->final_price,
            ]);
        }

        // تحديث المخزون
        $product->decrement('stock', $quantity);

        return ['success' => true, 'message' => 'Product added to cart successfully.'];
    }

    /**
     * Update item quantity in cart
     */
    public function updateItemQuantity(int $userId, int $productId, int $quantity)
    {
        $product = Product::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($quantity > $product->stock + $this->getCartItemQuantity($userId, $productId)) {
            return ['success' => false, 'message' => 'Requested quantity exceeds available stock.'];
        }

        $cart = $this->getUserCart($userId);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        $oldQuantity = $cartItem->quantity;

        $cartItem->update([
            'quantity' => $quantity,
            'price'    => $product->final_price,
        ]);

        // تحديث المخزون (لو الكمية قلت -> نرجع فرق الكمية للمخزون، لو زادت -> ننقصها)
        $diff = $quantity - $oldQuantity;

        if ($diff > 0) {
            $product->decrement('stock', $diff);
        } elseif ($diff < 0) {
            $product->increment('stock', abs($diff));
        }

        return ['success' => true, 'message' => 'Cart updated successfully.'];
    }

    /**
     * Remove item from cart
     */
    public function removeItemFromCart(int $userId, int $productId)
    {
        $cart = $this->getUserCart($userId);
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        // ترجيع الكمية للمخزون
        $product = Product::find($productId);
        if ($product) {
            $product->increment('stock', $cartItem->quantity);
        }

        $cartItem->delete();

        return ['success' => true, 'message' => 'Item removed from cart.'];
    }

    /**
     * Clear the whole cart
     */
    public function clearCart(int $userId)
    {
        $cart = $this->getUserCart($userId);

        foreach ($cart->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $cart->items()->delete();

        return ['success' => true, 'message' => 'Cart cleared successfully.'];
    }

    private function getCartItemQuantity(int $userId, int $productId)
    {
        $cart = $this->getUserCart($userId);
        return $cart->items()->where('product_id', $productId)->value('quantity') ?? 0;
    }
}
