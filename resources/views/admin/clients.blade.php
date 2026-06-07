<x-admin-layout>
    <script>
        window.initialClientsData = @json($clients);
    </script>
    <div class="space-y-8" x-data="{
        searchQuery: '',
        filterDate: 'all',
        customRange: '',
        showAddClient: {{ $errors->any() ? 'true' : 'false' }},
        
        // Pagination State
        currentPage: 1,
        rowsPerPage: 10,
        clients: window.initialClientsData,

        get filteredClients() {
            return this.clients.filter(client => {
                // Search Query
                if (this.searchQuery) {
                    const query = this.searchQuery.toLowerCase();
                    const nameMatch = client.name.toLowerCase().includes(query);
                    const emailMatch = client.email.toLowerCase().includes(query);
                    if (!nameMatch && !emailMatch) return false;
                }

                // Date Filter
                const clientDate = new Date(client.created_at);
                const now = new Date();
                
                if (this.filterDate === 'today') {
                    return clientDate.toDateString() === now.toDateString();
                }
                
                if (this.filterDate === 'this_week') {
                    const startOfWeek = new Date(now);
                    startOfWeek.setDate(now.getDate() - now.getDay());
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);
                    return clientDate >= startOfWeek && clientDate <= endOfWeek;
                }
                
                if (this.filterDate === 'this_month') {
                    return clientDate.getMonth() === now.getMonth() && clientDate.getFullYear() === now.getFullYear();
                }
                
                if (this.filterDate === 'this_year') {
                    return clientDate.getFullYear() === now.getFullYear();
                }
                
                if (this.filterDate === 'custom' && this.customRange) {
                    const [start, end] = this.customRange.split(' to ');
                    if (start && end) {
                        const startDate = new Date(start);
                        const endDate = new Date(end);
                        endDate.setHours(23, 59, 59);
                        return clientDate >= startDate && clientDate <= endDate;
                    }
                }

                return true;
            });
        },

        get paginatedClients() {
            let start = (this.currentPage - 1) * parseInt(this.rowsPerPage);
            return this.filteredClients.slice(start, start + parseInt(this.rowsPerPage));
        },

        get totalPages() {
            return Math.ceil(this.filteredClients.length / parseInt(this.rowsPerPage));
        },

        formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        getDaysAgo(dateStr) {
            const date = new Date(dateStr);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            if (diffDays <= 1) return 'today';
            return `${diffDays} days ago`;
        }
    }" x-init="$watch('searchQuery', () => currentPage = 1); $watch('filterDate', () => currentPage = 1); $watch('rowsPerPage', () => currentPage = 1)">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Client <span class="text-sky-600 italic">Directory</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">User Management • Randolf Jan Studio</p>
            </div>
            
            <div class="flex gap-4">
                <x-primary-button @click="showAddClient = true" class="gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Client
                </x-primary-button>
            </div>
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

        <!-- Client List Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <!-- Table Controls -->
            <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/30">
                <!-- Search input -->
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" x-model="searchQuery" placeholder="Search clients by name or email..." 
                           class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-btn text-xs font-medium placeholder:text-slate-400 focus:ring-sky-500/20 focus:border-sky-500 transition-all outline-none">
                </div>

                <!-- Date Multi-Filter -->
                <div class="flex items-center gap-4 bg-white p-1.5 rounded-inner border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-2 pl-4">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Timeframe</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <select x-model="filterDate" 
                                class="border-none bg-slate-50 rounded-inner px-4 py-2 text-xs font-bold text-slate-900 focus:ring-0 cursor-pointer min-w-[140px]">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="this_week">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="this_year">This Year</option>
                            <option value="custom">Custom Range</option>
                        </select>

                        <!-- Custom Range Picker (Flatpickr) -->
                        <div x-show="filterDate === 'custom'" 
                             x-transition
                             x-data="{ 
                                init() {
                                    flatpickr(this.$refs.rangePicker, {
                                        mode: 'range',
                                        dateFormat: 'Y-m-d',
                                        onChange: (selectedDates, dateStr) => {
                                            customRange = dateStr;
                                        }
                                    });
                                }
                             }" class="relative">
                            <input x-ref="rangePicker" type="text" placeholder="Select Range..." 
                                   class="w-48 border-none bg-sky-50 rounded-inner px-4 py-2 text-xs font-bold text-sky-900 focus:ring-0 placeholder:text-sky-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile List (Visible on mobile, hidden on desktop) -->
            <div class="block md:hidden divide-y divide-slate-50">
                <template x-for="client in paginatedClients" :key="client.id">
                    <div @click="window.location = '/admin/clients/' + client.id" class="p-6 space-y-4 hover:bg-slate-50/50 hover:shadow-md transition-all cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-sm border border-sky-100/50">
                                <span x-text="client.name[0].toUpperCase()"></span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900" x-text="client.name"></p>
                                <p class="text-[10px] text-slate-400 font-medium lowercase italic" x-text="'@' + client.name.toLowerCase().replace(/\s+/g, '')"></p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-left">
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block">Contact</span>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-medium text-slate-600 truncate max-w-[120px]" x-text="client.email"></span>
                                </div>
                                <template x-if="client.phone">
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        <span class="text-[10px] font-medium text-slate-600" x-text="client.phone"></span>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block">Registered</span>
                                <p class="text-xs font-bold text-slate-900" x-text="formatDate(client.created_at)"></p>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest" x-text="getDaysAgo(client.created_at)"></p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-slate-50">
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Consultations</span>
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100">
                                <span class="text-[10px] font-black text-slate-900" x-text="client.appointments ? client.appointments.length : 0"></span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-2">Bookings</span>
                            </div>
                        </div>
                    </div>
                </template>
                
                <template x-if="paginatedClients.length === 0">
                    <div class="p-8 text-center text-slate-400 italic text-sm">No clients found.</div>
                </template>
            </div>

            <!-- Desktop Table (Hidden on mobile, visible on desktop) -->
            <div class="hidden md:block overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Client Profile</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Contact Info</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Account Created</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Consultations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="client in paginatedClients" :key="client.id">
                            <tr @click="window.location = '/admin/clients/' + client.id" class="group hover:bg-slate-50/50 transition-all cursor-pointer">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-sm border border-sky-100/50 group-hover:scale-110 transition-transform">
                                            <span x-text="client.name[0].toUpperCase()"></span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-900" x-text="client.name"></p>
                                            <p class="text-[10px] text-slate-400 font-medium lowercase italic" x-text="'@' + client.name.toLowerCase().replace(/\s+/g, '')"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-[10px] font-medium text-slate-600" x-text="client.email"></p>
                                        </div>
                                        <template x-if="client.phone">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                <p class="text-[10px] font-medium text-slate-600" x-text="client.phone"></p>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-slate-900" x-text="formatDate(client.created_at)"></p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest" x-text="getDaysAgo(client.created_at)"></p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-50 border border-slate-100">
                                        <span class="text-[10px] font-black text-slate-900" x-text="client.appointments ? client.appointments.length : 0"></span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-2">Bookings</span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        
                        <template x-if="paginatedClients.length === 0">
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 italic">No clients found.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer (Pagination) -->
            <div class="p-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                <!-- Rows Per Page -->
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Rows</span>
                    <select x-model="rowsPerPage" class="bg-white border-slate-100 rounded-btn text-xs font-bold text-slate-600 focus:ring-sky-500/20 px-4 py-1.5 min-w-[80px]">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="currentPage--" 
                            :disabled="currentPage === 1"
                            class="p-2.5 rounded-btn bg-white border border-slate-100 text-slate-400 hover:text-slate-900 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>

                    <div class="flex items-center gap-1">
                        <template x-for="page in totalPages">
                            <button @click="currentPage = page"
                                    class="w-9 h-9 rounded-btn text-[10px] font-black transition-all"
                                    :class="currentPage === page ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-400 hover:text-slate-600 border border-slate-100'"
                                    x-text="page"
                                    x-show="page === 1 || page === totalPages || Math.abs(page - currentPage) <= 1">
                            </button>
                        </template>
                    </div>

                    <button @click="currentPage++" 
                            :disabled="currentPage === totalPages || totalPages === 0"
                            class="p-2.5 rounded-btn bg-white border border-slate-100 text-slate-400 hover:text-slate-900 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
        <!-- Add Client Modal -->
        <template x-teleport="body">
            <div x-show="showAddClient" x-cloak class="fixed inset-0 z-[300] flex items-center justify-center p-6">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-500" @click="showAddClient = false"></div>
                
                <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-2xl p-12 border border-slate-100" 
                     x-show="showAddClient"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h4 class="text-3xl font-serif text-slate-900 italic">Register <span class="text-sky-600">Client</span></h4>
                            <p class="text-[10px] text-slate-400 font-black tracking-widest mt-1">Create Account for Client Access</p>
                        </div>
                        <button @click="showAddClient = false" class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">First Name</label>
                                <input type="text" name="first_name" required placeholder="John" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Last Name</label>
                                <input type="text" name="last_name" required placeholder="Doe" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Email Address</label>
                            <input type="email" name="email" required placeholder="Ex: client@domain.com" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Password</label>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                        </div>

                        <div class="flex justify-center mt-10">
                            <button type="submit" class="px-16 py-4 bg-slate-900 text-white rounded-2xl font-bold text-xs shadow-2xl hover:bg-sky-600 transition-all">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</x-admin-layout>
