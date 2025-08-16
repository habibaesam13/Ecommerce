@extends('layout')

@section('title', config('app.name') . "-Home Page")

@section('content')
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="1000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/products/5.jpg') }}" class="d-block" alt="Room 1">
            <div class="overlay-text">New Arrivals – Shop the Latest Trends</div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/products/1.jpg') }}" class="d-block" alt="Room 2">
            <div class="overlay-text">Bundle & Save – Up to 30% Off Sets</div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/products/4.jpg') }}" class="d-block" alt="Room 3">
            <div class="overlay-text">ALL what you need in the same place</div>
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<section class="category">
    @foreach ($categories as $category)
    <li><a href="{{ route('category-products', $category->id) }}">{{ $category->name }}</a></li>
    @endforeach
</section>

@endsection