<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Font Awesome for icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar">
        <span class="app-name">
            <a href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </span>


        <!-- Nav links -->
        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">Products</a>
            <a href="#">My Orders</a>
            <a href="#">About</a>
            <a href="#">Contact Us</a>
        </div>


        <!-- Search bar -->
        <div class="search-container">
    <form action="{{ route('products.index') }}" method="GET" class="search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="search-input">
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>




        <!-- Icons -->
        <div class="nav-icons">
            <a href="#"><i class="fas fa-heart"></i></a>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
            <a href="#"><i class="fas fa-user"></i> <span>{{ Auth::user()->short_name}}</span></a>
        </div>
    </nav>
    <div>
        @yield('content')
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>