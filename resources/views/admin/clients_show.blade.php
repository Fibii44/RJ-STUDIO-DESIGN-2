<x-admin-layout>
    <div class="space-y-8">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.clients.index') }}" 
               class="p-3 bg-white hover:bg-slate-50 text-slate-500 hover:text-slate-900 border border-slate-100 rounded-2xl transition-all shadow-sm flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Client <span class="text-sky-600 italic">Profile</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Randolf Jan Studio • Detailed View</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Client Profile Info -->
            <div class="space-y-8">
                <!-- Info Card -->
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-[2rem] bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-3xl border border-sky-100/50 mb-6 shadow-inner">
                        <span>{{ $client->name[0] }}</span>
                    </div>

                    <h4 class="text-xl font-serif text-slate-900 uppercase tracking-wide">{{ $client->name }}</h4>
                    <p class="text-[10px] text-slate-400 font-medium lowercase italic mt-1">@ {{ str_replace(' ', '', strtolower($client->name)) }}</p>

                    <div class="w-full border-t border-slate-50 my-6"></div>

                    <!-- Details Details -->
                    <div class="w-full space-y-4 text-left">
                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Email Address</span>
                            <div class="flex items-center gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-semibold">{{ $client->email }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Phone Number</span>
                            <div class="flex items-center gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-xs font-semibold">{{ $client->phone ?? 'Not provided' }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Billing Address</span>
                            <div class="flex items-start gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-xs font-semibold leading-relaxed">{{ $client->address ?? 'Not provided' }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Member Since</span>
                            <div class="flex items-center gap-2 text-slate-700">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-semibold">{{ $client->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Consultations History -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 md:p-12">
                    <header class="mb-8 flex justify-between items-center">
                        <div>
                            <h4 class="text-xl font-serif text-slate-900">Consultation <span class="text-sky-600 italic">History</span></h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">All booking requests and appointments from this client.</p>
                        </div>
                        <div class="px-4 py-1.5 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-black text-slate-900 uppercase tracking-widest">
                            {{ $client->appointments->count() }} total bookings
                        </div>
                    </header>

                    @if($client->appointments->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center border-2 border-dashed border-slate-100 rounded-[2rem] p-8">
                            <div class="w-16 h-16 rounded-[1.25rem] bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h5 class="text-sm font-bold text-slate-700 uppercase tracking-wider">No Bookings Yet</h5>
                            <p class="text-xs text-slate-400 max-w-xs mt-1">This client hasn't scheduled any consultations or appointments with the studio yet.</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($client->appointments as $appointment)
                                <div class="py-6 first:pt-0 last:pb-0 flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-0.5 rounded-inner border border-slate-100">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                                        </div>

                                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                            {{ $appointment->message ?? 'No special request message provided.' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4 shrink-0">
                                        <!-- Status Badge -->
                                        @if($appointment->status === 'confirmed')
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-[9px] font-black text-emerald-600 uppercase tracking-widest">
                                                Confirmed
                                            </span>
                                        @elseif($appointment->status === 'pending')
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-amber-50 border border-amber-100 text-[9px] font-black text-amber-600 uppercase tracking-widest">
                                                Pending
                                            </span>
                                        @elseif($appointment->status === 'declined')
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-rose-50 border border-rose-100 text-[9px] font-black text-rose-600 uppercase tracking-widest">
                                                Declined
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                                {{ $appointment->status }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
