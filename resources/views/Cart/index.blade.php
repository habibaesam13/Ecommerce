@extends('layout')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@section('title', 'Shopping Cart - '. config('app.name'))
@section('content')
<div class="container my-4 cart-page">

    <h2 class="mb-2 fw-bold">Shopping Cart</h2>

    @if($cart->items->isEmpty())
    <div class="empty-cart text-center py-5 m w-50 mx-auto">
        <i class="fa-solid fa-cart-shopping fa-3x mb-3"></i>
        <p class="lead text-muted">Your bag is empty.</p>
        <p class="text-muted">Looks like you haven’t added anything yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-5 mt-2">
            Shop Now
        </a>
    </div>

    @else
    <div class="row g-2">
        <p class="text-danger text-center w-50 mx-auto hurry">🔥Hurry up! Your items are reserved.</p>
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="cart-items">
                @foreach($cart->items as $item)
                <div class="cart-item d-flex align-items-start py-3 position-relative">
                    <!-- Delete Icon at top-right of item -->
                    <form action="{{ route('cart.delete', $item->product_id) }}" method="POST"
                        class="position-absolute top-0 end-0 m-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" title="Remove">
                            <i class="fa-solid fa-trash" style="font-size: 1rem;"></i>
                        </button>
                    </form>

                    <!-- Product Image -->
                    <img src="{{ asset('storage/'.$item->product->img) }}" class="cart-item-img me-3" alt="{{ $item->product->name }}">

                    <!-- Product Details -->
                    <div class="flex-grow-1">
                        <h5 class="product-name mb-1">
                            {{ $item->product->name }}
                            <span class="badge">
                                <a href="{{ route('category-products', $item->product->category->id) }}" class="text-decoration-none">
                                    {{ $item->product->category->name ?? '' }}
                                </a>
                            </span>
                        </h5>
                        <p class="fw-bold mb-2" style="font-size: 1.25rem;color: #333;">
                            {{ $item->product->discount_amount ? number_format($item->product->final_price, 2) : number_format($item->product->price, 2) }} $
                        </p>
                        <p class="mb-1" style="font-weight: bold;text-transform: capitalize;color: #333;"> {{ $item->product->stock > 0 ? 'In stock: '.$item->product->stock : 'Out of stock' }}</p>

                        <!-- Quantity + Total -->
                        <form action="{{ route('cart.update', $item->product_id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex flex-column align-items-start">
                                <div class="input-group input-group-sm quantity-group" style="max-width: 150px;">
                                    <button type="button" class="custom-btn px-3" onclick="changeQty(this, -1)">-</button>
                                    <input type="text" name="quantity" class="form-control text-center mx-2"
                                        value="{{ $item->quantity }}" min="1" readonly>
                                    <button type="button" class="custom-btn px-3" onclick="changeQty(this, 1)">+</button>
                                </div>
                                <p class="fw-bold mt-2">Total: ${{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </form>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div id="toast-body" class="toast-body">
                <!-- Message will be inserted here -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


        <!-- Summary -->
        <div class="col-lg-4">
            <div class="summary-card p-4 rounded shadow-sm">
                <h4 class="fw-bold mb-3">Order Summary</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-bold">${{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span class="fw-bold">Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold">${{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                </div>
                <a href="#" class="btn btn-dark w-100 rounded-pill py-2">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
<script>
    function changeQty(btn, delta) {
        let input = btn.parentElement.querySelector('input[name="quantity"]');
        let form = btn.closest('form');
        let current = parseInt(input.value) || 1;
        if (delta === -1 && current <= 1) return;
        input.value = current + delta;
        form.submit();
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            showToast("{{ session('success') }}", "bg-success");
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", "bg-danger");
        @endif
    });

    function showToast(message, bgClass) {
        const toastEl = document.getElementById('liveToast');
        const toastBody = document.getElementById('toast-body');
        
        toastEl.className = `toast align-items-center text-white ${bgClass} border-0`; 
        toastBody.innerText = message;

        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    }
</script>
