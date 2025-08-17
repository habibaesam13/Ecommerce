<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function index($search = null)
{
    $query = Product::with('category');

    if ($search) {
        $query->search($search); 
    }

    return $query->cursorPaginate(5);
}




    public function show($categoryId)
    {
        return Product::with('category')
            ->where('category_id', $categoryId)
            ->cursorPaginate(3);
    }
}
