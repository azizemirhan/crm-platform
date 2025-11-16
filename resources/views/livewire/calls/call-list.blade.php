<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Total Calls</div>
            <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Today</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['today'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Answered</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['answered'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Missed</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['missed'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Total Duration</div>
            <div class="text-2xl font-bold">{{ floor($stats['total_duration'] / 60) }}m</div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Filters -->
        <div class="p-4 border-b bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search calls..."
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <select wire:model.live="filters.direction" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Directions</option>
                        <option value="inbound">Inbound</option>
                        <option value="outbound">Outbound</option>
                    </select>
                </div>

                <div>
                    <select wire:model.live="filters.disposition" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Dispositions</option>
                        <option value="answered">Answered</option>
                        <option value="no-answer">No Answer</option>
                        <option value="busy">Busy</option>
                        <option value="voicemail">Voicemail</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div>
                    <select wire:model.live="filters.user_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($search || $filters['direction'] || $filters['disposition'] || $filters['user_id'])
                <div class="mt-4">
                    <button wire:click="clearFilters" class="text-sm text-gray-600 hover:text-gray-900">
                        Clear all filters
                    </button>
                </div>
            @endif
        </div>

        <!-- Call List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Direction
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Duration
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Agent
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($calls as $call)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($call->direction === 'outbound')
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3l4 4m0 0l-4 4m4-4H4"/>
                                        </svg>
                                        <span class="text-sm">Outbound</span>
                                    @else
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l-4 4m0 0l4 4m-4-4h16"/>
                                        </svg>
                                        <span class="text-sm">Inbound</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $call->direction === 'outbound' ? $call->to_number : $call->from_number }}
                                </div>
                                @if($call->related_to)
                                    <div class="text-sm text-gray-500">
                                        {{ $call->related_to->full_name ?? $call->related_to->name ?? '' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $call->disposition === 'answered' ? 'bg-green-100 text-green-800' :
                                       ($call->disposition === 'no-answer' ? 'bg-yellow-100 text-yellow-800' :
                                       ($call->disposition === 'busy' ? 'bg-red-100 text-red-800' :
                                       'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($call->disposition ?? $call->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $call->formatDuration() }}
                                @if($call->is_recorded)
                                    <svg class="w-4 h-4 inline text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                    </svg>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $call->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $call->created_at->format('M d, Y') }}
                                <div class="text-xs text-gray-400">{{ $call->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('calls.show', $call) }}" class="text-blue-600 hover:text-blue-900">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <p>No calls found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($calls->hasPages())
            <div class="p-4 border-t">
                {{ $calls->links() }}
            </div>
        @endif
    </div>
</div>
