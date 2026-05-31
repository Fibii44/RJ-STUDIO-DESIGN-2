<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-8 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs text-slate-900 tracking-widest hover:bg-slate-100 focus:outline-none transition-all shadow-sm']) }}>
    {{ $slot }}
</button>
