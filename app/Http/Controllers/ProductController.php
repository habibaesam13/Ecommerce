<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\FavouriteService;

class ProductController extends Controller
{

    private ProductService $productService;
    private CategoryService $categoryService;
    private FavouriteService $favouriteService;

    public function __construct(ProductService $productService, CategoryService $categoryService, FavouriteService $favouriteService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->favouriteService = $favouriteService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->index($request->q);
        $favourites = $this->favouriteService->getFavouritesByUserId(auth()->id());
        return view('products.index', compact('products', 'favourites'));
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
