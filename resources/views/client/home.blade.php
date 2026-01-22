<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 dark:text-white leading-tight">
                    Project: <span class="text-sky-600 italic">Villa Modern Residence</span>
                </h2>
                <div class="flex items-center gap-3 text-sm font-medium text-slate-500">
                    <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                    <span>Currently in Phase 03: Architectural Blueprints</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="#messages" class="p-3 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </a>
                <a href="#book" class="inline-flex items-center px-8 py-3.5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl font-bold text-sm hover:scale-105 transition shadow-xl shadow-slate-200 dark:shadow-none">
                    Schedule Site Visit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-3 relative h-[450px] rounded-[3rem] overflow-hidden shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&q=80&w=1200" alt="Latest Rendering" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent flex flex-col justify-end p-12">
                        <span class="text-sky-400 font-bold uppercase tracking-widest text-xs mb-2">Latest 3D Rendering</span>
                        <h3 class="text-white text-3xl font-serif">Exterior View - South Wing Elevation</h3>
                    </div>
                    <div class="absolute top-8 right-8 p-4 glass-card rounded-2xl">
                         <p class="text-[10px] font-bold text-white uppercase tracking-widest leading-none">Status</p>
                         <p class="text-white font-serif italic text-lg mt-1">Ready for Review</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-8">Design Milestones</h4>
                    <div class="space-y-10 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100 dark:before:bg-slate-800">
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center border-4 border-white dark:border-slate-900">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Site Survey</p>
                            <p class="text-[10px] text-slate-400 font-medium">Completed Dec 12</p>
                        </div>
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-sky-500 flex items-center justify-center border-4 border-white dark:border-slate-900"></div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Schematic Design</p>
                            <p class="text-[10px] text-sky-600 font-bold uppercase mt-1">In Progress</p>
                        </div>
                        <div class="relative pl-8 opacity-40">
                            <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center border-4 border-white dark:border-slate-900"></div>
                            <p class="text-sm font-bold">Construction Permit</p>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-50 dark:border-slate-800">
                        <p class="text-[10px] text-slate-400 font-bold uppercase mb-2">Estimated Completion</p>
                        <p class="font-serif text-lg text-slate-800 dark:text-white">October 2026</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif text-2xl">Project Documentation</h3>
                        <a href="#" class="text-xs font-bold text-sky-600 uppercase">Download Full Set</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-sky-300 transition-all cursor-pointer group">
                            <div class="aspect-video rounded-2xl bg-slate-100 dark:bg-slate-800 overflow-hidden mb-4 relative">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900/40">
                                    <span class="px-4 py-2 bg-white rounded-lg text-xs font-bold">Zoom View</span>
                                </div>
                                <img src="https://images.unsplash.com/photo-1503387762-592dea58ef23?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Floor Plan - Level 01</h4>
                            <p class="text-xs text-slate-500 mt-1">Updated 2 days ago • PDF (4.2MB)</p>
                        </div>

                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-sky-300 transition-all cursor-pointer group">
                            <div class="aspect-video rounded-2xl bg-slate-100 dark:bg-slate-800 overflow-hidden mb-4 relative">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Landscape Schematic</h4>
                            <p class="text-xs text-slate-500 mt-1">Pending Approval • PDF (1.8MB)</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-sky-600 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-full border-2 border-white/30 overflow-hidden">
                                    <img src="https://i.pravatar.cc/100?img=11" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-sky-200">Head Architect</p>
                                    <p class="font-bold text-sm leading-none">Feby Studio</p>
                                </div>
                            </div>
                            <p class="text-sm italic leading-relaxed mb-6">"The orientation of the glass wall has been adjusted by 5° to maximize natural light during the morning hours. Let me know your thoughts."</p>
                            <a href="#" class="inline-block w-full py-3 bg-white text-sky-600 rounded-xl font-bold text-xs text-center uppercase tracking-widest hover:bg-sky-50 transition">Reply to Studio</a>
                        </div>
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <h4 class="font-serif text-xl mb-6">Upcoming Meeting</h4>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-14 bg-sky-50 dark:bg-sky-950 flex flex-col items-center justify-center rounded-xl border border-sky-100 dark:border-sky-900">
                                <span class="text-[10px] font-bold text-sky-600 uppercase">Jan</span>
                                <span class="text-xl font-bold text-sky-900 dark:text-white leading-none">28</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-900 dark:text-white leading-tight">Project Material Review</p>
                                <p class="text-xs text-slate-500 mt-1">RJ Studio Headquarters</p>
                                <p class="text-xs text-sky-600 font-bold mt-2">10:00 AM PST</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>