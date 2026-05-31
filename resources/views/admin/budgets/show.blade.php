<x-admin-layout>
    <div class="min-h-screen bg-[#F8FAFC] pb-24">
        <!-- Header with Breadcrumbs -->
        <div class="bg-white border-b border-slate-100 -mx-8 -mt-8 px-8 py-10 mb-12 relative overflow-hidden">
            
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="mb-6 no-print">
                    <a href="{{ route('admin.budgets.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black tracking-widest text-slate-400 hover:text-sky-600 transition-colors group">
                        <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </a>
                </div>

                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-slate-900">{{ $project->name }} <span class="text-sky-600 italic">Statement</span></h1>
                        <div class="flex items-center gap-4 mt-2">
                            <p class="text-[10px] font-black text-slate-400 tracking-[0.2em]">Resource Forensic Report • {{ $project->client_name ?? 'Internal Project' }}</p>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <div class="flex items-center gap-2">
                                <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[9px] font-bold text-slate-600 tracking-widest">
                                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'No Start Date' }}
                                    @if($project->end_date)
                                        — {{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}
                                    @else
                                        — Present
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 no-print" x-data="{ showBudgetModal: false }">
                        <button @click="$dispatch('open-modal', 'project-settings')" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 text-white rounded-inner font-bold text-xs hover:bg-slate-900 transition shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </button>
                        <button onclick="window.print()" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-inner font-bold text-xs hover:bg-slate-50 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Export
                        </button>

                        <form id="deleteProjectForm" action="{{ route('admin.budgets.destroy', $project) }}" method="POST" class="hidden">
                            @csrf @method('DELETE')
                        </form>

                        <button type="button" 
                                @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                    detail: {
                                        title: 'Delete Project', 
                                        message: 'Are you sure you want to permanently remove this construction project and all its records?', 
                                        confirmButton: 'Delete Project',
                                        action: 'deleteProjectForm'
                                    }
                                }))" 
                                class="w-11 h-11 bg-white border border-rose-100 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>

                        <!-- Edit Project Modal -->
                        <!-- Edit Project Modal -->
                        <template x-teleport="body">
                            <x-modal name="project-settings" :show="false" @close="show = false">
                                <x-slot name="header">
                                    <div class="space-y-1">
                                        <h4 class="text-3xl font-black text-slate-900">Project <span class="text-sky-600">Settings</span></h4>
                                        <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1">Configure architectural milestones and budget limits</p>
                                    </div>
                                </x-slot>

                                <form id="editProjectForm_main" action="{{ route('admin.budgets.update', $project) }}" method="POST" 
                                      class="space-y-6" onsubmit="this.querySelectorAll('.comma-input').forEach(i => i.value = i.value.replace(/,/g, ''))">
                                    @csrf @method('PATCH')
                                    
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-2 space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Project Name</label>
                                            <input type="text" name="name" value="{{ $project->name }}" required class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Client Name</label>
                                            <input type="text" name="client_name" value="{{ $project->client_name }}" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Location</label>
                                            <input type="text" name="location" value="{{ $project->location }}" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Total Budget (₱)</label>
                                            <input type="text" name="total_budget" value="{{ number_format($project->total_budget, 2) }}" required 
                                                   oninput="formatNumberInput(this)"
                                                   class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold comma-input">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Status</label>
                                            <select name="status" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                                <option value="Active" {{ $project->status === 'Active' ? 'selected' : '' }}>Active Site</option>
                                                <option value="Planned" {{ $project->status === 'Planned' ? 'selected' : '' }}>Planned</option>
                                                <option value="Paused" {{ $project->status === 'Paused' ? 'selected' : '' }}>Paused</option>
                                                <option value="Completed" {{ $project->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Start Date</label>
                                            <input type="date" name="start_date" value="{{ $project->start_date }}" required class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">End Date (Optional)</label>
                                            <input type="date" name="end_date" value="{{ $project->end_date }}" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all font-bold">
                                        </div>
                                    </div>
                                </form>

                                <x-slot:footer>
                                    <div class="flex justify-center">
                                        <button type="submit" form="editProjectForm_main" class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs shadow-xl hover:bg-sky-600 transition-all">
                                            Save Changes
                                        </button>
                                    </div>
                                </x-slot:footer>
                            </x-modal>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12 no-print">
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[11px] font-bold text-slate-400 mb-4 relative z-10">Total Project Budget</p>
                    <h3 class="text-3xl font-semibold text-slate-900 relative z-10 truncate" title="₱{{ number_format($project->total_budget, 2) }}">₱{{ number_format($project->total_budget, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 relative z-10">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest">Allocated Capital</span>
                    </div>
                </div>

                <!-- Material Spent -->
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4 relative z-10">Material Expenditure</p>
                    <h3 class="text-3xl font-semibold text-slate-900 relative z-10 truncate" title="₱{{ number_format($project->total_materials, 2) }}">₱{{ number_format($project->total_materials, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 relative z-10">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest">Hardware & Supplies</span>
                    </div>
                </div>

                <!-- Labor Spent -->
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4 relative z-10">Labor Expenditure</p>
                    <h3 class="text-3xl font-semibold text-slate-900 relative z-10 truncate" title="₱{{ number_format($project->total_labors, 2) }}">₱{{ number_format($project->total_labors, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 relative z-10">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest">Manpower & Fees</span>
                    </div>
                </div>

                <!-- Misc Spent -->
                <div class="bg-white rounded-card p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <p class="text-[9px] font-black text-slate-400 tracking-widest mb-4 relative z-10">Miscellaneous</p>
                    <h3 class="text-3xl font-semibold text-slate-900 relative z-10 truncate" title="₱{{ number_format($project->total_expenses, 2) }}">₱{{ number_format($project->total_expenses, 2) }}</h3>
                    <div class="mt-4 flex items-center gap-2 relative z-10">
                        <span class="text-[8px] font-bold text-slate-400 tracking-widest">Food, Gas & Others</span>
                    </div>
                </div>
            </div>

            <div x-data="budgetManager()" class="space-y-6">
                <div class="flex items-center justify-between no-print">
                    <div class="flex bg-slate-100 p-1 rounded-inner shadow-inner border border-slate-200/50">
                        <button @click="activeTab = 'summary'" 
                                :class="activeTab === 'summary' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                                class="px-8 py-3 text-[11px] font-bold tracking-wide rounded-xl transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5m11 2a4 4 0 014 4v2m-3-10a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Report Summary
                        </button>
                        <button @click="activeTab = 'materials'" 
                                :class="activeTab === 'materials' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                                class="px-8 py-3 text-[11px] font-bold tracking-wide rounded-xl transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Materials List
                        </button>
                        <button @click="activeTab = 'labor'" 
                                :class="activeTab === 'labor' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                                class="px-8 py-3 text-[11px] font-bold tracking-wide rounded-xl transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Labor Logs
                        </button>
                        <button @click="activeTab = 'expenses'" 
                                :class="activeTab === 'expenses' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                                class="px-8 py-3 text-[11px] font-bold tracking-wide rounded-xl transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Miscellaneous
                        </button>
                    </div>

                    <div class="flex gap-4">
                        <x-primary-button x-show="activeTab === 'materials'" @click="$dispatch('open-modal', 'log-material')" class="gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Log Material
                        </x-primary-button>

                        <x-primary-button x-show="activeTab === 'labor'" @click="$dispatch('open-modal', 'log-labor')" class="gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Log Labor Fee
                        </x-primary-button>

                        <x-primary-button x-show="activeTab === 'expenses'" @click="$dispatch('open-modal', 'log-expense')" class="gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Log Expense
                        </x-primary-button>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="space-y-6">
                    <!-- Summary Section -->
                    <div x-show="activeTab === 'summary'" x-transition:enter="duration-500 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        @include('admin.budgets.partials.financial_summary')
                    </div>

                    <!-- Materials Section -->
                    <div x-show="activeTab === 'materials'" x-transition:enter="duration-500 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        @include('admin.budgets.partials.materials_table')
                    </div>

                    <!-- Labor Section -->
                    <div x-show="activeTab === 'labor'" x-transition:enter="duration-500 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        @include('admin.budgets.partials.labor_table')
                    </div>

                    <!-- Miscellaneous Section -->
                    <div x-show="activeTab === 'expenses'" x-transition:enter="duration-500 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        @include('admin.budgets.partials.expense_table')
                    </div>
                </div>

                {{-- Bulk Logging & Manage Modals --}}
                @include('admin.budgets.partials.logging_modals', ['project' => $project, 'materials' => $materials])
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .rounded-card { border: 1px solid #eee !important; box-shadow: none !important; }
        }
    </style>
    @include('admin.budgets.helpers.scripts')
</x-admin-layout>
