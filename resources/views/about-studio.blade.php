<x-studio-layout title="About | RJ DESIGN STUDIO">
    <main class="pt-40 pb-32 sky-mesh min-h-screen overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-24">
            <div class="space-y-6">
                <h1 class="font-serif text-4xl lg:text-7xl text-slate-900 leading-tight">
                    About <span class="text-sky-600 italic">the Studio</span>
                </h1>
                @guest
                <p class="text-xl text-slate-500 max-w-2xl leading-relaxed">Defining the intersection of structural integrity and digital innovation.</p>
                @endguest
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-40">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="relative">
                    <div class="aspect-[4/5] rounded-card overflow-hidden shadow-premium border border-slate-100">
                        <img src="{{ asset('images/about-pic.webp') }}" alt="RJ Studio Workspace" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-10 -right-10 p-12 bg-slate-900 text-white rounded-card shadow-2xl hidden md:block border-[12px] border-white">
                        <p class="text-6xl font-serif">2024</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-sky-400 mt-3">Studio Established</p>
                    </div>
                </div>

                <div class="space-y-10">
                    <h3 class="text-4xl lg:text-6xl font-serif text-slate-900 leading-tight">From your vision to <br> <span class="italic text-sky-600">Final Construction.</span></h3>
                    
                    <div class="text-slate-500 leading-relaxed text-lg space-y-6">
                        <p>
                            An <strong class="text-slate-900">Experienced Design and Construction Firm</strong> specialized in preparing Architectural and Engineering design and plans for Residential & Commercial Buildings and Infrastructures, that also accepts construction supervisions and workscopes.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 pt-6">
                        <div class="p-10 rounded-card bg-white shadow-sm border border-slate-100 transition-all hover:shadow-premium group">
                            <span class="inline-block px-4 py-1.5 bg-sky-50 text-sky-600 rounded-full text-[9px] font-black uppercase tracking-[0.2em] mb-6">Service 01</span>
                            <p class="font-serif text-2xl text-slate-900 mb-2">Architectural Design</p>
                            <p class="text-sm text-slate-400 leading-relaxed">Bespoke planning, 3D modeling, and technical blueprints.</p>
                        </div>
                        <div class="p-10 rounded-card bg-white shadow-sm border border-slate-100 transition-all hover:shadow-premium group">
                            <span class="inline-block px-4 py-1.5 bg-sky-50 text-sky-600 rounded-full text-[9px] font-black uppercase tracking-[0.2em] mb-6">Service 02</span>
                            <p class="font-serif text-2xl text-slate-900 mb-2">Professional Build</p>
                            <p class="text-sm text-slate-400 leading-relaxed">Realizing the design through expert engineering.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-card border border-slate-100 p-12 lg:p-24 flex flex-col lg:flex-row items-center gap-20 shadow-premium relative">
                <div class="w-64 h-64 lg:w-96 lg:h-96 rounded-card overflow-hidden border-[15px] border-slate-50 shadow-inner shrink-0 rotate-3">
                    <img src="{{ asset('/images/RJ-pic.webp') }}" alt="Randolf Jan H. Felices" class="w-full h-full object-cover transition-all duration-1000 scale-110">
                </div>
                <div class="text-center lg:text-left space-y-8 relative z-10">
                    <div class="space-y-3">
                        <h3 class="text-5xl font-serif text-slate-900 leading-none">Randolf Jan H. Felices</h3>
                        <p class="text-sky-600 font-black uppercase tracking-[0.3em] text-[10px]">Lead Architect</p>
                    </div>
                    <div class="text-slate-500 leading-relaxed text-lg max-w-2xl space-y-6">
                        <p class="text-2xl font-serif italic text-slate-800">
                            "Visionary behind RJ Design Studio, Randolf Jan bridges the gap between architectural planning and digital functionality."
                        </p>
                        <p class="text-base">
                            His practice is rooted in <span class="font-bold text-sky-600">"Perspective"</span>—ensuring every structure is accessible, transparent, and built to last for generations.
                        </p>
                    </div>
                    <div class="flex justify-center lg:justify-start gap-12 pt-6">
                        <div class="flex flex-col gap-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Network</span>
                            <div class="flex gap-8">
                                <a href="#" class="text-[10px] font-black uppercase tracking-widest text-slate-900 hover:text-sky-600 transition">LinkedIn</a>
                                <a href="#" class="text-[10px] font-black uppercase tracking-widest text-slate-900 hover:text-sky-600 transition">Behance</a>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Direct</span>
                            <a href="{{ route('portfolio') }}" class="text-[10px] font-black uppercase tracking-widest text-sky-600 hover:underline transition">View Portfolio &rarr;</a>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-sky-50/50 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
            </div>
        </div>
    </main>

    @push('styles')
    <style>
        .sky-mesh {
            background-color: #ffffff;
            background-image: radial-gradient(at 0% 0%, hsla(202,100%,97%,1) 0, transparent 50%), 
                                radial-gradient(at 50% 0%, hsla(199,100%,98%,1) 0, transparent 50%), 
                                radial-gradient(at 100% 0%, hsla(190,100%,97%,1) 0, transparent 50%);
        }
    </style>
    @endpush
</x-studio-layout>