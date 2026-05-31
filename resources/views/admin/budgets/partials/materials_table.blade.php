<x-studio-table 
    title="Material Expenditure Log" 
    :headers="[
        ['label' => 'Item Description'],
        ['label' => 'Date Logged', 'class' => 'text-center'],
        ['label' => 'Unit Price', 'class' => 'text-center'],
        ['label' => 'Qty Used', 'class' => 'text-center'],
        ['label' => 'Total Cost', 'class' => 'text-right']
    ]"
>
    <x-slot name="filter">
        <x-table-filter placeholder="Search materials..." id="material-search" />
    </x-slot>
    @forelse($project->costs as $cost)
        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer" 
            @click="openEdit('material', {{ $cost->toJson() }})">
            <td class="px-8 py-6">
                <p class="text-xs font-bold text-slate-900">
                    {{ $cost->material ? $cost->material->name : $cost->custom_material_name }}
                </p>
                @if($cost->notes)
                    <p class="text-[11px] text-slate-400 mt-1 bg-slate-50 rounded-lg px-2 py-1 inline-block">
                        {{ $cost->notes }}
                    </p>
                @endif
            </td>
            <td class="px-8 py-6 text-center">
                <span class="text-[11px] font-bold text-slate-400">
                    {{ $cost->cost_date ? \Carbon\Carbon::parse($cost->cost_date)->format('M d, Y') : 'N/A' }}
                </span>
            </td>
            <td class="px-8 py-6 text-center">
                <span class="text-xs font-bold text-slate-900">₱{{ number_format($cost->unit_price_at_time, 2) }}</span>
            </td>
            <td class="px-8 py-6 text-center">
                @php $u = $cost->custom_unit ?? ($cost->material ? $cost->material->unit : null); @endphp
                <span class="text-xs font-bold text-slate-900">{{ number_format($cost->quantity, 0) }}</span>
                @if($u && $u !== '1')
                    <span class="text-[11px] text-slate-400 font-bold ml-1">{{ $u }}</span>
                @endif
            </td>
            <td class="px-8 py-6 text-right">
                <span class="text-xs font-bold text-slate-900">₱{{ number_format($cost->total, 2) }}</span>
            </td>
        </tr>
    @empty
        <tr class="no-data">
            <td colspan="5" class="px-8 py-20 text-center">
                <p class="text-xs font-medium text-slate-400 italic">No material expenditures logged yet.</p>
            </td>
        </tr>
    @endforelse
    <x-slot name="footer">
        <div class="flex items-center justify-between">
            <p class="text-[11px] font-bold text-slate-400">Showing {{ $project->costs->count() }} total material logs</p>
        </div>
    </x-slot>
</x-studio-table>
