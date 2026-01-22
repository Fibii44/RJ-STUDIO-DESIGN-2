<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-sky-600 rounded-xl mb-4 shadow-lg shadow-sky-200">
            <span class="text-white font-bold text-xl">RJ</span>
        </div>
        <h2 class="text-2xl font-serif font-bold text-slate-800">Welcome Back</h2>
        <p class="text-sm text-slate-500">Access your architectural portal</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-sky-600 hover:text-sky-700 font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 rounded-xl shadow-lg shadow-sky-100 transition-all border-none">
                {{ __('Log in to Studio') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-sky-600 font-bold hover:underline">Register here</a>
            </p>
        </div>
    </form>
</x-guest-layout>