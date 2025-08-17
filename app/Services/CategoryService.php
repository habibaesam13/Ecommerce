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

    public function show($categoryId)
    {
        return Category::find($categoryId);
    }

    public function index(){
        return Category::all();
    }


}
