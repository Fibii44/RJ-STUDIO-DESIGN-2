<x-app-layout>
@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition.opacity.duration.500ms
         class="fixed inset-0 z-[200] flex items-center justify-center p-6 bg-slate-900/40 backdrop-blur-md">
        
        <div @click.away="show = false" 
             class="bg-white w-full max-w-sm rounded-[3rem] p-10 shadow-2xl border border-slate-100 text-center animate-in zoom-in duration-300">
            
            <div class="w-20 h-20 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h3 class="font-serif text-2xl text-slate-900 mb-2">Confirmed!</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                {{ session('success') }}
            </p>

            <button @click="show = false" 
                    class="w-full py-4 bg-slate-900 hover:bg-sky-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] transition-all duration-300 shadow-xl shadow-slate-900/20">
                Great, thanks!
            </button>
        </div>
    </div>
@endif

    <x-slot name="header">
        <div class="pt-24 pb-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <h2 class="font-serif text-5xl lg:text-7xl text-slate-900 leading-tight">
                        Welcome, <span class="text-sky-600 italic">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium tracking-tight text-lg">
                        Villa Modern Residence <span class="text-slate-300 mx-2">|</span> Phase 03: Schematic Design
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('services') }}" class="inline-flex items-center px-10 py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-600 hover:translate-y-[-4px] transition-all duration-300 shadow-2xl shadow-slate-900/20">
                        New Consultation
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-24 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-3 relative h-[550px] rounded-[3.5rem] overflow-hidden shadow-premium group">
                    <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&q=80&w=1200" alt="Latest Rendering" class="object-cover w-full h-full transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent flex flex-col justify-end p-12">
                        <span class="text-sky-400 font-black uppercase tracking-widest text-[10px] mb-3">Latest 3D Rendering</span>
                        <h3 class="text-white text-4xl font-serif">Exterior View - South Wing Elevation</h3>
                    </div>
                </div>

                <div class="bg-white rounded-[3.5rem] p-10 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 mb-10">Design Milestones</h4>
                        <div class="space-y-12 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100">
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-0.5 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center border-4 border-white">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                </div>
                                <p class="text-[11px] font-black uppercase tracking-widest text-slate-900">Site Survey</p>
                                <p class="text-[10px] text-slate-400 mt-1">Completed</p>
                            </div>
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-0.5 w-6 h-6 rounded-full bg-sky-500 flex items-center justify-center border-4 border-white animate-pulse"></div>
                                <p class="text-[11px] font-black uppercase tracking-widest text-slate-900">Schematic Design</p>
                                <p class="text-[10px] text-sky-600 font-bold mt-1">In Progress</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-8 border-t border-slate-50">
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Target Handover</p>
                        <p class="font-serif text-2xl text-slate-900">Oct 2026</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-10">
                    <h3 class="font-serif text-3xl">Project Documentation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group cursor-pointer">
                            <div class="aspect-video rounded-[2.5rem] overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-500 border border-slate-100">
                                <img src="https://images.unsplash.com/photo-1503387762-592dea58ef23?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                            </div>
                            <h4 class="font-serif text-xl text-slate-900">Floor Plan - L01</h4>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Blueprint &bull; PDF</p>
                        </div>
                        <div class="group cursor-pointer">
                            <div class="aspect-video rounded-[2.5rem] overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-500 border border-slate-100">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                            </div>
                            <h4 class="font-serif text-xl text-slate-900">Landscape Plan</h4>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Blueprint &bull; PDF</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-10">
                    <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
                         <p class="text-[10px] font-black uppercase tracking-[0.2em] text-sky-400 mb-6">Studio Note</p>
                         <p class="text-lg font-serif italic leading-relaxed text-slate-200">"Welcome to the portal. Here you can track your modern villa's progress and schedule meetings with Feby Angela."</p>
                         <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    </div>

                    <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                        <h4 class="font-serif text-2xl mb-8">Next Meeting</h4>
                        
                        @php $latest = $appointments->where('status', 'confirmed')->first() ?? $appointments->first(); @endphp

                        @if($latest)
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-20 bg-sky-50 flex flex-col items-center justify-center rounded-2xl border border-sky-100">
                                <span class="text-[10px] font-black text-sky-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($latest->appointment_date)->format('M') }}</span>
                                <span class="text-3xl font-serif text-sky-900 leading-none mt-1">{{ \Carbon\Carbon::parse($latest->appointment_date)->format('d') }}</span>
                            </div>
                            <div>
                                <p class="font-serif text-xl text-slate-900 leading-tight">{{ $latest->service_type }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest mt-2 {{ $latest->status === 'confirmed' ? 'text-green-500' : 'text-amber-500' }}">
                                    {{ ucfirst($latest->status) }}
                                </p>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">No upcoming meetings</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>