<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 dark:text-white leading-tight">
                    Your <span class="text-sky-600 italic">Consultations</span>
                </h2>
                <p class="text-sm font-medium text-slate-500">Track the status of your RJ Studio project briefs.</p>
            </div>
            <a href="{{ route('services') }}" class="inline-flex items-center px-8 py-3.5 bg-slate-900 dark:bg-sky-600 text-white rounded-xl font-bold text-sm hover:scale-105 transition shadow-xl">
                New Request
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6">
                @forelse($appointments as $appointment)
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 px-8 py-2 rounded-bl-[1.5rem] text-[10px] font-black uppercase tracking-widest
                            {{ $appointment->status === 'confirmed' ? 'bg-green-500 text-white' : 
                               ($appointment->status === 'cancelled' ? 'bg-red-500 text-white' : 'bg-amber-500 text-white') }}">
                            {{ $appointment->status }}
                        </div>

                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                            <div class="flex items-start gap-6">
                                <div class="w-16 h-16 bg-sky-50 dark:bg-sky-950 flex flex-col items-center justify-center rounded-2xl border border-sky-100 dark:border-sky-900 shrink-0">
                                    <span class="text-[10px] font-bold text-sky-600 uppercase">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</span>
                                    <span class="text-2xl font-bold text-sky-900 dark:text-white leading-none">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-serif text-slate-900 dark:text-white">{{ $appointment->service_type }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 mt-2">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $appointment->location ?? 'Virtual Consultation' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 lg:max-w-md p-4 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Project Brief</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400 italic line-clamp-2">"{{ $appointment->message ?? 'No additional details provided.' }}"</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-24 bg-white dark:bg-slate-900 rounded-[3rem] border border-dashed border-slate-200 dark:border-slate-800">
                        <p class="text-slate-400 font-serif text-xl">No appointments found yet.</p>
                        <a href="{{ route('services') }}" class="text-sky-600 font-bold uppercase text-[10px] tracking-widest mt-4 inline-block">Start your project brief &rarr;</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>