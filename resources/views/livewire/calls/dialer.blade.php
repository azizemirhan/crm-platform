<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold">Dialer</h3>
        <button onclick="closeDialer()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @if(!$calling)
        <!-- Search Contacts -->
        <div class="mb-4">
            <input type="text"
                   wire:model.live.debounce.300ms="searchTerm"
                   placeholder="Search contacts or leads..."
                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

            @if(count($searchResults) > 0)
                <div class="mt-2 border rounded-lg max-h-48 overflow-y-auto">
                    @foreach($searchResults as $result)
                        <div wire:click="selectResult('{{ $result['type'] }}', {{ $result['id'] }}, '{{ $result['phone'] }}')"
                             class="p-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0">
                            <div class="font-medium">{{ $result['name'] }}</div>
                            <div class="text-sm text-gray-600">{{ $result['phone'] }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Phone Number Display -->
        <div class="mb-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <div class="text-2xl font-mono h-8">
                    {{ $phoneNumber ?: 'Enter phone number' }}
                </div>
            </div>
        </div>

        <!-- Dial Pad -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            @foreach(['1', '2', '3', '4', '5', '6', '7', '8', '9', '*', '0', '#'] as $digit)
                <button wire:click="addDigit('{{ $digit }}')"
                        class="bg-gray-100 hover:bg-gray-200 rounded-lg p-4 text-xl font-semibold transition">
                    {{ $digit }}
                </button>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <button wire:click="call"
                    @if(!$phoneNumber) disabled @endif
                    class="flex-1 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white py-3 rounded-lg inline-flex items-center justify-center transition">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Call
            </button>
            <button wire:click="backspace"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"/>
                </svg>
            </button>
            <button wire:click="clearNumber"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @else
        <!-- Calling Interface -->
        <div class="text-center py-8">
            <div class="mb-6">
                <div class="w-20 h-20 bg-green-500 rounded-full mx-auto flex items-center justify-center text-white mb-4 animate-pulse">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div class="text-2xl font-semibold mb-2">{{ $phoneNumber }}</div>
                <div class="text-gray-600">{{ $currentCall?->status }}</div>
            </div>

            <button wire:click="endCall"
                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg inline-flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"/>
                </svg>
                End Call
            </button>
        </div>
    @endif

    <!-- Error/Success Messages -->
    @if (session()->has('success'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
