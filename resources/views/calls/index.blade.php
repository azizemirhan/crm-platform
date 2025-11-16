<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calls
            </h2>
            <button onclick="openDialer()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Make Call
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('calls.call-list')
        </div>
    </div>

    <!-- Dialer Modal -->
    <div id="dialerModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 w-96">
            <div class="bg-white rounded-lg shadow-xl">
                @livewire('calls.dialer')
            </div>
        </div>
    </div>

    <script>
        function openDialer() {
            document.getElementById('dialerModal').classList.remove('hidden');
        }

        function closeDialer() {
            document.getElementById('dialerModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('dialerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDialer();
            }
        });
    </script>
</x-app-layout>
