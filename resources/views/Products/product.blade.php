@extends('layout')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@section('title', $product->name . ' - ' . config('app.name'))
@section('content')
<div class="container my-1">
    <div class="row g-1">
        <div class="col-md-6 d-flex  align-items-center justify-content-center">
            <div class="position-relative w-50">

                {{-- Favourite Button --}}
                <form action="{{ route('favourites.toggle') }}" method="POST" class="favorite-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-link p-0">
                        @if($isFav)
                        <i class="fa fa-heart favorite-icon text-danger fs-4"></i>
                        @else
                        <i class="fa fa-heart favorite-icon text-secondary fs-4"></i>
                        @endif
                    </button>
                </form>
                <img src="{{ asset('storage/'.$product->img) }}"
                    alt="{{ $product->name }}"
                    class="img-fluid rounded shadow "
                    loading="eager">
                {{-- Discount Badge --}}
                @if($product->discount_amount > 0)
                <div class="triangle-discount">
                    <span>-{{ (int) $product->discount_amount }}%</span>
                </div>
                @endif

                <div class="product-colors  mt-3">
                    <h6 class="color-label">Color</h6>
                    <ul class="list-inline">
                        <li class="list-inline-item "></li>
                        <li class="list-inline-item "></li>
                        <li class="list-inline-item "></li>
                        <li class="list-inline-item "></li>
                        <li class="list-inline-item "></li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Product Details --}}
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="category-name">
                            <a href="{{ route('category-products', $product->category->id) }}">
                                {{ $categoryName }}
                            </a>
                        </div>
                        <div class="stock">
                            @if($product->stock > 0)
                            <span class="text-success fw-bold">In Stock & Ready to Ship</span>
                            @else
                            <span class="text-danger fw-bold">Out of Stock</span>
                            @endif
                        </div>
                    </div>

                    {{-- Product Title --}}
                    <h2 class="card-title mb-3">{{ $product->name }}</h2>

                    {{-- Description --}}
                    <p class="card-text text-muted mb-3">
                        {{ $product->description }}
                    </p>

                    {{-- Price --}}
                    @if($product->discount_amount > 0)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-muted text-decoration-line-through fs-5">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        <span class="fw-bold text-success fs-4">
                            ${{ number_format($product->final_price, 2) }}
                        </span>
                    </div>
                    @else
                    <p class="fw-bold text-success fs-4 mb-3">
                        ${{ number_format($product->price, 2) }}
                    </p>
                    @endif


                    {{-- Actions --}}
                    <div class="d-flex flex-column">

                        {{-- Quantity Selector --}}
                        <div class="d-flex  mb-3">
                            <button class="btn decrease px-3" type="button" onclick="decreaseQty()">-</button>
                            <input id="quantity" name="quantity" type="text" value="1" readonly class="form-control text-center mx-2" style="width:60px;background-color: transparent;border: none;font-weight: bold;">
                            <button class="btn increase px-3" type="button" onclick="increaseQty({{ $product->stock }})">+</button>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center gap-2" style="margin-top: 5%;">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-50">
                                @csrf
                                <input type="hidden" id="finalQuantity" name="quantity" value="1">
                                <button type="submit" class="btn cart w-100">Add to Cart</button>
                            </form>

                            <a href="{{ route('products.index') }}" class="btn products w-50">
                                Back to Products
                            </a>
                        </div>
                    </div>

                    <div class="container2">
                        <div class="card shipping-card">
                            <div class=" d-flex justify-content-between align-items-center">
                                <h5 style="font-weight: bold;margin: 15px 0 0 15px;">Shipping</h5>
                            </div>
                            <div class="card-body">
                                <div class="shipping-grid">
                                    <div class="shipping-item">
                                        <div class="icon-circle">
                                            <i class="fas fa-percentage text-muted"></i>
                                        </div>
                                        <div class="shipping-content">
                                            <div class="shipping-label">Discount</div>
                                            <p class="shipping-value">Disc 50%</p>
                                        </div>
                                    </div>
                                    <div class="shipping-item">
                                        <div class="icon-circle">
                                            <i class="fas fa-percentage text-muted"></i>
                                        </div>
                                        <div class="shipping-content">
                                            <div class="shipping-label">Package</div>
                                            <p class="shipping-value">Reg</p>
                                        </div>
                                    </div>
                                    <div class="shipping-item">
                                        <div class="icon-circle">
                                            <i class="fas fa-percentage text-muted"></i>
                                        </div>
                                        <div class="shipping-content">
                                            <div class="shipping-label">Delivery Time</div>
                                            <p class="shipping-value">3-4 Working Days</p>
                                        </div>
                                    </div>
                                    <div class="shipping-item">
                                        <div class="icon-circle">
                                            <i class="fas fa-percentage text-muted"></i>
                                        </div>
                                        <div class="shipping-content">
                                            <div class="shipping-label">Arrive</div>
                                            <p class="shipping-value">0 - 12 Oct 2025</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function increaseQty(maxStock) {
        let qty = document.getElementById("quantity");
        let finalInput = document.getElementById("finalQuantity");
        let current = parseInt(qty.value);
        if (current < maxStock) {
            qty.value = current + 1;
            finalInput.value = current + 1;
        }
    }

    function decreaseQty() {
        let qty = document.getElementById("quantity");
        let finalInput = document.getElementById("finalQuantity");
        let current = parseInt(qty.value);
        if (current > 1) {
            qty.value = current - 1;
            finalInput.value = current - 1;
        }
    }
</script>
