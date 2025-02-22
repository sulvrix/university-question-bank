<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>

<div class="d-flex align-items-center justify-content-center vh-100">
    @if (Route::has('login'))
        @auth
            <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Dashboard</a>
        @else
            <a class="btn btn-primary" href="{{ url('login') }}" role="button">Login</a>
        @endauth
    @endif
</div>

</body>

</html>
