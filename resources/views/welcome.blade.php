<x-studio-layout title="Home | RJ DESIGN STUDIO">
    <main class="relative min-h-screen">
        <!-- Hero Section -->
        <header class="relative min-h-screen flex items-center bg-white pt-24 lg:pt-28 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-5">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-sky-500 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-sky-200 rounded-full blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 w-full relative z-10 py-12">
                <!-- Top Row: Giant Title + Description -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-16 relative z-10">
                    <!-- Left Column: Giant Title (Span 8) -->
                    <div class="lg:col-span-8">
                        <h1 class="text-5xl md:text-7xl lg:text-[5.5rem] xl:text-[6.5rem] font-serif text-slate-900 leading-tight">
                            Built for <br>
                            <span class="text-sky-600 italic">Perspective</span>
                        </h1>
                    </div>

                    <!-- Right Column: Description Text (Span 4) -->
                    <div class="lg:col-span-4 pb-2">
                        <p class="text-sm lg:text-base text-slate-500 leading-relaxed font-medium">
                            Where architectural vision meets engineering precision. We design and build modern spaces that redefine human-centered living.
                        </p>
                    </div>
                </div>

                <!-- Bottom Row: Wide Image Banner overlapping the text -->
                <div class="relative w-full z-20 -mt-16 md:-mt-28 lg:-mt-40 xl:-mt-48">
                    <img src="{{ asset('images/home-pic.webp') }}?v={{ filemtime(public_path('images/home-pic.webp')) }}" alt="Modern Architecture" class="w-full h-auto filter drop-shadow-[0_25px_50px_rgba(0,0,0,0.12)]">
                </div>
            </div>
        </header>

        <!-- Gallery Preview -->
        <section class="py-32 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex justify-between items-end mb-16">
                    <div class="space-y-2">
                        <h2 class="text-4xl font-serif text-slate-900">Featured Perspectives</h2>
                        <p class="text-slate-400 font-medium">A glimpse into our recent structural designs.</p>
                    </div>
                    <a href="{{ route('portfolio') }}" class="text-[10px] font-black uppercase tracking-widest text-sky-600 hover:underline">View All &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($featuredProjects as $index => $project)
                    <div class="space-y-6 group {{ $index === 1 ? 'md:translate-y-12' : '' }}">
                        <div class="aspect-square rounded-card overflow-hidden bg-slate-50 border border-slate-100 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="{{ asset($project->image_path) }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                        </div>
                        <h4 class="font-serif text-xl px-4">{{ $project->title }}</h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</x-studio-layout>