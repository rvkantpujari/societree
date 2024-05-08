<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'SocieTree - A Society Management System')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <section class="min-h-screen flex flex-col justify-center items-center md:pt-6 pt-0 px-4 bg-gray-100">
            <section>
                <a href="/">
                    <x-app-logo class="w-full h-20 fill-current text-gray-500" />
                </a>
            </section>

            <section class="w-full max-w-md mt-6 p-8 bg-white shadow-md overflow-hidden rounded-lg">
                {{ $slot }}
            </section>
        </section>
    </body>
</html>
