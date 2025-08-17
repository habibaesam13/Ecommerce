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

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function index(){
        return [
            'categories' => $this->categoryService->index(),
            'products' => $this->productService->index(),
        ];
    }
}
