<x-app-layout>
    @push('styles')
    <style>
        /* Calls Page Custom Styles */
        .calls-header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .dialer-modal-overlay {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .dialer-modal-content {
            animation: slideUp 0.3s ease-in-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .call-button-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
    @endpush

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
    <div id="dialerModal" class="dialer-modal-overlay hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md">
            <div class="dialer-modal-content bg-white rounded-2xl shadow-2xl transform transition-all">
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
        // Calls Page Custom JavaScript
        (function() {
            'use strict';

            window.openDialer = function() {
                const modal = document.getElementById('dialerModal');
                if (!modal) return;

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Add entrance animation
                setTimeout(() => {
                    modal.style.opacity = '1';
                }, 10);

                console.log('Dialer modal opened');
            };

            window.closeDialer = function() {
                const modal = document.getElementById('dialerModal');
                if (!modal) return;

                // Add exit animation
                modal.style.opacity = '0';

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    modal.style.opacity = '1';
                }, 300);

                console.log('Dialer modal closed');
            };

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('dialerModal');
                if (!modal) return;

                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeDialer();
                    }
                });

                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeDialer();
                    }
                });

                console.log('Calls page initialized successfully');
            });
        })();
    </script>
    @endpush
</x-app-layout>
