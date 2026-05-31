<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-8 py-4 bg-rose-50 border border-rose-100 rounded-2xl font-bold text-xs text-rose-500 tracking-widest hover:bg-rose-500 hover:text-white focus:outline-none transition-all']) }}>
    {{ $slot }}
</button>
