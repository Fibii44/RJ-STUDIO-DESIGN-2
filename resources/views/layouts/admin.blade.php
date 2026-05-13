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
            --card-radius: 1.5rem;
            --inner-radius: 1.25rem;
            --button-radius: 1rem;
        }
        .rounded-card { border-radius: var(--card-radius) !important; }
        .rounded-inner { border-radius: var(--inner-radius) !important; }
        .rounded-btn { border-radius: var(--button-radius) !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
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
    @auth
    <!-- Global Confirmation Modal -->
    <x-modal name="confirm-modal" maxWidth="sm">
        <div x-data="{ 
            title: 'Confirm Action', 
            message: 'Are you sure you want to proceed?', 
            confirmButton: 'Confirm',
            action: null,
            init() {
                window.addEventListener('open-confirm', (e) => {
                    this.title = e.detail.title || 'Confirm Action';
                    this.message = e.detail.message || 'Are you sure?';
                    this.confirmButton = e.detail.confirmButton || 'Confirm';
                    this.action = e.detail.action;
                    $dispatch('open-modal', 'confirm-modal');
                });
            },
            proceed() {
                if (this.action) this.action();
                $dispatch('close-modal', 'confirm-modal');
            }
        }" class="p-8 text-center">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            
            <h3 class="font-serif text-2xl text-slate-900 mb-2" x-text="title"></h3>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed" x-text="message"></p>
            
            <div class="flex flex-col gap-3">
                <button @click="proceed()" class="w-full py-4 bg-red-500 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-red-600 shadow-lg shadow-red-200 transition-all" x-text="confirmButton"></button>
                <button @click="$dispatch('close-modal', 'confirm-modal')" class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">Cancel</button>
            </div>
        </div>
    </x-modal>
    @endauth
    @stack('scripts')
</body>
</html>