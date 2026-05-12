<x-admin-layout>
    <div class="space-y-8" x-data="{ 
        filterStatus: 'all',
        filterDate: 'all',
        customRange: '',
        selectedAppointment: null,
        
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
            $dispatch('open-modal', 'admin-view-appointment');
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-3xl font-serif text-slate-900 leading-tight">Consultation <span class="text-sky-600 italic">Registry</span></h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Client Management • Randolf Jan Studio</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="px-6 py-2 rounded-xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">
                    {{ count($appointments) }} Total Bookings
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center justify-between gap-6">
            <!-- Status Tabs -->
            <div class="flex p-1 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <button @click="filterStatus = 'all'" 
                        :class="filterStatus === 'all' ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-500 hover:bg-slate-50'"
                        class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    All
                </button>
                <button @click="filterStatus = 'pending'" 
                        :class="filterStatus === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'text-slate-500 hover:bg-slate-50'"
                        class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Pending
                </button>
                <button @click="filterStatus = 'confirmed'" 
                        :class="filterStatus === 'confirmed' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'text-slate-500 hover:bg-slate-50'"
                        class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Confirmed
                </button>
                <button @click="filterStatus = 'cancelled'" 
                        :class="filterStatus === 'cancelled' ? 'bg-rose-500 text-white shadow-lg shadow-rose-200' : 'text-slate-500 hover:bg-slate-50'"
                        class="px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
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
                            class="border-none bg-slate-50 rounded-xl px-4 py-2 text-xs font-bold text-slate-900 focus:ring-0 cursor-pointer min-w-[140px]">
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
                               class="w-48 border-none bg-sky-50 rounded-xl px-4 py-2 text-xs font-bold text-sky-900 focus:ring-0 placeholder:text-sky-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
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
                        @forelse($appointments as $appointment)
                            <tr class="group hover:bg-slate-50/50 transition-all cursor-pointer active:scale-[0.99]"
                                @click="openDetails({{ $appointment->toJson() }})"
                                x-show="matchesFilter({{ $appointment->toJson() }})"
                                x-transition>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600 font-bold text-xs group-hover:scale-110 transition-transform">
                                            {{ substr($appointment->first_name, 0, 1) }}{{ substr($appointment->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $appointment->first_name }} {{ $appointment->last_name }}</p>
                                            <p class="text-[10px] text-slate-500 font-medium">{{ $appointment->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-bold text-sky-600 uppercase tracking-widest">{{ $appointment->service_type }}</p>
                                        <p class="text-[10px] text-slate-500 italic max-w-xs truncate">{{ $appointment->message ?? 'No message provided' }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ][$appointment->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full border text-[8px] font-black uppercase tracking-widest {{ $statusClasses }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-xs font-black uppercase tracking-widest text-slate-400">No appointments scheduled yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                    <div class="flex items-center gap-5 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="w-14 h-14 bg-sky-900 text-white rounded-2xl flex items-center justify-center font-bold text-xl" x-text="selectedAppointment ? selectedAppointment.first_name[0] + selectedAppointment.last_name[0] : ''"></div>
                        <div>
                            <p class="text-sm font-black text-slate-900 uppercase tracking-widest" x-text="selectedAppointment ? selectedAppointment.first_name + ' ' + selectedAppointment.last_name : ''"></p>
                            <p class="text-xs text-slate-500 font-medium" x-text="selectedAppointment ? selectedAppointment.email : ''"></p>
                            <p class="text-[10px] text-sky-600 font-bold" x-text="selectedAppointment ? selectedAppointment.phone : ''"></p>
                        </div>
                    </div>

                    <!-- Appointment Meta -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Requested Service</label>
                            <p class="text-xs font-bold text-slate-900" x-text="selectedAppointment ? selectedAppointment.service_type : ''"></p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Proposed Date</label>
                            <p class="text-xs font-bold text-slate-900" x-text="selectedAppointment ? new Date(selectedAppointment.appointment_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'}) : ''"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Message / Brief</label>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs text-slate-600 italic leading-relaxed" x-text="selectedAppointment ? selectedAppointment.message : 'No message provided'"></p>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    <div class="pt-8 border-t border-slate-100 space-y-3" x-show="selectedAppointment && selectedAppointment.status === 'pending'">
                        <div class="flex gap-4">
                            <!-- Approve Form -->
                            <form :action="`/admin/appointments/${selectedAppointment.id}/confirm`" method="POST" class="flex-1" x-ref="approveForm">
                                @csrf
                                @method('PATCH')
                                <button type="button" 
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                            detail: { 
                                                title: 'Approve Consultation',
                                                message: 'This will officially confirm the appointment and notify the client.',
                                                confirmButton: 'Confirm Booking',
                                                action: () => $refs.approveForm.submit()
                                            } 
                                        }))"
                                        class="w-full py-4 bg-sky-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-700 shadow-lg shadow-sky-200 transition-all">
                                    Approve Request
                                </button>
                            </form>

                            <!-- Cancel Form (Admin side rejection) -->
                            <form :action="`/appointments/${selectedAppointment.id}/cancel`" method="POST" class="flex-1" x-ref="adminCancelForm">
                                @csrf
                                @method('PATCH')
                                <button type="button" 
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                            detail: { 
                                                title: 'Reject Request',
                                                message: 'Are you sure you want to decline this consultation request?',
                                                confirmButton: 'Decline Request',
                                                action: () => $refs.adminCancelForm.submit()
                                            } 
                                        }))"
                                        class="w-full py-4 bg-white border-2 border-slate-100 text-slate-400 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-50 transition-all">
                                    Decline
                                </button>
                            </form>
                        </div>
                    </div>

                    <div x-show="selectedAppointment && selectedAppointment.status !== 'pending'" class="pt-4 text-center">
                        <div class="inline-flex items-center px-6 py-2 rounded-full border border-slate-100 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Status: <span class="ml-2" :class="selectedAppointment.status === 'confirmed' ? 'text-emerald-600' : 'text-rose-600'" x-text="selectedAppointment.status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>
</x-admin-layout>
