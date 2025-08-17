<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;


    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    public function show($categoryId)
    {

        $category = $this->categoryService->show($categoryId);
        if (! $category) {
            abort(404, 'Category not found');
        }
        $products = $this->productService->show($categoryId);
        return view('products.categoryProducts', compact('products', 'category'));
    }
}
