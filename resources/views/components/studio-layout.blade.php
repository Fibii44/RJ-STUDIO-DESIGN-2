@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'ogImage' => null
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Metadata -->
        <title>{{ $title ?? 'RJ DESIGN STUDIO | Architectural Design & Build Firm' }}</title>
        <meta name="description" content="{{ $description ?? 'RJ Design Studio is an experienced architectural design and construction firm specializing in bespoke plans, 3D visualizations, and turnkey Design & Build services.' }}">
        <meta name="keywords" content="{{ $keywords ?? 'RJ Design Studio, RJ Design, architecture firm, design and build, architectural design, construction services, Randolf Jan Felices, residential design, commercial build, structural integrity' }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Facebook / LinkedIn -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $title ?? 'RJ DESIGN STUDIO | Architectural Design & Build Firm' }}">
        <meta property="og:description" content="{{ $description ?? 'RJ Design Studio is an experienced architectural design and construction firm specializing in bespoke plans, 3D visualizations, and turnkey Design & Build services.' }}">
        <meta property="og:image" content="{{ $ogImage ?? asset('/images/Rj-logo.webp') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $title ?? 'RJ DESIGN STUDIO | Architectural Design & Build Firm' }}">
        <meta property="twitter:description" content="{{ $description ?? 'RJ Design Studio is an experienced architectural design and construction firm specializing in bespoke plans, 3D visualizations, and turnkey Design & Build services.' }}">
        <meta property="twitter:image" content="{{ $ogImage ?? asset('/images/Rj-logo.webp') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />
        
        <!-- Favicon -->
        <link rel="icon" type="image/webp" href="{{ asset('/images/Rj-logo.webp') }}">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('styles')
    </head>
    <body class="antialiased bg-white text-slate-900 font-sans selection:bg-sky-500/30 overflow-x-hidden">
        <div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth > 1024 }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))" class="flex min-h-screen">
            @auth
                <x-sidebar />
            @endauth

            <div class="flex-1 flex flex-col"
                 :class="{ 'lg:pl-72': sidebarOpen && {{ Auth::check() ? 'true' : 'false' }}, 'lg:pl-24': !sidebarOpen && {{ Auth::check() ? 'true' : 'false' }} }">
                
                @auth
                <!-- Authenticated Top Navbar -->
                <div class="h-16 bg-white/80 backdrop-blur-xl border-b border-slate-50 flex items-center justify-between lg:justify-end px-8 sticky top-0 z-50">
                    <!-- Mobile Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2.5 rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-100 transition-all focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-4 hover:opacity-80 transition-opacity focus:outline-none">
                            <div class="flex flex-col text-right hidden sm:flex">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-medium text-slate-500">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-sky-600 flex items-center justify-center text-white shadow-md shadow-sky-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 transform -translate-y-2"
                             class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50"
                             style="display: none;">
                            <div class="p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    @include('layouts.navigation')
                @endauth

                <div class="flex-1">
                    {{ $slot }}
                </div>

                @guest
                    <x-studio-footer />
                @endguest
            </div>
        </div>

        <!-- Performance & Interaction Scripts -->
        <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipfG6STP9qaO3uYpS7oU3wE3uI/Zwc29H5Zz0B9Xb5zUfj3D6Y1f5" crossorigin="anonymous"></script>



        @stack('scripts')
    </body>
</html>
