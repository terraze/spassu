<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles / Scripts -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- Bootstrap -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    </head>
    <body>
        <!-- Header -->
        @include('components.header')

        <!-- Main Content -->
        <main class="container py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
        @include('components.toast')
        @include('components.loading-overlay')

        <!-- Scripts -->
        <script src="{{ asset('js/data-table.js') }}"></script>
        <script src="{{ asset('js/form-handler.js') }}"></script>
        <script src="{{ asset('js/table-handler.js') }}"></script>
        @stack('scripts')
    </body>
</html>
