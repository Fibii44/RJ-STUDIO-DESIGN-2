<x-studio-layout title="Portfolio | RJ DESIGN STUDIO">
    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    <main class="pt-40 pb-32" 
        x-data='{ 
            activeCategory: "All",
            modalOpen: false,
            currentIndex: 0,
            currentProject: { images: [] },
            categoriesWithData: @json($projects->pluck("category")->unique()->values()).map(c => c.toLowerCase()),
            
            openModal(project, index = 0) {
                this.currentProject = project;
                this.currentIndex = index;
                this.modalOpen = true;
            },
            next() { this.currentIndex = (this.currentIndex + 1) % this.currentProject.images.length; },
            prev() { this.currentIndex = (this.currentIndex - 1 + this.currentProject.images.length) % this.currentProject.images.length; }
        }'
        x-effect="document.body.classList.toggle('overflow-hidden', modalOpen)">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 pt-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-4">
                    <h1 class="font-serif text-5xl lg:text-8xl text-slate-900 leading-tight">
                        Selected <span class="text-sky-600 italic">Works</span>
                    </h1>
                </div>
                <p class="text-slate-500 max-w-sm text-lg leading-relaxed border-l-2 border-sky-600 pl-8">
                    A curation of professional projects developed by Randolf and the RJ Studio team.
                </p>
            </div>
            
            <div class="flex gap-10 border-b border-slate-100 mt-20 pb-4 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <button @click="activeCategory = 'All'" 
                        :class="activeCategory === 'All' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 transition-all outline-none">
                    All Projects
                </button>
                <button @click="activeCategory = 'Design'" 
                        :class="activeCategory === 'Design' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 transition-all outline-none">
                    Architectural Design
                </button>
                <button @click="activeCategory = 'Construction'" 
                        :class="activeCategory === 'Construction' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 transition-all outline-none">
                    Construction
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
                @foreach($projects as $project)
                    <div class="group cursor-pointer" 
                         x-show="activeCategory === 'All' || activeCategory.toLowerCase() === '{{ strtolower($project->category) }}'"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         @click="openModal({{ $project->toJson() }}, 0)">
                        
                        <div class="aspect-[16/10] rounded-[3.5rem] overflow-hidden bg-slate-50 relative shadow-sm group-hover:shadow-premium transition-all duration-700 border border-slate-100">
                            <img src="{{ asset($project->image_path) }}" class="object-cover w-full h-full grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-105">
                            
                            @if($project->images->count() > 1)
                                <div class="absolute bottom-8 right-8 px-5 py-2.5 bg-white/40 backdrop-blur-md rounded-full text-[9px] font-black text-slate-900 uppercase tracking-widest border border-white/20 z-10 shadow-xl">
                                    {{ $project->images->count() }} Perspectives
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-slate-900/5 group-hover:bg-transparent transition-colors"></div>
                        </div>

                        <div class="mt-10 flex justify-between items-start px-4">
                            <div class="space-y-3">
                                <h3 class="text-4xl font-serif text-slate-900 leading-tight group-hover:text-sky-600 transition-colors">{{ $project->title }}</h3>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">{{ $project->category }} <span class="mx-2 text-slate-200">|</span> {{ $project->year }}</p>
                            </div>
                            <span class="w-16 h-16 rounded-full border border-slate-100 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-all duration-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div x-show="activeCategory !== 'All' && !categoriesWithData.includes(activeCategory)" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 class="py-40 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-sky-50 rounded-[3rem] flex items-center justify-center text-sky-600 mb-10 rotate-3 border border-sky-100/50 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-5xl text-slate-900 mb-6">Masterpieces in <span class="text-sky-600 italic">Progress.</span></h3>
                <p class="text-slate-400 max-w-md text-xl leading-relaxed font-medium">We are currently documenting our latest <span x-text="activeCategory"></span> projects. Check back soon for the blueprints.</p>
                
                <button @click="activeCategory = 'All'" class="mt-12 text-[10px] font-black uppercase tracking-[0.4em] text-slate-900 hover:text-sky-600 transition-all border-b-2 border-slate-900 hover:border-sky-600 pb-2">
                    View All Works
                </button>
            </div>

            {{-- Special Case: No Projects at all --}}
            @if($projects->isEmpty())
                <div class="py-40 flex flex-col items-center text-center">
                    <h3 class="font-serif text-5xl text-slate-900 mb-6 italic opacity-20 text-slate-400">Architectural Gallery Empty.</h3>
                </div>
            @endif
        </div>

        <!-- Project Modal Component -->
        <x-project-modal />
    </main>
</x-studio-layout>