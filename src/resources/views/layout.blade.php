<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EventGo') }}</title>

{{--        <script type="text/javascript" src="/vendor/blog/js/manifest.js" defer></script>--}}
{{--        <script type="text/javascript" src="/vendor/blog/js/vendor.js" defer></script>--}}
        <script type="text/javascript" src="/vendor/blog/js/app.js" defer></script>

        <link rel="stylesheet" href="/vendor/blog/css/app.css">
    </head>
    <body>
        <div id="app">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </body>
</html>
