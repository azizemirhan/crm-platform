<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('calls.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Call Details
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Call Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="p-3 rounded-full {{ $call->direction === 'outbound' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                    @if($call->direction === 'outbound')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3l4 4m0 0l-4 4m4-4H4"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l-4 4m0 0l4 4m-4-4h16"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">
                                        {{ $call->direction === 'outbound' ? $call->to_number : $call->from_number }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ $call->direction === 'outbound' ? 'Outbound Call' : 'Inbound Call' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $call->disposition === 'answered' ? 'bg-green-100 text-green-800' :
                                   ($call->disposition === 'no-answer' ? 'bg-yellow-100 text-yellow-800' :
                                   ($call->disposition === 'busy' ? 'bg-red-100 text-red-800' :
                                   'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($call->disposition ?? $call->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Call Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-600">Duration</div>
                            <div class="text-lg font-semibold">{{ $call->formatDuration() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Started At</div>
                            <div class="text-lg font-semibold">
                                {{ $call->started_at?->format('M d, h:i A') ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Ended At</div>
                            <div class="text-lg font-semibold">
                                {{ $call->ended_at?->format('M d, h:i A') ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Agent</div>
                            <div class="text-lg font-semibold">{{ $call->user->name }}</div>
                        </div>
                    </div>

                    <!-- Recording -->
                    @if($call->recording_url)
                        <div class="border-t pt-4">
                            <h3 class="font-semibold mb-2">Call Recording</h3>
                            <audio controls class="w-full">
                                <source src="{{ $call->recording_url }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="text-sm text-gray-600 mt-2">
                                Duration: {{ $call->recording_duration }}s
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related To -->
            @if($call->related_to)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-semibold mb-4">Related To</h3>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($call->related_to->full_name ?? $call->related_to->name ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold">{{ $call->related_to->full_name ?? $call->related_to->name }}</div>
                                <div class="text-sm text-gray-600">{{ class_basename($call->related_to_type) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Notes & Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold mb-4">Notes & Summary</h3>
                    <form action="{{ route('calls.update', $call) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disposition</label>
                                <select name="disposition" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="answered" {{ $call->disposition === 'answered' ? 'selected' : '' }}>Answered</option>
                                    <option value="busy" {{ $call->disposition === 'busy' ? 'selected' : '' }}>Busy</option>
                                    <option value="no-answer" {{ $call->disposition === 'no-answer' ? 'selected' : '' }}>No Answer</option>
                                    <option value="failed" {{ $call->disposition === 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="voicemail" {{ $call->disposition === 'voicemail' ? 'selected' : '' }}>Voicemail</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Summary</label>
                                <input type="text"
                                       name="summary"
                                       value="{{ $call->summary }}"
                                       class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Brief call summary...">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                <textarea name="notes"
                                          rows="6"
                                          class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Add detailed notes about the call...">{{ $call->notes }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
