<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анализатор страниц</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@section('header')
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Анализатор страниц</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/urls">Страницы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
@show
@section('main')
    <main class="flex-shrink-0">
        <div class="container mt-1">
            @include('flash::message')
        </div>
        @yield('content')
    </main>
@show
@section('footer')
    <footer class="fixed-bottom border-top">
        <div class="text-center m-2">
            <a href="https://github.com/Greentus/php-project-lvl3">Hexlet Project 3</a>
        </div>
    </footer>
@show
</body>
</html>