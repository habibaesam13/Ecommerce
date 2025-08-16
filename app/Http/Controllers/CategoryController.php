<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }
    public function index(){
        $categories = $this->categoryService->getAllCategories();
        return view('categories.index', compact('categories'));
    }

public function categoryProducts($categoryId)
{
    $category = $this->categoryService->categoryProducts($categoryId);

    return view('products.categoryProducts', [
        'category' => $category,
        'products' => $category->products
    ]);
}

}