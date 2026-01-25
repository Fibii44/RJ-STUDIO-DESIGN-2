<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-sky-600">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Architect's Control Center</h3>
                    {{ __("You're logged in as Admin, Randolf Jan!") }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500 uppercase font-bold tracking-wider">Active Projects</p>
                    <p class="text-3xl font-black text-sky-600">12</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>