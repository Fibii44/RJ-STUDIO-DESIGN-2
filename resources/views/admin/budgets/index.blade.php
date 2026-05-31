<x-admin-layout>
    <div class="space-y-8" x-data="{ showAddProject: {{ $errors->any() ? 'true' : 'false' }} }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-3xl font-serif text-slate-900">Construction <span class="text-sky-600 italic">Financials</span></h3>
                <p class="text-[11px] text-slate-400 font-bold">Project Capital Management • Construction Financials</p>
            </div>
            <div class="flex gap-4">
                <x-primary-button @click="showAddProject = true" class="gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Project
                </x-primary-button>
            </div>
        </div>


        <!-- Project Breakdown -->
        <x-studio-table 
            title="Active Construction Project List" 
            :subtitle="$projects->count() . ' Projects Found'"
            :headers="[
                ['label' => 'Project Details'],
                ['label' => 'Financial Status'],
                ['label' => 'Timeline'],
                ['label' => 'Spent vs Budget'],
                ['label' => 'Utilization', 'class' => 'text-center']
            ]"
        >
            @forelse($projects as $project)
                @php 
                    $spent = $project->total_spent;
                    $budget = $project->total_budget ?? 0;
                    $balance = $budget - $spent;
                    $percent = $budget > 0 ? ($spent / $budget) * 100 : 0;
                @endphp
                <tr class="hover:bg-slate-50 transition-colors group cursor-pointer" onclick="window.location='{{ route('admin.budgets.show', $project) }}'">
                    <td class="px-8 py-6">
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ Str::title($project->name) }}</p>
                            <p class="text-[11px] text-slate-400 font-bold mt-0.5">{{ Str::title($project->client_name ?? 'No Client Listed') }} • {{ Str::title($project->location ?? 'No Location') }}</p>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                            {{ $project->status === 'Active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="space-y-1">
                            <p class="text-[11px] font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}
                                @if($project->end_date)
                                    — {{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}
                                @else
                                    — Present
                                @endif
                            </p>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="space-y-1">
                            <p class="text-xs font-black text-slate-900">₱{{ number_format($spent, 2) }} / <span class="text-slate-400">₱{{ number_format($budget, 2) }}</span></p>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[8px] font-black text-slate-400 tracking-widest">Balance:</span>
                                <span class="text-[10px] font-black {{ $balance < 0 ? 'text-rose-600' : 'text-slate-900' }}">
                                    ₱{{ number_format($balance, 2) }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col items-center gap-1.5">
                            <div class="w-24 h-1.5 bg-slate-50 rounded-full overflow-hidden">
                                <div class="h-full {{ $percent > 100 ? 'bg-rose-500' : ($percent > 80 ? 'bg-orange-500' : 'bg-sky-500') }} transition-all" style="width: {{ min(100, $percent) }}%"></div>
                            </div>
                            <span class="text-[8px] font-black tracking-widest {{ $percent > 100 ? 'text-rose-500' : 'text-slate-400' }}">
                                {{ number_format($percent, 1) }}%
                            </span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-serif italic text-slate-900">No Construction Projects Logged</p>
                                <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-1">Start by adding a new construction site to manage its financials</p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-studio-table>

        <!-- Add Project Modal -->
        <template x-teleport="body">
            <div x-show="showAddProject" x-cloak class="fixed inset-0 z-[300] flex items-center justify-center p-6">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-500" @click="showAddProject = false"></div>
                
                <div class="relative bg-white w-full max-w-2xl rounded-card overflow-hidden shadow-2xl p-12 border border-white/20" 
                     x-show="showAddProject"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h4 class="text-3xl font-serif text-slate-900 italic">Initialize <span class="text-sky-600">Site</span></h4>
                            <p class="text-[10px] text-slate-400 font-black tracking-widest mt-1">Create Financial Record for Construction</p>
                        </div>
                        <button @click="showAddProject = false" class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="mb-8 p-6 bg-rose-50 border border-rose-100 rounded-2xl">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-[10px] font-bold text-rose-600 tracking-widest">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.budgets.store') }}" method="POST" class="space-y-6" onsubmit="this.querySelectorAll('.comma-input').forEach(i => i.value = i.value.replace(/,/g, ''))">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2 space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Project Name</label>
                                <input type="text" name="name" required placeholder="Ex: South Residence Construction" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Client Name (Optional)</label>
                                <input type="text" name="client_name" placeholder="Ex: Mr. John Doe" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Location</label>
                                <input type="text" name="location" placeholder="Ex: Bukidnon, PH" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Initial Capital (₱)</label>
                                <input type="text" name="total_budget" required placeholder="0.00" 
                                       oninput="formatNumberInput(this)"
                                       class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold comma-input">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Project Status</label>
                                <select name="status" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                    <option value="Active">Active Site</option>
                                    <option value="Planned">Planned</option>
                                    <option value="Paused">Paused</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Start Date</label>
                                <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">End Date (Optional)</label>
                                <input type="date" name="end_date" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>
                        </div>

                        <div class="flex justify-center mt-10">
                            <button type="submit" class="px-16 py-4 bg-slate-900 text-white rounded-2xl font-bold text-xs shadow-2xl hover:bg-sky-600 transition-all">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
    <script>
        function formatNumberInput(input) {
            let cursor = input.selectionStart;
            let oldLen = input.value.length;
            
            // Remove everything except numbers and one decimal point
            let value = input.value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            if (parts.length > 2) parts = [parts[0], parts.slice(1).join('')];
            
            // Add commas
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = parts.join('.');
            
            // Adjust cursor
            let newLen = input.value.length;
            input.setSelectionRange(cursor + (newLen - oldLen), cursor + (newLen - oldLen));
        }
    </script>
</x-admin-layout>
