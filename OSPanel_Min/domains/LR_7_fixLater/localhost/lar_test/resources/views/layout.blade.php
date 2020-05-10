<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cover.css') }}">
    <link rel="stylesheet" href="{{ asset("css/cover.css") }}">
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <title>
        @yield("app-title", "Довідник студентів")
    </title>
</head>
<body class="text-center">
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">@yield("app-title")</h3>
            <nav class="nav nav-masthead justify-content-center">
                <a class="nav-link" href="/">Головна</a>
                <a class="nav-link" href="/students">Студенти</a>
                <a class="nav-link" href="/about">Про проект</a>
            </nav>
        </div>
    </header>
    <main role="main" class="inner cover">
        <h1 class="cover-heading">@yield("page-title")</h1>
        @yield("page-content")
    </main>

    <footer class="mastfoot mt-auto">
        <div class="inner">
            @yield("page-footer")
        </div>
    </footer>
</div>
</body>
</html>
