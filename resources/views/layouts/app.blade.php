<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />
        <link rel="icon" type="image/webp" href="{{ asset('/images/Rj-logo.webp') }}">

        <!-- Flatpickr (Calendar) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            .flatpickr-calendar {
                background: #ffffff;
                border-radius: 2rem !important;
                border: 1px solid #f1f5f9 !important;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important;
                padding: 10px;
            }
            .flatpickr-day.selected {
                background: #0284c7 !important;
                border-color: #0284c7 !important;
            }
            .flatpickr-months .flatpickr-month {
                color: #0f172a !important;
                font-family: serif;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-sky-500/30">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
