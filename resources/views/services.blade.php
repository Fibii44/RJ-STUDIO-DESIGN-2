<x-studio-layout title="Our Services | RJ DESIGN STUDIO">
    <main class="pt-40 pb-32 overflow-hidden" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-24 pt-10 text-center relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl -z-10"></div>
            
            <h1 class="font-serif text-5xl lg:text-7xl text-slate-900 leading-tight"
                x-show="loaded" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-8">
                Tailored <span class="text-sky-600 italic">Execution.</span>
            </h1>
            
            @guest
            <p class="mt-10 text-slate-500 max-w-2xl mx-auto text-xl leading-relaxed"
               x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-200" x-transition:enter-start="opacity-0 translate-y-4">
                Elevating architectural standards through precision design, management, and innovative construction solutions.
            </p>
            @endguest
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-stretch">
                
                <!-- Package 01 -->
                <div class="p-12 rounded-card bg-white border border-slate-100 flex flex-col justify-between group hover:scale-[1.02] transition-all duration-500 hover:shadow-premium"
                     x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-300" x-transition:enter-start="opacity-0 translate-y-12">
                    <div>
                        <div class="w-16 h-16 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600 mb-10 group-hover:rotate-6 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        
                        <h3 class="text-4xl font-serif mb-6 leading-tight">Architectural <br><span class="text-sky-600">Design</span></h3>
                        <p class="text-slate-500 leading-relaxed mb-12 text-base">Focus on the vision. We provide complete blueprints, 3D renderings, and technical specifications ready for construction.</p>
                        
                        <ul class="space-y-6 mb-16">
                            <li class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-800">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                Schematic Drawings
                            </li>
                            <li class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-800">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                3D Visualizations
                            </li>
                        </ul>
                    </div>
                    <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Architectural Design']) : route('register') }}" 
                       class="w-full py-6 rounded-inner bg-slate-900 text-white text-center text-[10px] font-black uppercase tracking-[0.3em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10">
                       {{ Auth::check() ? 'Book Consultation' : 'Inquire for Design' }}
                    </a>
                </div>

                <!-- Package: Featured (Design & Build) -->
                <div class="p-12 rounded-card bg-slate-900 text-white shadow-premium flex flex-col justify-between transform md:-translate-y-8 relative overflow-hidden group hover:scale-[1.03] transition-all duration-700"
                     x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-400" x-transition:enter-start="opacity-0 translate-y-12">
                    
                    <div class="absolute top-0 right-0 w-72 h-72 bg-sky-600/20 rounded-full blur-3xl -z-0"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-inner bg-white/10 flex items-center justify-center text-sky-400 mb-10 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>

                        <h3 class="text-4xl font-serif mb-8 text-white leading-tight">Design & <span class="text-sky-400 italic">Build</span></h3>
                        <p class="text-sky-100/70 leading-relaxed mb-12 text-lg">The ultimate all-in-one package. We manage the entire lifecycle of your project, from the initial architectural drawings to the final structural build.</p>
                        
                        <ul class="space-y-8 mb-16">
                            <li class="flex items-center gap-5 text-[10px] font-black uppercase tracking-widest text-white">
                                <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                End-to-End Management
                            </li>
                            <li class="flex items-center gap-5 text-[10px] font-black uppercase tracking-widest text-white">
                                <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Unified Design & Build
                            </li>
                            <li class="flex items-center gap-5 text-[10px] font-black uppercase tracking-widest text-white">
                                <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Structural Integrity
                            </li>
                        </ul>
                    </div>
                    <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Design & Build']) : route('register') }}" 
                       class="w-full py-7 rounded-card bg-sky-600 text-white text-center text-[10px] font-black uppercase tracking-[0.3em] hover:bg-white hover:text-sky-600 transition-all shadow-2xl relative z-10">
                       {{ Auth::check() ? 'Start Your Masterpiece' : 'Start Full Project' }}
                    </a>
                </div>

                <!-- Package 02 -->
                <div class="p-12 rounded-card bg-white border border-slate-100 flex flex-col justify-between group hover:scale-[1.02] transition-all duration-500 hover:shadow-premium"
                     x-show="loaded" x-transition:enter="transition ease-out duration-1000 delay-500" x-transition:enter-start="opacity-0 translate-y-12">
                    <div>
                        <div class="w-16 h-16 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600 mb-10 group-hover:-rotate-6 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        </div>
                        
                        <h3 class="text-4xl font-serif mb-6 leading-tight">Professional <br><span class="text-sky-600">Build</span></h3>
                        <p class="text-slate-500 leading-relaxed mb-12 text-base">Bring your existing plans to life. We specialize in high-quality structural execution and project management.</p>
                        
                        <ul class="space-y-6 mb-16">
                            <li class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-800">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                Structural Build-out
                            </li>
                            <li class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-800">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                Site Supervision
                            </li>
                        </ul>
                    </div>
                    <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Construction']) : route('register') }}" 
                       class="w-full py-6 rounded-inner bg-slate-900 text-white text-center text-[10px] font-black uppercase tracking-[0.3em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10">
                       {{ Auth::check() ? 'Book Consultation' : 'Inquire for Build' }}
                    </a>
                </div>

            </div>
        </div>
    </main>
</x-studio-layout>