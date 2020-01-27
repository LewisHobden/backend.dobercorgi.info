<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <title>@yield('title') | Dobercorgi Backend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600,700|Material+Icons" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle"
                aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Dobercorgi Admin</a>
        <div class="collapse navbar-collapse" id="navbarToggle">
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link {{ Request::is('/') ? "active" : "" }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ Request::is('categories/*') ? "active" : "" }}"
                                        href="{{ url('/categories') }}">Categories</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Logout</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('login') }}">Login</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container pt-md-3">
        @yield('content')
    </div>
</div>
</body>
</html>
