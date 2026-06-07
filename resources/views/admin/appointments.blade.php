<x-admin-layout>
    <script>
        window.initialAppointmentsData = @json($appointments);
    </script>
    <div class="space-y-8" x-data="{ 
        filterStatus: 'all',
        filterDate: 'all',
        customRange: '',
        selectedAppointment: null,
        submitting: false,
        
        // Pagination State
        currentPage: 1,
        rowsPerPage: 10,
        appointments: window.initialAppointmentsData,

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
            // Reset to page 1 when filters change (logic handled by watchers or simple checks)
            
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
            $dispatch('open-modal', 'admin-view-appointment');
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
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Consultation <span class="text-sky-600 italic">Registry</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Client Management • Randolf Jan Studio</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-card border border-slate-100 shadow-sm">
                <div class="px-6 py-2 rounded-btn bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                    {{ count($appointments) }} Total Bookings
                </div>
            </div>
        </div>


        <!-- Main Registry Card -->
        <div class="bg-white rounded-card border border-slate-100 shadow-sm overflow-hidden">
            <!-- Table Controls -->
            <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/30">
                <div class="flex p-1 bg-white rounded-inner border border-slate-100 shadow-sm self-start">
                    <button @click="filterStatus = 'all'" 
                            :class="filterStatus === 'all' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-400 hover:text-slate-600'"
                            class="px-6 py-2.5 rounded-btn text-[10px] font-black uppercase tracking-widest transition-all">
                        All
                    </button>
                    <button @click="filterStatus = 'pending'" 
                            :class="filterStatus === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'text-slate-400 hover:text-slate-600'"
                            class="px-6 py-2.5 rounded-btn text-[10px] font-black uppercase tracking-widest transition-all">
                        Pending
                    </button>
                    <button @click="filterStatus = 'confirmed'" 
                            :class="filterStatus === 'confirmed' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'text-slate-400 hover:text-slate-600'"
                            class="px-6 py-2.5 rounded-btn text-[10px] font-black uppercase tracking-widest transition-all">
                        Confirmed
                    </button>
                    <button @click="filterStatus = 'cancelled'" 
                            :class="filterStatus === 'cancelled' ? 'bg-slate-500 text-white shadow-lg shadow-slate-200' : 'text-slate-400 hover:text-slate-600'"
                            class="px-6 py-2.5 rounded-btn text-[10px] font-black uppercase tracking-widest transition-all">
                        Cancelled
                    </button>
                    <button @click="filterStatus = 'declined'" 
                            :class="filterStatus === 'declined' ? 'bg-rose-500 text-white shadow-lg shadow-rose-200' : 'text-slate-400 hover:text-slate-600'"
                            class="px-6 py-2.5 rounded-btn text-[10px] font-black uppercase tracking-widest transition-all">
                        Declined
                    </button>
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
                        
                        <div class="grid grid-cols-2 gap-4 text-left">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-1">Client</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-[9px]">
                                        <span x-text="appointment.first_name[0] + appointment.last_name[0]"></span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700" x-text="appointment.first_name + ' ' + appointment.last_name"></span>
                                </div>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-1">Service</span>
                                <span class="text-xs font-bold text-sky-600 uppercase tracking-wider block" x-text="appointment.service_type"></span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-1">Project Brief</span>
                            <p class="text-[11px] text-slate-500 italic line-clamp-2" x-text="'&quot;' + (appointment.message || 'No details provided.') + '&quot;'"></p>
                        </div>
                    </div>
                </template>
                
                <template x-if="paginatedAppointments.length === 0">
                    <div class="p-8 text-center">
                        <p class="text-slate-400 font-serif text-lg">No appointments found yet.</p>
                    </div>
                </template>
            </div>

            <!-- Desktop Table (Hidden on mobile, visible on desktop) -->
            <div class="hidden md:block overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-50">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Client Info</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Consultation Detail</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Schedule</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="appointment in paginatedAppointments" :key="appointment.id">
                            <tr class="group hover:bg-slate-50/50 transition-all cursor-pointer active:scale-[0.99]"
                                @click="openDetails(appointment)">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-inner bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-xs group-hover:scale-110 transition-transform">
                                            <span x-text="appointment.first_name[0] + appointment.last_name[0]"></span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase tracking-widest" x-text="appointment.first_name + ' ' + appointment.last_name"></p>
                                            <p class="text-[10px] text-slate-500 font-medium" x-text="appointment.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-bold text-sky-600 uppercase tracking-widest" x-text="appointment.service_type"></p>
                                        <p class="text-[10px] text-slate-500 italic max-w-xs truncate" x-text="appointment.message || 'No message provided'"></p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-slate-900" x-text="formatDate(appointment.appointment_date)"></p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest" x-text="formatTime(appointment.appointment_date)"></p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-full border text-[8px] font-black uppercase tracking-widest transition-all duration-300"
                                          :class="{
                                            'bg-amber-50 text-amber-600 border-amber-100': appointment.status === 'pending',
                                            'bg-emerald-50 text-emerald-600 border-emerald-100': appointment.status === 'confirmed',
                                            'bg-rose-50 text-rose-600 border-rose-100': appointment.status === 'declined',
                                            'bg-slate-50 text-slate-500 border-slate-100': appointment.status === 'cancelled'
                                          }"
                                          x-text="appointment.status">
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <template x-if="paginatedAppointments.length === 0">
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="max-w-xs mx-auto space-y-3">
                                        <div class="w-16 h-16 bg-slate-50 rounded-card flex items-center justify-center text-slate-300 mx-auto">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                        <p class="text-xs font-black uppercase tracking-widest text-slate-400">No matching records</p>
                                        <p class="text-[10px] text-slate-400">Try adjusting your filters or search criteria.</p>
                                    </div>
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

        <!-- Admin: Appointment Details & Approval Modal -->
        <x-modal name="admin-view-appointment" maxWidth="xl">
            <div class="p-8 lg:p-10" x-show="selectedAppointment">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-serif text-2xl text-slate-900">Consultation Brief</h3>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">Reviewing Request Details</p>
                    </div>
                    <button @click="$dispatch('close-modal', 'admin-view-appointment')" class="text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Client Summary -->
                    <div class="flex items-center gap-5 p-6 bg-slate-50 rounded-card border border-slate-100">
                        <div class="w-14 h-14 bg-sky-900 text-white rounded-inner flex items-center justify-center font-bold text-xl" x-text="selectedAppointment ? selectedAppointment.first_name[0] + selectedAppointment.last_name[0] : ''"></div>
                        <div>
                            <p class="text-sm font-black text-slate-900 uppercase tracking-widest" x-text="selectedAppointment ? selectedAppointment.first_name + ' ' + selectedAppointment.last_name : ''"></p>
                            <p class="text-xs text-slate-500 font-medium" x-text="selectedAppointment ? selectedAppointment.email : ''"></p>
                            <p class="text-[10px] text-sky-600 font-bold" x-text="selectedAppointment ? selectedAppointment.phone : ''"></p>
                        </div>
                    </div>

                    <!-- Appointment Meta -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-card border border-slate-100 shadow-sm">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Requested Service</label>
                            <p class="text-xs font-bold text-slate-900" x-text="selectedAppointment ? selectedAppointment.service_type : ''"></p>
                        </div>
                        <div class="p-4 bg-white rounded-card border border-slate-100 shadow-sm">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Proposed Date & Time</label>
                            <p class="text-xs font-bold text-slate-900" x-text="selectedAppointment ? new Date(selectedAppointment.appointment_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'}) + ' @ ' + new Date(selectedAppointment.appointment_date).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'}) : ''"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Message / Brief</label>
                        <div class="p-5 bg-slate-50 rounded-card border border-slate-100">
                            <p class="text-xs text-slate-600 italic leading-relaxed" x-text="selectedAppointment ? selectedAppointment.message : 'No message provided'"></p>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    <div class="pt-8 border-t border-slate-100 space-y-3" x-show="selectedAppointment && selectedAppointment.status === 'pending'">
                        <div class="flex gap-4">
                            <!-- Cancel Form (Admin side rejection) -->
                            <form :action="`/appointments/${selectedAppointment.id}/cancel`" method="POST" class="flex-1" id="admin-decline-form">
                                @csrf
                                @method('PATCH')
                                <button type="button" 
                                        :disabled="submitting"
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                            detail: { 
                                                title: 'Reject Request',
                                                message: 'Are you sure you want to decline this consultation request?',
                                                confirmButton: 'Decline Request',
                                                action: () => { submitting = true; document.getElementById('admin-decline-form').submit(); }
                                            } 
                                        }))"
                                        class="w-full py-4 bg-white border-2 border-slate-100 text-slate-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-50 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                                    <template x-if="submitting">
                                        <svg class="animate-spin h-3 w-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <span>Decline</span>
                                </button>
                            </form>

                            <!-- Approve Form -->
                            <form :action="`/admin/appointments/${selectedAppointment.id}/confirm`" method="POST" class="flex-1" id="admin-approve-form">
                                @csrf
                                @method('PATCH')
                                <button type="button" 
                                        :disabled="submitting"
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                            detail: { 
                                                title: 'Approve Consultation',
                                                message: 'This will officially confirm the appointment and notify the client.',
                                                confirmButton: 'Confirm Booking',
                                                action: () => { submitting = true; document.getElementById('admin-approve-form').submit(); }
                                            } 
                                        }))"
                                        class="w-full py-4 bg-sky-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-700 shadow-lg shadow-sky-200 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                                    <template x-if="submitting">
                                        <svg class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <span>Approve Request</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div x-show="selectedAppointment && selectedAppointment.status !== 'pending'" class="pt-4 text-center">
                        <div class="inline-flex items-center px-6 py-2 rounded-full border border-slate-100 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Status: <span class="ml-2 font-black" 
                                          :class="{
                                              'text-emerald-600': selectedAppointment.status === 'confirmed',
                                              'text-rose-600': selectedAppointment.status === 'declined',
                                              'text-slate-600': selectedAppointment.status === 'cancelled'
                                          }" 
                                          x-text="selectedAppointment.status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>
</x-admin-layout>
