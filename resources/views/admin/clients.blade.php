<x-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Client <span class="text-sky-600 italic">Directory</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">User Management • Randolf Jan Studio</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="px-6 py-2 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                    {{ count($clients) }} Total Clients
                </div>
            </div>
        </div>

        <!-- Client List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Client Profile</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Contact Info</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Account Created</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Consultations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($clients as $client)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-sm border border-sky-100/50 group-hover:scale-110 transition-transform">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $client->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium lowercase italic">@ {{ str_replace(' ', '', strtolower($client->name)) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-[10px] font-medium text-slate-600">{{ $client->email }}</p>
                                        </div>
                                        @if($client->phone)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            <p class="text-[10px] font-medium text-slate-600">{{ $client->phone }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-slate-900">{{ $client->created_at->format('M d, Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $client->created_at->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100">
                                        <span class="text-[10px] font-black text-slate-900">{{ $client->appointments->count() }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-2">Bookings</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic">No clients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
