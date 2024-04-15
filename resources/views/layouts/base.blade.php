<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'VisualApp' }}</title>
                <!-- Scripts -->
                @vite(['resources/css/app.css', 'resources/js/app.js'])

                <!-- Styles -->
                @livewireStyles

    </head>
    <body class="bg-gradient-to-br from-teal-100 via-gray-100 to-pink-50 dark:bg-gradient-to-br dark:from-black dark:via-slate-900 dark:to-black p-8 rounded-lg shadow-lg">
        {{ $slot }}

        @livewireScripts
    </body>
</html>