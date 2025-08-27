@extends('layout')

@section('title', 'Your Cart')

@section('content')
<div class="container my-4">
    <h2>Your Cart</h2>

    @if($cart->items->isEmpty())
        <p>Your cart is empty. <a href="{{ route('products.index') }}">Shop now</a></p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width:70px; display:inline;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h4>Total: ${{ number_format($cart->total, 2) }}</h4>
            
        </div>
    @endif
</div>
@endsection
