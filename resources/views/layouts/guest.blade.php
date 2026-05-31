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
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side: Cinematic Branding Section -->
            <div class="hidden lg:flex lg:w-[45%] xl:w-[40%] relative overflow-hidden bg-slate-900">
                <img src="{{ asset('/images/about-pic.webp') }}" 
                     alt="Architect" 
                     class="absolute inset-0 w-full h-full object-cover opacity-70 grayscale-[20%] transition-transform duration-[20s] ease-linear"
                     style="animation: slowZoom 40s infinite alternate;">
                
                <!-- Overlays for Depth -->
                <div class="absolute inset-0 bg-gradient-to-tr from-slate-900 via-slate-900/60 to-transparent"></div>
                <div class="absolute inset-0 bg-sky-900/10 mix-blend-overlay"></div>
                
                <!-- Branding Content -->
                <div class="relative z-10 w-full h-full p-16 flex flex-col justify-between">
                    <!-- Studio Logo -->
                    <a href="/" class="flex items-center gap-4 group">
                        <img src="{{ asset('/images/Rj-logo.webp') }}" alt="Logo" class="h-12 w-auto brightness-0 invert">
                        <div class="text-white">
                            <span class="text-xs font-black uppercase tracking-[0.3em] block">RJ-STUDIO</span>
                            <span class="text-[8px] font-bold uppercase tracking-[0.4em] text-sky-400 block mt-1">Architecture + Design</span>
                        </div>
                    </a>

                    <!-- Hero Messaging -->
                    <div class="space-y-6">

                        <h1 class="text-5xl xl:text-6xl font-serif text-white leading-tight">
                            Elevating spaces through <span class="italic text-sky-300 underline decoration-sky-500/30 underline-offset-8">visionary</span> design.
                        </h1>
                        <p class="text-slate-300 text-lg font-light leading-relaxed max-w-md">
                            Welcome to your personal studio portal. Track your projects, manage consultations, and witness your vision come to life.
                        </p>
                    </div>


                </div>
            </div>

            <!-- Right Side: Authentication Section -->
            <div class="flex-1 flex flex-col items-center justify-center p-8 lg:p-16 bg-slate-50/50">
                <div class="w-full max-w-lg">
                    <!-- Mobile Logo (Visible only on small screens) -->
                    <div class="lg:hidden flex justify-center mb-10">
                        <a href="/" class="hover:opacity-80 transition-opacity">
                            <x-application-logo class="h-16 w-auto" />
                        </a>
                    </div>

                    <!-- Auth Card -->
                    <div class="w-full bg-white shadow-premium rounded-card border border-slate-100 p-12 lg:p-14 relative overflow-hidden">
                        <!-- Subtle background detail -->
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-sky-50 rounded-full blur-3xl opacity-50"></div>
                        
                        <div class="relative z-10">
                            {{ $slot }}
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>

        <style>
            @keyframes slowZoom {
                from { transform: scale(1.1); }
                to { transform: scale(1.25); }
            }
        </style>
    </body>
</html>
