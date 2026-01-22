<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RJ DESIGN STUDIO | Architecture & Planning</title>

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

        <header class="relative min-h-screen flex items-center sky-mesh pt-32">
            <div class="max-w-7xl mx-auto px-6 w-full grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 text-xs font-bold tracking-widest uppercase">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        Architectural Studio 2026
                    </div>
                    <h1 class="text-5xl lg:text-8xl font-serif tracking-tight leading-[1.1]">
                        Built for <br><span class="text-sky-600 italic">Perspective.</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-md leading-relaxed">
                        Transforming concepts into structural reality. RJ Design Studio specializes in modern residential and commercial architecture.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 dark:bg-sky-600 text-white rounded-xl font-bold text-center hover:translate-y-[-2px] transition-all shadow-xl shadow-slate-200 dark:shadow-none">
                            Schedule a Consultation
                        </a>
                        <a href="#portfolio" class="px-8 py-4 border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-transparent rounded-xl font-bold text-center hover:bg-white transition-all">
                            View Portfolio
                        </a>
                    </div>
                </div>

                <div class="relative lg:h-[600px]">
                    <div class="h-full rounded-[2rem] overflow-hidden shadow-2xl relative group">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1200" alt="Studio Interior" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex items-end p-10">
                            <p class="text-white text-xl font-serif italic">"Form follows function, but both follow emotion."</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section id="portfolio" class="py-24 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="mb-16">
                    <h2 class="text-3xl font-serif mb-2 text-slate-900 dark:text-white">Selected Works</h2>
                    <p class="text-slate-500">A glimpse into our architectural philosophy.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $projects = [
                            ['name' => 'The Glass Pavilion', 'tag' => 'Residential', 'img' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600'],
                            ['name' => 'Cyan Office Hub', 'tag' => 'Commercial', 'img' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=600'],
                            ['name' => 'Minimalist Retreat', 'tag' => 'Eco-Design', 'img' => 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=600'],
                        ];
                    @endphp

                    @foreach($projects as $project)
                    <div class="group cursor-pointer">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden mb-4 relative">
                            <img src="{{ $project['img'] }}" alt="{{ $project['name'] }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest text-sky-600">
                                {{ $project['tag'] }}
                            </div>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white">{{ $project['name'] }}</h3>
                        <p class="text-sm text-slate-500">View Project Details &rarr;</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="services" class="py-24">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-sky-600 rounded-[3rem] p-12 lg:p-20 text-center text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-4xl lg:text-5xl font-serif mb-6">Ready to start your project?</h2>
                        <p class="text-sky-100 mb-10 max-w-md mx-auto">Join our client portal to schedule a meeting, track design progress, and manage documents.</p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-sky-600 rounded-xl font-bold hover:bg-sky-50 transition-colors">Create Client Account</a>
                            <a href="{{ route('login') }}" class="px-10 py-4 border border-white/30 rounded-xl font-bold hover:bg-white/10 transition-colors">Log In</a>
                        </div>
                    </div>
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-sky-500 rounded-full opacity-50"></div>
                </div>
            </div>
        </section>

        <footer class="py-12 border-t border-slate-100 dark:border-slate-900">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2 grayscale opacity-50">
                    <div class="w-6 h-6 bg-slate-900 rounded flex items-center justify-center font-bold text-white text-[10px]">RJ</div>
                    <span class="font-bold text-sm uppercase tracking-tighter text-slate-900 dark:text-white">RJ Design Studio</span>
                </div>
                <p class="text-slate-400 text-sm italic">Created by Feby &bull; Architecting the Future</p>
                <div class="flex gap-8 text-sm font-medium text-slate-500">
                    <a href="#" class="hover:text-sky-600">Privacy</a>
                    <a href="#" class="hover:text-sky-600">Terms</a>
                </div>
            </div>
        </footer>

    </body>
</html>