<div class="flex flex-col h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('organization-admin.all_support_tickets') }}" wire:navigate
                   class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Tickets
                </a>
                <div class="h-6 border-l border-gray-300"></div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        Ticket #{{ $supportTicket->ticket_number }}
                    </h1>
                    <p class="text-sm text-gray-600">{{ $supportTicket->subject }}</p>
                    <p class="text-xs text-gray-500">Created by: {{ $supportTicket->created_by_admin->name ?? 'Organization Admin' }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Status Badge -->
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($supportTicket->status) }}">
                    {{ ucfirst(str_replace('_', ' ', $supportTicket->status)) }}
                </span>
                
                <!-- Priority Badge -->
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPriorityColor($supportTicket->priority) }}">
                    {{ ucfirst($supportTicket->priority) }}
                </span>

                <!-- Status Update Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Update Status
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 ring-1 ring-black ring-opacity-5">
                        <button wire:click="updateTicketStatus('open')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Open
                        </button>
                        <button wire:click="updateTicketStatus('in_progress')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            In Progress
                        </button>
                        <button wire:click="updateTicketStatus('resolved')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Resolved
                        </button>
                        <button wire:click="updateTicketStatus('closed')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Closed
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
        @if(count($messages) > 0)
            @foreach($messages as $message)
                <div class="flex {{ $message['sender_id'] == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message['sender_id'] == auth()->id() ? 'bg-primary-600 text-white' : 'bg-white text-gray-900 border border-gray-200' }}">
                        <!-- Message Header -->
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-medium {{ $message['sender_id'] == auth()->id() ? 'text-primary-100' : 'text-gray-500' }}">
                                {{ $message['sender']['name'] }}
                            </span>
                            <span class="text-xs {{ $message['sender_id'] == auth()->id() ? 'text-primary-100' : 'text-gray-500' }}">
                                {{ \Carbon\Carbon::parse($message['created_at'])->format('g:i A') }}
                            </span>
                        </div>
                        
                        <!-- Message Content -->
                        <div class="text-sm">
                            {{ $message['message'] }}
                        </div>
                        
                        <!-- Attachments -->
                        @if($message['attachments'])
                            @php
                                $attachments = is_string($message['attachments']) ? json_decode($message['attachments'], true) : $message['attachments'];
                            @endphp
                            @if($attachments)
                                <div class="mt-2 space-y-1">
                                    @foreach($attachments as $attachment)
                                        <div class="flex items-center space-x-2 p-2 bg-gray-100 rounded">
                                            <x-ui.icon name="document" class="w-4 h-4 text-gray-500" />
                                            <a href="{{ Storage::url($attachment['path']) }}" 
                                               target="_blank"
                                               class="text-sm text-blue-600 hover:text-blue-800">
                                                {{ $attachment['name'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-8">
                <x-ui.icon name="chat-bubble-left-right" class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">No messages yet</h3>
                <p class="mt-1 text-sm text-gray-500">Start the conversation by sending a message.</p>
            </div>
        @endif
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t border-gray-200 p-6">
        <form wire:submit.prevent="sendMessage" class="space-y-4">
            <!-- File Attachments -->
            @if($attachments)
                <div class="flex flex-wrap gap-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center space-x-2 bg-gray-100 rounded-lg px-3 py-2">
                            <x-ui.icon name="document" class="w-4 h-4 text-gray-500" />
                            <span class="text-sm text-gray-700">
                                @php
                                    $displayName = 'Attachment';
                                    if (is_array($attachment)) {
                                        $displayName = $attachment['name'] ?? ($attachment['path'] ?? 'Attachment');
                                    } elseif (is_object($attachment) && method_exists($attachment, 'getClientOriginalName')) {
                                        $displayName = $attachment->getClientOriginalName();
                                    } elseif (is_string($attachment)) {
                                        $displayName = basename($attachment);
                                    }
                                @endphp
                                {{ $displayName }}
                            </span>
                            <x-ui.button variant="ghost" size="sm" wire:click="removeAttachment({{ $index }})">
                                <x-ui.icon name="x-mark" class="w-4 h-4 text-red-500" />
                            </x-ui.button>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex space-x-4">
                <!-- Message Input -->
                <div class="flex-1">
                    <x-ui.textarea wire:model="newMessage" rows="3" placeholder="Type your message..." />
                    <x-ui.error name="newMessage" />
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col space-y-2">
                    <!-- File Upload -->
                    <label class="cursor-pointer">
                        <x-ui.button variant="outline" color="teal" type="button">
                            <x-ui.icon name="paper-clip" class="w-4 h-4 mr-2" />
                            Attach
                        </x-ui.button>
                        <input type="file" 
                               wire:model="attachments"
                               multiple
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                               class="sr-only">
                    </label>

                    <!-- Send Button -->
                    <x-ui.button variant="primary" color="teal" type="submit" :loading="false" wire:target="sendMessage">
                        <span wire:loading.remove wire:target="sendMessage">Send</span>
                        <span wire:loading wire:target="sendMessage">Sending...</span>
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('scrollToBottom', () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    });
</script>