<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анализатор страниц</title>
    <script src="/js/app.js" defer></script>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column">
@section('header')
    <header class="flex-shrink-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home.index') }}">Анализатор страниц</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home.index') }}">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('urls.index') }}">Страницы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
@show
@section('main')
    <main class="flex-grow-1">
        <div class="container mt-1">
            @include('flash::message')
        </div>
        @yield('content')
    </main>
@show
@section('footer')
    <footer class="border-top flex-shrink-0">
        <div class="text-center m-2">
            <a href="https://github.com/Greentus/php-project-lvl3">Hexlet Project 3</a>
        </div>
    </footer>
@show
</body>
</html>