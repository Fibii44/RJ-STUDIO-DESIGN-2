@props(['disabled' => false, 'placeholder' => ''])

<textarea {{ $disabled ? 'disabled' : '' }} 
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'w-full rounded-inner border-slate-100 bg-slate-50 text-xs px-6 py-4 font-medium text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all placeholder:text-slate-300 placeholder:font-medium resize-none']) }}>{{ $slot }}</textarea>
