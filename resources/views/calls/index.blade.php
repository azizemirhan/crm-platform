<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Calls</h2>
                <p class="text-sm text-gray-600 mt-1">Manage and track all your call activities</p>
            </div>
            <button onclick="openDialer()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl inline-flex items-center gap-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span class="font-semibold">Make Call</span>
            </button>
        </div>
    </x-slot>

    <div class="space-y-6">
        @livewire('calls.call-list')
    </div>

    <!-- Modern Dialer Modal -->
    <div id="dialerModal" class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl transform transition-all">
                <!-- Close Button -->
                <button onclick="closeDialer()" class="absolute -top-4 -right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors z-10">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                @livewire('calls.dialer')
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openDialer() {
            document.getElementById('dialerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDialer() {
            document.getElementById('dialerModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.getElementById('dialerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDialer();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('dialerModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeDialer();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
