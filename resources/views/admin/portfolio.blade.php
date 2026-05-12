<x-admin-layout>
    <div class="space-y-8" x-effect="document.body.style.overflow = (showUpload || bundleModal || deleteModal) ? 'hidden' : ''" x-data='{ 
        activeCategory: "All", 
        activeYear: "All",
        showUpload: false,
        bundleModal: false,
        deleteModal: false,
        displayLimit: 8,
        fileCount: 0,
        descriptionText: "",
        isUploading: false,
        selectedProject: { id: null, title: "", category: "", year: "", images: [] },
        projectToDelete: null,
        imageToDelete: null,
        allProjects: @json($projects->items()),

        get availableYears() {
            const years = [...new Set(this.allProjects.map(p => p.year))].sort((a, b) => b - a);
            return ["All", ...years];
        },

        get filteredProjects() {
            return this.allProjects.filter(p => {
                const categoryMatch = this.activeCategory === "All" || p.category === this.activeCategory;
                const yearMatch = this.activeYear === "All" || p.year.toString() === this.activeYear.toString();
                return categoryMatch && yearMatch;
            });
        },

        get displayedProjects() {
            return this.filteredProjects.slice(0, this.displayLimit);
        },
        
        openBundle(project) {
            this.selectedProject = project;
            this.bundleModal = true;
        },

        confirmDelete(project) {
            this.projectToDelete = project;
            this.imageToDelete = null;
            this.deleteModal = true;
        },

        confirmImageDelete(image) {
            this.imageToDelete = image;
            this.projectToDelete = null;
            this.deleteModal = true;
        }
    }'>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-3xl font-serif text-slate-900">Portfolio <span class="text-sky-600 italic">Library</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Randolf Jan's Selected Works</p>
            </div>
            
            <div class="flex gap-4">
                <button @click="showUpload = !showUpload" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-sky-600 transition shadow-xl">
                    <svg x-show="!showUpload" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <svg x-show="showUpload" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span x-text="showUpload ? 'Close Form' : 'Add New Work'"></span>
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-100 mb-10 pb-4">
            <div class="flex gap-10 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <template x-for="cat in ['All', 'Design', 'Construction']">
                    <button @click="activeCategory = cat; displayLimit = 8" 
                            :class="activeCategory === cat ? 'text-sky-600 border-b-2 border-sky-600' : 'text-slate-400 hover:text-slate-900'" 
                            class="text-[10px] font-black uppercase tracking-[0.3em] pb-4 -mb-4.5 transition-all outline-none"
                            x-text="cat === 'All' ? 'All Projects' : (cat === 'Design' ? 'Architectural Design' : cat)"></button>
                </template>
            </div>

            <div class="relative" x-data="{ yearOpen: false }">
                <button @click="yearOpen = !yearOpen" 
                        class="flex items-center gap-3 bg-white p-2.5 px-5 rounded-2xl border border-slate-200 hover:border-sky-200 hover:shadow-sm transition-all outline-none">
                    <span class="text-[8px] font-black uppercase tracking-widest text-slate-400">Filter Year</span>
                    <span class="text-[10px] font-black text-sky-600" x-text="activeYear"></span>
                    <svg class="w-3 h-3 text-slate-400 transition-transform" :class="yearOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="yearOpen" 
                     @click.away="yearOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-2 w-32 bg-white rounded-2xl shadow-2xl border border-slate-100 p-2 z-[100] grid gap-1">
                    <template x-for="year in availableYears">
                        <button @click="activeYear = year; displayLimit = 8; yearOpen = false" 
                                :class="activeYear.toString() === year.toString() ? 'bg-sky-50 text-sky-600' : 'text-slate-500 hover:bg-slate-50'" 
                                class="w-full text-left px-4 py-2 rounded-xl text-[10px] font-black transition-all"
                                x-text="year"></button>
                    </template>
                </div>
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="showUpload" 
                 x-cloak
                 class="fixed inset-0 z-[200] flex items-center justify-center p-6 md:p-12">
                
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-500" 
                     @click="showUpload = false"
                     x-show="showUpload"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white w-full max-w-4xl max-h-[90vh] rounded-3xl shadow-2xl border border-white/20 overflow-hidden flex flex-col"
                     x-show="showUpload"
                     x-transition:enter="ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                     @click.stop>
                    
                    <div class="p-8 lg:p-10 pb-4 flex justify-between items-start border-b border-slate-50">
                        <div class="space-y-1">
                            <h4 class="font-serif text-3xl text-slate-900">Upload <span class="italic text-sky-600">Project</span></h4>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.3em]">Curation • Architectural Bundle</p>
                        </div>
                        <button @click="showUpload = false" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    
                    <form id="uploadProjectForm" action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data" 
                          class="flex-1 overflow-y-auto p-8 lg:p-10 pt-2 custom-scrollbar" 
                          @submit="isUploading = true">
                        @csrf
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2 space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 ml-2">Project Title</label>
                                    <input type="text" name="title" required placeholder="Ex: Minimalist Glass Villa" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-sky-500/10 transition-all text-xs px-4">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 ml-2">Category</label>
                                    <select name="category" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 text-xs px-4">
                                        <option value="Design">Architectural Design</option>
                                        <option value="Construction">Construction Management</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2 space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 ml-2">Location (Optional)</label>
                                    <input type="text" name="location" placeholder="Ex: Bukidnon, Philippines" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-sky-500/10 transition-all text-xs px-4">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 ml-2">Project Year</label>
                                    <input type="number" name="year" value="{{ date('Y') }}" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-sky-500/10 transition-all text-xs px-4">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center px-2">
                                    <label class="text-[10px] font-bold text-slate-400">Concept Description (Optional)</label>
                                    <span class="text-[10px] font-bold italic transition-colors" 
                                          :class="(descriptionText.length > 1500) ? 'text-red-500' : 'text-slate-300'">
                                        <span x-text="descriptionText.length"></span>/1500
                                    </span>
                                </div>
                                <textarea name="description" 
                                          x-model="descriptionText"
                                          placeholder="Briefly describe the architectural vision..." 
                                          class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-sky-500/10 transition-all text-xs p-4 min-h-[80px] max-h-[160px]"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Main Cover Upload -->
                                <div class="space-y-2" x-data="{ coverPreview: null }">
                                    <div class="flex justify-between items-center px-2">
                                        <label class="text-[10px] font-bold text-sky-600">Main Cover Perspective</label>
                                        <span class="text-[10px] font-medium text-sky-500 italic">Max 5MB per image</span>
                                    </div>
                                    <div class="relative group/upload h-28 rounded-2xl border-2 border-dashed border-sky-100 bg-sky-50/30 overflow-hidden transition-all hover:border-sky-300 cursor-pointer">
                                        <input type="file" name="cover" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                               @change="const file = $el.files[0]; if(file) { coverPreview = URL.createObjectURL(file) }">
                                        
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-2 pointer-events-none" x-show="!coverPreview">
                                            <svg class="w-6 h-6 text-sky-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-[8px] font-black uppercase tracking-widest text-sky-600">Select Featured Render</p>
                                        </div>

                                        <img x-show="coverPreview" :src="coverPreview" class="w-full h-full object-cover">
                                        
                                        <!-- Overlay on Hover when image exists -->
                                        <div x-show="coverPreview" class="absolute inset-0 bg-sky-600/20 opacity-0 group-hover/upload:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="px-3 py-1 bg-white text-sky-600 text-[10px] font-bold rounded-full shadow-sm">Change Image</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gallery Bundle Upload -->
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center px-2">
                                        <label class="text-[10px] font-bold text-slate-400">Gallery Bundle (Multiple)</label>
                                        <span class="text-[10px] font-medium transition-colors italic"
                                              :class="fileCount > 10 ? 'text-red-500' : 'text-sky-500'">
                                            <span x-text="fileCount > 10 ? 'Limit exceeded: Max 10' : 'Max 5MB per image / 10 images'"></span>
                                        </span>
                                    </div>
                                    <div class="relative group/upload h-28 rounded-2xl border-2 border-dashed overflow-hidden transition-all cursor-pointer"
                                         :class="fileCount > 10 ? 'border-red-200 bg-red-50/30' : 'border-slate-100 bg-slate-50/50 hover:border-slate-300'">
                                        <input type="file" name="images[]" multiple required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                               @change="fileCount = $el.files.length">
                                        
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-2 pointer-events-none">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2 transition-colors"
                                                 :class="fileCount > 10 ? 'bg-red-100' : 'bg-slate-100 group-hover/upload:bg-sky-50'">
                                                <svg class="w-4 h-4" :class="fileCount > 10 ? 'text-red-500' : 'text-slate-400 group-hover/upload:text-sky-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <p class="text-[8px] font-black uppercase tracking-widest" 
                                               :class="fileCount > 10 ? 'text-red-600' : 'text-slate-400 group-hover/upload:text-sky-600'"
                                               x-text="fileCount > 0 ? (fileCount > 10 ? fileCount + ' Images - Too Many!' : fileCount + ' Perspectives Selected') : 'Batch Upload Bundle'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="p-8 lg:p-10 pt-6 border-t border-slate-50 flex justify-center bg-white">
                        <button type="submit" form="uploadProjectForm" 
                                :disabled="isUploading || fileCount > 10"
                                class="px-12 py-4 bg-slate-900 text-white rounded-xl font-bold uppercase tracking-widest text-[9px] hover:bg-sky-600 transition-all shadow-xl flex items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-text="isUploading ? 'CURATING...' : 'Create Project'"></span>
                            <template x-if="isUploading">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <template x-for="(project, index) in displayedProjects" :key="project.id">
                <div class="group bg-white rounded-[2.5rem] p-4 border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                    
                    <div class="aspect-[16/10] rounded-[1.8rem] overflow-hidden mb-5 relative bg-slate-50">
                        <img :src="project.image_path" 
                             loading="lazy"
                             class="object-cover w-full h-full group-hover:scale-105 transition-all duration-700">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                            <button @click="openBundle(project)" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-sky-600 hover:text-white transition-all shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                            </button>

                            <button @click="confirmDelete(project)" class="w-12 h-12 bg-white text-red-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-serif text-lg text-slate-900 line-clamp-1" x-html="project.title"></h4>
                            <span class="text-[10px] font-black text-slate-300" x-text="project.year"></span>
                        </div>
                        <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest" x-text="project.category"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Studio Styled Pagination -->
        <div class="mt-12 py-8 border-t border-slate-50">
            {{ $projects->links() }}
        </div>

        <template x-teleport="body">
            <div x-show="bundleModal" x-cloak class="fixed inset-0 z-[250] flex items-center justify-center p-6 md:p-12">
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-500" @click="bundleModal = false"></div>
                
                <form :action="`/admin/portfolio/${selectedProject.id}`" method="POST" enctype="multipart/form-data" class="relative bg-white w-full max-w-6xl h-full max-h-[90vh] rounded-3xl overflow-hidden shadow-2xl flex flex-col lg:flex-row border border-white/20" @click.stop>
                    @csrf @method('PATCH')
                    
                    <!-- Left: Bundle Preview -->
                    <div class="flex-1 p-8 lg:p-12 overflow-y-auto custom-scrollbar bg-slate-50/30">
                         <div class="flex justify-between items-center mb-10">
                            <div class="space-y-1">
                                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">Project Perspectives</h3>
                                <p class="text-[10px] text-sky-600 font-bold" x-text="selectedProject.images ? selectedProject.images.length + ' Perspectives Rendered' : '0 Perspectives'"></p>
                            </div>
                            <button @click="bundleModal = false" class="lg:hidden w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <template x-for="img in selectedProject.images" :key="img.id">
                                <div class="group/img relative aspect-square rounded-[2rem] overflow-hidden bg-white border-2 border-white shadow-premium transition-all hover:shadow-2xl">
                                    <img :src="img.path" class="w-full h-full object-cover transition-all duration-700">
                                    <div class="absolute inset-0 bg-red-600/90 opacity-0 group-hover/img:opacity-100 transition-all flex items-center justify-center backdrop-blur-sm">
                                        <button type="button" @click="confirmImageDelete(img)" class="w-12 h-12 rounded-full bg-white text-red-600 flex items-center justify-center hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Add Icon Card -->
                            <div class="relative group/add aspect-square rounded-[2rem] border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-white hover:border-sky-400 hover:shadow-xl transition-all overflow-hidden">
                                <input type="file" name="new_images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       @change="fileCount = $el.files.length">
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-sky-600 mb-2 group-hover/add:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                    <p class="text-[8px] font-black uppercase text-slate-400 tracking-widest group-hover/add:text-sky-600 transition-colors" x-text="fileCount > 0 ? fileCount + ' Selected' : 'Add Perspective'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Edit Details -->
                    <div class="w-full lg:w-[450px] flex flex-col bg-white border-l border-slate-100 overflow-hidden">
                        <div class="flex-1 flex flex-col h-full">
                            
                            <!-- Header -->
                            <div class="p-8 lg:p-10 pb-6 flex justify-between items-start border-b border-slate-50/50">
                                <h2 class="text-2xl font-serif text-slate-900 leading-tight">Edit <span class="text-sky-600 italic">Project</span></h2>
                                <button type="button" @click="bundleModal = false" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <!-- Scrollable Body -->
                            <div class="flex-1 overflow-y-auto p-8 lg:p-10 space-y-6 custom-scrollbar">
                                <div class="space-y-1.5">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Project Title</label>
                                    <input type="text" name="title" x-model="selectedProject.title" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 text-xs px-4 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Year</label>
                                        <input type="number" name="year" x-model="selectedProject.year" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 text-xs px-4 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Category</label>
                                        <select name="category" x-model="selectedProject.category" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 text-xs px-4">
                                            <option value="Design">Design</option>
                                            <option value="Construction">Construction</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 ml-2">Location</label>
                                    <input type="text" name="location" x-model="selectedProject.location" placeholder="Ex: Bukidnon, Philippines" class="w-full h-11 rounded-xl border-slate-100 bg-slate-50 text-xs px-4">
                                </div>

                                <div class="space-y-1.5">
                                    <div class="flex justify-between items-center px-2">
                                        <label class="text-[10px] font-bold text-slate-400">Description</label>
                                        <span class="text-[10px] font-bold italic transition-colors" 
                                              :class="((selectedProject.description?.length || 0) > 1500) ? 'text-red-500' : 'text-slate-300'">
                                            <span x-text="selectedProject.description?.length || 0"></span>/1500
                                        </span>
                                    </div>
                                    <textarea name="description" x-model="selectedProject.description" rows="3" placeholder="Briefly describe the architectural concept..." class="w-full rounded-2xl border-slate-100 bg-slate-50 text-xs p-4 focus:ring-4 focus:ring-sky-500/10 transition-all min-h-[80px] max-h-[160px]"></textarea>
                                </div>


                            </div>

                            <!-- Footer (Sticky/Fixed at bottom of modal) -->
                            <div class="p-8 lg:p-10 border-t border-slate-50 bg-white flex gap-3">
                                <button type="button" @click="bundleModal = false" class="flex-1 py-4 bg-slate-50 text-slate-400 rounded-xl font-bold uppercase text-[9px] tracking-widest hover:bg-slate-100 transition-all">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-[2] py-4 bg-slate-900 text-white rounded-xl font-bold uppercase text-[9px] tracking-[0.2em] shadow-xl hover:bg-sky-600 transition-all">
                                    Save All Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </template>
        <template x-teleport="body">
            <div x-show="deleteModal" x-cloak class="fixed inset-0 z-[300] flex items-center justify-center p-6">
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-500" @click="deleteModal = false"></div>
                
                <div class="relative bg-white w-full max-w-md rounded-[2.5rem] overflow-hidden shadow-2xl p-10 text-center border border-white/20" 
                     x-show="deleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    
                    <!-- Warning Icon -->
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-serif text-slate-900 mb-3" x-text="imageToDelete ? 'Remove Perspective?' : 'Delete Project?'"></h3>
                    <p class="text-xs text-slate-400 mb-10 leading-relaxed">
                        <span x-show="projectToDelete">Are you sure you want to permanently remove <span class="font-bold text-slate-600 italic" x-html="projectToDelete?.title"></span>?</span>
                        <span x-show="imageToDelete">Permanently remove this architectural perspective from the project bundle?</span>
                        This action cannot be undone.
                    </p>

                    <div class="flex gap-3">
                        <button @click="deleteModal = false" class="flex-1 py-4 bg-slate-50 text-slate-400 rounded-xl font-bold uppercase text-[9px] tracking-widest hover:bg-slate-100 transition-all">
                            Keep it
                        </button>
                        <form :action="projectToDelete ? '/admin/portfolio/' + projectToDelete.id : (imageToDelete ? '/admin/portfolio/image/' + imageToDelete.id : '#')" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-4 bg-red-600 text-white rounded-xl font-bold uppercase text-[9px] tracking-[0.2em] shadow-xl hover:bg-red-700 transition-all">
                                Confirm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-admin-layout>