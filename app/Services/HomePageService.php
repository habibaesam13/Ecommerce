<?php

namespace App\Services;
use App\Services\CategoryService;
use App\Services\ProductService;
class HomePageService
{
    /**
     * Create a new class instance.
     */
    private CategoryService $categoryService;
    private ProductService $productService;
    private FavouriteService $favouriteService;

    public function __construct(CategoryService $categoryService, ProductService $productService, FavouriteService $favouriteService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->favouriteService = $favouriteService;
    }

    public function index(){
        return [
            'categories' => $this->categoryService->index(),
            'favourites' => $this->favouriteService->getFavouritesByUserId(auth()->id()),
            'products' => $this->productService->newArrivals(),
        ];
    }
}
