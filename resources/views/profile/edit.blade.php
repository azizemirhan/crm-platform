<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profile Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Profile Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Profile Information</h3>

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

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-2 text-red-600">Delete Account</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                    </p>

                    <button type="button"
                            onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <h3 class="text-lg font-semibold mb-4">Are you sure?</h3>
            <p class="text-sm text-gray-600 mb-4">
                This action cannot be undone. Please enter your password to confirm.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password"
                           name="password"
                           id="password"
                           required
                           class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button"
                            onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
