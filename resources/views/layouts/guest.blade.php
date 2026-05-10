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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-12 sm:pt-0">
            <div class="mb-12">
                <a href="/" class="hover:opacity-80 transition-opacity">
                    <x-application-logo class="h-16 w-auto" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 bg-white shadow-premium rounded-[3rem] border border-slate-100 overflow-hidden">
                {{ $slot }}
            </div>
            
            <div class="mt-12 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">
                RJ Design Studio &bull; Architecture & Technology
            </div>
        </div>
    </body>
</html>
