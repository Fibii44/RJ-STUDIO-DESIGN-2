<x-app-layout>
    <x-slot name="header">
        <div class="pt-10 pb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-4xl font-serif text-slate-900 leading-tight">My <span class="text-sky-600 italic">Calendar</span></h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">Timeline & Appointment Pins</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button @click="$dispatch('open-modal', 'appointment-modal')" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                        New Consultation
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-24 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8" x-data="calendar()">
            
            <!-- Calendar Navigation -->
            <div class="flex items-center gap-4">
                <div class="flex p-1 bg-white rounded-card border border-slate-100 shadow-sm">
                    <button @click="prevMonth()" class="p-2 hover:bg-slate-50 rounded-full transition-colors text-slate-400 hover:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="px-6 flex items-center">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-900" x-text="monthName + ' ' + year"></span>
                    </div>
                    <button @click="nextMonth()" class="p-2 hover:bg-slate-50 rounded-full transition-colors text-slate-400 hover:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <button @click="goToToday()" class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                    Today
                </button>
            </div>


        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Calendar Grid -->
            <div class="lg:col-span-8 bg-white rounded-card border border-slate-100 shadow-sm overflow-hidden p-4 sm:p-8">
                <div class="grid grid-cols-7 mb-6">
                    <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                        <div class="text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 py-2 sm:py-4" x-text="day"></div>
                    </template>
                </div>

                <div class="grid grid-cols-7 gap-1 sm:gap-2">
                    <template x-for="blank in blanks">
                        <div class="aspect-square bg-slate-50/30 rounded-lg sm:rounded-2xl border border-dashed border-slate-100/50"></div>
                    </template>

                    <template x-for="date in daysInMonth">
                        <div class="aspect-square relative group rounded-lg sm:rounded-2xl border transition-all duration-300 flex flex-col p-1.5 sm:p-3"
                             :class="{
                                'bg-sky-50 border-sky-100 ring-4 ring-sky-50/50': isToday(date),
                                'bg-white border-slate-100 hover:border-sky-200 hover:shadow-md cursor-pointer': !isToday(date)
                             }"
                             @click="selectDay(date)">
                            
                            <span class="text-[10px] sm:text-xs font-black" 
                                  :class="isToday(date) ? 'text-sky-600' : 'text-slate-400 group-hover:text-slate-900'"
                                  x-text="date"></span>

                            <!-- Appointment Indicators (Smart Stacking) -->
                            <div class="mt-auto flex flex-col items-center sm:items-stretch gap-1 w-full">
                                <!-- Desktop text badge -->
                                <template x-for="(app, index) in getAppointmentsForDate(date).slice(0, 2)">
                                    <div class="hidden sm:block px-2 py-0.5 rounded-md transition-all duration-300 truncate"
                                         :class="{
                                            'bg-amber-500/10 text-amber-700 border border-amber-200': app.status === 'pending',
                                            'bg-emerald-500 text-white shadow-sm': app.status === 'confirmed',
                                            'bg-rose-400 text-white': app.status === 'declined'
                                         }"
                                         :title="app.first_name + ' - ' + app.service_type">
                                        <p class="text-[7px] font-black uppercase tracking-tighter truncate" x-text="app.first_name"></p>
                                    </div>
                                </template>
                                
                                <!-- Mobile dot badge -->
                                <div class="flex sm:hidden gap-0.5 justify-center flex-wrap">
                                    <template x-for="(app, index) in getAppointmentsForDate(date).slice(0, 3)">
                                        <span class="w-1.5 h-1.5 rounded-full"
                                              :class="{
                                                 'bg-amber-500': app.status === 'pending',
                                                 'bg-emerald-500': app.status === 'confirmed',
                                                 'bg-rose-400': app.status === 'declined'
                                              }"></span>
                                    </template>
                                </div>
                                
                                <!-- Overflow Indicator (Desktop only) -->
                                <template x-if="getAppointmentsForDate(date).length > 2">
                                    <div class="hidden sm:block text-[6px] font-black text-slate-400 text-center py-0.5 uppercase tracking-widest bg-slate-50 rounded border border-slate-100">
                                        +<span x-text="getAppointmentsForDate(date).length - 2"></span> more
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Upcoming Appointments View (Global) -->
                <div class="bg-slate-900 rounded-card p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/10 rounded-full blur-3xl group-hover:bg-sky-500/20 transition-colors"></div>
                    
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-sky-400 mb-2">Upcoming Schedule</p>
                        
                        <div class="space-y-4">
                            <template x-for="app in getUpcomingAppointments().slice(0, 5)">
                                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition-all cursor-pointer group/item"
                                     @click="viewAppointment(app)">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-sky-400" x-text="new Date(app.appointment_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric'})"></span>
                                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-400" x-text="formatTime(app.appointment_date)"></span>
                                        </div>
                                        <span class="h-1 w-4 rounded-full" 
                                              :class="app.status === 'confirmed' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]' : 'bg-amber-500'"></span>
                                    </div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-white group-hover/item:text-sky-300 transition-colors" x-text="app.first_name + ' ' + app.last_name"></p>
                                    <p class="text-[10px] text-slate-400 font-medium" x-text="app.service_type"></p>
                                </div>
                            </template>

                            <template x-if="getUpcomingAppointments().length === 0">
                                <div class="py-12 flex flex-col items-center justify-center text-center opacity-50">
                                    <svg class="w-10 h-10 mb-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-[10px] font-black uppercase tracking-widest">No upcoming pins</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Selected Date Quick Info (Optional context) -->
                <div class="bg-white rounded-inner p-6 border border-slate-100" x-show="appointmentsForSelectedDate.length > 0">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4" x-text="'On ' + selectedDateFull"></p>
                    <div class="space-y-3">
                        <template x-for="app in appointmentsForSelectedDate">
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors" @click="viewAppointment(app)">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-900 uppercase" x-text="app.first_name"></span>
                                    <span class="text-[9px] text-slate-500" x-text="formatTime(app.appointment_date)"></span>
                                </div>
                                <div class="w-1.5 h-1.5 rounded-full" :class="app.status === 'confirmed' ? 'bg-emerald-500' : 'bg-amber-500'"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Legend -->
                <div class="bg-white rounded-inner p-6 border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Status Legend</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="h-1 w-4 rounded-full bg-amber-500"></div>
                            <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Pending Review</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-1 w-4 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]"></div>
                            <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Confirmed Project</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Quick View Modal -->
        <x-modal name="calendar-view-appointment" maxWidth="md">
            <div class="p-8" x-show="viewingApp">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-serif text-2xl text-slate-900">Pin Details</h3>
                    <button @click="$dispatch('close-modal', 'calendar-view-appointment')" class="text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-900 tracking-widest" x-text="viewingApp?.service_type"></p>
                            <p class="text-[10px] text-slate-500 font-medium uppercase mt-1">Consultation Session</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-2xl border border-slate-100">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Time</label>
                            <p class="text-xs font-bold text-slate-900" x-text="viewingApp ? formatTime(viewingApp.appointment_date) : ''"></p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl border border-slate-100">
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Status</label>
                            <span class="text-[9px] font-black uppercase tracking-widest" :class="viewingApp?.status === 'confirmed' ? 'text-emerald-600' : 'text-amber-600'" x-text="viewingApp?.status"></span>
                        </div>
                    </div>

                    <!-- Client Quick Actions -->
                    <div class="pt-6 border-t border-slate-100 space-y-3" x-show="viewingApp && viewingApp.status === 'pending'">
                        <form :action="`/appointments/${viewingApp.id}/cancel`" method="POST" id="calendar-cancel-form">
                            @csrf
                            @method('PATCH')
                            <button type="button" 
                                    :disabled="submitting"
                                    @click="window.dispatchEvent(new CustomEvent('open-confirm', { 
                                        detail: { 
                                            title: 'Cancel Consultation',
                                            message: 'Are you sure you want to cancel this request?',
                                            confirmButton: 'Cancel Request',
                                            action: () => { submitting = true; document.getElementById('calendar-cancel-form').submit(); }
                                        } 
                                    }))"
                                    class="w-full py-4 bg-white border-2 border-red-100 text-red-500 hover:bg-red-50 hover:border-red-200 rounded-2xl font-black uppercase tracking-widest text-[10px] transition-all flex items-center justify-center gap-2">
                                <template x-if="submitting">
                                    <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <span>Cancel Request</span>
                            </button>
                        </form>
                    </div>

                    <div x-show="viewingApp && viewingApp.status !== 'pending'" class="pt-4 text-center">
                        <div class="inline-flex items-center px-6 py-2 rounded-full border border-slate-100 bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Status: <span class="ml-2 font-black" 
                                          :class="{
                                              'text-emerald-600': viewingApp.status === 'confirmed',
                                              'text-rose-600': viewingApp.status === 'declined',
                                              'text-slate-600': viewingApp.status === 'cancelled'
                                          }" 
                                          x-text="viewingApp.status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
        </div>
    </div>

    @push('scripts')
    <script>
        function calendar() {
            return {
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                daysInMonth: [],
                blanks: [],
                monthName: '',
                selectedDate: new Date().getDate(),
                selectedDateFull: '',
                appointments: @json($appointments),
                appointmentsForSelectedDate: [],
                viewingApp: null,
                submitting: false,

                init() {
                    this.calculateCalendar();
                    this.updateSelectedDateInfo();
                },

                calculateCalendar() {
                    const firstDay = new Date(this.year, this.month, 1).getDay();
                    const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    
                    this.blanks = Array.from({ length: firstDay }, (_, i) => i);
                    this.daysInMonth = Array.from({ length: daysInMonth }, (_, i) => i + 1);
                    this.monthName = new Date(this.year, this.month).toLocaleString('default', { month: 'long' });
                },

                prevMonth() {
                    if (this.month === 0) {
                        this.month = 11;
                        this.year--;
                    } else {
                        this.month--;
                    }
                    this.calculateCalendar();
                },

                nextMonth() {
                    if (this.month === 11) {
                        this.month = 0;
                        this.year++;
                    } else {
                        this.month++;
                    }
                    this.calculateCalendar();
                },

                goToToday() {
                    const today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.selectedDate = today.getDate();
                    this.calculateCalendar();
                    this.updateSelectedDateInfo();
                },

                isToday(date) {
                    const today = new Date();
                    return date === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
                },

                getAppointmentsForDate(date) {
                    return this.appointments.filter(app => {
                        const appDate = new Date(app.appointment_date);
                        return appDate.getDate() === date && 
                               appDate.getMonth() === this.month && 
                               appDate.getFullYear() === this.year;
                    });
                },

                selectDay(date) {
                    this.selectedDate = date;
                    this.updateSelectedDateInfo();
                },

                updateSelectedDateInfo() {
                    const dateObj = new Date(this.year, this.month, this.selectedDate);
                    this.selectedDateFull = dateObj.toLocaleDateString('en-US', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                    this.appointmentsForSelectedDate = this.getAppointmentsForDate(this.selectedDate);
                },

                formatTime(dateString) {
                    return new Date(dateString).toLocaleTimeString('en-US', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                },

                getUpcomingAppointments() {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    return this.appointments
                        .filter(app => new Date(app.appointment_date) >= today)
                        .sort((a, b) => new Date(a.appointment_date) - new Date(b.appointment_date));
                },

                viewAppointment(app) {
                    this.viewingApp = app;
                    this.$dispatch('open-modal', 'calendar-view-appointment');
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
