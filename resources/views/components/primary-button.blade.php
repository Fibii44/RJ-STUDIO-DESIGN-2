<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-8 py-4 bg-sky-600 border border-transparent rounded-2xl font-bold text-xs text-white tracking-widest hover:bg-sky-700 focus:bg-sky-700 active:bg-sky-800 focus:outline-none transition-all shadow-xl']) }}>
    {{ $slot }}
</button>
