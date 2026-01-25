<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portfolio | RJ DESIGN STUDIO</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans">
        
        @include('layouts.navigation')

        <main class="pt-32 pb-24" 
    x-data="{ 
        activeCategory: 'All',
        modalOpen: false,
        currentIndex: 0,
        currentProject: { images: [] },
        
        openModal(project, index = 0) {
            this.currentProject = project;
            this.currentIndex = index;
            this.modalOpen = true;
        },
        next() { this.currentIndex = (this.currentIndex + 1) % this.currentProject.images.length; },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.currentProject.images.length) % this.currentProject.images.length; }
    }"
    x-effect="document.body.classList.toggle('overflow-hidden', modalOpen)">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 pt-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-1">
                    <span class="text-sky-600 font-bold uppercase tracking-[0.3em] text-[10px]">Excellence in Design</span>
                    <h1 class="font-serif text-5xl lg:text-7xl text-slate-900 dark:text-white leading-tight">
                        Selected <span class="text-sky-600 italic">Works</span>
                    </h1>
                </div>
                <p class="text-slate-500 max-w-sm text-sm leading-relaxed border-l-2 border-sky-600 pl-6">
                    A curation of professional projects developed by Feby and the RJ Studio team.
                </p>
            </div>
            
            <div class="flex gap-8 border-b border-slate-100 dark:border-slate-800 mt-16 pb-4 overflow-x-auto whitespace-nowrap">
                <button @click="activeCategory = 'All'" 
                        :class="activeCategory === 'All' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900 dark:hover:text-white'" 
                        class="text-[10px] font-bold uppercase tracking-widest pb-4 -mb-4.5 transition-all outline-none">
                    All Projects
                </button>
                <button @click="activeCategory = 'Design'" 
                        :class="activeCategory === 'Design' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900 dark:hover:text-white'" 
                        class="text-[10px] font-bold uppercase tracking-widest pb-4 -mb-4.5 transition-all outline-none">
                    Architectural Design
                </button>
                <button @click="activeCategory = 'Construction'" 
                        :class="activeCategory === 'Construction' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900 dark:hover:text-white'" 
                        class="text-[10px] font-bold uppercase tracking-widest pb-4 -mb-4.5 transition-all outline-none">
                    Construction
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
                @forelse($projects as $project)
                    <div class="group cursor-pointer" 
                         x-show="activeCategory === 'All' || activeCategory === '{{ $project->category }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         @click="openModal({{ $project->toJson() }}, 0)">
                        
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-slate-900 relative shadow-sm group-hover:shadow-2xl transition-all duration-500">
                            <img src="{{ asset($project->image_path) }}" class="object-cover w-full h-full grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-105">
                            
                            @if($project->images->count() > 1)
                                <div class="absolute bottom-6 right-6 px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black text-white uppercase tracking-widest border border-white/10 z-10">
                                    {{ $project->images->count() }} Perspectives
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
                        </div>

                        <div class="mt-8 flex justify-between items-start px-2">
                            <div>
                                <h3 class="text-2xl font-serif text-slate-900 dark:text-white">{{ $project->title }}</h3>
                                <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-[0.2em]">{{ $project->category }} • {{ $project->year }}</p>
                            </div>
                            <span class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-32 text-center opacity-50 italic font-serif text-xl text-slate-400">Masterpieces in progress.</div>
                @endforelse
            </div>
        </div>

        <div x-show="modalOpen" 
             x-cloak 
             @keydown.window.escape="modalOpen = false"
             class="fixed inset-0 z-[100] flex items-center justify-center p-0 md:p-6 lg:p-12"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="absolute inset-0 bg-slate-950/98 backdrop-blur-2xl" @click="modalOpen = false"></div>
            
            <div class="relative w-full max-w-[95vw] h-full max-h-[90vh] bg-white dark:bg-slate-900 rounded-[2.5rem] md:rounded-[4rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/10" @click.stop>
                
                <div class="absolute top-0 left-0 right-0 z-[120] p-6 flex items-center justify-between pointer-events-none">
                    <div class="px-6 py-3 bg-black/20 backdrop-blur-md rounded-full border border-white/10 pointer-events-auto">
                        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-white" x-text="currentProject.title"></h2>
                    </div>
                    <button @click="modalOpen = false" class="w-12 h-12 bg-white/10 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-red-500 hover:rotate-90 transition-all duration-500 border border-white/20 pointer-events-auto shadow-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="relative flex-1 bg-black flex items-center justify-center overflow-hidden group/viewer">
                    <img :src="'/' + currentProject.images[currentIndex]?.path" 
                         class="max-w-full max-h-full object-contain transition-all duration-700 ease-out"
                         :key="currentIndex">
                    
                    <template x-if="currentProject.images.length > 1">
                        <div class="absolute inset-x-8 flex items-center justify-between pointer-events-none">
                            <button @click="prev()" class="pointer-events-auto w-14 h-14 bg-white/5 hover:bg-sky-600 backdrop-blur-sm text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/viewer:opacity-100 shadow-2xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg>
                            </button>
                            <button @click="next()" class="pointer-events-auto w-14 h-14 bg-white/5 hover:bg-sky-600 backdrop-blur-sm text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/viewer:opacity-100 shadow-2xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
                            </button>
                        </div>
                    </template>

                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
                        <div class="px-6 py-2 bg-black/40 backdrop-blur-xl rounded-full border border-white/10 text-[10px] font-black text-white uppercase tracking-[0.4em] shadow-2xl">
                            <span class="text-sky-400" x-text="currentIndex + 1"></span> <span class="mx-2 opacity-30">/</span> <span x-text="currentProject.images.length"></span>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-[420px] bg-white dark:bg-slate-900 border-l border-slate-100 dark:border-white/5 flex flex-col">
                    <div class="p-10 border-b border-slate-50 dark:border-white/5">
                        <span class="text-sky-600 font-black uppercase tracking-[0.4em] text-[9px]" x-text="currentProject.category"></span>
                        <h3 class="text-3xl font-serif text-slate-900 dark:text-white leading-tight mt-2" x-text="currentProject.title"></h3>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1" x-text="'Release • ' + currentProject.year"></p>
                    </div>

                    <div class="flex-1 overflow-y-auto p-10 custom-scrollbar bg-slate-50/50 dark:bg-slate-950/30">
                        <div class="grid grid-cols-2 gap-4">
                            <template x-for="(img, index) in currentProject.images" :key="img.id">
                                <button @click="currentIndex = index" 
                                        class="relative aspect-square rounded-3xl overflow-hidden transition-all duration-500"
                                        :class="currentIndex === index ? 'ring-4 ring-sky-500 ring-offset-4 dark:ring-offset-slate-900' : 'opacity-40 hover:opacity-100 hover:scale-[1.05]'">
                                    <img :src="'/' + img.path" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="p-10">
                        <button @click="modalOpen = false" class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black uppercase text-[10px] tracking-[0.3em] hover:bg-sky-600 transition-all shadow-xl">
                            Return to Portfolio
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <footer class="py-12 border-t border-slate-100 dark:border-slate-900 text-center">
            <p class="text-sm text-slate-400 italic">RJ Design Studio &bull; Architecture & Technology</p>
        </footer>
    </body>
</html>