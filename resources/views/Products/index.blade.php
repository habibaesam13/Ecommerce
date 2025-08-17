@extends('layout')

@section('title', 'Products - ' . config('app.name'))

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center">All Products</h2>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Product Image --}}
                    <img src={{ asset('storage/'.$product->img) }} class="card-img-top" alt="{{ $product->name }}">

                    <div class="card-body d-flex flex-column">
                        {{-- Product Name --}}
                        <h5 class="card-title">{{ $product->name }}</h5>

                        {{-- Category --}}
                        <p class="text-muted mb-1">
                            Category: {{ $product->category->name ?? 'Uncategorized' }}
                        </p>

                        {{-- Price --}}
                        <p class="fw-bold mb-3">${{ number_format($product->price, 2) }}</p>

                        {{-- Details Button --}}
                        <a href="{{ route('product-details', $product->id) }}" class="btn btn-primary mt-auto">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
