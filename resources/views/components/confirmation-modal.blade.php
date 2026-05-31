<div x-data="{ 
    show: false,
    title: 'Delete Project?', 
    message: 'Are you sure you want to permanently remove this record? This action cannot be undone.', 
    confirmButton: 'Confirm',
    cancelButton: 'Keep it',
    type: 'danger',
    action: null,
    
    init() {
        window.addEventListener('open-confirm', (e) => {
            this.title = e.detail.title || 'Delete Project?';
            this.message = e.detail.message || 'Are you sure you want to proceed?';
            this.confirmButton = e.detail.confirmButton || 'Confirm';
            this.cancelButton = e.detail.cancelButton || 'Keep it';
            this.type = e.detail.type || 'danger';
            this.action = e.detail.action;
            this.show = true;
        });
    },
    
    proceed() {
        if (typeof this.action === 'string') {
            document.getElementById(this.action).submit();
        } else if (typeof this.action === 'function') {
            this.action();
        }
        this.show = false;
    }
}" 
x-show="show" 
x-cloak
class="fixed inset-0 z-[1000] flex items-center justify-center p-6 no-print">
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-500" @click="show = false"></div>

    <!-- Dialog Box -->
    <div class="relative bg-white w-full max-w-md rounded-[3rem] overflow-hidden shadow-2xl p-12 text-center border border-white/20"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-8"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-8">
        
        <!-- Large Warning Icon -->
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm transition-colors"
             :class="type === 'danger' ? 'bg-red-50 text-red-500' : 'bg-sky-50 text-sky-500'">
            <template x-if="type === 'danger'">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </template>
            <template x-if="type !== 'danger'">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </template>
        </div>
        
        <h3 class="text-3xl font-serif text-slate-900 mb-4" x-text="title"></h3>
        <p class="text-[11px] font-bold text-slate-400 mb-10 leading-relaxed px-6" x-html="message"></p>
        
        <div class="flex gap-4">
            <button @click="show = false" 
                    class="flex-1 py-4 bg-slate-50 text-slate-400 rounded-xl font-bold text-xs hover:bg-slate-100 transition-all"
                    x-text="cancelButton">
            </button>
            <button @click="proceed()" 
                    class="flex-1 py-4 rounded-xl font-bold text-xs shadow-xl transition-all"
                    :class="type === 'danger' ? 'bg-red-600 text-white hover:bg-red-700 shadow-red-100' : 'bg-sky-600 text-white hover:bg-sky-700 shadow-sky-100'"
                    x-text="confirmButton">
            </button>
        </div>
    </div>
</div>
