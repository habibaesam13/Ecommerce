<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function getAllCategories(){
        return Category::all();
    }

    public function categoryProducts($categoryId){
        return Category::with('products')->findOrFail($categoryId);
    }
}
