<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;

class ProductController extends Controller
{

    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request, ProductService $service)
    {
        $products = $service->index($request->q);
        return view('products.index', compact('products'));
    }


    public function details($id)
    {

        $product = Product::with('category')->findOrFail($id);
        $categoryName = $product->category->name;
        $user = auth()->user();

        $isFav = false;
        if ($user) {
            $isFav = $user->favourites()->where('product_id', $id)->exists();
        }
        return view('products.product', compact('product', 'isFav', 'categoryName'));
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
