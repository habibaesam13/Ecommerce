@extends('layout')

@section('title', $category->name . ' - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ $category->name }}</h2>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset( 'storage/'.$product->img) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-2">{{ Str::limit($product->description, 80) }}</p>

                        <p class="fw-bold text-success mb-1">${{ number_format($product->price, 2) }}</p>
                        @if($product->discount_price)
                            <p class="text-danger">Discount: ${{ number_format($product->discount_price, 2) }}</p>
                        @endif

                        <p class="text-muted mb-2">Stock: {{ $product->stock > 0 ? $product->stock : 'Out of stock' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found in this category.</p>
        @endforelse
    </div>
</div>
@endsection
