<x-app-layout>
    <div class="py-24 max-w-4xl mx-auto px-6" x-data="{ 
        showModal: false,
        formData: {
            first_name: '', 
            last_name: '', 
            email: '{{ Auth::user()->email }}', 
            phone: '', 
            date: '', 
            location: '', 
            message: '', 
            service: '{{ request('service') }}'
        },
        formatDate(dateStr) {
            if (!dateStr) return 'Not set';
            const options = { month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateStr).toLocaleDateString('en-US', options);
        }
    }">
        
        <div class="text-center mb-12">
            <span class="text-sky-600 font-bold uppercase tracking-[0.3em] text-[10px]">Consultation Brief</span>
            <h2 class="font-serif text-5xl mt-2 text-slate-900 dark:text-white">Project <span class="text-sky-600 italic">Details</span></h2>
            <p class="text-slate-500 mt-4">Discussing: <strong class="text-slate-900 dark:text-slate-200">{{ request('service') }}</strong></p>
        </div>

        <form @submit.prevent="showModal = true" id="appointmentForm" action="{{ route('appointments.store') }}" method="POST" 
              class="bg-white dark:bg-slate-900 p-8 md:p-12 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl">
            @csrf
            <input type="hidden" name="service_type" x-model="formData.service">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2">First Name</label>
                    <input type="text" name="first_name" x-model="formData.first_name" required 
                           class="w-full rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-950 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 shadow-sm transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2">Last Name</label>
                    <input type="text" name="last_name" x-model="formData.last_name" required 
                           class="w-full rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-950 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 shadow-sm transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2">Email Address</label>
                    <input type="email" name="email" x-model="formData.email" required 
                           class="w-full rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-950 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 shadow-sm transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2">Phone Number</label>
                    <input type="text" name="phone" x-model="formData.phone" required placeholder="+63" 
                           class="w-full rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-950 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 shadow-sm transition-all">
                </div>
            </div>

            <div class="space-y-8">
                <div class="p-8 rounded-[2rem] bg-slate-50 dark:bg-slate-950 border border-slate-100 dark:border-slate-800 group transition-all focus-within:border-sky-200">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-sky-600 mb-4">Project Site Location</label>
                    <div class="flex items-center gap-4">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="text" name="location" x-model="formData.location" placeholder="City, Province or Site Address"
                               class="w-full bg-transparent border-none focus:ring-0 p-0 text-slate-900 dark:text-white placeholder-slate-400">
                    </div>
                </div>

                <div class="space-y-6" x-data="calendarHandler()">
    <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 ml-2">Select Consultation Date & Time</label>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-slate-50 dark:bg-slate-950 p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h4 class="font-serif text-lg text-slate-900 dark:text-white" x-text="monthNames[month] + ' ' + year"></h4>
                <div class="flex gap-2">
                    <button type="button" @click="prevMonth()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition">&larr;</button>
                    <button type="button" @click="nextMonth()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition">&rarr;</button>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-1 text-center mb-2">
                <template x-for="day in days">
                    <span class="text-[9px] font-black uppercase text-slate-400" x-text="day"></span>
                </template>
            </div>

            <div class="grid grid-cols-7 gap-1">
                <template x-for="blank in blankdays">
                    <div class="aspect-square"></div>
                </template>
                <template x-for="date in no_of_days">
                    <button type="button" 
                            @click="selectDate(date)"
                            :disabled="isPast(date)"
                            class="aspect-square flex items-center justify-center rounded-xl text-sm font-medium transition-all"
                            :class="{
                                'bg-sky-600 text-white shadow-lg shadow-sky-200': isToday(date),
                                'bg-slate-900 text-white': isSelected(date),
                                'hover:bg-sky-50 dark:hover:bg-sky-900/30 text-slate-700 dark:text-slate-300': !isSelected(date) && !isPast(date),
                                'opacity-20 cursor-not-allowed': isPast(date)
                            }"
                            x-text="date">
                    </button>
                </template>
            </div>
        </div>

        <div class="flex flex-col justify-center">
            <h4 class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4 px-2">Available Slots</h4>
            <div class="grid grid-cols-2 gap-3">
                <template x-for="time in timeSlots">
                    <button type="button" 
                            @click="formData.time = time"
                            class="py-3 rounded-2xl border text-xs font-bold transition-all"
                            :class="formData.time === time ? 'bg-sky-600 border-sky-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:border-sky-300'">
                        <span x-text="time"></span>
                    </button>
                </template>
            </div>
            
            <input type="hidden" name="appointment_date" :value="formData.date + ' ' + formData.time">
        </div>
    </div>
</div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2">Project Vision</label>
                    <textarea name="message" x-model="formData.message" rows="4" placeholder="Briefly describe your style, budget, or specific requirements..."
                              class="w-full rounded-2xl border-slate-100 dark:border-slate-800 dark:bg-slate-950 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 shadow-sm transition-all"></textarea>
                </div>
            </div>

            <button type="submit" class="mt-12 w-full py-5 bg-slate-900 dark:bg-sky-600 text-white rounded-[2rem] font-bold uppercase tracking-widest hover:scale-[1.02] transition-all shadow-2xl shadow-slate-200 dark:shadow-none">
                Review Appointment Details
            </button>
        </form>

        <div x-show="showModal" x-cloak 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md">
            
            <div @click.away="showModal = false" class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-[3rem] p-8 md:p-12 shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-sky-600"></div>
                
                <h3 class="font-serif text-3xl mb-2 text-slate-900 dark:text-white text-center">Confirm <span class="text-sky-600 italic">Brief</span></h3>
                <p class="text-center text-slate-500 text-sm mb-8">Ensure all architectural requirements are correct.</p>
                
                <div class="space-y-4 mb-10">
                    <div class="flex flex-col border-b border-slate-50 dark:border-slate-800 pb-3">
                        <span class="text-slate-400 uppercase text-[9px] font-black tracking-widest mb-1">Project Client</span>
                        <span class="font-bold text-slate-800 dark:text-white" x-text="formData.first_name + ' ' + formData.last_name"></span>
                    </div>
                    <div class="flex flex-col border-b border-slate-50 dark:border-slate-800 pb-3">
                        <span class="text-slate-400 uppercase text-[9px] font-black tracking-widest mb-1">Requested Service</span>
                        <span class="font-bold text-sky-600" x-text="formData.service"></span>
                    </div>
                    <div class="flex flex-col border-b border-slate-50 dark:border-slate-800 pb-3">
                        <span class="text-slate-400 uppercase text-[9px] font-black tracking-widest mb-1">Site Location</span>
                        <span class="font-bold text-slate-800 dark:text-white" x-text="formData.location || 'Consultation Only'"></span>
                    </div>
                    <div class="flex flex-col border-b border-slate-50 dark:border-slate-800 pb-3">
                        <span class="text-slate-400 uppercase text-[9px] font-black tracking-widest mb-1">Meeting Schedule</span>
                        <span class="font-bold text-slate-800 dark:text-white" x-text="formatDate(formData.date)"></span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button @click="showModal = false" type="button" class="flex-1 py-4 border border-slate-200 dark:border-slate-700 rounded-2xl text-[10px] font-bold uppercase tracking-widest dark:text-white hover:bg-slate-50 transition">
                        Back to Edit
                    </button>
                    <button @click="document.getElementById('appointmentForm').submit()" type="button" class="flex-1 py-4 bg-sky-600 text-white rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-lg shadow-sky-200 dark:shadow-none hover:bg-slate-900 transition">
                        Confirm & Send Brief
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function calendarHandler() {
    return {
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        no_of_days: [],
        blankdays: [],
        timeSlots: ['09:00 AM', '10:30 AM', '01:00 PM', '02:30 PM', '04:00 PM'],

        init() {
            this.getNoOfDays();
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            let dayOfWeek = new Date(this.year, this.month).getDay();
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) { blankdaysArray.push(i); }
            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) { daysArray.push(i); }
            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
        },

        isToday(date) {
            const d = new Date();
            return d.getDate() === date && d.getMonth() === this.month && d.getFullYear() === this.year;
        },

        isSelected(date) {
            const selectedDate = `${this.year}-${String(this.month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
            return this.formData.date === selectedDate;
        },

        isPast(date) {
            const d = new Date(this.year, this.month, date);
            return d < new Date().setHours(0,0,0,0);
        },

        selectDate(date) {
            this.formData.date = `${this.year}-${String(this.month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
        },

        nextMonth() {
            if (this.month == 11) { this.month = 0; this.year++; } else { this.month++; }
            this.getNoOfDays();
        },

        prevMonth() {
            if (this.month == 0) { this.month = 11; this.year--; } else { this.month--; }
            this.getNoOfDays();
        }
    }
}
</script>