<aside class="fixed left-0 top-0 bottom-0 z-[150] bg-white border-r border-slate-100 transition-all duration-500 shadow-premium"
       :class="sidebarOpen ? 'w-72' : 'w-24'">
    
    <!-- Header Section with Integrated Toggle -->
    <div class="h-24 flex items-center px-6 border-b border-slate-50 relative overflow-hidden">
        <!-- Logo (Hidden when toggled/collapsed) -->
        <a href="{{ route('home') }}" 
           x-show="sidebarOpen" 
           x-transition:enter="transition ease-out duration-300" 
           x-transition:enter-start="opacity-0 -translate-x-4" 
           x-transition:enter-end="opacity-100 translate-x-0"
           class="flex items-center gap-4 shrink-0">
            <img src="{{ asset('/images/Rj-logo.webp') }}" alt="Logo" class="h-10 w-auto shrink-0">
            <div class="whitespace-nowrap">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900 block leading-none">RJ-STUDIO</span>
                <span class="text-[7px] font-bold uppercase tracking-[0.3em] text-sky-600 block mt-1">Architecture</span>
            </div>
        </a>

        <!-- Integrated Line Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="absolute transition-all duration-500 hover:bg-slate-50 p-2.5 rounded-xl group/toggle"
                :class="sidebarOpen ? 'right-6' : 'left-1/2 -translate-x-1/2'">
             <div class="flex flex-col gap-1.5 w-4">
                <span class="h-px bg-slate-900 transition-all duration-300" :class="sidebarOpen ? 'w-full' : 'w-full'"></span>
                <span class="h-px bg-slate-900 transition-all duration-300" :class="sidebarOpen ? 'w-full' : 'w-2/3'"></span>
            </div>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-6 space-y-2">
        <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="dashboard">
            Dashboard
        </x-sidebar-link>
        
        <x-sidebar-link href="{{ Auth::user()->role === 'admin' ? route('admin.appointments.index') : route('client.appointments') }}" :active="request()->routeIs('admin.appointments.*') || request()->routeIs('client.appointments')" icon="calendar">
            Appointments
        </x-sidebar-link>

        @if(Auth::user()->role === 'admin')
            <x-sidebar-link href="{{ route('admin.portfolio.index') }}" :active="request()->routeIs('admin.portfolio.*')" icon="admin">
                Portfolio Management
            </x-sidebar-link>
        @endif
    </nav>

    <!-- User Profile & Logout -->
    <div class="absolute bottom-0 left-0 right-0 p-6 bg-slate-50/50 border-t border-slate-100 overflow-hidden">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-sky-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-sky-600/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div x-show="sidebarOpen" x-transition.opacity class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[9px] font-medium text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" x-transition.opacity>
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
