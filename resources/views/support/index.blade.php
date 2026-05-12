<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 py-4">
            <div class="space-y-1">
                <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                    Support <span class="text-sky-600 italic">Center</span>
                </h2>
                <p class="text-sm font-medium text-slate-500">How can we assist you with your project today?</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Contact Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Message Studio -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-premium transition-all group">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-2">Message Studio</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Direct line to our architectural design team for project inquiries.</p>
                    <a href="mailto:support@rjstudio.com" class="text-[10px] font-black uppercase tracking-[0.2em] text-sky-600 hover:text-sky-700 transition-colors flex items-center gap-2">
                        Send Email <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Office Hours -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-premium transition-all group">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-2">Office Hours</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Monday – Friday<br>9:00 AM – 6:00 PM (GMT+8)</p>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-600">Response within 24h</span>
                </div>

                <!-- Documentation -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-premium transition-all group">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-2">Project Guide</h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">Learn about our design process and project management flow.</p>
                    <a href="#" class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-2">
                        View Guide <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- FAQs -->
            <div class="max-w-3xl mx-auto">
                <h3 class="font-serif text-3xl text-slate-900 mb-10 text-center">Frequently Asked <span class="text-sky-600 italic">Questions</span></h3>
                
                <div class="space-y-4" x-data="{ active: null }">
                    <!-- FAQ 1 -->
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <button @click="active = active === 1 ? null : 1" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">How do I track my consultation status?</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 1" x-collapse>
                            <div class="px-8 pb-6 text-sm text-slate-500 leading-relaxed">
                                You can track all your project briefs in the <a href='{{ route('client.appointments') }}' class='text-sky-600 font-bold hover:underline'>Appointments</a> page. We use three statuses: Pending (reviewing), Confirmed (scheduled), and Cancelled.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <button @click="active = active === 2 ? null : 2" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">What happens after I submit a new request?</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 2" x-collapse>
                            <div class="px-8 pb-6 text-sm text-slate-500 leading-relaxed">
                                Once submitted, our lead architect reviews your project brief. You will receive a confirmation within 24-48 hours. If approved, the status will change to "Confirmed" and we will reach out via email.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <button @click="active = active === 3 ? null : 3" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">Can I cancel a pending consultation?</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 3" x-collapse>
                            <div class="px-8 pb-6 text-sm text-slate-500 leading-relaxed">
                                Yes, you can cancel any "Pending" request directly from the consultation details modal. Once a request is "Confirmed," please contact the studio directly via email for rescheduling.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                        <button @click="active = active === 4 ? null : 4" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">Where can I see the studio's portfolio?</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 4" x-collapse>
                            <div class="px-8 pb-6 text-sm text-slate-500 leading-relaxed">
                                You can explore our curated architectural works in the <a href='{{ route('client.portfolio') }}' class='text-sky-600 font-bold hover:underline'>Studio Portfolio</a> section of your dashboard.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
