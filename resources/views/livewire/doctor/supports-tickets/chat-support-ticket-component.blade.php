<div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-50">
    <!-- Header -->
    <div class="bg-white dark:bg-white border-b border-gray-200 dark:border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('doctor.all_support_tickets') }}" wire:navigate 
                   class="inline-flex items-center text-primary-600 hover:text-primary-900 dark:text-primary-600 dark:hover:text-primary-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Tickets
                </a>
                <div class="h-6 border-l border-gray-300 dark:border-gray-300"></div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-900">
                        Ticket #{{ $supportTicket->ticket_number }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-600">{{ $supportTicket->subject }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Status Badge -->
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->statusColor }}">
                    {{ ucfirst($supportTicket->status) }}
                </span>
                
                <!-- Priority Badge -->
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->priorityColor }}">
                    {{ ucfirst($supportTicket->priority) }}
                </span>

                <!-- Status Update Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <x-ui.button
                        type="button"
                        size="sm"
                        variant="outline"
                        class="!px-3 !py-2 text-sm text-gray-700 dark:text-gray-700"
                        @click="open = !open">
                        Update Status
                        <x-ui.icon name="chevron-down" class="ml-2 -mr-1 h-4 w-4" />
                    </x-ui.button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-white rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-200">
                        <div class="py-1">
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                size="sm"
                                class="!justify-start w-full !px-4 !py-2 text-sm text-gray-700 dark:text-gray-700 hover:!bg-gray-100"
                                wire:click="updateTicketStatus('open')">
                                Open
                            </x-ui.button>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                size="sm"
                                class="!justify-start w-full !px-4 !py-2 text-sm text-gray-700 dark:text-gray-700 hover:!bg-gray-100"
                                wire:click="updateTicketStatus('in_progress')">
                                In Progress
                            </x-ui.button>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                size="sm"
                                class="!justify-start w-full !px-4 !py-2 text-sm text-gray-700 dark:text-gray-700 hover:!bg-gray-100"
                                wire:click="updateTicketStatus('pending')">
                                Pending
                            </x-ui.button>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                size="sm"
                                class="!justify-start w-full !px-4 !py-2 text-sm text-gray-700 dark:text-gray-700 hover:!bg-gray-100"
                                wire:click="updateTicketStatus('resolved')">
                                Resolved
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Messages Container -->
    <div class="flex-1 overflow-hidden">
        <div id="messages-container" 
             class="h-full overflow-y-auto px-6 py-4 space-y-4"
             wire:poll.3s="loadNewMessages">
            
            @forelse($messages as $message)
                <div class="flex {{ $message['sender_id'] == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        <!-- Message Bubble -->
                        <div class="flex items-end space-x-2 {{ $message['sender_id'] == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full {{ $message['sender_id'] == auth()->id() ? 'bg-primary-500' : 'bg-gray-500' }} flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($message['sender']['name'] ?? 'System', 0, 1) }}
                                </div>
                            </div>
                            
                            <!-- Message Content -->
                            <div class="flex flex-col">
                                <div class="px-4 py-2 rounded-lg {{ $message['message_type'] === 'system' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : ($message['sender_id'] == auth()->id() ? 'bg-primary-500 text-white' : 'bg-white dark:bg-white text-gray-900 dark:text-gray-900 border border-gray-200 dark:border-gray-200') }}">
                                    <p class="text-sm">{{ $message['message'] }}</p>
                                    
                                    <!-- Attachments -->
                                    @if(!empty($message['attachments']))
                                        @php 
                                            $attachments = is_string($message['attachments']) 
                                                ? json_decode($message['attachments'], true) 
                                                : $message['attachments'];
                                        @endphp
                                        <div class="mt-2 space-y-1">
                                            @foreach($attachments as $attachment)
                                                <div class="flex items-center space-x-2 p-2 bg-black bg-opacity-10 rounded">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <a href="{{ Storage::url($attachment['path']) }}" 
                                                       target="_blank"
                                                       class="text-xs underline">
                                                        {{ $attachment['name'] }}
                                                    </a>
                                                    <span class="text-xs opacity-75">({{ number_format($attachment['size'] / 1024, 1) }} KB)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Message Info -->
                                <div class="flex items-center mt-1 space-x-2 text-xs text-gray-500 dark:text-gray-600 {{ $message['sender_id'] == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                    <span>{{ $message['sender']['name'] ?? 'System' }}</span>
                                    <span>•</span>
                                    <span>{{ \Carbon\Carbon::parse($message['created_at'])->format('M j, g:i A') }}</span>
                                    @if($message['sender_id'] == auth()->id() && $message['is_read'])
                                        <span>•</span>
                                        <span class="text-primary-500">Read</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-900">No messages yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-600">Start the conversation by sending a message below.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Input -->
    <div class="bg-white dark:bg-white border-t border-gray-200 dark:border-gray-200 px-6 py-4">
        <form wire:submit.prevent="sendMessage" class="space-y-4">
            <!-- File Attachments Preview -->
            @if(!empty($attachments))
                <div class="flex flex-wrap gap-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-100 rounded-lg px-3 py-2">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-700">{{ $attachment['name'] }}</span>
                            <x-ui.button
                                type="button"
                                size="xs"
                                variant="ghost"
                                class="!p-0 text-red-500 hover:text-red-600"
                                squared
                                wire:click="removeAttachment({{ $index }})"
                                icon="x-mark" />
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Message Input Row -->
            <div class="flex items-end space-x-3">
                <!-- File Upload Button -->
                <label class="flex-shrink-0 cursor-pointer">
                    <input type="file" 
                           wire:model="attachments"
                           multiple
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                           class="hidden">
                    <x-ui.button
                        as="span"
                        variant="ghost"
                        size="sm"
                        squared
                        icon="paper-clip"
                        class="text-gray-600 hover:text-gray-800" />
                </label>

                <!-- Message Input -->
                <div class="flex-1">
                    <textarea wire:model="newMessage"
                              wire:keydown.enter.prevent="sendMessage"
                              wire:keydown="startTyping"
                              wire:keyup="stopTyping"
                              placeholder="Type your message..."
                              rows="1"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-white dark:text-gray-900 resize-none @error('newMessage') border-red-500 @enderror"
                              style="min-height: 40px; max-height: 120px;"></textarea>
                    @error('newMessage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Button -->
                <x-ui.button
                    type="submit"
                    color="teal"
                    variant="primary"
                    size="sm"
                    squared
                    icon="paper-airplane"
                    wire:loading.attr="disabled"
                    wire:target="sendMessage" />
            </div>
        </form>
    </div>

    <!-- Auto-scroll Script -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scrollToBottom', () => {
                setTimeout(() => {
                    const container = document.getElementById('messages-container');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);
            });
        });

        // Auto-scroll on page load
        window.addEventListener('load', () => {
            setTimeout(() => {
                const container = document.getElementById('messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 500);
        });

        // Auto-resize textarea
        document.addEventListener('input', function(e) {
            if (e.target.tagName.toLowerCase() === 'textarea') {
                e.target.style.height = 'auto';
                e.target.style.height = Math.min(e.target.scrollHeight, 120) + 'px';
            }
        });
    </script>
</div>