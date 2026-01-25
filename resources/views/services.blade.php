<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Our Services | RJ DESIGN STUDIO</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans">
        
        @include('layouts.navigation')

        <main class="pt-32 pb-24">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-20 pt-10 text-center">
                <span class="text-sky-600 font-bold uppercase tracking-[0.3em] text-[10px]">Service Packages</span>
                <h1 class="font-serif text-5xl lg:text-7xl text-slate-900 dark:text-white mt-4">
                    Tailored <span class="text-sky-600 italic">Execution.</span>
                </h1>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="text-[10px] font-bold text-sky-600 uppercase tracking-widest mb-6 italic">Package 01</div>
                            <h3 class="text-3xl font-serif mb-4">Architectural Design</h3>
                            <p class="text-sm text-slate-500 leading-relaxed mb-8">Focus on the vision. We provide complete blueprints, 3D renderings, and technical specifications ready for construction.</p>
                            <ul class="space-y-4 mb-10">
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-slate-700 dark:text-slate-300">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Schematic Drawings
                                </li>
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-slate-700 dark:text-slate-300">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    3D Visualizations
                                </li>
                            </ul>
                        </div>
                        <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Architectural Design']) : route('register') }}" 
                           class="w-full py-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center text-xs font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white transition">
                           {{ Auth::check() ? 'Book Consultation' : 'Inquire for Design' }}
                        </a>
                    </div>

                    <div class="p-10 rounded-[3rem] border-2 border-sky-600 bg-sky-600 text-white shadow-2xl shadow-sky-200 dark:shadow-none flex flex-col justify-between transform md:-translate-y-4 relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="text-[10px] font-bold text-sky-200 uppercase tracking-widest mb-6 italic">Most Popular</div>
                            <h3 class="text-3xl font-serif mb-4 text-white">Design & Build</h3>
                            <p class="text-sm text-sky-100 leading-relaxed mb-8">The complete architectural experience. We manage everything from the first sketch to the final brick, including IoT integration.</p>
                            <ul class="space-y-4 mb-10">
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-white">
                                    <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    End-to-End Management
                                </li>
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-white">
                                    <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Smart-Home Tech Setup
                                </li>
                            </ul>
                        </div>
                        <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Design & Build']) : route('register') }}" 
                           class="w-full py-4 rounded-2xl bg-white text-sky-600 text-center text-xs font-bold uppercase tracking-widest hover:bg-sky-50 transition relative z-10">
                           {{ Auth::check() ? 'Book Consultation' : 'Start Full Project' }}
                        </a>
                        
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-sky-500 rounded-full opacity-20"></div>
                    </div>

                    <div class="p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="text-[10px] font-bold text-sky-600 uppercase tracking-widest mb-6 italic">Package 02</div>
                            <h3 class="text-3xl font-serif mb-4">Construction</h3>
                            <p class="text-sm text-slate-500 leading-relaxed mb-8">Bring your existing plans to life. We specialize in high-quality structural execution and project management.</p>
                            <ul class="space-y-4 mb-10">
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-slate-700 dark:text-slate-300">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Structural Build-out
                                </li>
                                <li class="flex items-center gap-3 text-xs font-bold uppercase text-slate-700 dark:text-slate-300">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Site Supervision
                                </li>
                            </ul>
                        </div>
                        <a href="{{ Auth::check() ? route('appointments.create', ['service' => 'Construction']) : route('register') }}" 
                           class="w-full py-4 rounded-2xl border border-slate-200 dark:border-slate-700 text-center text-xs font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white transition">
                           {{ Auth::check() ? 'Book Consultation' : 'Inquire for Build' }}
                        </a>
                    </div>

                </div>
            </div>
        </main>

        <footer class="py-12 border-t border-slate-100 dark:border-slate-900 text-center">
            <p class="text-sm text-slate-400 italic">RJ Design Studio &bull; Architecture & Planning</p>
        </footer>
    </body>
</html>