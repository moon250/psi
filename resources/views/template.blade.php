<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Psi')</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body>
    @yield("body")
</body>
</html>
