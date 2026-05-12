<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RJ Studio | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-sky-500/30">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">
        @auth
            <x-sidebar />
        @endauth

        <div class="flex-1 flex flex-col transition-all duration-500"
             :class="sidebarOpen && {{ Auth::check() ? 'true' : 'false' }} ? 'pl-72' : ({{ Auth::check() ? 'true' : 'false' }} ? 'pl-24' : '')">
            
            <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-slate-100 flex items-center px-8 sticky top-0 z-50">
                 <h2 class="text-sm font-black uppercase tracking-[0.3em] text-slate-900">Admin Control Center</h2>
            </header>

            <main class="p-8 flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>