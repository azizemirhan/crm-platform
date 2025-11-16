<x-app-layout>
    @push('styles')
    <style>
        /* Profile Page Custom Styles */
        .profile-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .form-input-focus {
            transition: all 0.2s ease-in-out;
        }

        .form-input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .success-alert {
            animation: slideInDown 0.5s ease-in-out;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delete-modal-overlay {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .delete-modal-content {
            animation: scaleIn 0.3s ease-in-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .section-icon {
            transition: transform 0.3s ease;
        }

        .profile-card:hover .section-icon {
            transform: rotate(5deg) scale(1.1);
        }

        .save-button {
            position: relative;
            overflow: hidden;
        }

        .save-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .save-button:hover::before {
            width: 300px;
            height: 300px;
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="px-4">
            <h2 class="text-2xl font-bold text-gray-900">Profile Settings</h2>
            <p class="text-sm text-gray-600 mt-1">Manage your account information and preferences</p>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-4xl mx-auto">
            <!-- Success Message -->
            @if(session('success'))
                <div class="success-alert bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Profile Information -->
            <div class="profile-card bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="section-icon p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Profile Information</h3>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="tel"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                                <input type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title', $user->title) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                <input type="text"
                                       name="department"
                                       id="department"
                                       value="{{ old('department', $user->department) }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('department')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                                <select name="timezone"
                                        id="timezone"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select timezone...</option>
                                    <option value="UTC" {{ old('timezone', $user->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="Europe/Istanbul" {{ old('timezone', $user->timezone) == 'Europe/Istanbul' ? 'selected' : '' }}>Istanbul (GMT+3)</option>
                                    <option value="America/New_York" {{ old('timezone', $user->timezone) == 'America/New_York' ? 'selected' : '' }}>New York (EST)</option>
                                    <option value="America/Los_Angeles" {{ old('timezone', $user->timezone) == 'America/Los_Angeles' ? 'selected' : '' }}>Los Angeles (PST)</option>
                                    <option value="Europe/London" {{ old('timezone', $user->timezone) == 'Europe/London' ? 'selected' : '' }}>London (GMT)</option>
                                </select>
                                @error('timezone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mt-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="bio"
                                      id="bio"
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                    class="save-button bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 inline-flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="profile-card bg-white overflow-hidden shadow-lg sm:rounded-xl border border-red-100">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="section-icon p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-red-700">Delete Account</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                        Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.
                    </p>

                    <button type="button"
                            onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="delete-modal-overlay hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative w-full max-w-md">
            <div class="delete-modal-content bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-2">Delete Account?</h3>
                <p class="text-sm text-gray-600 text-center mb-6">
                    This action cannot be undone. Please enter your password to confirm.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               placeholder="Enter your password"
                               class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 px-4 py-3">
                    </div>

                    <div class="flex gap-3">
                        <button type="button"
                                onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
                                class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Profile Page Custom JavaScript
        (function() {
            'use strict';

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                // Add form-input-focus class to all inputs
                const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], select, textarea');
                inputs.forEach(input => {
                    input.classList.add('form-input-focus');
                });

                // Form validation feedback
                const form = document.querySelector('form[action*="profile.update"]');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';

                            setTimeout(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Save Changes';
                            }, 5000);
                        }
                    });
                }

                // Auto-dismiss success alert
                const successAlert = document.querySelector('.success-alert');
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.opacity = '0';
                        successAlert.style.transform = 'translateY(-20px)';
                        setTimeout(() => {
                            successAlert.remove();
                        }, 300);
                    }, 5000);
                }

                console.log('Profile page initialized successfully');
            });

            // Modal functions
            const modal = document.getElementById('deleteAccountModal');
            if (modal) {
                // Open modal
                window.openDeleteModal = function() {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                };

                // Close modal
                window.closeDeleteModal = function() {
                    const modalContent = modal.querySelector('.delete-modal-content');
                    modalContent.style.transform = 'scale(0.9)';
                    modalContent.style.opacity = '0';

                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                        modalContent.style.transform = 'scale(1)';
                        modalContent.style.opacity = '1';
                    }, 200);
                };

                // Close modal on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        closeDeleteModal();
                    }
                });

                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeDeleteModal();
                    }
                });

                // Update existing button onclick
                const deleteButton = document.querySelector('button[onclick*="deleteAccountModal"]');
                if (deleteButton) {
                    deleteButton.setAttribute('onclick', 'openDeleteModal()');
                }

                // Update cancel button onclick
                const cancelButton = modal.querySelector('button[onclick*="deleteAccountModal"]');
                if (cancelButton) {
                    cancelButton.setAttribute('onclick', 'closeDeleteModal()');
                }
            }
        })();
    </script>
    @endpush
</x-app-layout>
