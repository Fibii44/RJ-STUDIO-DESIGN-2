<!-- Letterhead -->
<header class="border-b-2 border-slate-900 pb-8 mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
    <div>
        <h1 class="text-2xl font-black tracking-widest text-slate-900 uppercase">Randolf Jan Studio</h1>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Design • Architecture • Construction Financials</p>
    </div>
    <div class="text-left md:text-right">
        <span class="px-3 py-1 bg-slate-100 rounded-md text-[9px] font-black uppercase tracking-widest text-slate-600">
            Official Statement
        </span>
        <p class="text-xs font-medium text-slate-500 mt-2">Export Date: <span class="font-bold text-slate-900">{{ now()->setTimezone('Asia/Manila')->format('F d, Y h:i A') }}</span></p>
    </div>
</header>

<!-- Project metadata cards -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="space-y-4">
        <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Project Information</h3>
        <div class="space-y-2">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Project Name</span>
                <span class="text-sm font-bold text-slate-900">{{ $project->name }}</span>
            </div>
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Location</span>
                <span class="text-sm font-medium text-slate-700">{{ $project->location ?? 'Not specified' }}</span>
            </div>
        </div>
    </div>
    <div class="space-y-4">
        <h3 class="text-sm font-black uppercase tracking-widest text-slate-400">Client & Duration</h3>
        <div class="space-y-2">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Client</span>
                <span class="text-sm font-bold text-slate-900">{{ $project->client_name ?? 'Internal Project' }}</span>
            </div>
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Project Term</span>
                <span class="text-sm font-medium text-slate-700">
                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }} 
                    — 
                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M d, Y') : 'Present' }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Financial Statement Overview -->
<section class="bg-slate-50 rounded-2xl p-8 border border-slate-100 mb-12">
    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Financial Summary & Ratios</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b border-slate-200/60 pb-8">
        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Total Project Budget</span>
            <span class="text-2xl font-bold text-slate-950">₱{{ number_format($project->total_budget, 2) }}</span>
        </div>
        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Total Realized Spent</span>
            <span class="text-2xl font-bold text-slate-950">₱{{ number_format($project->total_spent, 2) }}</span>
        </div>
        @php 
            $remaining = $project->total_budget - $project->total_spent;
            $isOver = $remaining < 0;
        @endphp
        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">
                {{ $isOver ? 'Budget Overrun' : 'Remaining Balance' }}
            </span>
            <span class="text-2xl font-bold {{ $isOver ? 'text-rose-600' : 'text-emerald-600' }}">
                ₱{{ number_format(abs($remaining), 2) }}
            </span>
        </div>
    </div>

    @php
        $budgetForCalc = $project->total_budget > 0 ? $project->total_budget : 1;
        $utilPercent = ($project->total_spent / $budgetForCalc) * 100;
        
        $spentForCalc = $project->total_spent > 0 ? $project->total_spent : 1;
        $matPercent = ($project->total_materials / $spentForCalc) * 100;
        $labPercent = ($project->total_labors / $spentForCalc) * 100;
        $expPercent = ($project->total_expenses / $spentForCalc) * 100;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
            <div class="flex justify-between text-xs font-bold">
                <span class="text-slate-500 uppercase tracking-wider">Budget Utilization Ratio</span>
                <span class="{{ $utilPercent > 100 ? 'text-rose-600' : 'text-emerald-600' }}">{{ number_format($utilPercent, 1) }}%</span>
            </div>
            <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full {{ $utilPercent > 100 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ min(100, $utilPercent) }}%"></div>
            </div>
        </div>

        <div class="space-y-3">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Cost Allocation Ratio</span>
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-600 font-medium">Materials & Supplies</span>
                    <span class="font-bold text-slate-900">{{ number_format($matPercent, 1) }}% (₱{{ number_format($project->total_materials, 2) }})</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-600 font-medium">Manpower & Labor</span>
                    <span class="font-bold text-slate-900">{{ number_format($labPercent, 1) }}% (₱{{ number_format($project->total_labors, 2) }})</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-600 font-medium">Miscellaneous & Others</span>
                    <span class="font-bold text-slate-900">{{ number_format($expPercent, 1) }}% (₱{{ number_format($project->total_expenses, 2) }})</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Table 1: Materials List -->
<section class="mb-12 print-break-inside-avoid">
    <div class="flex justify-between items-baseline border-b border-slate-900 pb-2 mb-4">
        <h3 class="text-sm font-black uppercase tracking-widest text-slate-900">1. Materials & Hardware Ledger</h3>
        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $project->costs->count() }} Items</span>
    </div>
    
    @if($project->costs->isEmpty())
        <p class="text-xs text-slate-400 italic">No materials or hardware expenses have been logged for this project.</p>
    @else
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="py-2 text-slate-500 font-bold">Date</th>
                    <th class="py-2 text-slate-500 font-bold">Material Item</th>
                    <th class="py-2 text-slate-500 font-bold text-right">Unit Cost</th>
                    <th class="py-2 text-slate-500 font-bold text-center">Qty</th>
                    <th class="py-2 text-slate-500 font-bold text-right">Total Cost</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($project->costs as $cost)
                    <tr>
                        <td class="py-2.5 text-slate-500">{{ $cost->cost_date ? \Carbon\Carbon::parse($cost->cost_date)->format('M d, Y') : 'N/A' }}</td>
                        <td class="py-2.5 font-semibold text-slate-900">{{ $cost->material ? $cost->material->name : $cost->custom_material_name }}</td>
                        <td class="py-2.5 text-right text-slate-700">₱{{ number_format($cost->unit_price_at_time, 2) }}</td>
                        <td class="py-2.5 text-center text-slate-700">
                            {{ number_format($cost->quantity, 0) }}
                            @php $u = $cost->custom_unit ?? ($cost->material ? $cost->material->unit : null); @endphp
                            @if($u && $u !== '1')
                                <span class="text-[10px] text-slate-400 font-bold ml-0.5">{{ $u }}</span>
                            @endif
                        </td>
                        <td class="py-2.5 text-right font-bold text-slate-900">₱{{ number_format($cost->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-900 font-bold text-slate-950">
                    <td colspan="4" class="py-3 text-right">Total Materials Cost:</td>
                    <td class="py-3 text-right">₱{{ number_format($project->total_materials, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</section>

<!-- Table 2: Labor Logs -->
<section class="mb-12 print-break-inside-avoid">
    <div class="flex justify-between items-baseline border-b border-slate-900 pb-2 mb-4">
        <h3 class="text-sm font-black uppercase tracking-widest text-slate-900">2. Manpower & Labor Log</h3>
        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $project->labors->count() }} Entries</span>
    </div>
    
    @if($project->labors->isEmpty())
        <p class="text-xs text-slate-400 italic">No labor or manpower expenses have been logged for this project.</p>
    @else
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="py-2 text-slate-500 font-bold">Date</th>
                    <th class="py-2 text-slate-500 font-bold">Worker / Role / Task</th>
                    <th class="py-2 text-slate-500 font-bold text-right">Amount Paid</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($project->labors as $labor)
                    <tr>
                        <td class="py-2.5 text-slate-500">{{ $labor->labor_date ? \Carbon\Carbon::parse($labor->labor_date)->format('M d, Y') : 'N/A' }}</td>
                        <td class="py-2.5 font-semibold text-slate-900">{{ $labor->name }}</td>
                        <td class="py-2.5 text-right font-bold text-slate-900">₱{{ number_format($labor->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-900 font-bold text-slate-950">
                    <td colspan="2" class="py-3 text-right">Total Labor Cost:</td>
                    <td class="py-3 text-right">₱{{ number_format($project->total_labors, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</section>

<!-- Table 3: Miscellaneous Expenses -->
<section class="mb-12 print-break-inside-avoid">
    <div class="flex justify-between items-baseline border-b border-slate-900 pb-2 mb-4">
        <h3 class="text-sm font-black uppercase tracking-widest text-slate-900">3. Miscellaneous & Other Expenses</h3>
        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $project->expenses->count() }} Entries</span>
    </div>
    
    @if($project->expenses->isEmpty())
        <p class="text-xs text-slate-400 italic">No miscellaneous expenses have been logged for this project.</p>
    @else
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="py-2 text-slate-500 font-bold">Date</th>
                    <th class="py-2 text-slate-500 font-bold">Expense Description</th>
                    <th class="py-2 text-slate-500 font-bold text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($project->expenses as $expense)
                    <tr>
                        <td class="py-2.5 text-slate-500">{{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') : 'N/A' }}</td>
                        <td class="py-2.5 font-semibold text-slate-900">{{ $expense->description }}</td>
                        <td class="py-2.5 text-right font-bold text-slate-900">₱{{ number_format($expense->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-slate-900 font-bold text-slate-950">
                    <td colspan="2" class="py-3 text-right">Total Miscellaneous Cost:</td>
                    <td class="py-3 text-right">₱{{ number_format($project->total_expenses, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</section>

<!-- Final Informational Footer -->
<footer class="mt-20 pt-8 border-t border-slate-100 text-center text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">
    End of Report • Randolf Jan Studio • Construction Project Statement
</footer>
