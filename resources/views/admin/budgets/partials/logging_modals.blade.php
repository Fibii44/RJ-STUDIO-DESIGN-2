@props(['project', 'materials'])

<!-- Log Materials Modal -->
<template x-teleport="body">
    <x-modal name="log-material" :show="false" @close="showLogModal = false" maxWidth="5xl">
        <x-slot name="header">
                <div class="space-y-1">
                    <h4 class="text-3xl font-black text-slate-900">Log <span class="text-sky-600">Materials</span></h4>
                    <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1">Batch log multiple hardware & supplies</p>
                </div>
        </x-slot>

        <div x-data="{ 
            batchDate: '{{ date('Y-m-d') }}',
            items: [{ 
                entryMode: 'master', 
                material_id: '', 
                custom_material_name: '', 
                custom_unit: '', 
                unit_price: '', 
                quantity: '', 
                notes: '' 
            }],
            addItem() {
                this.items.push({ 
                    entryMode: 'master', 
                    material_id: '', 
                    custom_material_name: '', 
                    custom_unit: '', 
                    unit_price: '', 
                    quantity: '', 
                    notes: '' 
                });
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            }
        }">
            <form id="logMaterialForm" action="{{ route('admin.projects.costs.store', $project) }}" method="POST" 
                  onsubmit="this.querySelectorAll('.comma-input').forEach(i => i.value = i.value.replace(/,/g, ''))">
                @csrf
                
                <!-- Batch Settings -->
                <div class="bg-slate-50 p-6 rounded-inner border border-slate-100 mb-6">
                    <div class="max-w-xs space-y-2">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.15em] ml-2">Global Batch Date</label>
                        <input type="date" name="cost_date" x-model="batchDate" required 
                               class="w-full h-12 rounded-xl border-slate-200 bg-white text-xs px-4 font-bold text-slate-600 focus:ring-4 focus:ring-sky-500/10">
                    </div>
                </div>

                <div class="flex items-center gap-4 mb-4 px-2">
                    <h5 class="text-[10px] font-black text-slate-900 tracking-[0.2em]">Materials List</h5>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <!-- Column Headers -->
                <div class="grid grid-cols-12 gap-3 px-2 mb-2 sticky top-0 bg-white z-10 py-2 border-b border-slate-50">
                    <div class="col-span-1 text-[9px] font-black text-slate-400 tracking-widest px-3">Mode</div>
                    <div class="col-span-5 text-[9px] font-black text-slate-400 tracking-widest px-3">Item / Material Selection</div>
                    <div class="col-span-2 text-[9px] font-black text-slate-400 tracking-widest px-3">Unit</div>
                    <div class="col-span-2 text-[9px] font-black text-slate-400 tracking-widest px-3">Price (₱)</div>
                    <div class="col-span-1 text-[9px] font-black text-slate-400 tracking-widest px-3">Qty</div>
                    <div class="col-span-1"></div>
                </div>

                <div class="space-y-3 pb-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="p-4 bg-white rounded-inner border border-slate-100 hover:border-sky-200 transition-all space-y-3 group">
                            <div class="grid grid-cols-12 gap-3 items-center">
                                <!-- Mode Toggle -->
                                <div class="col-span-1 flex flex-col gap-1">
                                    <button type="button" @click="item.entryMode = 'master'" 
                                            :class="item.entryMode === 'master' ? 'bg-sky-600 text-white' : 'bg-slate-100 text-slate-400'"
                                            class="p-1.5 rounded-lg transition-all" title="Registry">
                                        <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                    </button>
                                    <button type="button" @click="item.entryMode = 'manual'" 
                                            :class="item.entryMode === 'manual' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-400'"
                                            class="p-1.5 rounded-lg transition-all" title="Custom">
                                        <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>

                                <!-- Item Selection / Name -->
                                <div class="col-span-5">
                                    <div x-show="item.entryMode === 'master'">
                                        <select :name="'items['+index+'][material_id]'" x-model="item.material_id" 
                                                :required="item.entryMode === 'master'"
                                                class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 focus:ring-4 focus:ring-sky-500/10 font-bold">
                                            <option value="">Search material...</option>
                                            @foreach($materials as $mat)
                                                <option value="{{ $mat->id }}">{{ $mat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div x-show="item.entryMode === 'manual'">
                                        <input type="text" :name="'items['+index+'][custom_material_name]'" x-model="item.custom_material_name" 
                                               :required="item.entryMode === 'manual'" placeholder="e.g. Portland Cement" 
                                               class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div class="col-span-2">
                                    <input type="text" :name="'items['+index+'][custom_unit]'" x-model="item.custom_unit" 
                                           placeholder="pcs, bags..." 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all text-left">
                                </div>

                                <!-- Price -->
                                <div class="col-span-2">
                                    <input type="text" :name="'items['+index+'][unit_price]'" x-model="item.unit_price" required 
                                           placeholder="0.00" oninput="formatNumberInput(this)" 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all comma-input text-left">
                                </div>

                                <!-- Qty -->
                                <div class="col-span-1">
                                    <input type="text" :name="'items['+index+'][quantity]'" x-model="item.quantity" required 
                                           placeholder="0" oninput="formatNumberInput(this, false)" 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all comma-input text-left">
                                </div>

                                <!-- Actions -->
                                <div class="col-span-1 flex justify-center">
                                    <button type="button" x-show="items.length > 1" @click="removeItem(index)" 
                                            class="p-2 text-red-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Notes Sub-row -->
                            <div class="flex gap-3 items-center relative">
                                <div class="w-8 flex justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                </div>
                                <div class="flex-1 relative">
                                    <input type="text" :name="'items['+index+'][notes]'" x-model="item.notes" maxlength="500"
                                           placeholder="Additional details for this entry..." 
                                           class="w-full h-11 rounded-xl border-transparent bg-slate-50/50 text-[10px] px-4 pr-12 font-medium text-slate-500 focus:bg-white focus:border-slate-100 focus:ring-0 transition-all">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[8px] font-bold text-slate-300" x-text="(item.notes?.length || 0) + '/500'"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-4">
                    <button type="button" @click="addItem()" 
                            class="w-full py-4 border-2 border-dashed border-slate-100 rounded-inner text-slate-300 hover:border-sky-300 hover:text-sky-600 hover:bg-sky-50/50 transition-all flex items-center justify-center gap-2 font-black text-[9px] tracking-[0.2em]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Add Another Entry
                    </button>
                </div>
            </form>
        </div>

        <x-slot name="footer">
            <div class="flex justify-center">
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                            detail: {
                                title: 'Confirm Material Log', 
                                message: 'Are you sure you want to batch log these material entries?', 
                                confirmButton: 'Confirm & Save',
                                action: 'logMaterialForm',
                                type: 'info'
                            }
                        }))"
                        class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs tracking-widest shadow-xl hover:bg-sky-600 transition-all">
                    Confirm Batch Log
                </button>
            </div>
        </x-slot>
    </x-modal>
</template>

<!-- Log Labor Modal -->
<template x-teleport="body">
    <x-modal name="log-labor" :show="false" @close="showLaborModal = false" maxWidth="5xl">
        <x-slot name="header">
                <div class="space-y-1">
                    <h4 class="text-3xl font-black text-slate-900">Log <span class="text-sky-600">Manpower</span></h4>
                    <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1">Batch log labor fees and specialized services</p>
                </div>
        </x-slot>

        <div x-data="{ 
            batchDate: '{{ date('Y-m-d') }}',
            items: [{ description: '', amount: '', notes: '' }],
            addItem() {
                this.items.push({ description: '', amount: '', notes: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            }
        }">
            <form id="logLaborForm" action="{{ route('admin.projects.labors.store', $project) }}" method="POST" 
                  onsubmit="this.querySelectorAll('.comma-input').forEach(i => i.value = i.value.replace(/,/g, ''))">
                @csrf
                
                <div class="bg-slate-50 p-6 rounded-inner border border-slate-100 mb-6">
                    <div class="max-w-xs space-y-2">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.15em] ml-2">Global Batch Date</label>
                        <input type="date" name="labor_date" x-model="batchDate" required 
                               class="w-full h-12 rounded-xl border-slate-200 bg-white text-xs px-4 font-bold text-slate-600 focus:ring-4 focus:ring-sky-500/10">
                    </div>
                </div>

                <div class="flex items-center gap-4 mb-4 px-2">
                    <h5 class="text-[10px] font-black text-slate-900 tracking-[0.2em]">Manpower List</h5>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <!-- Column Headers -->
                <div class="grid grid-cols-12 gap-3 px-2 mb-2 sticky top-0 bg-white z-10 py-2 border-b border-slate-50">
                    <div class="col-span-9 text-[9px] font-black text-slate-400 tracking-widest px-3">Description / Service</div>
                    <div class="col-span-2 text-[9px] font-black text-slate-400 tracking-widest text-left px-3">Amount (₱)</div>
                    <div class="col-span-1"></div>
                </div>

                <div class="space-y-3 pb-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="p-4 bg-white rounded-inner border border-slate-100 hover:border-sky-200 transition-all space-y-3 group">
                            <div class="grid grid-cols-12 gap-3 items-center">
                                <!-- Description -->
                                <div class="col-span-9">
                                    <input type="text" :name="'items['+index+'][description]'" x-model="item.description" required 
                                           placeholder="e.g. Masonry Works, Carpentry..." 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                </div>

                                <!-- Amount -->
                                <div class="col-span-2">
                                    <input type="text" :name="'items['+index+'][amount]'" x-model="item.amount" required 
                                           placeholder="₱0.00" oninput="formatNumberInput(this)" 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all comma-input text-left">
                                </div>

                                <!-- Actions -->
                                <div class="col-span-1 flex justify-center">
                                    <button type="button" x-show="items.length > 1" @click="removeItem(index)" 
                                            class="p-2 text-red-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Notes Sub-row -->
                            <div class="flex gap-3 items-center relative">
                                <div class="w-8 flex justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                </div>
                                <div class="flex-1 relative">
                                    <input type="text" :name="'items['+index+'][notes]'" x-model="item.notes" maxlength="500"
                                           placeholder="Additional details for this labor log..." 
                                           class="w-full h-11 rounded-xl border-transparent bg-slate-50/50 text-[10px] px-4 pr-12 font-medium text-slate-500 focus:bg-white focus:border-slate-100 focus:ring-0 transition-all">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[8px] font-bold text-slate-300" x-text="(item.notes?.length || 0) + '/500'"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-4">
                    <button type="button" @click="addItem()" 
                            class="w-full py-4 border-2 border-dashed border-slate-100 rounded-inner text-slate-300 hover:border-sky-300 hover:text-sky-600 hover:bg-sky-50/50 transition-all flex items-center justify-center gap-2 font-black text-[9px] tracking-[0.2em]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Add Another Entry
                    </button>
                </div>
            </form>
        </div>

        <x-slot name="footer">
            <div class="flex justify-center">
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                            detail: {
                                title: 'Confirm Labor Log', 
                                message: 'Are you sure you want to batch log these manpower entries?', 
                                confirmButton: 'Confirm & Save',
                                action: 'logLaborForm',
                                type: 'info'
                            }
                        }))"
                        class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs tracking-widest shadow-xl hover:bg-sky-600 transition-all">
                    Confirm Batch Log
                </button>
            </div>
        </x-slot>
    </x-modal>
</template>

<!-- Log Expense Modal -->
<template x-teleport="body">
    <x-modal name="log-expense" :show="false" @close="showExpenseModal = false" maxWidth="5xl">
        <x-slot name="header">
                <div class="space-y-1">
                    <h4 class="text-3xl font-black text-slate-900">Log <span class="text-sky-600">Miscellaneous</span></h4>
                    <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1">Batch log indirect project costs</p>
                </div>
        </x-slot>

        <div x-data="{ 
            batchDate: '{{ date('Y-m-d') }}',
            items: [{ description: '', amount: '', notes: '' }],
            addItem() {
                this.items.push({ description: '', amount: '', notes: '' });
            },
            removeItem(index) {
                if (this.items.length > 1) this.items.splice(index, 1);
            }
        }">
            <form id="logExpenseForm" action="{{ route('admin.projects.expenses.store', $project) }}" method="POST" 
                  onsubmit="this.querySelectorAll('.comma-input').forEach(i => i.value = i.value.replace(/,/g, ''))">
                @csrf
                
                <div class="bg-slate-50 p-6 rounded-inner border border-slate-100 mb-6">
                    <div class="max-w-xs space-y-2">
                        <label class="text-[10px] font-black text-slate-400 tracking-[0.15em] ml-2">Global Batch Date</label>
                        <input type="date" name="expense_date" x-model="batchDate" required 
                               class="w-full h-12 rounded-xl border-slate-200 bg-white text-xs px-4 font-bold text-slate-600 focus:ring-4 focus:ring-sky-500/10">
                    </div>
                </div>

                <div class="flex items-center gap-4 mb-4 px-2">
                    <h5 class="text-[10px] font-black text-slate-900 tracking-[0.2em]">Miscellaneous List</h5>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <!-- Column Headers -->
                <div class="grid grid-cols-12 gap-3 px-2 mb-2 sticky top-0 bg-white z-10 py-2 border-b border-slate-50">
                    <div class="col-span-9 text-[9px] font-black text-slate-400 tracking-widest px-3">Expense Description</div>
                    <div class="col-span-2 text-[9px] font-black text-slate-400 tracking-widest text-left px-3">Amount (₱)</div>
                    <div class="col-span-1"></div>
                </div>

                <div class="space-y-3 pb-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="p-4 bg-white rounded-inner border border-slate-100 hover:border-sky-200 transition-all space-y-3 group">
                            <div class="grid grid-cols-12 gap-3 items-center">
                                <!-- Description -->
                                <div class="col-span-9">
                                    <input type="text" :name="'items['+index+'][description]'" x-model="item.description" required 
                                           placeholder="e.g. Site Visit Fuel, Building Permits..." 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                </div>

                                <!-- Amount -->
                                <div class="col-span-2">
                                    <input type="text" :name="'items['+index+'][amount]'" x-model="item.amount" required 
                                           placeholder="₱0.00" oninput="formatNumberInput(this)" 
                                           class="w-full h-12 rounded-xl border-slate-100 bg-slate-50 text-[11px] px-4 font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 transition-all comma-input text-left">
                                </div>

                                <!-- Actions -->
                                <div class="col-span-1 flex justify-center">
                                    <button type="button" x-show="items.length > 1" @click="removeItem(index)" 
                                            class="p-2 text-red-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Notes Sub-row -->
                            <div class="flex gap-3 items-center relative">
                                <div class="w-8 flex justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                </div>
                                <div class="flex-1 relative">
                                    <input type="text" :name="'items['+index+'][notes]'" x-model="item.notes" maxlength="500"
                                           placeholder="Additional details for this expense log..." 
                                           class="w-full h-11 rounded-xl border-transparent bg-slate-50/50 text-[10px] px-4 pr-12 font-medium text-slate-500 focus:bg-white focus:border-slate-100 focus:ring-0 transition-all">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[8px] font-bold text-slate-300" x-text="(item.notes?.length || 0) + '/500'"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-4">
                    <button type="button" @click="addItem()" 
                            class="w-full py-4 border-2 border-dashed border-slate-100 rounded-inner text-slate-300 hover:border-sky-300 hover:text-sky-600 hover:bg-sky-50/50 transition-all flex items-center justify-center gap-2 font-black text-[9px] tracking-[0.2em]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Add Another Entry
                    </button>
                </div>
            </form>
        </div>

        <x-slot name="footer">
            <div class="flex justify-center">
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                            detail: {
                                title: 'Confirm Expense Log', 
                                message: 'Are you sure you want to batch log these miscellaneous expenses?', 
                                confirmButton: 'Confirm & Save',
                                action: 'logExpenseForm',
                                type: 'info'
                            }
                        }))"
                        class="px-16 py-4 bg-slate-900 text-white rounded-inner font-bold text-xs tracking-widest shadow-xl hover:bg-sky-600 transition-all">
                    Confirm Batch Log
                </button>
            </div>
        </x-slot>
    </x-modal>
</template>

<!-- Manage Entry Modal -->
<template x-teleport="body">
    <x-modal name="edit-log" :show="false" @close="showEditModal = false">
        <x-slot name="header">
                <div class="space-y-1">
                    <h4 class="text-3xl font-black text-slate-900">Manage <span class="text-sky-600" x-text="editItem.type === 'material' ? 'Material' : (editItem.type === 'labor' ? 'Labor' : 'Expense')"></span></h4>
                    <p class="text-[10px] font-medium text-slate-400 tracking-wide mt-1">Update or remove record</p>
                </div>
        </x-slot>

        <form id="editEntryForm" :action="editItem.url" method="POST" 
              class="space-y-6" onsubmit="stripCommasBeforeSubmit(this)">
            @csrf
            @method('PATCH')
            
            <!-- Material Fields -->
            <div x-show="editItem.type === 'material'" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Item Name</label>
                    <input type="text" name="custom_material_name" x-model="editItem.data.custom_material_name" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10">
                </div>
                <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-3 space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Unit Price (₱)</label>
                        <input type="text" name="unit_price" x-model="editItem.data.unit_price_at_time" oninput="formatNumberInput(this)" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 comma-input">
                    </div>
                    <div class="col-span-2 space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Quantity</label>
                        <input type="text" name="quantity" x-model="editItem.data.quantity" oninput="formatNumberInput(this, false)" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 comma-input">
                    </div>
                    <div class="col-span-2 space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Unit</label>
                        <input type="text" name="custom_unit" x-model="editItem.data.custom_unit" placeholder="e.g. pcs" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6">
                    </div>
                    <div class="col-span-5 space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Log Date</label>
                        <input type="date" name="cost_date" x-model="editItem.data.cost_date" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6">
                    </div>
                </div>
                <div class="space-y-2 relative">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Additional Notes</label>
                    <textarea name="notes" x-model="editItem.data.notes" maxlength="500" placeholder="Optional notes..." 
                              class="w-full h-32 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 py-4 focus:ring-4 focus:ring-sky-500/10 transition-all resize-none"></textarea>
                    <span class="absolute right-4 bottom-4 text-[9px] font-black text-slate-300" x-text="(editItem.data.notes?.length || 0) + '/500'"></span>
                </div>
            </div>

            <!-- Labor Fields -->
            <div x-show="editItem.type === 'labor'" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Service Description</label>
                    <input type="text" name="description" x-model="editItem.data.description" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Amount (₱)</label>
                        <input type="text" name="amount" x-model="editItem.data.amount" oninput="formatNumberInput(this)" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 comma-input">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Log Date</label>
                        <input type="date" name="labor_date" x-model="editItem.data.labor_date" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6">
                    </div>
                </div>
                <div class="space-y-2 relative">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Additional Notes</label>
                    <textarea name="notes" x-model="editItem.data.notes" maxlength="500" placeholder="Optional labor notes..." 
                              class="w-full h-32 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 py-4 focus:ring-4 focus:ring-sky-500/10 transition-all resize-none"></textarea>
                    <span class="absolute right-4 bottom-4 text-[9px] font-black text-slate-300" x-text="(editItem.data.notes?.length || 0) + '/500'"></span>
                </div>
            </div>

            <!-- Expense Fields -->
            <div x-show="editItem.type === 'expense'" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Expense Description</label>
                    <input type="text" name="description" x-model="editItem.data.description" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Amount (₱)</label>
                        <input type="text" name="amount" x-model="editItem.data.amount" oninput="formatNumberInput(this)" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 comma-input">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Log Date</label>
                        <input type="date" name="expense_date" x-model="editItem.data.expense_date" class="w-full h-14 rounded-inner border-slate-100 bg-slate-50 text-xs px-6">
                    </div>
                </div>
                <div class="space-y-2 relative">
                    <label class="text-[11px] font-bold text-slate-500 tracking-wide ml-4">Additional Notes</label>
                    <textarea name="notes" x-model="editItem.data.notes" maxlength="500" placeholder="Optional expense notes..." 
                              class="w-full h-32 rounded-inner border-slate-100 bg-slate-50 text-xs px-6 py-4 focus:ring-4 focus:ring-sky-500/10 transition-all resize-none"></textarea>
                    <span class="absolute right-4 bottom-4 text-[9px] font-black text-slate-300" x-text="(editItem.data.notes?.length || 0) + '/500'"></span>
                </div>
            </div>
        </form>

        <form id="delete-form" :action="editItem.url" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                            detail: {
                                title: 'Delete Entry', 
                                message: 'Are you sure you want to permanently remove this record?', 
                                confirmButton: 'Delete Permanently',
                                action: 'delete-form',
                                type: 'danger'
                            }
                        }))" 
                        class="px-8 py-4 bg-red-50 text-red-600 rounded-inner font-bold text-[11px] hover:bg-red-600 hover:text-white transition-all">
                    Delete Entry
                </button>
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                            detail: {
                                title: 'Save Changes', 
                                message: 'Are you sure you want to update this record?', 
                                confirmButton: 'Update Record',
                                action: () => {
                                    let form = document.getElementById('editEntryForm');
                                    stripCommasBeforeSubmit(form);
                                    form.submit();
                                },
                                type: 'info'
                            }
                        }))"
                        :disabled="!isDirty()"
                        :class="!isDirty() ? 'opacity-40 cursor-not-allowed bg-slate-400' : 'bg-slate-900 hover:bg-sky-600 shadow-xl'"
                        class="px-12 py-4 text-white rounded-inner font-bold text-xs transition-all">
                    Save Changes
                </button>
            </div>
        </x-slot>
    </x-modal>
</template>
