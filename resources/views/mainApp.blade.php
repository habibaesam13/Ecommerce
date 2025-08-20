@extends('layout')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@section('title', config('app.name') . "-Home Page")

@section('content')
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/products/5.jpg') }}" class="d-block" alt="Room 1" loading="lazy">
            <div class="overlay-text">New Arrivals – Shop the Latest Trends</div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/products/1.jpg') }}" class="d-block" alt="Room 2" loading="lazy">
            <div class="overlay-text">Bundle & Save – Up to 30% Off Sets</div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/products/4.jpg') }}" class="d-block" alt="Room 3" loading="lazy">
            <div class="overlay-text">ALL what you need in the same place</div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>


<section class="new-arrivals">
    <div class="half-line"></div>
    <span>Discover our New Arrivals</span>
    <div class="half-line"></div>
</section>

<section class="products container my-5">
    <div class="row">
        @forelse ($products as $product)
        <div class="col custom-col mb-4">
            <a href="{{ route('product-details', $product->id) }}" class="card-link">
                <div class="card h-100 shadow-sm d-flex flex-column">
                    {{-- Favorite Icon --}}
                    @php
                    $isFavourite = $userFavourites->contains('id', $product->id);
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


                    <div class="position-relative">
                        <img src="{{ asset('storage/'.$product->img) }}"
                            class="card-img-top"
                            alt="{{ $product->name }}">

                        @if($product->discount_amount > 0)
                        <div class="triangle-discount">
                            <span>-{{ (int) $product->discount_amount }}%</span>
                        </div>
                        @endif

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

                        <div class="mt-auto">
                            <a href="#" class="btn btn-primary btn-sm w-100">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p class="text-center">No products found in this category.</p>
        @endforelse


        <!-- Pagination links -->
        <div class="mt-4 d-flex justify-content-center custom-pagination">
            {{ $products->links('vendor.pagination.arrows') }}
        </div>
    </div>
</section>


<section class="category">
    @foreach ($categories as $category)
    <li><a href="{{ route('category-products', $category->id) }}">{{ $category->name }}</a></li>
    @endforeach
</section>


@endsection