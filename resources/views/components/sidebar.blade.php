<!-- Mobile Backdrop Overlay -->
<div x-show="sidebarOpen" 
     x-transition:opacity
     @click="sidebarOpen = false" 
     class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[140] lg:hidden" 
     style="display: none;"></div>

<aside class="fixed top-0 bottom-0 z-[150] bg-white border-r border-slate-100 shadow-premium flex flex-col transition-all duration-300 no-print"
    :class="sidebarOpen ? 'w-72 left-0' : 'w-24 lg:left-0 -left-24'">

    <!-- Header Section with Integrated Toggle -->
    <div class="h-24 flex items-center px-6 border-b border-slate-50 relative overflow-hidden">
        <!-- Logo (Hidden when toggled/collapsed) -->
        <a href="{{ route('home') }}" x-show="sidebarOpen" class="flex items-center gap-4 shrink-0">
            <img src="{{ asset('/images/Rj-logo.webp') }}" alt="Logo" class="h-10 w-auto shrink-0">
            <div class="whitespace-nowrap">
                <span
                    class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900 block leading-none">RJ-STUDIO</span>
                <span
                    class="text-[6px] font-bold uppercase tracking-[0.15em] text-sky-600 block mt-1.5 text-center">Architecture
                    + Design</span>
            </div>
        </a>

        <!-- Integrated Line Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" class="absolute hover:bg-slate-50 p-2.5 rounded-xl group/toggle"
            :class="sidebarOpen ? 'right-6' : 'left-1/2 -translate-x-1/2'">
            <div class="flex flex-col gap-1.5 w-4">
                <span class="h-px bg-slate-900 transition-all duration-300"
                    :class="sidebarOpen ? 'w-full' : 'w-full'"></span>
                <span class="h-px bg-slate-900 transition-all duration-300"
                    :class="sidebarOpen ? 'w-full' : 'w-2/3'"></span>
            </div>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
        <nav class="p-6 space-y-8 overflow-hidden">
            <!-- Overview Group -->
            <div class="space-y-2">
                <p x-show="sidebarOpen" class="px-4 text-[9px] font-black text-slate-400 tracking-[0.2em] mb-4">Overview
                </p>
                <x-sidebar-link href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('home') }}"
                    :active="request()->routeIs('admin.dashboard') || request()->routeIs('home')" icon="dashboard">
                    Dashboard
                </x-sidebar-link>
            </div>

            @if(Auth::user()->role === 'admin')
                <!-- Management Group -->
                <div class="space-y-2">
                    <p x-show="sidebarOpen" class="px-4 text-[9px] font-black text-slate-400 tracking-[0.2em] mb-4">Studio
                        Registry</p>
                    <x-sidebar-link href="{{ route('admin.clients.index') }}"
                        :active="request()->routeIs('admin.clients.*')" icon="users">
                        Clients
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('admin.portfolio.index') }}"
                        :active="request()->routeIs('admin.portfolio.*')" icon="portfolio">
                        Portfolio Management
                    </x-sidebar-link>
                </div>
            @endif

            <!-- Scheduling Group -->
            <div class="space-y-2">
                <p x-show="sidebarOpen" class="px-4 text-[9px] font-black text-slate-400 tracking-[0.2em] mb-4">
                    Consultation</p>
                <x-sidebar-link
                    href="{{ Auth::user()->role === 'admin' ? route('admin.appointments.index') : route('client.appointments') }}"
                    :active="request()->routeIs('admin.appointments.*') && !request()->routeIs('admin.calendar.index') || request()->routeIs('client.appointments')" icon="appointments">
                    Appointments
                </x-sidebar-link>
                @if(Auth::user()->role === 'admin')
                    <x-sidebar-link href="{{ route('admin.calendar.index') }}"
                        :active="request()->routeIs('admin.calendar.index')" icon="calendar">
                        Schedule Calendar
                    </x-sidebar-link>
                @else
                    <x-sidebar-link href="{{ route('client.calendar.index') }}"
                        :active="request()->routeIs('client.calendar.index')" icon="calendar">
                        Schedule Calendar
                    </x-sidebar-link>
                @endif
                @if(Auth::user()->role !== 'admin')
                    <x-sidebar-link href="{{ route('client.portfolio') }}" :active="request()->routeIs('client.portfolio')"
                        icon="portfolio">
                        Studio Portfolio
                    </x-sidebar-link>
                @endif
                @if(Auth::user()->role === 'admin')
                    <x-sidebar-link href="{{ route('admin.schedule.index') }}"
                        :active="request()->routeIs('admin.schedule.*')" icon="admin">
                        Schedule Settings
                    </x-sidebar-link>
                @endif
            </div>

            @if(Auth::user()->role === 'admin')
                <!-- Financials Group -->
                <div class="space-y-2">
                    <p x-show="sidebarOpen" class="px-4 text-[9px] font-black text-slate-400 tracking-[0.2em] mb-4">
                        Financials</p>
                    <x-sidebar-link href="{{ route('admin.budgets.index') }}"
                        :active="request()->routeIs('admin.budgets.*')" icon="financials">
                        Construction Financials
                    </x-sidebar-link>
                    <x-sidebar-link href="{{ route('admin.materials.index') }}"
                        :active="request()->routeIs('admin.materials.*')" icon="procurement">
                        Material Registry
                    </x-sidebar-link>
                </div>
            @endif
        </nav>
    </div>

    @if(Auth::user()->role !== 'admin')
        <!-- Assistance Footer -->
        <div class="p-6 border-t border-slate-50 bg-white/50 backdrop-blur-sm overflow-hidden shrink-0">
            <div class="space-y-2">
                <p x-show="sidebarOpen" class="px-4 text-[9px] font-black text-slate-400 tracking-[0.2em] mb-4">Assistance
                </p>
                <x-sidebar-link href="{{ route('support') }}" :active="request()->routeIs('support')" icon="support">
                    Help & Support
                </x-sidebar-link>
            </div>
        </div>
    @endif

</aside>