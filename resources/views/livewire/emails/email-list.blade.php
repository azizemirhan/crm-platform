<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Inbox</div>
            <div class="text-2xl font-bold">{{ $stats['inbox'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Unread</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['unread'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-600">Starred</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['starred'] }}</div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-48 border-r bg-gray-50 p-4">
                <nav class="space-y-1">
                    <button wire:click="changeFolder('inbox')"
                            class="w-full text-left px-3 py-2 rounded-lg {{ $folder === 'inbox' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Inbox
                        </div>
                    </button>

                    <button wire:click="changeFolder('sent')"
                            class="w-full text-left px-3 py-2 rounded-lg {{ $folder === 'sent' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Sent
                        </div>
                    </button>

                    <button wire:click="changeFolder('starred')"
                            class="w-full text-left px-3 py-2 rounded-lg {{ $folder === 'starred' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Starred
                        </div>
                    </button>

                    <button wire:click="changeFolder('archived')"
                            class="w-full text-left px-3 py-2 rounded-lg {{ $folder === 'archived' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                            Archived
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Email List -->
            <div class="flex-1">
                <!-- Search and Actions -->
                <div class="p-4 border-b">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="Search emails..."
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        @if(count($selectedEmails) > 0)
                            <div class="flex space-x-2">
                                <button wire:click="markAsRead" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                                    Mark as Read
                                </button>
                                <button wire:click="archiveSelected" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">
                                    Archive
                                </button>
                                <button wire:click="deleteSelected" class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm">
                                    Delete
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Email Items -->
                <div class="divide-y">
                    @forelse($emails as $email)
                        <div class="p-4 hover:bg-gray-50 {{ !$email->is_read ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start space-x-4">
                                <input type="checkbox"
                                       wire:click="toggleSelect({{ $email->id }})"
                                       {{ in_array($email->id, $selectedEmails) ? 'checked' : '' }}
                                       class="mt-1 rounded border-gray-300">

                                <button wire:click="toggleStar({{ $email->id }})" class="mt-1">
                                    <svg class="w-5 h-5 {{ $email->is_starred ? 'fill-current text-yellow-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </button>

                                <a href="{{ route('emails.show', $email) }}" class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="font-semibold {{ !$email->is_read ? 'text-gray-900' : 'text-gray-700' }}">
                                                    {{ $folder === 'sent' ? 'To: ' : '' }}{{ $email->from_name ?? $email->from_email }}
                                                </span>
                                                @if($email->attachments_count > 0)
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text-sm {{ !$email->is_read ? 'font-semibold text-gray-900' : 'text-gray-700' }} truncate">
                                                {{ $email->subject }}
                                            </div>
                                            <div class="text-sm text-gray-500 truncate mt-1">
                                                {{ strip_tags(Str::limit($email->body_html ?? $email->body_text, 100)) }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500 ml-4 whitespace-nowrap">
                                            {{ $email->sent_at?->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p>No emails found</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($emails->hasPages())
                    <div class="p-4 border-t">
                        {{ $emails->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
