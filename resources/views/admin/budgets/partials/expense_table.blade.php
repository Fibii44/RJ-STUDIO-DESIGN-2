<x-studio-table 
    title="Miscellaneous Expenses" 
    :headers="[
        ['label' => 'Expense Description'],
        ['label' => 'Date Logged', 'class' => 'text-center'],
        ['label' => 'Amount', 'class' => 'text-right']
    ]"
>
    <x-slot name="filter">
        <x-table-filter placeholder="Search expenses..." id="expense-search" />
    </x-slot>
    @forelse($project->expenses as $expense)
        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer"
            @click="openEdit('expense', {{ $expense->toJson() }})">
            <td class="px-8 py-6">
                <p class="text-xs font-bold text-slate-900">{{ Str::title($expense->description) }}</p>
                @if($expense->notes)
                    <p class="text-[11px] text-slate-400 font-bold mt-0.5">{{ Str::title($expense->notes) }}</p>
                @endif
            </td>
            <td class="px-8 py-6 text-center">
                <span class="text-[11px] font-bold text-slate-400">
                    {{ $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') : 'N/A' }}
                </span>
            </td>
            <td class="px-8 py-6 text-right">
                <span class="text-xs font-bold text-emerald-600">₱{{ number_format($expense->amount, 2) }}</span>
            </td>
        </tr>
    @empty
        <tr class="no-data">
            <td colspan="3" class="px-8 py-20 text-center">
                <p class="text-xs font-medium text-slate-400 italic">No miscellaneous expenses logged yet.</p>
            </td>
        </tr>
    @endforelse
    <x-slot name="footer">
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-bold text-slate-400">Showing {{ $project->expenses->count() }} total miscellaneous logs</p>
        </div>
    </x-slot>
</x-studio-table>
