<x-guest-layout>
    <div class="mb-10 text-center">
       
        <h2 class="mt-8 text-2xl font-serif font-bold text-slate-900 dark:text-white leading-tight">
            Client Registration
        </h2>
        <p class="text-sm text-slate-500 mt-2">Join RJ Design Studio to manage your architectural projects.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <x-text-input id="name" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <x-text-input id="email" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <x-text-input id="password" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1" />
            <x-text-input id="password_confirmation" class="block w-full bg-slate-50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl py-3 px-4 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-4 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 rounded-xl shadow-xl shadow-sky-100 transition-all border-none text-sm font-bold">
                {{ __('Create Studio Account') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <a class="text-sm text-slate-500 hover:text-sky-600 font-medium transition" href="{{ route('login') }}">
                {{ __('Already have an account? Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>