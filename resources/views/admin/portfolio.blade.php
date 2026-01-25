<x-admin-layout>
    <div class="space-y-8" x-data="{ 
        activeCategory: 'All', 
        showUpload: false,
        bundleModal: false,
        fileCount: 0,
        selectedProject: { id: null, title: '', category: '', year: '', images: [] },
        
        openBundle(project) {
            this.selectedProject = project;
            this.bundleModal = true;
        }
    }">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-3xl font-serif text-slate-900">Portfolio <span class="text-sky-600 italic">Library</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Randolf Jan's Selected Works</p>
            </div>
            
            <button @click="showUpload = !showUpload" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-sky-600 transition shadow-xl">
                <svg x-show="!showUpload" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <svg x-show="showUpload" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                <span x-text="showUpload ? 'Close Form' : 'Add New Work'"></span>
            </button>
        </div>

        <div x-show="showUpload" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-sky-600"></div>
            <h4 class="font-serif text-xl mb-6">Upload <span class="italic text-sky-600">New Project Bundle</span></h4>
            
            <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Project Title</label>
                    <input type="text" name="title" required placeholder="Project Title" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-sky-500/10 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Category</label>
                    <select name="category" class="w-full rounded-2xl border-slate-100 bg-slate-50">
                        <option value="Design">Architectural Design</option>
                        <option value="Construction">Construction Management</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Year</label>
                    <input type="number" name="year" value="{{ date('Y') }}" class="w-full rounded-2xl border-slate-100 bg-slate-50">
                </div>
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black uppercase text-sky-600 ml-2">Renders (Select Multiple)</label>
                    <input type="file" name="images[]" multiple required @change="fileCount = $el.files.length" class="w-full p-4 rounded-2xl border-2 border-dashed border-slate-200 text-xs">
                    <p x-show="fileCount > 0" class="text-[10px] text-sky-600 font-bold" x-text="fileCount + ' files selected'"></p>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-4 bg-sky-600 text-white rounded-2xl font-bold uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg">Confirm Upload</button>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-4 bg-slate-100/50 p-1.5 rounded-2xl w-fit">
            <button @click="activeCategory = 'All'" :class="activeCategory === 'All' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">All Works</button>
            <button @click="activeCategory = 'Design'" :class="activeCategory === 'Design' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500'" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Design</button>
            <button @click="activeCategory = 'Construction'" :class="activeCategory === 'Construction' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500'" class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Construction</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="group bg-white rounded-[2.5rem] p-4 border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1"
                     x-show="activeCategory === 'All' || activeCategory === '{{ $project->category }}'"
                     x-transition.scale.95>
                    
                    <div class="aspect-[16/10] rounded-[1.8rem] overflow-hidden mb-5 relative">
                        <img src="{{ asset($project->image_path) }}" class="object-cover w-full h-full grayscale group-hover:grayscale-0 transition-all duration-700">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                            <button @click="openBundle({{ $project->load('images')->toJson() }})" class="w-12 h-12 bg-white text-slate-900 rounded-full flex items-center justify-center hover:bg-sky-600 hover:text-white transition-all shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                            </button>

                            <form action="{{ route('admin.portfolio.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entire project?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-12 h-12 bg-white text-red-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-serif text-lg text-slate-900">{{ $project->title }}</h4>
                            <span class="text-[10px] font-black text-slate-300">{{ $project->year }}</span>
                        </div>
                        <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest">{{ $project->category }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <template x-teleport="body">
            <div x-show="bundleModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 md:p-10">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xl transition-opacity duration-500" @click="bundleModal = false"></div>
                
                <div class="relative bg-white/95 dark:bg-slate-900/95 backdrop-blur-md w-full max-w-6xl h-full max-h-[85vh] rounded-[3.5rem] overflow-hidden shadow-2xl flex flex-col lg:flex-row border border-white/20" @click.stop>
                    
                    <div class="flex-1 p-10 overflow-y-auto bg-slate-50/20 dark:bg-slate-950/20 custom-scrollbar border-b lg:border-b-0 lg:border-r border-slate-200/50">
                         <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">Current Bundle</h3>
                            <span class="px-3 py-1 bg-sky-100 text-sky-700 rounded-lg text-[10px] font-bold" x-text="selectedProject.images ? selectedProject.images.length + ' Perspectives' : '0 Perspectives'"></span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <template x-for="img in selectedProject.images" :key="img.id">
                                <div class="group/img relative aspect-square rounded-[2rem] overflow-hidden border-4 border-white dark:border-slate-800 shadow-xl">
                                    <img :src="'/' + img.path" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-red-600/90 opacity-0 group-hover/img:opacity-100 transition-all flex items-center justify-center">
                                        <form :action="'/admin/portfolio/image/' + img.id" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Permanently remove render?')" class="bg-white text-red-600 px-4 py-2 rounded-xl text-[10px] font-bold uppercase">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="w-full lg:w-[400px] p-10 flex flex-col justify-between bg-white dark:bg-slate-900">
                        <div class="space-y-8 overflow-y-auto custom-scrollbar pr-2">
                            <h2 class="text-2xl font-serif text-slate-900 dark:text-white">Edit <span class="text-sky-600 italic">Project</span></h2>

                            <form :action="`/admin/portfolio/${selectedProject.id}`" method="POST" class="space-y-4">
                                @csrf @method('PATCH')
                                <div class="space-y-1">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Title</label>
                                    <input type="text" name="title" x-model="selectedProject.title" class="w-full rounded-xl border-slate-100 bg-slate-50 dark:bg-slate-800 text-sm">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Year</label>
                                    <input type="number" name="year" x-model="selectedProject.year" class="w-full rounded-xl border-slate-100 bg-slate-50 dark:bg-slate-800 text-sm">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Category</label>
                                    <select name="category" x-model="selectedProject.category" class="w-full rounded-xl border-slate-100 bg-slate-50 dark:bg-slate-800 text-sm">
                                        <option value="Design">Architectural Design</option>
                                        <option value="Construction">Construction Management</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full py-4 bg-sky-600 text-white rounded-xl font-bold uppercase text-[10px] tracking-widest shadow-lg hover:bg-slate-900 transition-all">Update Details</button>
                            </form>

                            <div class="pt-8 border-t border-slate-100 dark:border-white/5 space-y-4">
                                <h4 class="text-[9px] font-black uppercase text-sky-600 ml-2">Add More Renders</h4>
                                <form :action="`/admin/portfolio/${selectedProject.id}/add-images`" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <input type="file" name="new_images[]" multiple required class="w-full text-[10px] text-slate-400">
                                    <button type="submit" class="w-full py-3 bg-slate-900 text-white rounded-xl font-bold uppercase text-[10px]">Upload to Bundle</button>
                                </form>
                            </div>
                        </div>

                        <button @click="bundleModal = false" class="mt-8 w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold uppercase text-[10px] tracking-widest hover:bg-sky-600 hover:text-white transition-all">
                            Done Managing
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-admin-layout>