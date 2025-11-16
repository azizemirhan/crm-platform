<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form wire:submit.prevent="send">
            <div class="p-6 space-y-4">
                <!-- Template Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Use Template (Optional)</label>
                    <div class="flex space-x-2">
                        <select wire:model="template_id" class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select a template --</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="loadTemplate" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Load Template
                        </button>
                    </div>
                </div>

                <!-- To Recipients -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To *</label>
                    <div class="space-y-2">
                        @foreach($to as $index => $recipient)
                            <div class="flex items-center space-x-2">
                                <input type="email"
                                       wire:model="to.{{ $index }}.email"
                                       class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="recipient@example.com">
                                <button type="button" wire:click="removeRecipient('to', {{ $index }})" class="text-red-600 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach

                        <div class="flex items-center space-x-2">
                            <input type="email"
                                   wire:model="newRecipient"
                                   wire:keydown.enter.prevent="addRecipient"
                                   class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Add recipient...">
                            <select wire:model="recipientType" class="rounded-lg border-gray-300">
                                <option value="to">To</option>
                                <option value="cc">Cc</option>
                                <option value="bcc">Bcc</option>
                            </select>
                            <button type="button" wire:click="addRecipient" class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg">
                                Add
                            </button>
                        </div>
                    </div>
                    @error('to') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- CC Recipients -->
                @if(count($cc) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cc</label>
                        <div class="space-y-2">
                            @foreach($cc as $index => $recipient)
                                <div class="flex items-center space-x-2">
                                    <input type="email"
                                           wire:model="cc.{{ $index }}.email"
                                           class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="recipient@example.com">
                                    <button type="button" wire:click="removeRecipient('cc', {{ $index }})" class="text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- BCC Recipients -->
                @if(count($bcc) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bcc</label>
                        <div class="space-y-2">
                            @foreach($bcc as $index => $recipient)
                                <div class="flex items-center space-x-2">
                                    <input type="email"
                                           wire:model="bcc.{{ $index }}.email"
                                           class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="recipient@example.com">
                                    <button type="button" wire:click="removeRecipient('bcc', {{ $index }})" class="text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                    <input type="text"
                           wire:model="subject"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Email subject...">
                    @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Body -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea wire:model="body"
                              rows="12"
                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Write your message..."></textarea>
                    @error('body') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Send Email
                        </button>
                        <button type="button" wire:click="saveDraft" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">
                            Save Draft
                        </button>
                    </div>
                    <a href="{{ route('emails.index') }}" class="text-gray-600 hover:text-gray-900">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
