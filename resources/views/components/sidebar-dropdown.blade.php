@props(['title', 'icon', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="space-y-1">
    <button @click="open = !open" 
            :class="open ? 'bg-slate-50 text-slate-900 border-slate-100' : 'text-slate-500 hover:bg-slate-50 border-transparent'"
            class="w-full group flex items-center justify-between px-4 py-3.5 rounded-2xl border transition-all">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                @switch($icon)
                    @case('admin')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        @break
                    @case('procurement')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @break
                @endswitch
            </div>
            <span x-show="sidebarOpen" class="text-[10px] font-black tracking-widest whitespace-nowrap">
                {{ $title }}
            </span>
        </div>
        <div x-show="sidebarOpen">
            <svg :class="open ? 'rotate-180' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </button>

    <div x-show="open && sidebarOpen" x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" class="pl-12 space-y-1">
        {{ $slot }}
    </div>
</div>
