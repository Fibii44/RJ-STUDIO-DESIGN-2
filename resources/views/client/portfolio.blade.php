<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                    Studio <span class="text-sky-600 italic">Portfolio</span>
                </h2>
                <p class="text-sm font-medium text-slate-500">Explore our curated selection of architectural masterpieces.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen" 
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
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Category Filter -->
            <div class="flex gap-10 border-b border-slate-100 mb-12 pb-4 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <button @click="activeCategory = 'All'" 
                        :class="activeCategory === 'All' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 outline-none">
                    All Projects
                </button>
                <button @click="activeCategory = 'Design'" 
                        :class="activeCategory === 'Design' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 outline-none">
                    Architectural Design
                </button>
                <button @click="activeCategory = 'Construction'" 
                        :class="activeCategory === 'Construction' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                        class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 outline-none">
                    Construction
                </button>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="group cursor-pointer" 
                         @click="openModal({{ $project->toJson() }})"
                         x-show="activeCategory === 'All' || activeCategory.toLowerCase() === '{{ strtolower($project->category) }}'"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-50 relative shadow-sm group-hover:shadow-premium transition-all duration-700 border border-slate-100">
                            <img src="{{ asset($project->image_path) }}" class="object-cover w-full h-full transition-all duration-1000 group-hover:scale-105">
                            
                            <!-- Floating Info Badge -->
                            <div class="absolute top-6 left-6 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-[-10px] group-hover:translate-x-0 z-20">
                                <div class="px-6 py-3 bg-slate-900 text-white rounded-2xl shadow-2xl flex flex-col gap-0.5 border border-white/10">
                                    <h3 class="text-xs font-black uppercase tracking-[0.2em]">{{ $project->title }}</h3>
                                    <p class="text-[8px] text-sky-400 font-bold uppercase tracking-[0.15em]">{{ $project->category }} • {{ $project->year }}</p>
                                </div>
                            </div>

                            @if($project->images->count() > 1)
                                <div class="absolute bottom-8 right-8 px-5 py-2.5 bg-white/40 backdrop-blur-md rounded-full text-[9px] font-black text-slate-900 uppercase tracking-widest border border-white/20 z-10 shadow-xl">
                                    {{ $project->images->count() }} Perspectives
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 px-4">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ $project->title }}</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $project->location ?? 'Confidential Location' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div x-show="activeCategory !== 'All' && !categoriesWithData.includes(activeCategory)" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 class="py-32 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-sky-50 rounded-[2.5rem] flex items-center justify-center text-sky-600 mb-8 border border-sky-100/50">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-3xl text-slate-900 mb-4">Gallery in <span class="text-sky-600 italic">Progress.</span></h3>
                <p class="text-slate-400 max-w-sm text-sm leading-relaxed font-medium">We are currently documenting our latest projects. Check back soon.</p>
            </div>
        </div>

        <!-- Project Modal Component -->
        <x-project-modal />
    </div>
</x-app-layout>
