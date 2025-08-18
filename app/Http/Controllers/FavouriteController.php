<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use App\Services\FavouriteService;
use Illuminate\Http\Request;


class FavouriteController extends Controller
{


    private FavouriteService $favouriteService;

    public function __construct(FavouriteService $favouriteService)
    {
        $this->favouriteService = $favouriteService;
    }

    public function index()
    {

        $favourites = $this->favouriteService->getFavouritesByUserId(auth()->id());
        return view('favourites.index', compact('favourites'));
    }

    public function toggle(Request $request)
{
    $productId = $request->product_id;

    $added = $this->favouriteService->toggle(auth()->id(), $productId);

    if ($added) {
        return redirect()->back()->with('success', 'Product added to favourites');
    } else {
        return redirect()->back()->with('success', 'Product removed from favourites');
    }
}
}