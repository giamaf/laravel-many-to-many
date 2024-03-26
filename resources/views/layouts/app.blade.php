<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    {{-- Flickering fix --}}
    <style>
        body {
            visibility: hidden;
        }
    </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'
        integrity='sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=='
        crossorigin='anonymous' />

    {{-- CDNS --}}
    @yield('cdns')

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        {{-- NavBar --}}
        @include('includes.layouts.navbar')

        {{-- Main --}}
        <main class="container my-3">
            {{-- ! Delete Alert --}}
            @include('includes.layouts.alert')

            @yield('content')

            {{-- Modal --}}
            @include('includes.layouts.modal')
        </main>

        {{-- Footer --}}
        <footer class="container">
            @yield('footer')
        </footer>
    </div>

    @yield('scripts')
</body>

</html>
