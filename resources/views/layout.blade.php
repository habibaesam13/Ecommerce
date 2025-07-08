<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <nav>
        <div>
            <a href="{{ route('home') }}" style="font-size: 1.2rem; font-weight: bold;">
                {{ config('app.name') }}
            </a>
        </div>
        <div style="display: flex; align-items: center; font-family: Arial, Helvetica, sans-serif;">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">My Orders</a>
            <a href="#">About</a>
            <a href="#">Contact Us</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <div style="padding: 2rem;">
        @yield('content')
    </div>

</body>
</html>
