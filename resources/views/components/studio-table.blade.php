@props(['title' => '', 'subtitle' => '', 'headers' => [], 'id' => 'table-' . strtolower(Str::random(8))])

<div x-data="{ 
    perPage: 10, 
    currentPage: 1,
    totalRows: 0,
    rows: [],
    searchQuery: '',
    
    init() {
        this.refresh();
        // Watch for changes in the table body (e.g., filtering)
        const observer = new MutationObserver(() => this.refresh());
        observer.observe(this.$refs.tbody, { childList: true });
    },
    
    refresh() {
        const allRows = Array.from(this.$refs.tbody.querySelectorAll('tr:not(.no-data)'));
        this.rows = allRows.filter(row => {
            if (!this.searchQuery) return true;
            return row.textContent.toLowerCase().includes(this.searchQuery.toLowerCase());
        });

        // Hide rows that don't match search query
        allRows.forEach(row => {
            if (!this.rows.includes(row)) {
                row.style.display = 'none';
            }
        });

        this.totalRows = this.rows.length;
        if (this.currentPage > this.totalPages && this.totalPages > 0) {
            this.currentPage = this.totalPages;
        }
        this.applyPagination();
    },
    
    get totalPages() {
        return Math.ceil(this.totalRows / this.perPage);
    },
    
    applyPagination() {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + parseInt(this.perPage);
        
        this.rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    },
    
    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
            this.applyPagination();
        }
    },
    
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.applyPagination();
        }
    }
}" 
x-init="init()"
{{ $attributes->merge(['class' => 'bg-white rounded-card border border-slate-100 shadow-sm overflow-hidden flex flex-col']) }}>
    
    @if($title || $subtitle || isset($filter))
        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex flex-wrap gap-4 justify-between items-center">
            <div class="space-y-1">
                @if($title)
                    <h5 class="text-sm font-bold text-slate-900">{{ $title }}</h5>
                @endif
                @if($subtitle)
                    <span class="text-[10px] font-bold text-slate-400">{{ $subtitle }}</span>
                @endif
            </div>

            @if(isset($filter))
                <div class="w-full md:w-80" @input="searchQuery = $event.target.value; currentPage = 1; refresh()">
                    {{ $filter }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="overflow-x-auto flex-1">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/10">
                    @foreach($headers as $header)
                        <th class="px-8 py-5 text-[11px] font-bold text-slate-500 tracking-wide {{ $header['class'] ?? '' }}">
                            {{ $header['label'] ?? $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody x-ref="tbody" class="divide-y divide-slate-50">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="px-8 py-4 bg-slate-50/30 border-t border-slate-50 flex items-center justify-between no-print">
        <div class="flex items-center gap-8">
            <div class="text-[11px] font-bold text-slate-400">
                <template x-if="totalRows > 0">
                    <p>
                        Viewing 
                        <span class="text-slate-900" x-text="(currentPage - 1) * perPage + 1"></span>
                        <span x-show="totalRows > 1">
                            — <span class="text-slate-900" x-text="Math.min(totalRows, currentPage * perPage)"></span>
                        </span>
                        of <span class="text-slate-900" x-text="totalRows"></span>
                    </p>
                </template>
                <template x-if="totalRows === 0">
                    <span>No entries documented</span>
                </template>
            </div>

            <!-- Row Selector (Custom Alpine Dropdown) -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                        class="flex items-center bg-white border border-slate-200 rounded-xl px-4 py-2 shadow-sm hover:border-sky-500 transition-all group">
                    <span class="text-[11px] font-bold text-slate-400 mr-2 group-hover:text-sky-500">Limit</span>
                    <span class="text-[11px] font-bold text-slate-900" x-text="perPage"></span>
                    <svg class="w-2.5 h-2.5 ml-2 text-slate-300 group-hover:text-sky-500 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute bottom-full mb-2 left-0 w-24 bg-white rounded-xl shadow-2xl border border-slate-100 overflow-hidden z-[100]">
                    <template x-for="option in [10, 25, 50]">
                        <button @click="perPage = option; currentPage = 1; refresh(); open = false" 
                                class="w-full px-4 py-2.5 text-left text-[11px] font-bold transition-all border-b border-slate-50 last:border-0"
                                :class="perPage == option ? 'bg-sky-50 text-sky-600' : 'text-slate-600 hover:bg-slate-50 hover:text-sky-600'"
                                x-text="option">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2" x-show="totalPages > 1">
            <button @click="prevPage()" 
                    :disabled="currentPage === 1"
                    class="p-2 rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-sky-600 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
            </button>
            
            <div class="flex items-center gap-1">
                <span class="text-[11px] font-bold text-slate-900" x-text="currentPage"></span>
                <span class="text-[11px] font-bold text-slate-300">/</span>
                <span class="text-[11px] font-bold text-slate-400" x-text="totalPages"></span>
            </div>

            <button @click="nextPage()" 
                    :disabled="currentPage === totalPages"
                    class="p-2 rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-sky-600 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

