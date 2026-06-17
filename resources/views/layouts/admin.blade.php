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
    <style>
        :root {
            --card-radius: 1.25rem;
            --inner-radius: 0.75rem;
            --button-radius: 0.75rem;
        }
        .rounded-card { border-radius: var(--card-radius) !important; }
        .rounded-inner { border-radius: var(--inner-radius) !important; }
        .rounded-btn { border-radius: var(--button-radius) !important; }
        [x-cloak] { display: none !important; }

        /* Luxury Scrollbar Logic */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .luxury-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .luxury-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .luxury-scroll::-webkit-scrollbar-thumb {
            background-color: #E2E8F0;
            border-radius: 20px;
            border: 2px solid transparent;
            background-clip: content-box;
        }
        .luxury-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #CBD5E1;
        }
        @media print {
            .no-print { display: none !important; }
            .lg\:pl-72, .lg\:pl-24 { padding-left: 0 !important; }
            body, html { background: white !important; }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-sky-500/30">
    <div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth > 1024 }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))" class="flex min-h-screen">
        @auth
            <x-sidebar />
        @endauth

        <div class="flex-1 flex flex-col transition-[padding] duration-300"
             id="main-content"
             :class="{ 'lg:pl-72': sidebarOpen && {{ Auth::check() ? 'true' : 'false' }}, 'lg:pl-24': !sidebarOpen && {{ Auth::check() ? 'true' : 'false' }} }">
            @auth
            <script>
                // Pre-apply sidebar padding before Alpine.js initialises to prevent flash
                (function() {
                    var open = localStorage.getItem('sidebarOpen');
                    var isOpen = open !== null ? open === 'true' : window.innerWidth > 1024;
                    var el = document.getElementById('main-content');
                    if (el) el.classList.add(isOpen ? 'lg:pl-72' : 'lg:pl-24');
                })();
            </script>
            @endauth
            
            <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-slate-100 flex items-center justify-between lg:justify-end px-8 sticky top-0 z-50 no-print">
                 <!-- Mobile Sidebar Toggle -->
                 <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2.5 rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-100 transition-all focus:outline-none">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                     </svg>
                 </button>
                 
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
    @auth
    <!-- Global Confirmation Modal -->
    <x-confirmation-modal />
    @endauth
    @stack('scripts')
</body>
</html>