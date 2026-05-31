@props(['placeholder' => 'Search records...', 'id' => 'table-search'])

<div class="relative group">
    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
        <svg class="h-4 h-4 text-slate-400 group-focus-within:text-sky-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    <input type="text" 
           id="{{ $id }}"
           {{ $attributes->merge(['class' => 'block w-full pl-12 pr-12 py-4 bg-white border border-slate-100 rounded-2xl text-xs font-medium text-slate-900 placeholder:text-slate-400 placeholder:font-bold placeholder:text-xs transition-all shadow-sm']) }}
           placeholder="{{ $placeholder }}">
    
    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
        <div class="h-8 w-8 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
        </div>
    </div>
</div>
