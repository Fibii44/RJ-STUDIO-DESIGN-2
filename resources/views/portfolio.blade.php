<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portfolio | RJ DESIGN STUDIO</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans">
        
        @include('layouts.navigation')

        <main class="pt-32 pb-24">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 pt-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-1">
                        <span class="text-sky-600 font-bold uppercase tracking-[0.3em] text-[10px]">Excellence in Design</span>
                        <h1 class="font-serif text-5xl lg:text-7xl text-slate-900 dark:text-white leading-tight">
                            Selected <span class="text-sky-600 italic">Works</span>
                        </h1>
                    </div>
                    <p class="text-slate-500 max-w-sm text-sm leading-relaxed">
                        A curation of residential, commercial, and technical projects developed by Feby and the RJ Studio team.
                    </p>
                </div>
                
                <div class="flex gap-8 border-b border-slate-100 dark:border-slate-800 mt-16 pb-4 overflow-x-auto whitespace-nowrap">
                    <button class="text-[10px] font-bold uppercase tracking-widest text-sky-600 border-b-2 border-sky-600 pb-4 -mb-4.5">All Projects</button>
                    <button class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Residential</button>
                    <button class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Commercial</button>
                    <button class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-sky-600 transition">IoT Integrated</button>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
                    
                    <div class="group cursor-pointer">
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=1200" alt="Villa Modern" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
                            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                        </div>
                        <div class="mt-8 flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-serif text-slate-900 dark:text-white">Villa Modern Residence</h3>
                                <p class="text-xs text-slate-500 mt-2 font-medium uppercase tracking-widest">Minimalist Residential • 2025</p>
                            </div>
                            <span class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>

                    <div class="group cursor-pointer">
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                            <img src="https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&q=80&w=1200" alt="Smart Hub" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
                            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                        </div>
                        <div class="mt-8 flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-serif text-slate-900 dark:text-white">The Cyan Tech Hub</h3>
                                <p class="text-xs text-slate-500 mt-2 font-medium uppercase tracking-widest">IoT Integrated Office • 2026</p>
                            </div>
                            <span class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>

                    <div class="group cursor-pointer">
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                            <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&q=80&w=1200" alt="Studio Exterior" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
                            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                        </div>
                        <div class="mt-8 flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-serif text-slate-900 dark:text-white">Brutalist Workspace</h3>
                                <p class="text-xs text-slate-500 mt-2 font-medium uppercase tracking-widest">Commercial Design • 2024</p>
                            </div>
                            <span class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>

                    <div class="group cursor-pointer">
                        <div class="aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=1200" alt="Landscape Design" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-1000 grayscale group-hover:grayscale-0">
                            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                        </div>
                        <div class="mt-8 flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-serif text-slate-900 dark:text-white">Serene Garden Pavilion</h3>
                                <p class="text-xs text-slate-500 mt-2 font-medium uppercase tracking-widest">Landscape & Eco • 2025</p>
                            </div>
                            <span class="w-10 h-10 rounded-full border border-slate-200 dark:border-slate-800 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <footer class="py-12 border-t border-slate-100 dark:border-slate-900 text-center">
            <p class="text-sm text-slate-400 italic">RJ Design Studio &bull; Architecture & Technology</p>
        </footer>
    </body>
</html>