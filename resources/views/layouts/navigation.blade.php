<nav x-data="{ open: false, atTop: true }" 
     @scroll.window="atTop = (window.pageYOffset > 10 ? false : true)"
     :class="atTop ? 'bg-transparent border-transparent' : 'bg-white/80 backdrop-blur-xl border-slate-100 shadow-lg'"
     class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500 border-b">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route('home') : url('/') }}" class="group">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('/images/Rj-logo.webp') }}" alt="RJ Studio Logo" class="h-12 w-auto group-hover:scale-105 transition-all duration-500">
                            <div class="hidden md:block">
                                <span class="text-xs font-black uppercase tracking-[0.3em] text-slate-900 block leading-none">RJ-STUDIO</span>
                                <span class="text-[8px] font-bold uppercase tracking-[0.4em] text-sky-600 block mt-1">Architecture</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-12 sm:-my-px sm:ms-16 sm:flex">
                    <a href="{{ Auth::check() ? route('home') : url('/') }}" 
                       class="text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 {{ (Auth::check() ? request()->routeIs('home') : request()->is('/')) ? 'text-sky-600' : 'text-slate-500 hover:text-slate-900' }}">
                        Home
                    </a>

                    <a href="{{ route('about-studio') }}" 
                       class="text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 {{ request()->routeIs('about-studio') ? 'text-sky-600' : 'text-slate-500 hover:text-slate-900' }}">
                        About Studio
                    </a>

                    <a href="{{ route('portfolio') }}" 
                       class="text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 {{ request()->routeIs('portfolio') ? 'text-sky-600' : 'text-slate-500 hover:text-slate-900' }}">
                        Portfolio
                    </a>

                    <a href="{{ route('services') }}" 
                       class="text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 {{ request()->routeIs('services') ? 'text-sky-600' : 'text-slate-500 hover:text-slate-900' }}">
                        Services
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div x-data="{ dropOpen: false }" class="relative">
                        <button @click="dropOpen = !dropOpen" @click.away="dropOpen = false"
                                class="inline-flex items-center px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-white hover:border-sky-500 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-sky-600 flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="ms-3 h-3 w-3 opacity-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="dropOpen" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-4"
                             class="absolute right-0 mt-4 w-64 rounded-[2rem] bg-white shadow-premium border border-slate-100 py-6 px-3 z-[110]">
                            
                            <div class="px-6 pb-4 mb-4 border-b border-slate-50">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Account</p>
                                <p class="text-sm font-serif text-slate-900 mt-1 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.portfolio.index') }}" class="group flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-sky-600 hover:bg-sky-50 rounded-2xl transition-all">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                    Admin Dashboard
                                </a>
                            @endif

                            <a href="{{ route('client.appointments') }}" class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-2xl transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                My Appointments
                            </a>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-2xl transition-all">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                Settings
                            </a>

                            <div class="my-4 border-t border-slate-50 mx-6"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-6 py-3 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50 rounded-2xl transition-all">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-sky-600 transition">Log In</a>
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 text-white dark:bg-white dark:text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sky-600 dark:hover:bg-sky-50 transition-all shadow-xl shadow-slate-900/10">Register</a>
                    </div>
                @endauth 
            </div>
        </div>
    </div>
</nav>