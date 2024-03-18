<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('public/favicon.png') }}" type="image/x-icon">
    <title>Dashboard +</title>
    @vite('resources/js/app.js')
</head>
<body>
    <header>
        @include('admin.includes.nav')
    </header>

    <div class="container py-4">
        @yield('contents')
    </div>

</body>
</html>
