<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                    Your <span class="text-sky-600 italic">Consultations</span>
                </h2>
                <p class="text-sm font-medium text-slate-500">Track the status of your RJ Studio project briefs.</p>
            </div>
            <button @click.prevent="$dispatch('open-modal', 'appointment-modal')" class="inline-flex items-center px-8 py-3.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:scale-105 transition shadow-xl">
                New Request
            </button>
        </div>
    </x-slot>

    <script>
        window.initialClientAppointmentsData = @json($appointments);
    </script>
    <div class="py-12 bg-[#F8FAFC] min-h-screen" x-data="{ 
        filterStatus: 'all',
        filterDate: 'all',
        customRange: '',
        selectedAppointment: null,
        
        // Pagination State
        currentPage: 1,
        rowsPerPage: 10,
        appointments: window.initialClientAppointmentsData,

        get filteredAppointments() {
            return this.appointments.filter(app => this.matchesFilter(app));
        },

        get paginatedAppointments() {
            let start = (this.currentPage - 1) * parseInt(this.rowsPerPage);
            return this.filteredAppointments.slice(start, start + parseInt(this.rowsPerPage));
        },

        get totalPages() {
            return Math.ceil(this.filteredAppointments.length / parseInt(this.rowsPerPage));
        },

        matchesFilter(appointment) {
            // Status Filter
            if (this.filterStatus !== 'all' && appointment.status !== this.filterStatus) return false;
            
            // Date Filter
            const appDate = new Date(appointment.appointment_date);
            const now = new Date();
            
            if (this.filterDate === 'today') {
                return appDate.toDateString() === now.toDateString();
            }
            
            if (this.filterDate === 'this_week') {
                const startOfWeek = new Date(now);
                startOfWeek.setDate(now.getDate() - now.getDay());
                const endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 6);
                return appDate >= startOfWeek && appDate <= endOfWeek;
            }
            
            if (this.filterDate === 'this_month') {
                return appDate.getMonth() === now.getMonth() && appDate.getFullYear() === now.getFullYear();
            }
            
            if (this.filterDate === 'this_year') {
                return appDate.getFullYear() === now.getFullYear();
            }
            
            if (this.filterDate === 'custom' && this.customRange) {
                const [start, end] = this.customRange.split(' to ');
                if (start && end) {
                    const startDate = new Date(start);
                    const endDate = new Date(end);
                    endDate.setHours(23, 59, 59);
                    return appDate >= startDate && appDate <= endDate;
                }
            }
            
            return true;
        },

        openDetails(appointment) {
            this.selectedAppointment = appointment;
            $dispatch('open-modal', 'view-appointment');
        },

        formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        },

        formatTime(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }
    }" x-init="$watch('filterStatus', () => currentPage = 1); $watch('filterDate', () => currentPage = 1); $watch('rowsPerPage', () => currentPage = 1)">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Filter Bar -->
            <div class="flex flex-wrap items-center justify-between gap-6 mb-10">
                <!-- Status Tabs -->
                <div class="flex p-1.5 bg-slate-100 rounded-2xl">
                    <button @click="filterStatus = 'all'" 
                            :class="filterStatus === 'all' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest">
                        All
                    </button>
                    <button @click="filterStatus = 'pending'" 
                            :class="filterStatus === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest">
                        Pending
                    </button>
                    <button @click="filterStatus = 'confirmed'" 
                            :class="filterStatus === 'confirmed' ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest">
                        Confirmed
                    </button>
                    <button @click="filterStatus = 'cancelled'" 
                            :class="filterStatus === 'cancelled' ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'text-slate-500 hover:text-slate-700'"
                            class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest">
                        Cancelled
                    </button>
                </div>

                <!-- Date Multi-Filter -->
                <div class="flex items-center gap-4 bg-white p-1.5 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-2 pl-4">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 whitespace-nowrap">Timeframe</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <select x-model="filterDate" 
                                class="border-none bg-slate-50 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-900 focus:ring-0 cursor-pointer min-w-[140px]">
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
                                   class="w-48 border-none bg-sky-50 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest text-sky-900 focus:ring-0 placeholder:text-sky-300">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-card border border-slate-100 shadow-sm overflow-hidden">
                <!-- Mobile List (Visible on mobile, hidden on desktop) -->
                <div class="block md:hidden divide-y divide-slate-100">
                    <template x-for="appointment in paginatedAppointments" :key="appointment.id">
                        <div class="p-6 space-y-4 hover:bg-slate-50/50 cursor-pointer" @click="openDetails(appointment)">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-sky-50 rounded-inner flex flex-col items-center justify-center border border-sky-100/50">
                                        <span class="text-[8px] font-bold text-sky-600 uppercase" x-text="new Date(appointment.appointment_date).toLocaleString('en-US', { month: 'short' })"></span>
                                        <span class="text-sm font-bold text-sky-900 leading-none" x-text="new Date(appointment.appointment_date).getDate()"></span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900" x-text="formatTime(appointment.appointment_date)"></p>
                                        <p class="text-[9px] text-slate-400 font-medium" x-text="new Date(appointment.appointment_date).getFullYear()"></p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm"
                                      :class="{
                                        'bg-amber-50 text-amber-600 border border-amber-100': appointment.status === 'pending',
                                        'bg-emerald-50 text-emerald-600 border border-emerald-100': appointment.status === 'confirmed',
                                        'bg-rose-50 text-rose-600 border border-rose-100': appointment.status === 'declined',
                                        'bg-slate-50 text-slate-500 border border-slate-100': appointment.status === 'cancelled'
                                      }">
                                    <span x-text="appointment.status"></span>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-xs font-serif text-slate-900" x-text="appointment.service_type"></h4>
                                <p class="text-[11px] text-slate-500 italic mt-1 line-clamp-2" x-text="'&quot;' + (appointment.message || 'No details provided.') + '&quot;'"></p>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="paginatedAppointments.length === 0">
                        <div class="p-8 text-center">
                            <p class="text-slate-400 font-serif text-lg">No appointments found yet.</p>
                            <button @click.prevent="$dispatch('open-modal', 'appointment-modal')" class="text-sky-600 font-bold uppercase text-[9px] tracking-widest mt-2 inline-block hover:underline">Start your project brief &rarr;</button>
                        </div>
                    </template>
                </div>

                <!-- Desktop Table (Hidden on mobile, visible on desktop) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Date & Time</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Service Type</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Project Brief</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <template x-for="appointment in paginatedAppointments" :key="appointment.id">
                                <tr class="group hover:bg-slate-50/50 cursor-pointer active:scale-[0.99]"
                                    @click="openDetails(appointment)">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-sky-50 rounded-inner flex flex-col items-center justify-center border border-sky-100/50 group-hover:scale-110 transition-transform">
                                                <span class="text-[9px] font-bold text-sky-600 uppercase" x-text="new Date(appointment.appointment_date).toLocaleString('en-US', { month: 'short' })"></span>
                                                <span class="text-lg font-bold text-sky-900 leading-none" x-text="new Date(appointment.appointment_date).getDate()"></span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-900" x-text="formatTime(appointment.appointment_date)"></p>
                                                <p class="text-[10px] text-slate-400 font-medium" x-text="new Date(appointment.appointment_date).getFullYear()"></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-sm font-serif text-slate-900 group-hover:text-sky-600 transition-colors" x-text="appointment.service_type"></span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="max-w-xs">
                                            <p class="text-xs text-slate-500 italic line-clamp-2" x-text="'&quot;' + (appointment.message || 'No details provided.') + '&quot;'"></p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm transition-all duration-300"
                                              :class="{
                                                'bg-amber-50 text-amber-600 border border-amber-100': appointment.status === 'pending',
                                                'bg-emerald-50 text-emerald-600 border border-emerald-100': appointment.status === 'confirmed',
                                                'bg-rose-50 text-rose-600 border border-rose-100': appointment.status === 'declined',
                                                'bg-slate-50 text-slate-500 border border-slate-100': appointment.status === 'cancelled'
                                              }">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2"
                                                  :class="{
                                                    'bg-amber-500': appointment.status === 'pending',
                                                    'bg-emerald-500': appointment.status === 'confirmed',
                                                    'bg-rose-500': appointment.status === 'declined',
                                                    'bg-slate-400': appointment.status === 'cancelled'
                                                  }"></span>
                                            <span x-text="appointment.status"></span>
                                        </span>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty State -->
                            <template x-if="paginatedAppointments.length === 0">
                                <tr>
                                    <td colspan="4" class="px-8 py-24 text-center">
                                        <p class="text-slate-400 font-serif text-xl">No appointments found yet.</p>
                                        <button @click.prevent="$dispatch('open-modal', 'appointment-modal')" class="text-sky-600 font-bold uppercase text-[10px] tracking-widest mt-4 inline-block hover:underline">Start your project brief &rarr;</button>
                                    </td>
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
                </div>
            </div>
        </div>

        <!-- Appointment Details Modal -->
        <x-modal name="view-appointment" maxWidth="xl">
            <div class="p-8 lg:p-10" x-show="selectedAppointment">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-serif text-2xl text-slate-900">Consultation Details</h3>
                    <button @click="$dispatch('close-modal', 'view-appointment')" class="text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="w-16 h-16 bg-white rounded-2xl flex flex-col items-center justify-center border border-slate-100 shadow-sm">
                            <span class="text-[10px] font-bold text-sky-600 uppercase" x-text="selectedAppointment ? new Date(selectedAppointment.appointment_date).toLocaleString('en-us', {month:'short'}) : ''"></span>
                            <span class="text-2xl font-bold text-sky-900 leading-none" x-text="selectedAppointment ? new Date(selectedAppointment.appointment_date).getDate() : ''"></span>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-slate-900" x-text="selectedAppointment ? new Date(selectedAppointment.appointment_date).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true}) : ''"></p>
                            <p class="text-xs text-slate-500 font-medium" x-text="selectedAppointment ? selectedAppointment.service_type : ''"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Project Brief</label>
                            <p class="text-sm text-slate-600 italic leading-relaxed" x-text="selectedAppointment ? selectedAppointment.message : 'No message'"></p>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Status</label>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest"
                                    :class="{
                                        'bg-green-100 text-green-600': selectedAppointment && selectedAppointment.status === 'confirmed',
                                        'bg-rose-100 text-rose-600': selectedAppointment && selectedAppointment.status === 'declined',
                                        'bg-slate-100 text-slate-600': selectedAppointment && selectedAppointment.status === 'cancelled',
                                        'bg-amber-100 text-amber-600': selectedAppointment && selectedAppointment.status === 'pending'
                                    }">
                                    <span class="w-2 h-2 rounded-full mr-2" 
                                          :class="{
                                              'bg-green-500': selectedAppointment && selectedAppointment.status === 'confirmed',
                                              'bg-rose-500': selectedAppointment && selectedAppointment.status === 'declined',
                                              'bg-slate-400': selectedAppointment && selectedAppointment.status === 'cancelled',
                                              'bg-amber-500': selectedAppointment && selectedAppointment.status === 'pending'
                                          }"></span>
                                    <span x-text="selectedAppointment ? selectedAppointment.status : ''"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 border-t border-slate-100 flex items-center gap-4" x-show="selectedAppointment && selectedAppointment.status === 'pending'">
                        <form :action="`/appointments/${selectedAppointment.id}/cancel`" method="POST" class="w-full" x-ref="cancelForm">
                            @csrf
                            @method('PATCH')
                            <button type="button" 
                                    @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                        detail: { 
                                            title: 'Cancel Consultation',
                                            message: 'Are you sure you want to cancel this request? This action cannot be undone.',
                                            confirmButton: 'Yes, Cancel Request',
                                            action: () => $refs.cancelForm.submit()
                                        } 
                                    }))"
                                    class="w-full py-4 bg-white border-2 border-red-100 text-red-500 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-red-50 hover:border-red-200 transition-all shadow-sm">
                                Cancel My Request
                            </button>
                        </form>
                    </div>

                    <div x-show="selectedAppointment && selectedAppointment.status !== 'pending'" class="pt-4 text-center">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">This request is already <span x-text="selectedAppointment.status"></span></p>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>


</x-app-layout>