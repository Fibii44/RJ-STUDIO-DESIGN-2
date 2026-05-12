<x-studio-layout title="{{ $project->title }} | RJ DESIGN STUDIO">
    <main class="min-h-screen bg-white">
        <!-- Minimal Header -->
        <nav class="fixed top-0 left-0 right-0 z-50 px-10 py-8 flex justify-between items-center mix-blend-difference pointer-events-none">
            <a href="{{ route('portfolio') }}" class="pointer-events-auto group flex items-center gap-4 text-white">
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-white group-hover:text-black transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l-7-7m7-7H3" /></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] opacity-0 group-hover:opacity-100 transition-all duration-500">Back to Works</span>
            </a>
        </nav>

        <!-- Hero Section -->
        <section class="h-screen relative overflow-hidden bg-slate-900">
            <img src="{{ asset($project->image_path) }}" class="absolute inset-0 w-full h-full object-cover grayscale opacity-60 scale-105 animate-slow-zoom">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
            
            <div class="absolute inset-x-0 bottom-0 p-10 lg:p-24">
                <div class="max-w-7xl mx-auto space-y-8">
                    <div class="flex items-center gap-4" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
                        <span class="w-3 h-3 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-sky-400 font-black uppercase tracking-[0.5em] text-[10px]" x-show="loaded" x-transition.opacity>{{ $project->category }}</span>
                    </div>
                    <h1 class="font-serif text-6xl lg:text-9xl text-white leading-none tracking-tighter">
                        {{ $project->title }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-12 pt-8 border-t border-white/10">
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-white/30 uppercase tracking-widest">Architectural Release</p>
                            <p class="font-serif text-2xl text-white">{{ $project->year }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-white/30 uppercase tracking-widest">Location</p>
                            <p class="font-serif text-2xl text-white">{{ $project->location ?? 'Design Studio Release' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery / Perspectives -->
        <section class="py-32 lg:py-48 px-10">
            <div class="max-w-7xl mx-auto">
                <div class="mb-32 max-w-2xl">
                    <h2 class="text-sm font-black uppercase tracking-[0.4em] text-slate-400 mb-8">Concept Brief</h2>
                    <p class="text-3xl font-serif text-slate-900 leading-relaxed italic">
                        "{{ $project->description ?? 'Every structure tells a story. This project represents the intersection of structural integrity and modern minimalist aesthetics, designed to maximize natural perspective.' }}"
                    </p>
                </div>

                <!-- Perspective Mosaic -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-20 gap-y-32 lg:gap-y-64">
                    @foreach($project->images as $index => $image)
                        <div class="group {{ $index % 2 != 0 ? 'lg:mt-48' : '' }}" 
                             x-data="{ visible: false }" 
                             x-intersect="visible = true">
                            <div class="relative aspect-[4/5] rounded-[3rem] overflow-hidden bg-slate-50 shadow-premium transition-all duration-700 group-hover:shadow-2xl"
                                 :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                                 style="transition-delay: {{ $index * 100 }}ms">
                                <img src="{{ asset($image->path) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-100 group-hover:scale-105">
                                
                                <div class="absolute top-8 left-8 px-4 py-2 bg-white/40 backdrop-blur-md rounded-full border border-white/20">
                                    <p class="text-[9px] font-black text-slate-900 uppercase tracking-widest">P. 0{{ $index + 1 }}</p>
                                </div>
                            </div>
                            <div class="mt-10 space-y-3">
                                <h4 class="text-2xl font-serif text-slate-900 leading-tight">Perspective Analysis</h4>
                                <p class="text-[10px] font-black text-sky-600 uppercase tracking-[0.4em]">Spatial Detail • {{ $project->year }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Footer Call to Action -->
        @guest
        <section class="py-32 bg-slate-950 text-white text-center">
            <div class="max-w-4xl mx-auto px-6 space-y-12">
                <h3 class="text-5xl lg:text-7xl font-serif leading-tight">Inspired by <br> <span class="text-sky-400 italic">this design?</span></h3>
                <p class="text-slate-400 text-xl leading-relaxed max-w-lg mx-auto">Let's discuss how we can bring a similar architectural perspective to your next project.</p>
                <div class="pt-8">
                    <a href="{{ route('services') }}" class="inline-block px-12 py-6 bg-white text-slate-950 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-400 transition-all shadow-2xl">
                        Start Your Project Brief
                    </a>
                </div>
            </div>
        </section>
        @endguest
    </main>

    <style>
        @keyframes slow-zoom {
            from { transform: scale(1.05); }
            to { transform: scale(1.15); }
        }
        .animate-slow-zoom {
            animation: slow-zoom 20s linear infinite alternate;
        }
    </style>
</x-studio-layout>
