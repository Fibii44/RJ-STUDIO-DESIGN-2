<x-studio-layout title="Portfolio | RJ DESIGN STUDIO">
    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    <main class="{{ Auth::check() ? 'pt-16 lg:pt-16' : 'pt-32 lg:pt-40' }} pb-32" 
        x-data='{ 
            activeCategory: "All",
            activeYear: "All",
            displayLimit: 6,
            modalOpen: false,
            currentIndex: 0,
            currentProject: { images: [] },
            allProjects: @json($projects),
            categoriesWithData: @json($projects->pluck("category")->unique()->values()).map(c => c.toLowerCase()),
            yearsWithData: @json($projects->pluck("year")->unique()->sortDesc()->values()),
            
            get filteredProjects() {
                return this.allProjects.filter(p => {
                    const catMatch = this.activeCategory === "All" || p.category.toLowerCase() === this.activeCategory.toLowerCase();
                    const yearMatch = this.activeYear === "All" || p.year == this.activeYear;
                    return catMatch && yearMatch;
                });
            },

            get visibleProjects() {
                return this.filteredProjects.slice(0, this.displayLimit);
            },
            
            openModal(project, index = 0) {
                this.currentProject = project;
                this.currentIndex = index;
                this.modalOpen = true;
            },
            next() { this.currentIndex = (this.currentIndex + 1) % this.currentProject.images.length; },
            prev() { this.currentIndex = (this.currentIndex - 1 + this.currentProject.images.length) % this.currentProject.images.length; }
        }'
        x-effect="document.body.classList.toggle('overflow-hidden', modalOpen)">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-4">
                    <h1 class="font-serif {{ Auth::check() ? 'text-4xl' : 'text-4xl lg:text-7xl' }} text-slate-900 leading-tight">
                        Selected <span class="text-sky-600 italic">Works</span>
                    </h1>
                </div>
                @guest
                <p class="text-slate-500 max-w-sm text-lg leading-relaxed border-l-2 border-sky-600 pl-8">
                    A curation of professional projects developed by Randolf and the RJ Studio team.
                </p>
                @endguest
            </div>
            
            <div class="flex flex-col gap-8 mt-12 md:mt-20 w-full">
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-x-8 gap-y-4 border-b border-slate-100 pb-4 w-full">
                    <button @click="activeCategory = 'All'; displayLimit = 6" 
                            :class="activeCategory === 'All' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                            class="text-[10px] font-black uppercase tracking-[0.3em] pb-2 transition-all outline-none">
                        All Projects
                    </button>
                    <button @click="activeCategory = 'Design'; displayLimit = 6" 
                            :class="activeCategory === 'Design' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                            class="text-[10px] font-black uppercase tracking-[0.3em] pb-2 transition-all outline-none">
                        Architectural Design
                    </button>
                    <button @click="activeCategory = 'Construction'; displayLimit = 6" 
                            :class="activeCategory === 'Construction' ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                            class="text-[10px] font-black uppercase tracking-[0.3em] pb-2 transition-all outline-none">
                        Construction
                    </button>
                </div>

                <!-- Year Filter -->
                <div class="flex flex-wrap items-center gap-3 md:gap-6 w-full">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-300">Archive Year:</span>
                    <button @click="activeYear = 'All'; displayLimit = 6" 
                            :class="activeYear === 'All' ? 'bg-sky-600 text-white shadow-lg shadow-sky-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100'" 
                            class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest transition-all">
                        All Time
                    </button>
                    <template x-for="year in yearsWithData" :key="year">
                        <button @click="activeYear = year; displayLimit = 6" 
                                :class="activeYear == year ? 'bg-sky-600 text-white shadow-lg shadow-sky-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100'" 
                                class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest transition-all"
                                x-text="year">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="project in visibleProjects" :key="project.id">
                    <a :href="'/portfolio/' + project.id" class="group" 
                          x-transition:enter="transition ease-out duration-500"
                          x-transition:enter-start="opacity-0 translate-y-8"
                          x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <div class="aspect-[16/10] rounded-card overflow-hidden bg-slate-50 relative shadow-sm group-hover:shadow-premium transition-all duration-700 border border-slate-100">
                            <img :src="project.image_path" class="object-cover w-full h-full transition-all duration-1000 group-hover:scale-105">
                            
                            <!-- Floating Info Badge (App-style) -->
                            <div class="absolute top-4 left-4 md:top-6 md:left-6 md:opacity-0 group-hover:opacity-100 transition-all duration-500 md:translate-x-[-10px] group-hover:translate-x-0 z-20">
                                <div class="px-4 py-2 md:px-6 md:py-3 bg-slate-900 text-white rounded-2xl shadow-2xl flex flex-col gap-0.5 border border-white/10">
                                    <h3 class="text-[10px] md:text-xs font-black tracking-[0.2em]" x-text="project.title"></h3>
                                    <p class="text-[7px] md:text-[8px] text-sky-400 font-bold uppercase tracking-[0.15em]" x-text="project.category + ' • ' + project.year"></p>
                                </div>
                            </div>

                            <template x-if="project.images && project.images.length > 1">
                                <div class="absolute bottom-4 right-4 md:bottom-8 md:right-8 px-4 py-2 md:px-5 md:py-2.5 bg-white/40 backdrop-blur-md rounded-full text-[8px] md:text-[9px] font-black text-slate-900 uppercase tracking-widest border border-white/20 z-10 shadow-xl md:opacity-0 group-hover:opacity-100 md:translate-y-2 group-hover:translate-y-0 transition-all duration-500">
                                    <span x-text="project.images.length"></span> Perspectives
                                </div>
                            </template>

                        </div>
                    </a>
                </template>
            </div>

            <!-- Load More Button -->
            <div class="mt-20 flex justify-center" x-show="filteredProjects.length > displayLimit">
                <button @click="displayLimit += 6" class="group flex flex-col items-center gap-4 outline-none">
                    <span class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-400 group-hover:text-sky-600 transition-colors">Show More Masterpieces</span>
                    <div class="w-12 h-12 rounded-full border border-slate-100 flex items-center justify-center group-hover:border-sky-600 group-hover:bg-sky-50 transition-all duration-500">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-sky-600 group-hover:translate-y-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
            </div>

            <!-- Empty State -->
            @if($projects->isNotEmpty())
            <div x-show="filteredProjects.length === 0" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 class="py-40 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-sky-50 rounded-card flex items-center justify-center text-sky-600 mb-10 rotate-3 border border-sky-100/50 shadow-inner">
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
            @endif

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