<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <title>Spassu</title>

        <!-- Styles / Scripts -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    </head>
    <body>
        <!-- Header -->
        @include('components.header')

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
    </body>
</html>
