<x-studio-layout title="Home | RJ DESIGN STUDIO">
    <main class="relative min-h-screen">
        <!-- Hero Section -->
        <header class="relative min-h-screen flex items-center bg-white pt-32 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-5">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-sky-500 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-sky-200 rounded-full blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 w-full grid lg:grid-cols-2 gap-12 items-center relative z-10">
                <div class="space-y-8">
                    <h1 class="text-5xl lg:text-8xl font-serif tracking-tight leading-[1.1] text-slate-900">
                        Built for <br><span class="text-sky-600 italic">Perspective.</span>
                    </h1>
                    <p class="text-xl text-slate-500 max-w-lg leading-relaxed font-medium">
                        Architectural excellence meets structural precision. We design and build modern spaces that redefine living.
                    </p>
                    <div class="flex flex-wrap gap-6 pt-4">
                        <a href="{{ route('portfolio') }}" class="px-10 py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-600 hover:translate-y-[-4px] transition-all duration-300 shadow-2xl shadow-slate-900/20">
                            Explore Works
                        </a>
                        <a href="{{ route('services') }}" class="px-10 py-5 bg-white text-slate-900 border border-slate-200 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:border-sky-600 hover:translate-y-[-4px] transition-all duration-300">
                            Our Services
                        </a>
                    </div>
                </div>

                <div class="relative group">
                    <div class="aspect-[4/5] rounded-[4rem] overflow-hidden shadow-premium rotate-2 group-hover:rotate-0 transition-all duration-1000 border-[12px] border-white relative z-10 bg-slate-50">
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=1000" alt="Modern Architecture" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                    </div>
                    <div class="absolute -inset-4 bg-sky-100 rounded-[5rem] -z-0 blur-2xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
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
                    <div class="space-y-6 group">
                        <div class="aspect-square rounded-[3rem] overflow-hidden bg-slate-50 border border-slate-100 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <h4 class="font-serif text-xl px-4">Modern Villa Concept</h4>
                    </div>
                    <div class="space-y-6 group md:translate-y-12">
                        <div class="aspect-square rounded-[3rem] overflow-hidden bg-slate-50 border border-slate-100 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="https://images.unsplash.com/photo-1600566753190-17f0bb2a6c3e?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <h4 class="font-serif text-xl px-4">Minimalist Interior</h4>
                    </div>
                    <div class="space-y-6 group">
                        <div class="aspect-square rounded-[3rem] overflow-hidden bg-slate-50 border border-slate-100 shadow-sm group-hover:shadow-xl transition-all duration-500">
                            <img src="https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        </div>
                        <h4 class="font-serif text-xl px-4">Urban Residential</h4>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-studio-layout>