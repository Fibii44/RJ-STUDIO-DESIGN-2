<x-app-layout>
    <x-slot name="header">
        <div class="pt-10 pb-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <h2 class="font-serif text-4xl text-slate-900 leading-tight">
                        My <span class="text-sky-600 italic">Profile</span>
                    </h2>
                    <p class="text-slate-500 font-medium tracking-tight text-lg">
                        Manage your account details and security settings
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-24 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
            
            @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center gap-4 text-emerald-600 shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-widest">Profile settings updated successfully.</p>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left Column: Profile Card -->
                <div class="lg:col-span-1 bg-white rounded-card border border-slate-100 shadow-sm p-8 flex flex-col items-center text-center relative overflow-hidden group">
                    <!-- Subtle top gradient decoration -->
                    <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-r from-sky-400/20 to-sky-600/20"></div>
                    
                    <!-- Avatar circle with initials -->
                    @php
                        $words = explode(' ', Auth::user()->name);
                        $initials = '';
                        foreach ($words as $word) {
                            $initials .= strtoupper(substr($word, 0, 1));
                        }
                        $initials = substr($initials, 0, 2);
                    @endphp
                    <div class="w-24 h-24 rounded-full bg-sky-600 flex items-center justify-center text-white font-serif text-3xl font-bold shadow-xl shadow-sky-600/20 relative z-10 mt-10 mb-6 border-4 border-white">
                        {{ $initials }}
                    </div>

                    <h3 class="text-2xl font-serif text-slate-900 mb-1">{{ Auth::user()->name }}</h3>
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-sky-50 text-sky-600 border border-sky-100/50 mb-8">
                        {{ ucfirst(Auth::user()->role) }} Access
                    </span>

                    <div class="w-full space-y-6 text-left border-t border-slate-50 pt-8">
                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Email Address</span>
                            <span class="text-sm font-medium text-slate-700">{{ Auth::user()->email }}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Phone Number</span>
                            <span class="text-sm font-medium text-slate-700">{{ Auth::user()->phone ?? 'Not provided' }}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Billing Address</span>
                            <span class="text-sm font-medium text-slate-700 block leading-relaxed">{{ Auth::user()->address ?? 'Not provided' }}</span>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/50 mt-4">
                            <span class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Member Since</span>
                            <span class="text-xs font-semibold text-slate-600">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Edit Forms -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Profile Information Form -->
                    <div class="bg-white rounded-card border border-slate-100 shadow-sm p-8 md:p-12"
                         x-data="{ 
                             editing: {{ $errors->any() ? 'true' : 'false' }}, 
                             first_name: '{{ old('first_name', $user->first_name) }}',
                             last_name: '{{ old('last_name', $user->last_name) }}',
                             email: '{{ old('email', $user->email) }}',
                             phone: '{{ old('phone', $user->phone ?? '') }}',
                             address: '{{ old('address', $user->address ?? '') }}',
                             original: {
                                 first_name: '{{ old('first_name', $user->first_name) }}',
                                 last_name: '{{ old('last_name', $user->last_name) }}',
                                 email: '{{ old('email', $user->email) }}',
                                 phone: '{{ old('phone', $user->phone ?? '') }}',
                                 address: '{{ old('address', $user->address ?? '') }}'
                             },
                             cancel() {
                                 this.first_name = this.original.first_name;
                                 this.last_name = this.original.last_name;
                                 this.email = this.original.email;
                                 this.phone = this.original.phone;
                                 this.address = this.original.address;
                                 this.editing = false;
                             },
                             hasChanges() {
                                 return this.first_name.trim() !== this.original.first_name.trim() || 
                                        this.last_name.trim() !== this.original.last_name.trim() || 
                                        this.email.trim() !== this.original.email.trim() || 
                                        (this.phone || '').trim() !== (this.original.phone || '').trim() || 
                                        (this.address || '').trim() !== (this.original.address || '').trim();
                             }
                         }">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h4 class="text-xl font-serif text-slate-900">Profile <span class="text-sky-600 italic">Information</span></h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Update your account's profile information, phone, and address details.</p>
                            </div>
                            <button type="button" 
                                    x-show="!editing" 
                                    @click="editing = true" 
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-50 text-slate-700 hover:bg-sky-50 hover:text-sky-600 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Info
                            </button>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">First Name</label>
                                    <input type="text" name="first_name" x-model="first_name" :disabled="!editing" required 
                                           :class="!editing ? 'bg-slate-50/50 border-slate-100/50 text-slate-500 cursor-not-allowed' : 'bg-slate-50 border-slate-100 text-slate-900 focus:ring-4 focus:ring-sky-500/10'"
                                           class="w-full h-14 rounded-2xl border text-xs px-6 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->get('first_name')" />
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Last Name</label>
                                    <input type="text" name="last_name" x-model="last_name" :disabled="!editing" required 
                                           :class="!editing ? 'bg-slate-50/50 border-slate-100/50 text-slate-500 cursor-not-allowed' : 'bg-slate-50 border-slate-100 text-slate-900 focus:ring-4 focus:ring-sky-500/10'"
                                           class="w-full h-14 rounded-2xl border text-xs px-6 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->get('last_name')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Email Address</label>
                                    <input type="email" name="email" x-model="email" :disabled="!editing" required 
                                           :class="!editing ? 'bg-slate-50/50 border-slate-100/50 text-slate-500 cursor-not-allowed' : 'bg-slate-50 border-slate-100 text-slate-900 focus:ring-4 focus:ring-sky-500/10'"
                                           class="w-full h-14 rounded-2xl border text-xs px-6 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->get('email')" />
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Phone Number</label>
                                    <input type="text" name="phone" x-model="phone" :disabled="!editing" placeholder="Ex: +1 (555) 000-0000" 
                                           :class="!editing ? 'bg-slate-50/50 border-slate-100/50 text-slate-500 cursor-not-allowed' : 'bg-slate-50 border-slate-100 text-slate-900 focus:ring-4 focus:ring-sky-500/10'"
                                           class="w-full h-14 rounded-2xl border text-xs px-6 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->get('phone')" />
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Address</label>
                                <textarea name="address" x-model="address" :disabled="!editing" placeholder="Ex: 123 Studio Way, Architecture City" rows="3" 
                                          :class="!editing ? 'bg-slate-50/50 border-slate-100/50 text-slate-500 cursor-not-allowed' : 'bg-slate-50 border-slate-100 text-slate-900 focus:ring-4 focus:ring-sky-500/10'"
                                          class="w-full rounded-2xl border text-xs px-6 py-4 transition-all resize-none"></textarea>
                                <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->get('address')" />
                            </div>

                            <div class="flex justify-end gap-3 pt-4" x-show="editing" style="display: none;" x-transition>
                                <button type="button" @click="cancel()" class="px-6 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                    Cancel
                                </button>
                                <x-primary-button ::disabled="!hasChanges()" :class="'transition-all duration-300'" ::class="!hasChanges() ? 'opacity-50 cursor-not-allowed pointer-events-none shadow-none' : ''">{{ __('Save Changes') }}</x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Security & Password Form -->
                    <div class="bg-white rounded-card border border-slate-100 shadow-sm p-8 md:p-12"
                         x-data="{ 
                             changingPassword: {{ $errors->updatePassword->any() ? 'true' : 'false' }},
                             current_password: '',
                             password: '',
                             password_confirmation: '',
                             hasChanges() {
                                 return this.current_password.trim().length > 0 && 
                                        this.password.trim().length > 0 && 
                                        this.password_confirmation.trim().length > 0;
                             }
                         }">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h4 class="text-xl font-serif text-slate-900">Security & <span class="text-sky-600 italic">Password</span></h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Ensure your account is using a long, random password to stay secure.</p>
                            </div>
                            <button type="button" 
                                    x-show="!changingPassword" 
                                    @click="changingPassword = true" 
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-50 text-slate-700 hover:bg-sky-50 hover:text-sky-600 border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Change Password
                            </button>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6" x-show="changingPassword" style="display: none;" x-transition>
                            @csrf
                            @method('put')

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Current Password</label>
                                <input type="password" name="current_password" x-model="current_password" required class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->updatePassword->get('current_password')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">New Password</label>
                                    <input type="password" name="password" x-model="password" required class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->updatePassword->get('password')" />
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" x-model="password_confirmation" required class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                    <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->updatePassword->get('password_confirmation')" />
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="changingPassword = false; current_password = ''; password = ''; password_confirmation = '';" class="px-6 py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                    Cancel
                                </button>
                                <x-primary-button ::disabled="!hasChanges()" :class="'transition-all duration-300'" ::class="!hasChanges() ? 'opacity-50 cursor-not-allowed pointer-events-none shadow-none' : ''">{{ __('Update Password') }}</x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Delete Account Form -->
                    <div class="bg-white rounded-card border border-slate-100 shadow-sm p-8 md:p-12">
                        <header class="mb-8">
                            <h4 class="text-xl font-serif text-slate-900">Delete <span class="text-red-500 italic">Account</span></h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                        </header>

                        <div x-data="{ confirmingUserDeletion: false }">
                            <button @click="confirmingUserDeletion = true" class="px-8 py-4 bg-red-50 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-100 transition-colors shadow-sm">
                                Delete Account
                            </button>

                            <template x-teleport="body">
                                <div x-show="confirmingUserDeletion" x-cloak class="fixed inset-0 z-[300] flex items-center justify-center p-6">
                                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-500" @click="confirmingUserDeletion = false"></div>
                                    
                                    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-2xl p-12 border border-slate-100" 
                                         x-show="confirmingUserDeletion"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                                        
                                        <div class="flex justify-between items-center mb-10">
                                            <div>
                                                <h4 class="text-3xl font-serif text-slate-900 italic">Delete <span class="text-red-500">Account</span></h4>
                                                <p class="text-[10px] text-slate-400 font-black tracking-widest mt-1">This action cannot be undone</p>
                                            </div>
                                            <button @click="confirmingUserDeletion = false" class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-red-500 transition-all shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>

                                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                                            @csrf
                                            @method('delete')

                                            <p class="text-xs text-slate-500 leading-relaxed">
                                                Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                                            </p>

                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-black tracking-widest text-slate-400 ml-4">Password</label>
                                                <input type="password" name="password" required placeholder="••••••••" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 text-xs px-6 focus:ring-4 focus:ring-sky-500/10 transition-all">
                                                <x-input-error class="mt-2 text-rose-500 text-xs" :messages="$errors->userDeletion->get('password')" />
                                            </div>

                                            <div class="flex justify-end gap-3 mt-10">
                                                <button type="button" @click="confirmingUserDeletion = false" class="px-6 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-100 transition-all">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="px-10 py-4 bg-red-600 text-white rounded-2xl font-bold text-xs shadow-2xl hover:bg-red-700 transition-all">
                                                    Delete Permanently
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
