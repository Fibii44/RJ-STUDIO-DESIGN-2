<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RJ Studio | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col transition-all duration-300">
            <div class="p-6 flex items-center gap-3 border-b border-slate-800">
                <div class="w-8 h-8 bg-sky-600 rounded-lg flex items-center justify-center text-white font-bold">RJ</div>
                <span class="text-white font-bold tracking-widest text-sm uppercase">Admin Panel</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" ...>
                    {{ __('Dashboard') }}
                </x-nav-link>
                
                <a href="{{ route('admin.portfolio.index') }}" 
                class="flex items-center px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-sky-400 transition {{ request()->routeIs('admin.portfolio.*') ? 'bg-slate-800 text-sky-400' : '' }}">
                    Manage Portfolio
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-sky-400 transition">
                    Client Inquiries
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-widest">Architect</div>
                <div class="px-4 py-2 text-sm text-white font-bold">{{ Auth::user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-400 hover:text-red-300 mt-2">
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center px-8">
                 <h2 class="text-lg font-bold text-slate-800">Control Center</h2>
            </header>

            <main class="p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>