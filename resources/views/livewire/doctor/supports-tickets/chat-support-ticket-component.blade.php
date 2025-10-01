<div class="flex flex-col h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('doctor.all_support_tickets') }}" wire:navigate 
                   class="inline-flex items-center text-primary-600 hover:text-primary-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Tickets
                </a>
                <div class="h-6 border-l border-gray-300 dark:border-gray-600"></div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Ticket #{{ $supportTicket->ticket_number }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $supportTicket->subject }}</p>
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
                    <button @click="open = !open" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Update Status
                        <svg class="ml-2 -mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">
                        <div class="py-1">
                            <button wire:click="updateTicketStatus('open')" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Open
                            </button>
                            <button wire:click="updateTicketStatus('in_progress')" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                In Progress
                            </button>
                            <button wire:click="updateTicketStatus('pending')" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Pending
                            </button>
                            <button wire:click="updateTicketStatus('resolved')" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Resolved
                            </button>
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
                                <div class="px-4 py-2 rounded-lg {{ $message['message_type'] === 'system' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : ($message['sender_id'] == auth()->id() ? 'bg-primary-500 text-white' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600') }}">
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
                                <div class="flex items-center mt-1 space-x-2 text-xs text-gray-500 dark:text-gray-400 {{ $message['sender_id'] == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
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
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No messages yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start the conversation by sending a message below.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Input -->
    <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-6 py-4">
        <form wire:submit.prevent="sendMessage" class="space-y-4">
            <!-- File Attachments Preview -->
            @if(!empty($attachments))
                <div class="flex flex-wrap gap-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $attachment['name'] }}</span>
                            <button type="button" 
                                    wire:click="removeAttachment({{ $index }})"
                                    class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
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
                    <div class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </div>
                </label>

                <!-- Message Input -->
                <div class="flex-1">
                    <textarea wire:model="newMessage"
                              wire:keydown.enter.prevent="sendMessage"
                              wire:keydown="startTyping"
                              wire:keyup="stopTyping"
                              placeholder="Type your message..."
                              rows="1"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white resize-none @error('newMessage') border-red-500 @enderror"
                              style="min-height: 40px; max-height: 120px;"></textarea>
                    @error('newMessage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Button -->
                <button type="submit" 
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                        class="flex-shrink-0 inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 disabled:bg-primary-400 text-white font-medium rounded-lg transition-colors">
                    <span wire:loading.remove wire:target="sendMessage">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </span>
                    <span wire:loading wire:target="sendMessage">
                        <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l-3-2.647z"></path>
                        </svg>
                    </span>
                </button>
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