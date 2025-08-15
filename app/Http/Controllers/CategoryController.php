<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function categoryProducts(Category $category)
{
    dd($category);
    $category->load('products'); 

    return view('products.categoryProducts', [
        'category' => $category,
        'products' => $category->products
    ]);
}
}