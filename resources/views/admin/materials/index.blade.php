<x-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Material <span class="text-sky-600 italic font-serif">Registry</span></h2>
                <p class="text-[10px] font-medium text-slate-400 uppercase tracking-[0.2em] mt-2">Master Settings • Randolf Jan Studio</p>
            </div>
            <button @click="$dispatch('open-modal', 'add-material-modal')" class="group relative px-8 py-4 bg-slate-900 text-white rounded-inner overflow-hidden transition-all hover:bg-sky-600 shadow-2xl">
                <div class="relative flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Add New Material</span>
                </div>
            </button>
        </div>

        @if(session('success'))
        <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-card flex items-center gap-4 text-emerald-600 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="w-10 h-10 rounded-inner bg-emerald-500 flex items-center justify-center text-white shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="p-6 bg-rose-50 border border-rose-100 rounded-card flex items-center gap-4 text-rose-600 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500 mb-6">
            <div class="w-10 h-10 rounded-inner bg-rose-500 flex items-center justify-center text-white shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-black uppercase tracking-[0.2em]">Validation Error</p>
                <ul class="list-disc list-inside text-[10px] font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Materials Table -->
        <x-studio-table 
            title="Master Material Registry" 
            :headers="[
                ['label' => 'Material Description'],
                ['label' => 'Standard Unit', 'class' => 'text-center'],
                ['label' => 'Management', 'class' => 'text-right']
            ]"
        >
            <x-slot name="filter">
                <x-table-filter placeholder="Search registry..." id="registry-search" />
            </x-slot>

            @forelse($materials as $material)
                <tr class="hover:bg-slate-50 transition-all cursor-pointer group" 
                    @click="$dispatch('open-modal', 'edit-material-{{ $material->id }}')">
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-slate-900">{{ $material->name }}</span>
                    </td>

                    <td class="px-8 py-6 text-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full border border-slate-100 group-hover:bg-white group-hover:border-sky-100 transition-all">
                            {{ $material->unit }}
                        </span>
                    </td>

                    <td class="px-8 py-6 text-right" @click.stop>
                        <div class="flex items-center justify-end gap-2">
                            <button @click="$dispatch('open-confirm', { 
                                        title: 'Remove from Registry?', 
                                        message: 'Are you sure you want to remove <b>{{ $material->name }}</b>? This will not affect existing project history.',
                                        confirmButton: 'Confirm Removal',
                                        action: () => $refs.deleteForm{{ $material->id }}.submit(),
                                        type: 'danger'
                                    })" 
                                    class="p-2 text-slate-300 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete Item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <form x-ref="deleteForm{{ $material->id }}" action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <x-modal name="edit-material-{{ $material->id }}" maxWidth="lg">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black text-slate-900">Edit <span class="text-sky-600 italic font-serif">Material</span></h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Update Registry Entry</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.materials.update', $material) }}" method="POST" class="space-y-6" onsubmit="stripCommasBeforeSubmit(this)">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Material Name</label>
                                <x-form-input name="name" :value="$material->name" required />
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Unit</label>
                                <x-form-input name="unit" :value="$material->unit" placeholder="e.g. Gallon" required />
                            </div>

                            <div class="flex justify-center pt-4">
                                <button type="button" 
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                            detail: {
                                                title: 'Update Registry?', 
                                                message: 'Save changes to this material definition?', 
                                                confirmButton: 'Update Material',
                                                action: () => $el.closest('form').submit(),
                                                type: 'info'
                                            }
                                        }))"
                                        class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs tracking-widest shadow-xl hover:bg-sky-600 transition-all">
                                    Update Item
                                </button>
                            </div>
                        </form>
                    </div>
                </x-modal>
            @empty
                <tr class="no-data">
                    <td colspan="3" class="px-8 py-20 text-center text-slate-400 text-xs font-medium italic">No materials found in the master list. Add your first item above.</td>
                </tr>
            @endforelse

            <x-slot name="footer">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Global Registry • {{ $materials->count() }} Total Items</p>
                </div>
            </x-slot>
        </x-studio-table>
    </div>

    <!-- Add Material Modal -->
    <x-modal name="add-material-modal" maxWidth="lg">
        <div class="p-8">
            <h4 class="text-3xl font-black text-slate-900">Add to <span class="text-sky-600 italic font-serif">Registry</span></h4>
            <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1 mb-10">Expand the global material database</p>

            <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-6" onsubmit="stripCommasBeforeSubmit(this)">
                @csrf
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Material Name</label>
                    <x-form-input name="name" required placeholder="e.g. Boysen Permacoat" />
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Unit</label>
                    <x-form-input name="unit" required placeholder="e.g. Gallon" />
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs tracking-widest shadow-xl hover:bg-sky-600 transition-all">
                        Save Material
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
    @include('admin.budgets.helpers.scripts')
</x-admin-layout>
