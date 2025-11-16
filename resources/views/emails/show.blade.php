<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('emails.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $email->subject }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <form action="{{ route('emails.star', $email) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-yellow-500">
                        <svg class="w-6 h-6 {{ $email->is_starred ? 'fill-current text-yellow-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </button>
                </form>
                <form action="{{ route('emails.archive', $email) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </button>
                </form>
                <form action="{{ route('emails.destroy', $email) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this email?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-600 hover:text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Email Header -->
                    <div class="border-b pb-4 mb-4">
                        <h1 class="text-2xl font-bold mb-4">{{ $email->subject }}</h1>
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($email->from_name ?? $email->from_email, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $email->from_name ?? $email->from_email }}</div>
                                        <div class="text-sm text-gray-600">{{ $email->from_email }}</div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <strong>To:</strong>
                                    @foreach($email->to as $recipient)
                                        {{ $recipient['email'] }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </div>
                                @if($email->cc)
                                    <div class="text-sm text-gray-600">
                                        <strong>Cc:</strong>
                                        @foreach($email->cc as $recipient)
                                            {{ $recipient['email'] }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $email->sent_at?->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Email Body -->
                    <div class="prose max-w-none">
                        {!! $email->body_html !!}
                    </div>

                    <!-- Attachments -->
                    @if($email->attachments && count($email->attachments) > 0)
                        <div class="mt-6 pt-4 border-t">
                            <h3 class="font-semibold mb-2">Attachments ({{ count($email->attachments) }})</h3>
                            <div class="space-y-2">
                                @foreach($email->attachments as $attachment)
                                    <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <span class="flex-1">{{ $attachment['name'] }}</span>
                                        <span class="text-sm text-gray-600">{{ $attachment['size'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
