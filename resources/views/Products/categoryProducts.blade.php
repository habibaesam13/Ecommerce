@extends('layout')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@section('title', $category->name . ' - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ $category->name }}</h2>
    <div class="row">
        @forelse ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm position-relative {{ ($loop->iteration % 3 == 2) ? 'featured-card' : 'normal-card' }}">

                <div class="position-relative">
                    <img src="{{ asset('storage/'.$product->img) }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}">

                    @if($product->discount_amount > 0)
                        <div class="triangle-discount">
                            <span>-{{ (int) $product->discount_amount }}%</span>
                        </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted mb-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                    @if($product->discount_amount > 0)
                        <p class="mb-1 text-muted text-decoration-line-through">
                            ${{ number_format($product->price, 2) }}
                        </p>
                        <p class="fw-bold text-success fs-5">
                            ${{ number_format($product->final_price, 2) }}
                        </p>
                    @else
                        <p class="fw-bold text-success fs-5">
                            ${{ number_format($product->price, 2) }}
                        </p>
                    @endif

                    <p class="text-muted mb-2">
                        Stock: {{ $product->stock > 0 ? $product->stock : 'Out of stock' }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No products found in this category.</p>
        @endforelse

        <!-- Pagination links -->
        <div class="mt-4 d-flex justify-content-center custom-pagination">
            {{ $products->links('vendor.pagination.arrows') }}
        </div>
    </div>
</div>
@endsection
