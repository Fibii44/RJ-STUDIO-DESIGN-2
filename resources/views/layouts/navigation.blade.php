@guest
<nav x-data="{ open: false, atTop: true }" 
     @scroll.window="atTop = (window.pageYOffset > 10 ? false : true)"
     :class="atTop ? 'bg-transparent border-transparent' : 'bg-white/80 backdrop-blur-xl border-slate-100 shadow-lg'"
     class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500 border-b">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="group">
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
                    <a href="{{ url('/') }}" 
                       class="text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 {{ request()->is('/') ? 'text-sky-600' : 'text-slate-500 hover:text-slate-900' }}">
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
                <div class="flex items-center gap-6">
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-sky-600 transition">Log In</a>
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10">Register</a>
                </div>
            </div>
        </div>
    </div>
</nav>
@endguest