<x-admin-layout>
    <div class="space-y-8">
        <!-- Header (Matching Construction Financials Index style) -->
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-3xl font-serif text-slate-900">Labor <span class="text-sky-600 italic">Tracker</span></h3>
                <p class="text-[10px] text-slate-400 font-black tracking-[0.2em]">Workforce Management • Global Labor Tracker</p>
            </div>
            <div class="flex gap-4 no-print">
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-6 py-2.5 flex items-center gap-4">
                    <div>
                        <p class="text-[8px] font-black text-indigo-400 uppercase tracking-widest">Total Labor Spent</p>
                        <p class="text-base font-bold text-indigo-600 italic">₱{{ number_format($totalLaborSpent, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl">
            <!-- Summary Card Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
                <!-- Total Labor Cost -->
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4">Global Manpower Cost</p>
                    <h3 class="text-3xl font-semibold text-slate-900 truncate">₱{{ number_format($totalLaborSpent, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest uppercase">Cumulative Value</span>
                    </div>
                </div>

                <!-- Total Entries -->
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4">Total Service Logs</p>
                    <h3 class="text-3xl font-semibold text-slate-900 truncate">{{ $labors->total() }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest uppercase">Active Records</span>
                    </div>
                </div>

                <!-- Project Coverage -->
                @php 
                    $uniqueProjects = $labors->pluck('construction_project_id')->unique()->count();
                @endphp
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4">Project Coverage</p>
                    <h3 class="text-3xl font-semibold text-slate-900 truncate">{{ $uniqueProjects }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest uppercase">Assigned Sites</span>
                    </div>
                </div>

                <!-- Avg Rate -->
                @php 
                    $avg = $labors->total() > 0 ? $totalLaborSpent / $labors->total() : 0;
                @endphp
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4">Avg. Cost / Entry</p>
                    <h3 class="text-3xl font-semibold text-slate-900 truncate">₱{{ number_format($avg, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest uppercase">Unit Rate</span>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-card flex items-center gap-4 text-emerald-600 shadow-sm mb-8">
                <div class="w-10 h-10 rounded-inner bg-emerald-500 flex items-center justify-center text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Main List -->
            <x-studio-table title="Global workforce Management" subtitle="Master list of all professional services and labor logs">
                <x-slot name="headers">
                    <th class="px-10 py-6 text-[10px] font-bold text-slate-400">Date</th>
                    <th class="px-10 py-6 text-[10px] font-bold text-slate-400">Description / Service</th>
                    <th class="px-10 py-6 text-[10px] font-bold text-slate-400">Project Assignment</th>
                    <th class="px-10 py-6 text-[10px] font-bold text-slate-400 text-right">Fee Amount</th>
                    <th class="px-10 py-6 text-[10px] font-bold text-slate-400 text-center">Actions</th>
                </x-slot>

                @forelse($labors as $labor)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="px-10 py-7 whitespace-nowrap">
                            <span class="text-[10px] font-bold text-slate-400">
                                {{ $labor->labor_date ? \Carbon\Carbon::parse($labor->labor_date)->format('M d, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="px-10 py-7">
                            <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                {{ $labor->description }}
                            </p>
                            @if($labor->notes)
                                <p class="text-[8px] text-slate-400 font-medium mt-1 italic">{{ Str::limit($labor->notes, 50) }}</p>
                            @endif
                        </td>
                        <td class="px-10 py-7">
                            @if($labor->constructionProject)
                                <a href="{{ route('admin.budgets.show', $labor->constructionProject) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg text-[9px] font-bold text-slate-500 hover:bg-sky-50 hover:text-sky-600 transition-all border border-slate-100 group/badge">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover/badge:text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M12 21v-3m0 0V7"/></svg>
                                    {{ $labor->constructionProject->title }}
                                </a>
                            @else
                                <span class="text-[9px] font-bold text-slate-300 italic">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-10 py-7 text-right">
                            <span class="text-xs font-semibold text-indigo-600 tracking-tight">₱{{ number_format($labor->amount, 2) }}</span>
                        </td>
                        <td class="px-10 py-7 text-center">
                            <form action="{{ route('admin.labors.destroy', $labor) }}" method="POST" onsubmit="return confirm('Remove this labor record?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-2 text-slate-300 hover:text-red-500 transition-all transform hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center text-slate-300 italic text-xs">
                            No workforce expenditures recorded across any projects yet.
                        </td>
                    </tr>
                @endforelse

                <x-slot name="footer">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400">Showing {{ $labors->count() }} total global labor records</p>
                        <div class="no-print">
                            {{ $labors->links() }}
                        </div>
                    </div>
                </x-slot>
            </x-studio-table>
        </div>
    </div>
</x-admin-layout>
