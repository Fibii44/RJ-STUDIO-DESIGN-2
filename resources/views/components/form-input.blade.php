@props(['disabled' => false, 'type' => 'text', 'placeholder' => ''])

<input {{ $disabled ? 'disabled' : '' }} 
    type="{{ $type }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all placeholder:text-slate-300 placeholder:font-medium']) }}>
