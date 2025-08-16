<?php

namespace App\Http\Controllers;

use App\Services\HomePageService;


class HomePageController extends Controller
{
    private HomePageService $homePageService;

    public function __construct(HomePageService $homePageService) {
        $this->homePageService = $homePageService;
    }
    public function index(){
        $categories = $this->homePageService->index();
        return view('mainApp', compact('categories'));
    }
}
