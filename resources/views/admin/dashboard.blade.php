<x-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Studio <span class="text-sky-600 italic">Command Center</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Operational Overview • Randolf Jan Studio</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Current Session</p>
                <p class="text-xs font-bold text-slate-900">{{ now()->format('F d, Y') }}</p>
            </div>
        </div>

        @if($ongoingAppointment)
        <!-- Ongoing Appointment Alert -->
        <div class="relative overflow-hidden bg-slate-900 rounded-card p-8 lg:p-10 shadow-2xl group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-sky-600/20 blur-[100px] rounded-full -mr-20 -mt-20 transition-all group-hover:bg-sky-500/30"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="space-y-3 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-500/10 border border-sky-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-sky-500">Active Schedule Detected</span>
                    </div>
                    <h4 class="text-2xl font-serif text-white">Next Appointment with <span class="text-sky-400 italic">{{ $ongoingAppointment->user->name }}</span></h4>
                    <p class="text-slate-400 text-xs max-w-lg">Scheduled for {{ \Carbon\Carbon::parse($ongoingAppointment->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($ongoingAppointment->appointment_time)->format('h:i A') }}. Click to view details and manage.</p>
                </div>
                
                <a href="{{ route('admin.appointments.index') }}" class="px-8 py-4 bg-white text-slate-900 rounded-btn font-black uppercase text-[10px] tracking-widest hover:bg-sky-600 hover:text-white transition-all shadow-xl">
                    Open Appointment Portal
                </a>
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Total Users -->
            <div class="bg-white p-8 rounded-card border border-slate-100 shadow-sm hover:shadow-xl hover:border-sky-100 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-inner bg-slate-50 flex items-center justify-center group-hover:bg-sky-50 transition-all text-slate-400 group-hover:text-sky-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Network</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 leading-none">{{ $totalUsers }}</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase">Users</span>
                </div>
            </div>

            <!-- Total Projects -->
            <div class="bg-white p-8 rounded-card border border-slate-100 shadow-sm hover:shadow-xl hover:border-sky-100 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-inner bg-slate-50 flex items-center justify-center group-hover:bg-sky-50 transition-all text-slate-400 group-hover:text-sky-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Curation</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 leading-none">{{ $totalProjects }}</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase">Projects</span>
                </div>
            </div>

            <!-- Upcoming Appointments (Confirmed) -->
            <div class="bg-white p-8 rounded-card border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-inner bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Upcoming</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-emerald-600 leading-none">{{ $upcomingAppointments }}</span>
                    <span class="text-[9px] font-bold text-emerald-600/50 uppercase tracking-widest">Active</span>
                </div>
            </div>

            <!-- Declined Appointments -->
            <div class="bg-white p-8 rounded-card border border-slate-100 shadow-sm hover:shadow-xl hover:border-rose-100 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-inner bg-rose-50 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Declined</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-rose-600 leading-none">{{ $declinedAppointments }}</span>
                    <span class="text-[9px] font-black text-rose-600/50 uppercase tracking-widest">Archive</span>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="bg-white p-8 rounded-card border border-slate-100 shadow-sm hover:shadow-xl hover:border-sky-100 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-inner bg-slate-50 flex items-center justify-center group-hover:bg-sky-50 transition-all text-slate-400 group-hover:text-sky-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Registry</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-slate-900 leading-none">{{ $totalAppointments }}</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase">Consults</span>
                </div>
            </div>
        </div>

        <!-- Recent Appointments Table -->
        <div class="bg-white rounded-card border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-serif text-slate-900">Recent Requests</h4>
                </div>
                <a href="{{ route('admin.appointments.index') }}" class="px-6 py-2.5 bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-btn text-[9px] font-black uppercase tracking-widest transition-all">
                    View All
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[9px] font-black uppercase tracking-widest text-slate-400">Client</th>
                            <th class="px-8 py-4 text-[9px] font-black uppercase tracking-widest text-slate-400">Service</th>
                            <th class="px-8 py-4 text-[9px] font-black uppercase tracking-widest text-slate-400">Schedule</th>
                            <th class="px-8 py-4 text-[9px] font-black uppercase tracking-widest text-slate-400 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($latestAppointments as $appointment)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-[10px]">
                                            {{ substr($appointment->first_name, 0, 1) }}{{ substr($appointment->last_name, 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-700">{{ $appointment->first_name }} {{ $appointment->last_name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-xs font-medium text-slate-500">{{ $appointment->service_type }}</td>
                                <td class="px-8 py-4 text-xs font-medium text-slate-500">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d') }}
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest
                                        @if($appointment->status === 'pending') bg-amber-50 text-amber-600
                                        @elseif($appointment->status === 'confirmed') bg-emerald-50 text-emerald-600
                                        @elseif($appointment->status === 'declined') bg-rose-50 text-rose-600
                                        @else bg-slate-50 text-slate-400 @endif">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 text-xs font-medium italic">No recent appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Design Philosophy Placeholder -->
        <div class="bg-slate-50 p-12 rounded-card border border-slate-100 text-center space-y-4">
            <div class="inline-block px-4 py-1.5 rounded-full bg-white border border-slate-200 text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Studio Insight</div>
            <h5 class="text-3xl font-serif text-slate-900 leading-tight italic">"Good architecture is like a good conversation. <br>It should listen as much as it speaks."</h5>
            <p class="text-slate-400 text-xs font-medium">— Randolf Jan Design Studio</p>
        </div>
    </div>
</x-admin-layout>