<x-guest-layout>
    <div class="mb-6 text-center">
       
        <h2 class="mt-4 text-2xl font-serif font-bold text-slate-900 leading-tight">
            Client Registration
        </h2>
        <p class="text-sm text-slate-500 mt-2">Join RJ Design Studio to manage your architectural projects.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2" />
                <x-text-input id="first_name" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm" type="text" name="first_name" :value="old('first_name')" required autofocus placeholder="John" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2" />
                <x-text-input id="last_name" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm" type="text" name="last_name" :value="old('last_name')" required placeholder="Doe" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <x-text-input id="email" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <div class="relative">
                <x-text-input id="password" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 pl-4 pr-12 shadow-sm"
                                type="password"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="••••••••" />
                <button type="button" 
                        @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 0 0 1 .696 10.75 10.75 0 0 1-19.876 0z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                        <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                        <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                        <line x1="2" x2="22" y1="2" y2="22"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div x-data="{ showConfirmPassword: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 pl-4 pr-12 shadow-sm"
                                type="password"
                                x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password" 
                                placeholder="••••••••" />
                <button type="button" 
                        @click="showConfirmPassword = !showConfirmPassword" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 0 0 1 .696 10.75 10.75 0 0 1-19.876 0z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg x-show="showConfirmPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                        <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                        <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                        <line x1="2" x2="22" y1="2" y2="22"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button 
                class="w-full justify-center py-4 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 rounded-xl shadow-xl shadow-sky-100 transition-all border-none text-sm font-bold uppercase tracking-widest disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                x-bind:disabled="loading">
                <svg x-show="loading" x-cloak class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-show="!loading">{{ __('Create Account') }}</span>
                <span x-show="loading" x-cloak>{{ __('Creating Account...') }}</span>
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <a class="text-sm text-slate-500 hover:text-sky-600 font-medium transition" href="{{ route('login') }}">
                {{ __('Already have an account? Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>