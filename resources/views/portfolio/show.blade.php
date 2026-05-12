<x-studio-layout title="{{ $project->title }} | RJ DESIGN STUDIO">
    <main class="min-h-screen bg-white" x-data='{ 
        activeImg: "", 
        currentIndex: 0,
        images: [
            "{{ asset($project->image_path) }}"
            @if($project->images->count() > 0)
            ,
            @foreach($project->images as $img) "{{ asset($img->path) }}"{{ !$loop->last ? ',' : '' }} @endforeach
            @endif
        ],
        openModal(index) {
            this.currentIndex = index;
            this.activeImg = this.images[index];
            $dispatch("open-modal", "gallery-viewer");
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.activeImg = this.images[this.currentIndex];
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.activeImg = this.images[this.currentIndex];
        }
    }'>
        <!-- Navigation Context -->
        <div class="{{ Auth::check() ? 'pt-12' : 'pt-32' }} px-4 lg:px-8 relative flex items-center justify-center min-h-[40px]">
            <!-- Back Button (Absolute Left) -->
            <div class="absolute left-4 lg:left-8">
                <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-3 group text-slate-400 hover:text-sky-600 transition-all duration-300">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em]">Back to Portfolio</span>
                </a>
            </div>

            <!-- Centered Category -->
            <div class="text-center">
                <span class="text-sky-600 font-black uppercase tracking-[0.4em] text-[9px]">{{ $project->category }}</span>
            </div>
        </div>

        <!-- Project Header -->
        <header class="pt-12 pb-16 px-6 text-center max-w-4xl mx-auto">
            <h1 class="font-serif text-3xl lg:text-5xl text-slate-900 leading-tight tracking-tighter">
                {{ $project->title }}
            </h1>
        </header>

        <!-- Cinematic Hero Image -->
        <section class="px-6 lg:px-12">
            <div class="aspect-[21/9] rounded-3xl overflow-hidden shadow-2xl bg-slate-100 relative group cursor-zoom-in"
                 @click="openModal(0)">
                <img src="{{ asset($project->image_path) }}" class="w-full h-full object-cover transition-transform duration-[30s] ease-linear group-hover:scale-110">
                <div class="absolute inset-0 bg-slate-900/5"></div>
            </div>
        </section>

        <!-- Project Details Section -->
        <section class="py-24 lg:py-40 px-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-20">
                <!-- Left: Description (Long content) -->
                <div class="lg:col-span-8 space-y-12">
                    <div class="space-y-6">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-400">Project Brief & Inclusions</h3>
                        <p class="text-lg lg:text-xl font-serif text-slate-700 leading-relaxed whitespace-pre-line">
                            {{ $project->description ?? 'Every structure tells a story. This project represents the intersection of structural integrity and modern minimalist aesthetics.' }}
                        </p>
                    </div>
                </div>

                <!-- Right: Meta Info -->
                <div class="lg:col-span-4 lg:pl-12 space-y-12 border-l border-slate-100">
                    <div class="grid grid-cols-1 gap-12">
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Architectural Release</p>
                            <p class="font-serif text-3xl text-slate-900">{{ $project->year }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Project Location</p>
                            <p class="font-serif text-3xl text-slate-900 leading-tight">{{ $project->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Showcase -->
        @if($project->images->count() > 0)
        <section class="py-32 bg-slate-50 px-6">
            <div class="max-w-7xl mx-auto space-y-20">
                <div class="text-center space-y-4">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.4em] text-sky-600">Visual Perspectives</h2>
                    <h3 class="text-4xl font-serif text-slate-900">Project Gallery</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($project->images as $index => $image)
                        <div class="group relative rounded-2xl overflow-hidden shadow-sm bg-white border border-slate-100 transition-all duration-700 hover:shadow-2xl cursor-zoom-in"
                             @click="openModal({{ $index + 1 }})">
                            <img src="{{ asset($image->path) }}" class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-105">
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Universal Gallery Modal (Teleported for Centering) -->
        <template x-teleport="body">
            <div x-data="{ show: false }"
                 x-on:open-modal.window="$event.detail == 'gallery-viewer' ? show = true : null"
                 x-on:close-modal.window="$event.detail == 'gallery-viewer' ? show = false : null"
                 x-on:keydown.escape.window="show = false"
                 x-show="show" x-cloak
                 class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-12">
                 
                <!-- Dark Backdrop -->
                <div x-show="show" 
                     x-transition.opacity.duration.500ms 
                     class="absolute inset-0 bg-slate-950/95 backdrop-blur-2xl" 
                     @click="show = false"></div>

                <!-- Image Container -->
                <div x-show="show"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="relative w-full max-w-7xl h-full flex items-center justify-center z-10 group/inner">
                     
                    <!-- Integrated Close Button -->
                    <button @click="show = false" 
                            class="absolute top-0 right-0 lg:-top-6 lg:-right-6 w-12 h-12 bg-white/10 hover:bg-red-500 text-white rounded-full flex items-center justify-center transition-all z-[110] shadow-2xl backdrop-blur-md border border-white/20 group/close">
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    
                    <!-- Nav Buttons -->
                    <template x-if="images.length > 1">
                        <div class="absolute inset-x-0 flex items-center justify-between pointer-events-none z-[100] px-4 lg:-mx-12">
                            <button @click.stop="prev()" class="pointer-events-auto w-14 h-14 bg-white/5 hover:bg-sky-600 backdrop-blur-xl text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/inner:opacity-100 shadow-2xl hover:scale-110">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5"/></svg>
                            </button>
                            <button @click.stop="next()" class="pointer-events-auto w-14 h-14 bg-white/5 hover:bg-sky-600 backdrop-blur-xl text-white rounded-full flex items-center justify-center border border-white/10 transition-all opacity-0 group-hover/inner:opacity-100 shadow-2xl hover:scale-110">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5"/></svg>
                            </button>
                        </div>
                    </template>

                    <img :src="activeImg" class="max-w-full max-h-full object-contain shadow-2xl drop-shadow-2xl rounded-lg" :key="activeImg"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                </div>
            </div>
        </template>

        @guest
        <!-- Simple Footer CTA -->
        <section class="py-32 bg-white text-center">
            <div class="max-w-2xl mx-auto px-6 space-y-12">
                <div class="w-12 h-px bg-slate-200 mx-auto"></div>
                <h3 class="text-4xl lg:text-6xl font-serif text-slate-900 italic leading-tight">Inspired?</h3>
                <a href="{{ route('services') }}" class="inline-block px-12 py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10">
                    Get in Touch
                </a>
            </div>
        </section>
        @endguest
    </main>
</x-studio-layout>
