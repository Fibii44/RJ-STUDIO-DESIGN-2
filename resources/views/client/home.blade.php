<x-app-layout>
@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition.opacity.duration.500ms
         class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
        
        <div @click.away="show = false" 
             class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-[3rem] p-10 shadow-2xl border border-slate-100 dark:border-slate-800 text-center animate-in zoom-in duration-300">
            
            <div class="w-20 h-20 bg-sky-100 dark:bg-sky-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h3 class="font-serif text-2xl text-slate-900 dark:text-white mb-2">Confirmed!</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                {{ session('success') }}
            </p>

            <button @click="show = false" 
                    class="w-full py-4 bg-sky-600 hover:bg-slate-900 text-white rounded-2xl font-bold uppercase tracking-widest transition shadow-lg shadow-sky-200 dark:shadow-none">
                Great, thanks!
            </button>
        </div>
    </div>
@endif

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 dark:text-white leading-tight">
                    Welcome, <span class="text-sky-600 italic">{{ Auth::user()->name }}</span>
                </h2>
                <div class="flex items-center gap-3 text-sm font-medium text-slate-500">
                    <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                    <span>Project: Villa Modern Residence (Phase 03)</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="#messages" class="p-3 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </a>
                <a href="{{ route('services') }}" class="inline-flex items-center px-8 py-3.5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl font-bold text-sm hover:scale-105 transition shadow-xl">
                    New Consultation
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
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-8">Design Milestones</h4>
                    <div class="space-y-10 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100 dark:before:bg-slate-800">
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center border-4 border-white dark:border-slate-900">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Site Survey</p>
                            <p class="text-[10px] text-slate-400 font-medium tracking-tight">Completed</p>
                        </div>
                        <div class="relative pl-8">
                            <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-sky-500 flex items-center justify-center border-4 border-white dark:border-slate-900 animate-pulse"></div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Schematic Design</p>
                            <p class="text-[10px] text-sky-600 font-bold uppercase mt-1">In Progress</p>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-50 dark:border-slate-800">
                        <p class="text-[10px] text-slate-400 font-bold uppercase mb-2">Target Handover</p>
                        <p class="font-serif text-lg text-slate-800 dark:text-white">Oct 2026</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <h3 class="font-serif text-2xl">Project Documentation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-sky-300 transition-all cursor-pointer group">
                             <img src="https://images.unsplash.com/photo-1503387762-592dea58ef23?auto=format&fit=crop&q=80&w=600" class="w-full aspect-video object-cover rounded-2xl grayscale group-hover:grayscale-0 transition-all">
                             <h4 class="font-bold text-slate-900 dark:text-white mt-4 text-sm">Floor Plan - L01</h4>
                        </div>
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 hover:border-sky-300 transition-all cursor-pointer group">
                             <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=600" class="w-full aspect-video object-cover rounded-2xl grayscale group-hover:grayscale-0 transition-all">
                             <h4 class="font-bold text-slate-900 dark:text-white mt-4 text-sm">Landscape Plan</h4>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-sky-600 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden">
                         <p class="text-[10px] font-bold uppercase tracking-widest text-sky-200 mb-4">Studio Note</p>
                         <p class="text-sm italic leading-relaxed">"Welcome to the portal. Here you can track your modern villa's progress and schedule meetings with Feby Angela."</p>
                         <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <h4 class="font-serif text-xl mb-6">Your Next Meeting</h4>
                        
                        @php $latest = $appointments->where('status', 'confirmed')->first() ?? $appointments->first(); @endphp

                        @if($latest)
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-14 bg-sky-50 dark:bg-sky-950 flex flex-col items-center justify-center rounded-xl border border-sky-100">
                                <span class="text-[10px] font-bold text-sky-600 uppercase">{{ \Carbon\Carbon::parse($latest->appointment_date)->format('M') }}</span>
                                <span class="text-xl font-bold text-sky-900 dark:text-white leading-none">{{ \Carbon\Carbon::parse($latest->appointment_date)->format('d') }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-900 dark:text-white leading-tight">{{ $latest->service_type }}</p>
                                <p class="text-[10px] mt-1 {{ $latest->status === 'confirmed' ? 'text-green-500 font-bold' : 'text-amber-500 italic' }}">
                                    {{ ucfirst($latest->status) }}
                                </p>
                            </div>
                        </div>
                        @else
                        <p class="text-slate-400 text-xs italic">No upcoming meetings.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>