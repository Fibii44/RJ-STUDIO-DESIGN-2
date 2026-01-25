<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? route('home') : url('/') }}">
                        <x-application-logo class="block h-10 w-auto" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::check() ? route('home') : url('/')" 
                                :active="Auth::check() ? request()->routeIs('home') : request()->is('/')" 
                                class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link :href="route('about-studio')" :active="request()->routeIs('about-studio')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('About Studio') }}
                    </x-nav-link>

                    <x-nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Portfolio') }}
                    </x-nav-link>

                    <x-nav-link :href="route('services')" :active="request()->routeIs('services')" class="text-[11px] font-bold uppercase tracking-[0.2em]">
                        {{ __('Services') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-slate-200 dark:border-slate-800 text-sm font-bold rounded-xl text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 hover:border-sky-300 transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                        <x-dropdown-link :href="route('client.appointments')">
                            {{ __('My Appointments') }}
                        </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <div class="border-t border-slate-100 dark:border-slate-800"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-sky-600 transition">Log In</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-sky-600 text-white rounded-lg text-[10px] font-bold uppercase transition">Register</a>
                    </div>
                @endauth 
            </div>
        </div>
    </div>
</nav>