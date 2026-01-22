<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About | RJ DESIGN STUDIO</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html { scroll-behavior: smooth; }
            .sky-mesh {
                background-color: #f0f9ff;
                background-image: radial-gradient(at 0% 0%, hsla(202,100%,95%,1) 0, transparent 50%), 
                                  radial-gradient(at 50% 0%, hsla(199,100%,92%,1) 0, transparent 50%), 
                                  radial-gradient(at 100% 0%, hsla(190,100%,95%,1) 0, transparent 50%);
            }
            .dark .sky-mesh {
                background-color: #020617;
                background-image: radial-gradient(at 0% 0%, hsla(202,100%,10%,1) 0, transparent 50%);
            }
        </style>
    </head>
    <body class="antialiased bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans">
        
        @include('layouts.navigation')

        <main class="pt-32 pb-24 sky-mesh min-h-screen">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-20 pt-10">
                <div class="space-y-1">
                    <h1 class="font-serif text-5xl lg:text-7xl text-slate-900 dark:text-white leading-tight">
                        About <span class="text-sky-600 italic">the Studio</span>
                    </h1>
                    <p class="text-lg text-slate-500 max-w-2xl leading-relaxed">Defining the intersection of structural integrity and digital innovation.</p>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-32">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl shadow-sky-100 dark:shadow-none border border-slate-100 dark:border-slate-800">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000" alt="RJ Studio Workspace" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-8 -right-8 p-10 bg-sky-600 text-white rounded-[2.5rem] shadow-2xl hidden md:block border-8 border-white dark:border-slate-950">
                            <p class="text-5xl font-serif">2026</p>
                            <p class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-80 mt-2">Design & Build</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <span class="inline-block px-4 py-1 rounded-full bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 text-xs font-bold uppercase tracking-widest">Studio Purpose</span>
                        <h3 class="text-4xl lg:text-5xl font-serif text-slate-900 dark:text-white leading-tight">From your vision to <br> <span class="italic text-sky-600">Final Construction.</span></h3>
                        
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg space-y-4">
                            <p>
                                RJ Design Studio offers a seamless transition between architectural planning and physical reality. We don't just provide drawings; we offer a complete commitment to <strong>Construction</strong>. 
                            </p>
                            <p>
                                When you avail of our services, we take the lead in building your home from the ground up. By managing both the design and the build phases, we ensure that the structural integrity of your house matches the beauty of the original blueprint.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-4">
                            <div class="border-l-4 border-sky-200 dark:border-sky-800 pl-6">
                                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-tighter">Architectural Design</h4>
                                <p class="text-sm text-slate-500 mt-2">Bespoke planning, 3D modeling, and technical blueprints tailored to your lifestyle.</p>
                            </div>
                            <div class="border-l-4 border-sky-200 dark:border-sky-800 pl-6">
                                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-tighter">Professional Construction</h4>
                                <p class="text-sm text-slate-500 mt-2">Realizing the design through expert engineering and on-site management.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                

                <div class="bg-white/50 dark:bg-slate-900/40 backdrop-blur-sm rounded-[4rem] border border-white/50 dark:border-slate-800/50 p-12 lg:p-24 flex flex-col lg:flex-row items-center gap-16 shadow-sm">
                    <div class="w-56 h-56 lg:w-72 lg:h-72 rounded-full overflow-hidden border-[12px] border-white dark:border-slate-800 shadow-2xl shrink-0">
                        <img src="https://i.pravatar.cc/300?u=randolf" alt="Randolf Jan H. Felices" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                    <div class="text-center lg:text-left space-y-6">
                        <div class="space-y-2">
                            <h3 class="text-4xl font-serif text-slate-900 dark:text-white leading-none">Randolf Jan H. Felices</h3>
                            <p class="text-sky-600 font-bold uppercase tracking-[0.2em] text-[10px]">Lead Architect • Principal Developer</p>
                        </div>
                        <div class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg max-w-2xl space-y-4">
                            <p>
                                Randolf Jan is the visionary behind RJ Design Studio. With a unique dual-expertise in architectural planning and software engineering, he bridges the gap between physical space and digital functionality.
                            </p>
                            <p class="text-base italic">
                                Over the years, Randolf has dedicated his practice to ensuring that every client feels involved in the journey. His philosophy is simple: great architecture should be accessible, transparent, and built to last generations.
                            </p>
                            <p class="text-base">
                                His approach to design is rooted in "Perspective"—ensuring that every structure respects its environment while utilizing modern IoT technology to improve the daily lives of its inhabitants.
                            </p>
                        </div>
                        <div class="flex justify-center lg:justify-start gap-8 pt-4">
                            <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-sky-600 transition">LinkedIn</a>
                            <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-sky-600 transition">Behance</a>
                            <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-widest text-sky-600 hover:underline transition">View Portfolio</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-12 border-t border-slate-100 dark:border-slate-900 text-center">
            <p class="text-sm text-slate-400 italic">RJ Design Studio &bull; Architecture & Planning</p>
        </footer>
    </body>
</html>