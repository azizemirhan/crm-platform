<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center px-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Emails</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your email communications and campaigns</p>
            </div>
            <a href="{{ route('emails.compose') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-3 rounded-xl inline-flex items-center gap-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-semibold">Compose Email</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Email Folder Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-2 overflow-x-auto">
                <a href="{{ route('emails.index', ['folder' => 'inbox']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder', 'inbox') === 'inbox' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-inbox"></i>
                    <span>Inbox</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'sent']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'sent' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-send"></i>
                    <span>Sent</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'drafts']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'drafts' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Drafts</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'starred']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'starred' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-star"></i>
                    <span>Starred</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'archived']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'archived' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-archive"></i>
                    <span>Archived</span>
                </a>
                <a href="{{ route('emails.index', ['folder' => 'trash']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ request()->get('folder') === 'trash' ? 'bg-purple-100 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="bi bi-trash"></i>
                    <span>Trash</span>
                </a>
            </div>
        </div>

        <!-- Email List -->
        @livewire('emails.email-list', ['folder' => request()->get('folder', 'inbox')])
    </div>
</x-app-layout>
