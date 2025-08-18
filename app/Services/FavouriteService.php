<?php

namespace App\Services;

use App\Models\Favourite;

class FavouriteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function toggle(int $userId, int $productId)
    {
        $favourite = Favourite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favourite) {
            
            $favourite->delete();
            return false; 
        } else {
            
            Favourite::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return true; 
        }
    }

    public function getFavouritesByUserId($userId)
    {
        return Favourite::where('user_id', $userId)->get()->pluck('product');
    }
}
