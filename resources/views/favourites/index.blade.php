@extends('layout')
<link rel="stylesheet" href="{{ asset('css/favourite.css') }}">
@section('title', 'Your Wishlist - ' . config('app.name'))
@section('content')
<div class="container py-4">
    <h2 class=" text-center">Your Wishlist</h2>
    <h6 class=" text-center mb-2">Find your saved items and get ready to order them</h6>
    <div class="row">
        @forelse ($favourites as $product)
        <div class="col-md-3 col-sm-6 gap-2">
            <div class="product-card">
                <div class="product-img-wrapper">
                    {{-- Favorite Icon --}}
                    @php
                    $isFavourite = $favourites->contains('id', $product->id);
                    @endphp
                    <form action="{{ route('favourites.toggle') }}" method="POST" class="favorite-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-link p-0">
                            @if($isFavourite)
                            <i class="fa fa-heart favorite-icon text-danger"></i>
                            @else
                            <i class="fa fa-heart favorite-icon text-secondary"></i>
                            @endif
                        </button>
                    </form>
                    <img src="{{ asset('storage/'.$product->img) }}" alt="{{ $product->name }}">
                    @if($product->discount_amount > 0)
                    <div class="triangle-discount">
                        <span>-{{ (int) $product->discount_amount }}%</span>
                    </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text text-muted mb-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                    <div class="wishlist-price d-flex align-items-center ">
                        @if($product->discount_amount > 0)
                        <span class="old-price">${{ number_format($product->price, 2) }}</span>
                        <span class="new-price">${{ number_format($product->final_price, 2) }}</span>
                        @else
                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    <p class="stock">
                        {{ $product->stock > 0 ? 'in stock ready to ship' : 'Out of stock' }}
                    </p>

                    {{-- Action Button --}}
                        <div class="d-flex justify-content-center gap-2 ">
                            <a href="#" class="btn cart w-50">Add to Cart</a>
                        </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No products in your wishlist.</p>
        @endforelse
    </div>
</div>
@endsection