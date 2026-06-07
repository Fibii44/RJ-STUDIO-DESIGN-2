<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|instrument-sans:300,400,600" rel="stylesheet" />
        <link rel="icon" type="image/webp" href="{{ asset('/images/Rj-logo.webp') }}">

        <!-- Flatpickr (Calendar) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>

            .flatpickr-calendar {
                background: #ffffff;
                border-radius: 2rem !important;
                border: 1px solid #f1f5f9 !important;
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important;
                padding: 10px;
            }
            .flatpickr-day.selected {
                background: #0284c7 !important;
                border-color: #0284c7 !important;
            }
            .flatpickr-months .flatpickr-month {
                color: #0f172a !important;
                font-family: serif;
            }
            .flatpickr-calendar.inline {
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
                width: 100% !important;
            }
            .flatpickr-innerContainer {
                width: 100% !important;
            }
            .flatpickr-rContainer {
                width: 100% !important;
            }
            .flatpickr-days {
                width: 100% !important;
            }
            .dayContainer {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-sky-500/30">
        @php
            $showSidebar = Auth::check() && (
                request()->routeIs('admin.*') || 
                request()->routeIs('home') || 
                request()->routeIs('client.*') || 
                request()->routeIs('support') || 
                request()->routeIs('profile.*')
            );
        @endphp
        <div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== null ? localStorage.getItem('sidebarOpen') === 'true' : window.innerWidth > 1024 }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))" class="flex min-h-screen">
            @if($showSidebar)
                <x-sidebar />
            @endif

            <div class="flex-1 flex flex-col"
                 :class="sidebarOpen && {{ $showSidebar ? 'true' : 'false' }} ? 'lg:pl-72' : ({{ $showSidebar ? 'true' : 'false' }} ? 'lg:pl-24' : '')">
                @include('layouts.navigation')

                @auth
                <!-- Authenticated Top Navbar -->
                <div class="h-16 bg-white/80 backdrop-blur-xl border-b border-slate-50 flex items-center justify-between lg:justify-end px-8 sticky top-0 z-50">
                    <!-- Mobile Sidebar Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2.5 rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-100 transition-all focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-4 hover:opacity-80 transition-opacity focus:outline-none">
                            <div class="flex flex-col text-right hidden sm:flex">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-medium text-slate-500">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-sky-600 flex items-center justify-center text-white shadow-md shadow-sky-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 transform -translate-y-2"
                             class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50"
                             style="display: none;">
                            <div class="p-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>My Profile</span>
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Page Heading -->
                @isset($header)
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
                        {{ $header }}
                    </div>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @auth
        <!-- Global Appointment Modal -->
        <x-modal name="appointment-modal" maxWidth="5xl" focusable>
            <div class="relative" x-data="{ loading: false }">
                <!-- Close Button -->
                <button type="button" @click="$dispatch('close-modal', 'appointment-modal')" class="absolute top-8 right-8 z-50 p-2 text-slate-400 hover:text-slate-900 transition-colors" :disabled="loading">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <form action="{{ route('appointments.store') }}" method="POST" class="flex flex-col lg:flex-row" @submit="loading = true">
                    @csrf
                    
                    <!-- Left Side: Form Details -->
                    <div class="p-10 lg:p-12 flex-1 border-r border-slate-50">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center text-sky-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h2 class="font-serif text-3xl text-slate-900">Project Request</h2>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-400 mt-1">Fill in your consultation details</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ explode(' ', Auth::user()->name)[0] }}" required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ count(explode(' ', Auth::user()->name)) > 1 ? explode(' ', Auth::user()->name)[1] : '' }}" required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Phone Number</label>
                                    <input type="text" name="phone" required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Service Type</label>
                                <select name="service_type" required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all">
                                    <option value="Architectural Design">Architectural Design</option>
                                    <option value="Design & Build">Design & Build</option>
                                    <option value="Professional Build">Professional Build</option>
                                </select>
                            </div>



                            <div x-data="{ message: '' }">
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Project Brief</label>
                                    <span class="text-[10px] font-bold text-slate-400" :class="message.length > 900 ? 'text-amber-500' : ''">
                                        <span x-text="message.length"></span> / 1000
                                    </span>
                                </div>
                                <textarea name="message" x-model="message" maxlength="1000" rows="4" placeholder="Tell us about your vision..." required class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-slate-50 border-transparent transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-start gap-4 mt-10">
                            <button type="submit" 
                                    class="relative px-10 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-sky-600 shadow-xl shadow-slate-900/10 transition-all active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed group overflow-hidden"
                                    :disabled="loading">
                                <span :class="{ 'opacity-0': loading }" class="transition-opacity duration-200">Submit Request</span>
                                
                                <!-- Loading Spinner -->
                                <div x-show="loading" 
                                     style="display: none;" 
                                     class="absolute inset-0 flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                            <button type="button" @click="$dispatch('close-modal', 'appointment-modal')" class="px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest text-slate-500 hover:bg-slate-100 transition-all" :disabled="loading">Cancel</button>
                        </div>
                    </div>

                    <!-- Right Side: Calendar -->
                    <div class="w-full lg:w-[420px] bg-slate-50/50 p-10 lg:p-12 flex flex-col">
                        <div class="mb-8">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Select Date & Time</label>
                            <p class="text-sm text-slate-600 font-medium">Please choose a preferred slot for our meeting.</p>
                        </div>
                        
                        <div x-data='{ 
                            fp: null,
                            selectedDate: "",
                            selectedTime: "",
                            availableSlots: [],
                            setup() {
                                if (this.fp) return;
                                const settings = {
                                    availableDays: {!! $scheduleSettings['availableDays'] !!},
                                    workingHours: {!! $scheduleSettings['workingHours'] !!},
                                    bookedSlots: {!! json_encode($scheduleSettings['bookedSlots']) !!}
                                };
                                this.fp = window.initAppointmentCalendar(this.$refs.calendar, settings, (dateStr, ranges) => {
                                    this.selectedDate = dateStr;
                                    this.availableSlots = ranges.filter(r => r && r.start && r.end).map(r => {
                                        const fullDate = `${dateStr} ${r.start}`;
                                        // Compare with bookedSlots (normalizing format)
                                        const isBooked = settings.bookedSlots.some(b => b.startsWith(fullDate));
                                        return { ...r, isBooked };
                                    });
                                    this.selectedTime = this.availableSlots.find(s => !s.isBooked)?.start || "";
                                    this.updateInput();
                                });
                            },
                            updateInput() {
                                if(this.selectedDate && this.selectedTime) {
                                    this.$refs.dateInput.value = this.selectedDate + " " + this.selectedTime;
                                } else {
                                    this.$refs.dateInput.value = this.selectedDate;
                                }
                            },
                            formatTime(time24) {
                                if (!time24) return "";
                                const parts = time24.split(":");
                                let hours = parseInt(parts[0], 10);
                                const ampm = hours >= 12 ? "PM" : "AM";
                                hours = hours % 12 || 12;
                                return `${hours}:${parts[1]} ${ampm}`;
                            }
                        }' 
                        x-on:open-modal.window="if($event.detail == 'appointment-modal') setTimeout(() => setup(), 150)"
                        class="calendar-container flex-1 min-h-[350px]">
                            <div x-ref="calendar"></div>
                            
                            <div x-show="availableSlots.length > 0" class="mt-6" style="display: none;" x-transition>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Available Time Slots</label>
                                <select x-model="selectedTime" @change="updateInput()" class="w-full rounded-xl border-slate-200 focus:ring-sky-500 focus:border-sky-500 bg-white shadow-sm text-sm font-medium text-slate-700 transition-all cursor-pointer py-3">
                                    <template x-for="(slot, index) in availableSlots" :key="index">
                                        <option :value="slot.start" :disabled="slot.isBooked" x-text="formatTime(slot.start) + ' – ' + formatTime(slot.end) + (slot.isBooked ? ' (Taken)' : '')"></option>
                                    </template>
                                </select>
                            </div>
                            
                            <div x-show="selectedDate !== '' && availableSlots.length === 0" class="mt-6 p-4 bg-amber-50 rounded-xl text-amber-700 text-xs font-medium text-center border border-amber-100" style="display: none;" x-transition>
                                No available time slots for this date.
                            </div>

                            <input type="hidden" name="appointment_date" x-ref="dateInput" required>
                        </div>

                        <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-[11px] text-slate-500 leading-relaxed font-medium">I will review your request and confirm the availability within 24 hours.</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </x-modal>
        <!-- Global Confirmation Modal -->
        <x-modal name="confirm-modal" maxWidth="sm">
            <div x-data="{ 
                title: 'Confirm Action', 
                message: 'Are you sure you want to proceed?', 
                confirmButton: 'Confirm',
                action: null,
                init() {
                    window.addEventListener('open-confirm', (e) => {
                        this.title = e.detail.title || 'Confirm Action';
                        this.message = e.detail.message || 'Are you sure?';
                        this.confirmButton = e.detail.confirmButton || 'Confirm';
                        this.action = e.detail.action;
                        $dispatch('open-modal', 'confirm-modal');
                    });
                },
                proceed() {
                    if (this.action) this.action();
                    $dispatch('close-modal', 'confirm-modal');
                }
            }" class="p-8 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                
                <h3 class="font-serif text-2xl text-slate-900 mb-2" x-text="title"></h3>
                <p class="text-sm text-slate-500 mb-8 leading-relaxed" x-text="message"></p>
                
                <div class="flex flex-col gap-3">
                    <button @click="proceed()" class="w-full py-4 bg-red-500 text-white rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-red-600 shadow-lg shadow-red-200 transition-all" x-text="confirmButton"></button>
                    <button @click="$dispatch('close-modal', 'confirm-modal')" class="w-full py-4 bg-slate-100 text-slate-500 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">Cancel</button>
                </div>
            </div>
        </x-modal>
        @endauth

        <script>
            window.initAppointmentCalendar = function(el, settings, onDateSelect) {
                try {
                    return flatpickr(el, { 
                        inline: true, 
                        enableTime: false, 
                        dateFormat: 'Y-m-d', 
                        minDate: 'today',
                        disable: [
                            function(date) {
                                const day = date.getDay();
                                return !settings.availableDays.includes(day.toString()) && 
                                       !settings.availableDays.includes(day);
                            }
                        ],
                        onChange: (selectedDates, dateStr, instance) => {
                            if (selectedDates.length > 0) {
                                const day = selectedDates[0].getDay();
                                const ranges = settings.workingHours[day] || [];
                                onDateSelect(dateStr, Array.isArray(ranges) ? ranges : []);
                            }
                        }
                    });
                } catch (error) {
                    el.innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-xl text-xs">Calendar Error: ${error.message}</div>`;
                    console.error("Calendar Init Error:", error);
                }
            };
        </script>
        @stack('scripts')
    </body>
</html>
