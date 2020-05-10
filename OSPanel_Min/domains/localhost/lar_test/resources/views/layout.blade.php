<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield("app-title", "Довідник студентів")
    </title>
</head>
<body>
    <ul>
        <li><a href="/">Головна</a></li>
        <li><a href="/students">Студенти</a></li>
        <li><a href="/about">Про проект</a></li>
    </ul>
    <h1>
        @yield("page-title")
    </h1>

    @yield("page-content")
</body>
</html>
