<!-- Project Modal Component -->
<template x-teleport="body">
    <div x-show="modalOpen" x-cloak 
     @keydown.window.escape="modalOpen = false"
     class="fixed inset-0 z-[200] flex items-center justify-center p-0 md:p-12"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">
    
    <!-- Ultra-dark Backdrop -->
    <div class="absolute inset-0 bg-slate-950/98 backdrop-blur-3xl" @click="modalOpen = false"></div>
    
    <!-- Modal Container -->
    <div class="relative w-full max-w-[98vw] h-full max-h-[92vh] bg-white rounded-[4rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/10" @click.stop>
        
        <!-- Top Overlay: Title & Close -->
        <div class="absolute top-0 left-0 right-0 z-[220] p-8 flex items-center justify-between pointer-events-none">
            <div class="px-8 py-4 bg-black/40 backdrop-blur-xl rounded-full border border-white/10 pointer-events-auto shadow-2xl">
                <h2 class="text-xs font-black tracking-[0.4em] text-white" x-text="currentProject.title"></h2>
            </div>
            <button @click="modalOpen = false" class="w-12 h-12 bg-slate-900 text-white rounded-full flex items-center justify-center hover:bg-red-500 hover:rotate-90 transition-all duration-700 shadow-2xl pointer-events-auto group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Left Side: Main Image Viewer -->
        <div class="relative flex-1 bg-black flex items-center justify-center overflow-hidden group/viewer">
            <template x-if="currentProject.images && currentProject.images.length > 0">
                <img :src="currentProject.images[currentIndex]?.path" 
                     class="max-w-full max-h-full object-contain transition-all duration-700 shadow-2xl"
                     :key="currentIndex"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-110"
                     x-transition:enter-end="opacity-100 scale-100">
            </template>
            
            <!-- Navigation Arrows -->
            <template x-if="currentProject.images && currentProject.images.length > 1">
                <div class="absolute inset-x-12 flex items-center justify-between pointer-events-none">
                    <button @click="prev()" class="pointer-events-auto w-20 h-20 bg-white/5 hover:bg-sky-600 backdrop-blur-md text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/viewer:opacity-100 shadow-2xl hover:scale-110">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5"/></svg>
                    </button>
                    <button @click="next()" class="pointer-events-auto w-20 h-20 bg-white/5 hover:bg-sky-600 backdrop-blur-md text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/viewer:opacity-100 shadow-2xl hover:scale-110">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5"/></svg>
                    </button>
                </div>
            </template>

            <!-- Image Counter -->
            <div class="absolute bottom-12 left-1/2 -translate-x-1/2 px-8 py-4 bg-black/60 backdrop-blur-2xl rounded-full border border-white/10 shadow-2xl">
                <p class="text-[10px] font-black text-white/90 tracking-[0.4em] uppercase">
                    Perspective <span class="text-sky-400" x-text="currentIndex + 1"></span> / <span x-text="currentProject.images?.length"></span>
                </p>
            </div>
        </div>

        <!-- Right Side: Sidebar Info -->
        <div class="w-full lg:w-[480px] bg-white flex flex-col h-full border-l border-slate-100">
            <!-- Header -->
            <div class="p-12 border-b border-slate-50 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-600 shadow-[0_0_15px_rgba(2,132,199,0.5)]"></span>
                    <span class="text-sky-600 font-black uppercase tracking-[0.5em] text-[10px]" x-text="currentProject.category"></span>
                </div>
                <h3 class="text-5xl font-serif text-slate-900 leading-tight" x-text="currentProject.title"></h3>
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest" x-text="'Architectural Release • ' + currentProject.year"></p>
            </div>

            <!-- Thumbnail Grid -->
            <div class="flex-1 overflow-y-auto p-12 scrollbar-hide bg-slate-50/30">
                <div class="grid grid-cols-2 gap-4">
                    <template x-for="(img, index) in currentProject.images" :key="img.id">
                        <button @click="currentIndex = index" 
                                class="relative aspect-[4/3] rounded-[2rem] overflow-hidden transition-all duration-500 border-2"
                                :class="currentIndex === index ? 'border-sky-500 shadow-xl scale-[1.02]' : 'border-transparent opacity-40 hover:opacity-100 hover:scale-[1.02]'">
                            <img :src="img.path" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
