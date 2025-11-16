<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Integrations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Twilio Integration -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @php
                            $twilioIntegration = $integrations->where('provider', 'twilio')->first();
                        @endphp

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-red-100 rounded">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">Twilio</h3>
                                    <p class="text-sm text-gray-600">Phone calls & SMS</p>
                                </div>
                            </div>
                            @if($twilioIntegration && $twilioIntegration->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded">Not Configured</span>
                            @endif
                        </div>

                        <form action="{{ route('settings.integrations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="provider" value="twilio">
                            <input type="hidden" name="name" value="Twilio">
                            <input type="hidden" name="is_active" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Account SID *</label>
                                    <input type="text"
                                           name="credentials[sid]"
                                           value="{{ $twilioIntegration?->getCredential('sid') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Auth Token *</label>
                                    <input type="password"
                                           name="credentials[token]"
                                           value="{{ $twilioIntegration?->getCredential('token') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Your auth token">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                    <input type="text"
                                           name="credentials[phone_number]"
                                           value="{{ $twilioIntegration?->getCredential('phone_number') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="+1234567890">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                    <textarea name="notes"
                                              rows="2"
                                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Optional notes...">{{ $twilioIntegration?->notes }}</textarea>
                                </div>

                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        Save Configuration
                                    </button>
                                    @if($twilioIntegration)
                                        <form action="{{ route('settings.integrations.destroy', $twilioIntegration) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="text-red-600 hover:text-red-700 text-sm">
                                                Remove
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SMTP Email Integration -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @php
                            $smtpIntegration = $integrations->where('provider', 'smtp')->first();
                        @endphp

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 rounded">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">SMTP Email</h3>
                                    <p class="text-sm text-gray-600">Email sending</p>
                                </div>
                            </div>
                            @if($smtpIntegration && $smtpIntegration->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded">Not Configured</span>
                            @endif
                        </div>

                        <form action="{{ route('settings.integrations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="provider" value="smtp">
                            <input type="hidden" name="name" value="SMTP Email">
                            <input type="hidden" name="is_active" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host *</label>
                                    <input type="text"
                                           name="credentials[host]"
                                           value="{{ $smtpIntegration?->getCredential('host') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="smtp.gmail.com">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Port *</label>
                                        <input type="number"
                                               name="credentials[port]"
                                               value="{{ $smtpIntegration?->getCredential('port', 587) }}"
                                               required
                                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="587">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                                        <select name="credentials[encryption]"
                                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                            <option value="tls" {{ $smtpIntegration?->getCredential('encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ $smtpIntegration?->getCredential('encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                                    <input type="text"
                                           name="credentials[username]"
                                           value="{{ $smtpIntegration?->getCredential('username') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="your@email.com">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                                    <input type="password"
                                           name="credentials[password]"
                                           value="{{ $smtpIntegration?->getCredential('password') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Your password or app password">
                                </div>

                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        Save Configuration
                                    </button>
                                    @if($smtpIntegration)
                                        <form action="{{ route('settings.integrations.destroy', $smtpIntegration) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="text-red-600 hover:text-red-700 text-sm">
                                                Remove
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SendGrid Integration -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @php
                            $sendgridIntegration = $integrations->where('provider', 'sendgrid')->first();
                        @endphp

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-indigo-100 rounded">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">SendGrid</h3>
                                    <p class="text-sm text-gray-600">Email delivery service</p>
                                </div>
                            </div>
                            @if($sendgridIntegration && $sendgridIntegration->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded">Not Configured</span>
                            @endif
                        </div>

                        <form action="{{ route('settings.integrations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="provider" value="sendgrid">
                            <input type="hidden" name="name" value="SendGrid">
                            <input type="hidden" name="is_active" value="1">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                                    <input type="password"
                                           name="credentials[api_key]"
                                           value="{{ $sendgridIntegration?->getCredential('api_key') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="SG.xxxxxxxxxxxxxxxx">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                                    <input type="email"
                                           name="credentials[from_email]"
                                           value="{{ $sendgridIntegration?->getCredential('from_email') }}"
                                           required
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="noreply@yourdomain.com">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                                    <input type="text"
                                           name="credentials[from_name]"
                                           value="{{ $sendgridIntegration?->getCredential('from_name') }}"
                                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Your Company">
                                </div>

                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        Save Configuration
                                    </button>
                                    @if($sendgridIntegration)
                                        <form action="{{ route('settings.integrations.destroy', $sendgridIntegration) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="text-red-600 hover:text-red-700 text-sm">
                                                Remove
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
