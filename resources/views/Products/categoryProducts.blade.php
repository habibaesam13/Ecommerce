@extends('layout')
<link rel="stylesheet" href="{{ asset('css/favourite.css') }}">
@section('title', $category->name . ' - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ $category->name }}</h2>
    <div class="row">
        @forelse ($products as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="{{ asset('storage/'.$product->img) }}" alt="{{ $product->name }}" loading="lazy">
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

                    <div class="wishlist-price d-flex align-items-center gap-2">
                        @if($product->discount_amount > 0)
                            <span class="old-price">${{ number_format($product->price, 2) }}</span>
                            <span class="new-price">${{ number_format($product->final_price, 2) }}</span>
                        @else
                            <span class="new-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <p class="stock">
                        {{ $product->stock > 0 ? 'In stock - ready to ship' : 'Out of stock' }}
                    </p>

                    {{-- Action Button --}}
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('product-details', $product->id) }}" class="btn cart w-50">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No products available.</p>
        @endforelse
    </div>
</div>
@endsection
