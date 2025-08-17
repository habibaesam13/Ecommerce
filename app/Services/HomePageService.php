<?php

namespace App\Services;
use App\Services\CategoryService;

class HomePageService
{
    /**
     * Create a new class instance.
     */
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(){
        return $this->categoryService->index();
    }
}
