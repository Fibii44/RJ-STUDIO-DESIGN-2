<x-app-layout>
@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition.opacity.duration.500ms
         class="fixed inset-0 z-[200] flex items-center justify-center p-6 bg-slate-900/40 backdrop-blur-md">
        
        <div @click.away="show = false" 
             class="bg-white w-full max-w-sm rounded-card p-10 shadow-2xl border border-slate-100 text-center animate-in zoom-in duration-300">
            
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
        <div class="pt-10 pb-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                        Welcome, <span class="text-sky-600 italic">{{ Auth::user()->name }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium tracking-tight text-lg">
                        {{ $recentProjects->first() ? $recentProjects->first()->title : 'Studio Project Hub' }} <span class="text-slate-300 mx-2">|</span> Latest Updates
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <button @click.prevent="$dispatch('open-modal', 'appointment-modal')" class="inline-flex items-center px-10 py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-600 hover:translate-y-[-4px] transition-all duration-300 shadow-2xl shadow-slate-900/20">
                        New Consultation
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-24 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <a href="{{ route('portfolio.show', $recentProjects[0]->id) }}" class="lg:col-span-3 relative h-[550px] rounded-card overflow-hidden shadow-premium group block">
                    @if($recentProjects->count() > 0)
                        <img src="{{ asset($recentProjects[0]->image_path) }}" alt="{{ $recentProjects[0]->title }}" class="object-cover w-full h-full transition-transform duration-1000 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/10 to-transparent flex flex-col justify-end p-12">
                            <span class="text-sky-400 font-black uppercase tracking-widest text-[10px] mb-3">{{ $recentProjects[0]->category }}</span>
                            <h3 class="text-white text-4xl font-serif">{{ $recentProjects[0]->title }}</h3>
                        </div>
                    @else
                        <div class="w-full h-full bg-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="font-serif">No projects uploaded yet</p>
                        </div>
                    @endif
                </a>

                <div class="bg-white rounded-card p-6 sm:p-10 border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 mb-8">Upcoming Appointments</h4>
                        
                        @if($appointments->count() > 0)
                            <div class="space-y-6">
                                @foreach($appointments->take(3) as $appointment)
                                    <div class="p-5 rounded-3xl border {{ $appointment->status === 'confirmed' ? 'border-green-100 bg-green-50/30' : 'border-slate-100 bg-slate-50/50' }} transition-all hover:shadow-md">
                                        <div class="flex justify-between items-start mb-3">
                                            <p class="text-xs font-black tracking-widest text-slate-900 leading-tight">{{ $appointment->service_type }}</p>
                                            <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-1 rounded-md 
                                                @if($appointment->status === 'confirmed') bg-emerald-100 text-emerald-700 
                                                @elseif(in_array($appointment->status, ['declined', 'cancelled'])) bg-rose-100 text-rose-700 
                                                @else bg-amber-100 text-amber-700 @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </div>
                                        <div class="space-y-1.5">
                                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                                <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-slate-50 rounded-card border border-dashed border-slate-200">
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">No scheduled appointments</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="pt-8 border-t border-slate-50 mt-8">
                        <a href="{{ route('client.appointments') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900 hover:text-sky-600 transition-colors flex items-center justify-between group">
                            View Full Schedule 
                            <span class="text-sky-600 group-hover:translate-x-2 transition-transform text-xl leading-none">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-10">
                    <h3 class="font-serif text-3xl">Studio Showcase</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @if($recentProjects->count() > 1)
                        <a href="{{ route('portfolio.show', $recentProjects[1]->id) }}" class="group cursor-pointer block">
                            <div class="aspect-video rounded-inner overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-500 border border-slate-100">
                                <img src="{{ asset($recentProjects[1]->image_path) }}" class="w-full h-full object-cover transition-all duration-700">
                            </div>
                            <h4 class="font-serif text-xl text-slate-900">{{ $recentProjects[1]->title }}</h4>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">{{ $recentProjects[1]->category }}</p>
                        </a>
                        @endif
                        @if($recentProjects->count() > 2)
                        <a href="{{ route('portfolio.show', $recentProjects[2]->id) }}" class="group cursor-pointer block">
                            <div class="aspect-video rounded-inner overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-500 border border-slate-100">
                                <img src="{{ asset($recentProjects[2]->image_path) }}" class="w-full h-full object-cover transition-all duration-700">
                            </div>
                            <h4 class="font-serif text-xl text-slate-900">{{ $recentProjects[2]->title }}</h4>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">{{ $recentProjects[2]->category }}</p>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="space-y-10">
                    <div class="bg-slate-900 rounded-card p-6 sm:p-10 text-white shadow-2xl relative overflow-hidden">
                         <p class="text-[10px] font-black uppercase tracking-[0.2em] text-sky-400 mb-6">Studio Note</p>
                         <p class="text-lg font-serif italic leading-relaxed text-slate-200">"Welcome to the portal. Here you can track your modern villa's progress and schedule meetings with Feby Angela."</p>
                         <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    </div>

                    <!-- Removed redundant Next Meeting block -->
                </div>
            </div>

        </div>
    </div>
</x-app-layout>