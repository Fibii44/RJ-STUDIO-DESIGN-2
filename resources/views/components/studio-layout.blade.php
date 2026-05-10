<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'RJ DESIGN STUDIO' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />
        
        <!-- Favicon -->
        <link rel="icon" type="image/webp" href="{{ asset('/images/Rj-logo.webp') }}">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('styles')
    </head>
    <body class="antialiased bg-white text-slate-900 font-sans selection:bg-sky-500/30 overflow-x-hidden">
        <div id="page-loader" class="fixed inset-0 z-[300] bg-white transition-opacity duration-700 pointer-events-none"></div>
        
        @include('layouts.navigation')

        <div class="page-entry">
            {{ $slot }}
        </div>

        <x-studio-footer />

        <!-- Performance & Interaction Scripts -->
        <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipfG6STP9qaO3uYpS7oU3wE3uI/Zwc29H5Zz0B9Xb5zUfj3D6Y1f5" crossorigin="anonymous"></script>
        
        <script>
            window.addEventListener('load', () => {
                const loader = document.getElementById('page-loader');
                if(loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.remove(), 700);
                }
            });
        </script>

        <style>
            .page-entry {
                animation: pageEnter 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            @keyframes pageEnter {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        @stack('scripts')
    </body>
</html>
