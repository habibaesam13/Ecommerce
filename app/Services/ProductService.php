<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show($categoryId){
        // Logic to retrieve products by category ID
        $products= Product::with('category')->where('category_id', $categoryId)->cursorPaginate(3);
        return $products;
    }
}
