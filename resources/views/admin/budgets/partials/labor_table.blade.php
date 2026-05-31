<x-studio-table 
    title="Labor & Workforce Log" 
    :headers="[
        ['label' => 'Labor Description'],
        ['label' => 'Date Logged', 'class' => 'text-center'],
        ['label' => 'Fee/Wage Amount', 'class' => 'text-right']
    ]"
>
    <x-slot name="filter">
        <x-table-filter placeholder="Search labor logs..." id="labor-search" />
    </x-slot>
    @forelse($project->labors as $labor)
        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer"
            @click="openEdit('labor', {{ $labor->toJson() }})">
            <td class="px-8 py-6">
                <p class="text-xs font-bold text-slate-900">{{ Str::title($labor->description) }}</p>
                @if($labor->notes)
                    <p class="text-[11px] text-slate-400 font-bold mt-0.5">{{ Str::title($labor->notes) }}</p>
                @endif
            </td>
            <td class="px-8 py-6 text-center">
                <span class="text-[11px] font-bold text-slate-400">
                    {{ $labor->labor_date ? \Carbon\Carbon::parse($labor->labor_date)->format('M d, Y') : 'N/A' }}
                </span>
            </td>
            <td class="px-8 py-6 text-right">
                <span class="text-xs font-bold text-indigo-600">₱{{ number_format($labor->amount, 2) }}</span>
            </td>
        </tr>
    @empty
        <tr class="no-data">
            <td colspan="3" class="px-8 py-20 text-center">
                <p class="text-xs font-medium text-slate-400 italic">No labor or service fees logged yet.</p>
            </td>
        </tr>
    @endforelse
    <x-slot name="footer">
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-bold text-slate-400">Showing {{ $project->labors->count() }} total labor logs</p>
        </div>
    </x-slot>
</x-studio-table>
