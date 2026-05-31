<div class="grid grid-cols-1 lg:grid-cols-5 gap-4" x-data="{ activeSlice: null }">
    <!-- Main Report Side -->
    <div class="lg:col-span-3 space-y-8">
        <!-- Visual Breakdown -->
        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-premium relative overflow-hidden">
            
            <div class="flex items-center justify-between mb-10 relative z-10">
                <h5 class="text-xs font-bold text-slate-900">
                    Financial Allocation Ratio
                </h5>
                <!-- Time Filter -->
                <div class="flex bg-slate-50 p-1 rounded-xl no-print">
                    @foreach(['all' => 'Lifetime', 'this_month' => 'Month', 'this_week' => 'Week', 'today' => 'Today'] as $val => $label)
                        <a href="{{ request()->fullUrlWithQuery(['period' => $val]) }}" 
                           class="px-4 py-1.5 text-[9px] font-bold rounded-lg transition-all {{ ($period ?? 'all') === $val ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @php 
                // Use filtered values passed from controller
                $displaySpent = $filteredTotalSpent ?? $project->total_spent;
                $displayMaterials = $filteredMaterials ?? $project->total_materials;
                $displayLabors = $filteredLabors ?? $project->total_labors;
                $displayExpenses = $filteredExpenses ?? $project->total_expenses;

                $totalForCalc = $displaySpent > 0 ? $displaySpent : 1;
                $matPercent = ($displayMaterials / $totalForCalc) * 100;
                $labPercent = ($displayLabors / $totalForCalc) * 100;
                $expPercent = ($displayExpenses / $totalForCalc) * 100;

                // SVG Donut Calculations
                $radius = 40;
                $circumference = 2 * pi() * $radius;
            @endphp

            <div class="flex flex-col md:flex-row items-center gap-12 relative z-10">
                <!-- SVG Donut Chart -->
                <div class="relative w-48 h-48 flex-shrink-0">
                    @if($displaySpent > 0)
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                            <!-- Background Circle -->
                            <circle cx="50" cy="50" r="{{ $radius }}" fill="transparent" stroke="#f8fafc" stroke-width="12"/>
                            
                            <!-- Miscellaneous (Bottom Layer) -->
                            <circle cx="50" cy="50" r="{{ $radius }}" fill="transparent" 
                                    stroke="#10b981" stroke-width="12"
                                    stroke-dasharray="{{ $circumference }}" 
                                    stroke-dashoffset="{{ $circumference - ($circumference * ($expPercent / 100)) }}"
                                    :stroke-width="activeSlice === 'misc' ? 16 : 12"
                                    :opacity="activeSlice && activeSlice !== 'misc' ? 0.3 : 1"
                                    @mouseenter="activeSlice = 'misc'"
                                    @mouseleave="activeSlice = null"
                                    class="transition-all duration-300 cursor-pointer ease-out"/>

                            <!-- Labor (Middle Layer) -->
                            <circle cx="50" cy="50" r="{{ $radius }}" fill="transparent" 
                                    stroke="#6366f1" stroke-width="12"
                                    stroke-dasharray="{{ $circumference }}" 
                                    stroke-dashoffset="{{ $circumference - ($circumference * ($labPercent / 100)) }}"
                                    style="transform: rotate({{ ($expPercent / 100) * 360 }}deg); transform-origin: 50% 50%;"
                                    :stroke-width="activeSlice === 'labor' ? 16 : 12"
                                    :opacity="activeSlice && activeSlice !== 'labor' ? 0.3 : 1"
                                    @mouseenter="activeSlice = 'labor'"
                                    @mouseleave="activeSlice = null"
                                    class="transition-all duration-300 cursor-pointer ease-out"/>

                            <!-- Materials (Top Layer) -->
                            <circle cx="50" cy="50" r="{{ $radius }}" fill="transparent" 
                                    stroke="#0ea5e9" stroke-width="12"
                                    stroke-dasharray="{{ $circumference }}" 
                                    stroke-dashoffset="{{ $circumference - ($circumference * ($matPercent / 100)) }}"
                                    style="transform: rotate({{ (($expPercent + $labPercent) / 100) * 360 }}deg); transform-origin: 50% 50%;"
                                    :stroke-width="activeSlice === 'materials' ? 16 : 12"
                                    :opacity="activeSlice && activeSlice !== 'materials' ? 0.3 : 1"
                                    @mouseenter="activeSlice = 'materials'"
                                    @mouseleave="activeSlice = null"
                                    class="transition-all duration-300 cursor-pointer ease-out"/>
                        </svg>

                        <!-- Center Info -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                            <span class="text-[8px] font-black tracking-widest text-slate-400 uppercase">
                                {{ ($period ?? 'all') === 'all' ? 'Total Spent' : 'Spent ' . Str::title(str_replace('_', ' ', $period)) }}
                            </span>
                            <span class="text-lg font-bold text-slate-900" 
                                x-text="activeSlice === 'materials' ? '₱{{ number_format($displayMaterials, 0) }}' : 
                                        (activeSlice === 'labor' ? '₱{{ number_format($displayLabors, 0) }}' : 
                                        (activeSlice === 'misc' ? '₱{{ number_format($displayExpenses, 0) }}' : '₱{{ number_format($displaySpent, 0) }}'))">
                                ₱{{ number_format($displaySpent, 0) }}
                            </span>
                        </div>
                    @else
                        <div class="w-full h-full rounded-full border-8 border-slate-50 flex items-center justify-center">
                            <span class="text-[10px] font-black text-slate-200 uppercase tracking-widest">No Data</span>
                        </div>
                    @endif
                </div>

                <!-- Detailed Legend -->
                <div class="flex-1 w-full space-y-4">
                    <!-- Materials -->
                    <div class="p-4 rounded-2xl border transition-all duration-300 cursor-default"
                         :class="activeSlice === 'materials' ? 'bg-sky-50 border-sky-100' : 'bg-white border-transparent'"
                         @mouseenter="activeSlice = 'materials'"
                         @mouseleave="activeSlice = null">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-sky-500 shadow-sm"></div>
                                <span class="text-[10px] font-bold text-slate-600">Materials & Hardware</span>
                            </div>
                            <span class="text-xs font-black text-slate-900">{{ number_format($matPercent, 1) }}%</span>
                        </div>
                        <div class="text-[11px] font-semibold text-slate-400 mt-1 ml-5">₱{{ number_format($displayMaterials, 2) }}</div>
                    </div>

                    <!-- Labor -->
                    <div class="p-4 rounded-2xl border transition-all duration-300 cursor-default"
                         :class="activeSlice === 'labor' ? 'bg-indigo-50 border-indigo-100' : 'bg-white border-transparent'"
                         @mouseenter="activeSlice = 'labor'"
                         @mouseleave="activeSlice = null">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-sm"></div>
                                <span class="text-[10px] font-bold text-slate-600">Manpower & Labor</span>
                            </div>
                            <span class="text-xs font-black text-slate-900">{{ number_format($labPercent, 1) }}%</span>
                        </div>
                        <div class="text-[11px] font-semibold text-indigo-500/70 mt-1 ml-5">₱{{ number_format($displayLabors, 2) }}</div>
                    </div>

                    <!-- Misc -->
                    <div class="p-4 rounded-2xl border transition-all duration-300 cursor-default"
                         :class="activeSlice === 'misc' ? 'bg-emerald-50 border-emerald-100' : 'bg-white border-transparent'"
                         @mouseenter="activeSlice = 'misc'"
                         @mouseleave="activeSlice = null">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm"></div>
                                <span class="text-[10px] font-bold text-slate-600">Miscellaneous & Others</span>
                            </div>
                            <span class="text-xs font-black text-slate-900">{{ number_format($expPercent, 1) }}%</span>
                        </div>
                        <div class="text-[11px] font-semibold text-emerald-500/70 mt-1 ml-5">₱{{ number_format($displayExpenses, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Budget Health Progress -->
            <div class="mt-12 pt-8 border-t border-slate-50">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-xs font-bold text-slate-900">Project Budget Utilization (Total)</p>
                    @php 
                        $budget = $project->total_budget > 0 ? $project->total_budget : 1;
                        $utilPercent = ($project->total_spent / $budget) * 100;
                        $isOver = $utilPercent > 100;
                    @endphp
                    <span class="text-sm font-black {{ $isOver ? 'text-rose-600' : 'text-emerald-600' }}">
                        {{ number_format($utilPercent, 1) }}% Overall
                    </span>
                </div>
                <div class="h-2 w-full bg-slate-50 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full {{ $isOver ? 'bg-rose-500' : 'bg-emerald-500' }} transition-all duration-1000" style="width: {{ min(100, $utilPercent) }}%"></div>
                </div>
                @if($period !== 'all')
                <p class="mt-4 text-[8px] font-bold text-slate-300 uppercase tracking-widest text-center italic">Currently viewing {{ str_replace('_', ' ', $period) }} metrics • Overall budget health shown above</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Side -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Quick Stats Card -->
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
            <h5 class="text-xs font-bold text-slate-400 mb-10 relative z-10">Statement Overview</h5>
            
            <div class="space-y-10 relative z-10">
                <div>
                    <p class="text-[8px] font-black tracking-widest text-slate-500 mb-2 uppercase">Total Project Value</p>
                    <p class="text-3xl font-semibold italic text-white">₱{{ number_format($project->total_budget, 2) }}</p>
                </div>
                <div>
                    <p class="text-[8px] font-black tracking-widest text-slate-500 mb-2 uppercase">Total Realized Cost</p>
                    <p class="text-3xl font-semibold italic text-sky-400">₱{{ number_format($project->total_spent, 2) }}</p>
                </div>
                
                @php 
                    $remaining = $project->total_budget - $project->total_spent;
                    $isRemainingOver = $remaining < 0;
                @endphp
                <div class="pt-8 border-t border-slate-800">
                    <p class="text-[8px] font-black tracking-widest text-slate-500 mb-2 uppercase">Remaining Balance</p>
                    <p class="text-3xl font-semibold italic {{ $isRemainingOver ? 'text-rose-400' : 'text-emerald-400' }}">
                        ₱{{ number_format(abs($remaining), 2) }}
                    </p>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-[7px] font-black tracking-[0.2em] {{ $isRemainingOver ? 'text-rose-500' : 'text-emerald-500' }} uppercase">
                            {{ $isRemainingOver ? 'Budget Overrun Detected' : 'Remaining Project Funds' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
