<div class="max-w-7xl mx-auto p-6">
    <!-- Ticket Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Ticket Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Ticket #{{ $ticket->ticket_number }}
                        </h1>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $this->getStatusColor($ticket->status) }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $this->getPriorityColor($ticket->priority) }}">
                            {{ ucfirst($ticket->priority) }} Priority
                        </span>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $ticket->subject }}</h2>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <span><strong>Created by:</strong> {{ $ticket->user->name }}</span>
                        <span><strong>Category:</strong> {{ ucfirst($ticket->category) }}</span>
                        <span><strong>Created:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}</span>
                        @if($ticket->assignedUser)
                            <span><strong>Assigned to:</strong> {{ $ticket->assignedUser->name }}</span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <!-- Status Update -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Update Status
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                            <div class="py-1">
                                <button wire:click="updateTicketStatus('open')" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Open
                                </button>
                                <button wire:click="updateTicketStatus('in_progress')" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    In Progress
                                </button>
                                <button wire:click="updateTicketStatus('resolved')" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Resolved
                                </button>
                                <button wire:click="updateTicketStatus('closed')" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Closed
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Assign Ticket -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Assign Ticket
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10 max-h-60 overflow-y-auto">
                            <div class="py-1">
                                <button wire:click="assignTicket(null)" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Unassign
                                </button>
                                @foreach($availableUsers as $user)
                                    <button wire:click="assignTicket({{ $user->id }})" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        {{ $user->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Description -->
            @if($ticket->description)
                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description:</h3>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $ticket->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Chat Messages -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- Messages Container -->
        <div class="h-96 overflow-y-auto p-4 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        <!-- Message Header -->
                        <div class="flex items-center gap-2 mb-1 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->sender->name }}
                            </span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                {{ $message->created_at->format('M d, H:i') }}
                            </span>
                            @if($message->message_type === 'system')
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">System</span>
                            @endif
                        </div>

                        <!-- Message Content -->
                        <div class="p-3 rounded-lg {{ $message->sender_id === auth()->id() 
                            ? 'bg-blue-600 text-white' 
                            : ($message->message_type === 'system' 
                                ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' 
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white') }}">
                            
                            <!-- Message Text -->
                            <p class="whitespace-pre-wrap">{{ $message->message }}</p>

                            <!-- Attachments -->
                            @if($message->attachments)
                                <div class="mt-2 space-y-2">
                                    @foreach($message->attachments as $index => $attachment)
                                        <div class="flex items-center gap-2 p-2 bg-white bg-opacity-20 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <button wire:click="downloadAttachment({{ $message->id }}, {{ $index }})" 
                                                    class="text-sm underline hover:no-underline">
                                                {{ $attachment['name'] }}
                                            </button>
                                            <span class="text-xs opacity-75">
                                                ({{ number_format($attachment['size'] / 1024, 1) }} KB)
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Read Status -->
                            @if($message->sender_id === auth()->id() && $message->is_read)
                                <div class="mt-1 text-xs opacity-75">
                                    ✓ Read
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
            <form wire:submit.prevent="sendMessage" class="space-y-4">
                <!-- File Attachments -->
                <div>
                    <input type="file" 
                           wire:model="attachments" 
                           multiple 
                           class="hidden" 
                           id="file-upload">
                    <label for="file-upload" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Attach Files
                    </label>
                </div>

                <!-- Show selected files -->
                @if($attachments)
                    <div class="space-y-2">
                        @foreach($attachments as $index => $attachment)
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $attachment->getClientOriginalName() }}
                                </span>
                                <button type="button" 
                                        wire:click="$set('attachments.{{ $index }}', null)"
                                        class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Message Input -->
                <div class="flex gap-2">
                    <div class="flex-1">
                        <textarea wire:model="newMessage" 
                                  placeholder="Type your message..." 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none"
                                  @keydown.ctrl.enter="$wire.sendMessage()"></textarea>
                        @error('newMessage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col justify-end">
                        <button type="submit" 
                                {{ $isLoading ? 'disabled' : '' }}
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            @if($isLoading)
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            @else
                                Send
                            @endif
                        </button>
                    </div>
                </div>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Press Ctrl+Enter to send quickly. Max file size: 10MB per file.
                </p>
            </form>
        </div>
    </div>
</div>

<!-- Auto-scroll to bottom script -->
<script>
    document.addEventListener('livewire:updated', () => {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });

    // Initial scroll to bottom
    window.addEventListener('load', () => {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
