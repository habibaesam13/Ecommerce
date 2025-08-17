@extends('layout')

@section('title', 'Products - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">{{ $product->name }}</h2>

        <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src={{ asset('storage/'.$product->img) }} alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5>{{ $product->name }}</h5>
                            <p>{{ $product->description }}</p>
                            <p><strong>${{ $product->price }}</strong></p>
                        </div>
                    </div>
                </div>
        </div>

</div>
@endsection
