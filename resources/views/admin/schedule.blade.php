<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                    Schedule <span class="text-sky-600 italic">Settings</span>
                </h2>
                <p class="text-sm font-medium text-slate-500">Configure your weekly availability for client consultations.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl font-bold text-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.schedule.update') }}" method="POST" 
                  x-data="{ 
                      availableDays: {{ json_encode(array_map('strval', $availableDays)) }},
                      workingHours: {{ json_encode($workingHours) }},
                      activeDay: 1,
                      checkOverlap(dayVal, currentIndex) {
                          const ranges = this.workingHours[dayVal];
                          if (!ranges || ranges.length <= 1) return false;
                          const current = ranges[currentIndex];
                          if (!current.start || !current.end) return false;
                          
                          return ranges.some((r, idx) => {
                              if (idx === currentIndex) return false;
                              if (!r.start || !r.end) return false;
                              // (StartA < EndB) && (EndA > StartB)
                              return (current.start < r.end) && (current.end > r.start);
                          });
                      },
                      applyToAll(sourceDay) {
                          const sourceRanges = JSON.parse(JSON.stringify(this.workingHours[sourceDay]));
                          Object.keys(this.workingHours).forEach(day => {
                              this.workingHours[day] = JSON.parse(JSON.stringify(sourceRanges));
                          });
                      },
                      addSlot(dayVal) {
                          if (!this.workingHours[dayVal]) this.workingHours[dayVal] = [];
                          const ranges = this.workingHours[dayVal];
                          let start = '09:00';
                          let end = '10:00';

                          if (ranges.length > 0) {
                              const lastRange = ranges[ranges.length - 1];
                              const lastEnd = lastRange.end;
                              const parts = lastEnd.split(':');
                              let hours = parseInt(parts[0]);
                              let mins = parts[1];
                              
                              // Start exactly at last end
                              let newStartHours = hours % 24;
                              // End 1 hour after new start
                              let newEndHours = (newStartHours + 1) % 24;
                              
                              start = `${newStartHours.toString().padStart(2, '0')}:${mins}`;
                              end = `${newEndHours.toString().padStart(2, '0')}:${mins}`;
                          }
                          
                          ranges.push({ start, end });
                      }
                  }"
                  class="space-y-8">
                @csrf
                
                <!-- Availability Card -->
                <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-100">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-sky-100 rounded-2xl flex items-center justify-center text-sky-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-2xl text-slate-900">Working Days</h3>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mt-1">Select the days you are open for appointments</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                        @php
                            $days = [
                                1 => 'Monday',
                                2 => 'Tuesday',
                                3 => 'Wednesday',
                                4 => 'Thursday',
                                5 => 'Friday',
                                6 => 'Saturday',
                                0 => 'Sunday'
                            ];
                        @endphp

                        @foreach($days as $value => $label)
                            <label class="relative flex flex-col items-center p-4 rounded-3xl border-2 cursor-pointer transition-all duration-300 group"
                                   :class="availableDays.includes('{{ $value }}') ? 'border-sky-500 bg-sky-50/50' : 'border-slate-100 bg-white hover:border-slate-200'">
                                <input type="checkbox" name="available_days[]" value="{{ $value }}" x-model="availableDays" class="hidden">
                                <span class="text-[10px] font-black uppercase tracking-widest" :class="availableDays.includes('{{ $value }}') ? 'text-sky-600' : 'text-slate-400'">{{ substr($label, 0, 3) }}</span>
                                <span class="mt-1 text-sm font-bold" :class="availableDays.includes('{{ $value }}') ? 'text-sky-900' : 'text-slate-600'">{{ $label }}</span>
                                
                                <template x-if="availableDays.includes('{{ $value }}')">
                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-sky-500 rounded-full flex items-center justify-center text-white shadow-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="bg-white rounded-[3rem] p-10 shadow-premium border border-slate-100">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-2xl text-slate-900">Specific Working Hours</h3>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400 mt-1">Configure time slots day by day</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($days as $value => $label)
                            <div class="overflow-hidden border border-slate-100 rounded-[2rem] transition-all duration-300"
                                 x-show="availableDays.includes('{{ $value }}')"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-4"
                                 :class="activeDay === {{ $value }} ? 'bg-slate-50 ring-1 ring-sky-500/20' : 'bg-white hover:bg-slate-50/30'">
                                
                                <!-- Accordion Header -->
                                <button type="button" 
                                        @click="activeDay = activeDay === {{ $value }} ? null : {{ $value }}"
                                        class="w-full p-6 flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <span class="w-10 h-10 rounded-xl shadow-sm flex items-center justify-center text-xs font-black transition-all"
                                              :class="activeDay === {{ $value }} ? 'bg-sky-500 text-white' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600'">
                                            {{ substr($label, 0, 1) }}
                                        </span>
                                        <div class="text-left">
                                            <h4 class="font-serif text-lg text-slate-900">{{ $label }}</h4>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" x-text="(workingHours[{{ $value }}] ? workingHours[{{ $value }}].length : 0) + ' Active Slots'"></p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 transition-transform duration-300" 
                                         :class="activeDay === {{ $value }} ? 'rotate-180 text-sky-500' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Accordion Content -->
                                <div x-show="activeDay === {{ $value }}" 
                                     x-collapse
                                     x-cloak
                                     class="px-6 pb-6 pt-2">
                                    <div class="p-6 bg-white rounded-3xl border border-slate-100/50 shadow-sm space-y-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Time Range Slots</span>
                                                <template x-if="workingHours[{{ $value }}]?.some((_, i) => checkOverlap({{ $value }}, i))">
                                                    <span class="text-[8px] font-black uppercase tracking-widest text-rose-500 bg-rose-50 px-2 py-1 rounded-lg animate-pulse">Overlap Detected!</span>
                                                </template>
                                            </div>
                                            <button type="button" @click="addSlot({{ $value }})" class="px-4 py-2 bg-sky-50 text-sky-600 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-sky-100 transition">
                                                + Add Slot
                                            </button>
                                        </div>

                                        <div class="space-y-4">
                                            <template x-for="(range, index) in workingHours[{{ $value }}]" :key="index">
                                                <div class="flex items-center gap-4 group/item transition-all p-2 rounded-2xl"
                                                     :class="checkOverlap({{ $value }}, index) ? 'bg-rose-50/50' : ''">
                                                    <div class="flex-1 relative">
                                                        <input type="time" :name="`days[{{ $value }}][${index}][start]`" x-model="range.start" required 
                                                               :class="checkOverlap({{ $value }}, index) ? 'border-rose-400 focus:ring-rose-500 focus:border-rose-500' : 'border-slate-200 focus:ring-sky-500 focus:border-sky-500'"
                                                               class="w-full rounded-xl bg-slate-50 p-3 font-bold text-sm transition-all">
                                                    </div>
                                                    <span class="text-slate-300 font-bold" :class="checkOverlap({{ $value }}, index) ? 'text-rose-300' : ''">to</span>
                                                    <div class="flex-1 relative">
                                                        <input type="time" :name="`days[{{ $value }}][${index}][end]`" x-model="range.end" required 
                                                               :class="checkOverlap({{ $value }}, index) ? 'border-rose-400 focus:ring-rose-500 focus:border-rose-500' : 'border-slate-200 focus:ring-sky-500 focus:border-sky-500'"
                                                               class="w-full rounded-xl bg-slate-50 p-3 font-bold text-sm transition-all">
                                                    </div>
                                                    <button type="button" @click="workingHours[{{ $value }}].splice(index, 1)" x-show="workingHours[{{ $value }}].length > 1" class="p-3 text-rose-400 hover:bg-rose-50 rounded-xl transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="pt-6 border-t border-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Finished setting up {{ $label }}?</p>
                                            <button type="button" @click="applyToAll({{ $value }})" class="w-full md:w-auto px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-sky-600 transition shadow-lg shadow-slate-900/10">
                                                Apply these hours to all days
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 p-6 bg-slate-900 rounded-3xl text-white">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Advanced Scheduling</p>
                                <p class="text-slate-400 text-xs mt-1 leading-relaxed">Each day can have its own unique working hours. This is perfect if you only want to take morning calls on Saturdays or late-night sessions on Fridays.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-12 py-5 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-[11px] hover:bg-sky-600 shadow-2xl shadow-slate-900/20 transition-all duration-300 hover:translate-y-[-4px] active:scale-95">
                        Save Schedule Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple toggle logic for the day labels
        document.querySelectorAll('label').forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            if (checkbox) {
                label.addEventListener('click', () => {
                    // Slight delay to allow checkbox state to change
                    setTimeout(() => {
                        if (checkbox.checked) {
                            label.classList.add('border-sky-500', 'bg-sky-50/50');
                            label.classList.remove('border-slate-100', 'bg-white');
                        } else {
                            label.classList.remove('border-sky-500', 'bg-sky-50/50');
                            label.classList.add('border-slate-100', 'bg-white');
                        }
                    }, 10);
                });
            }
        });
    </script>
</x-app-layout>
