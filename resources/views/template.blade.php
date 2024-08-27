<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Psi')</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if(!Request::is('blacklist'))
        <div class="quicklinks">
            <a href="{{ route('blacklist') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0C5.4 0 0 5.4 0 12C0 18.6 5.4 24 12 24C18.6 24 24 18.6 24 12C24 5.4 18.6 0 12 0ZM16.44 14.76C16.92 15.24 16.92 15.96 16.44 16.44C15.96 16.92 15.24 16.92 14.76 16.44L12 13.68L9.24 16.44C8.76 16.92 8.04 16.92 7.56 16.44C7.08 15.96 7.08 15.24 7.56 14.76L10.32 12L7.56 9.24C7.08 8.76 7.08 8.04 7.56 7.56C8.04 7.08 8.76 7.08 9.24 7.56L12 10.32L14.76 7.56C15.24 7.08 15.96 7.08 16.44 7.56C16.92 8.04 16.92 8.76 16.44 9.24L13.68 12L16.44 14.76Z" fill="currentColor"/>
                </svg>
                Blacklist
            </a>
        </div>
    @endif
    @yield("body")
</body>
</html>
