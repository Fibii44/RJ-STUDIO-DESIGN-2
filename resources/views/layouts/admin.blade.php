<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RJ Studio | Admin</title>
    <link rel="icon" type="image/webp" href="{{ asset('/images/Rj-logo.webp') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-sky-500/30">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">
        @auth
            <x-sidebar />
        @endauth

        <div class="flex-1 flex flex-col"
             :class="sidebarOpen && {{ Auth::check() ? 'true' : 'false' }} ? 'pl-72' : ({{ Auth::check() ? 'true' : 'false' }} ? 'pl-24' : '')">
            
            <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-slate-100 flex items-center justify-end px-8 sticky top-0 z-50">
                 
                 <div class="flex items-center gap-6">
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black uppercase text-sky-600 leading-none tracking-[0.2em] mb-1">{{ Auth::user()->role }}</span>
                        <span class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">{{ Auth::user()->name }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                 </div>
            </header>

            <main class="p-8 flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>