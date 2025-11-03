<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Support Tickets Management</h1>
        <p class="text-gray-600 mt-1">Manage and track all support tickets from users</p>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Tickets</label>
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by ticket number, subject, or user..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="statusFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Statuses</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <select wire:model.live="priorityFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Priorities</option>
                    @foreach($priorityOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select wire:model.live="categoryFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Categories</option>
                    @foreach($categoryOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Assignment Filter -->
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Assignment</label>
            <select wire:model.live="assignedFilter" class="w-full md:w-64 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Assignments</option>
                <option value="unassigned">Unassigned</option>
                @foreach($assignableUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($supportTickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($supportTickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <!-- Ticket Number -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $ticket->ticket_number }}</div>
                                </td>

                                <!-- User -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            @if($ticket->user->profile_photo_path)
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url($ticket->user->profile_photo_path) }}" alt="{{ $ticket->user->name }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $ticket->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Subject -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $ticket->subject }}">
                                        {{ $ticket->subject }}
                                    </div>
                                    <div class="text-sm text-gray-500 max-w-xs truncate" title="{{ $ticket->description }}">
                                        {{ Str::limit($ticket->description, 50) }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateTicketStatus({{ $ticket->id }}, $event.target.value)" 
                                            class="text-xs px-2 py-1 rounded-full border-0 {{ $this->getStatusClass($ticket->status) }} focus:ring-2 focus:ring-primary-500">
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" {{ $ticket->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Priority -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateTicketPriority({{ $ticket->id }}, $event.target.value)" 
                                            class="text-xs px-2 py-1 rounded-full border-0 {{ $this->getPriorityClass($ticket->priority) }} focus:ring-2 focus:ring-primary-500">
                                        @foreach($priorityOptions as $value => $label)
                                            <option value="{{ $value }}" {{ $ticket->priority === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($ticket->category) }}
                                    </span>
                                </td>

                                <!-- Assigned To -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->assignedUser)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-6 w-6">
                                                @if($ticket->assignedUser->profile_photo_path)
                                                    <img class="h-6 w-6 rounded-full object-cover" src="{{ Storage::url($ticket->assignedUser->profile_photo_path) }}" alt="{{ $ticket->assignedUser->name }}">
                                                @else
                                                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center">
                                                        <svg class="h-3 w-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-2">
                                                <div class="text-sm text-gray-900">{{ $ticket->assignedUser->name }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Unassigned</span>
                                    @endif
                                </td>

                                <!-- Created -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $ticket->created_at->format('M j, Y') }}</div>
                                    <div class="text-xs">{{ $ticket->created_at->format('g:i A') }}</div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Assignment Dropdown -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" 
                                                    class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                                                <div class="py-1">
                                                    @if($ticket->assignedUser)
                                                        <button wire:click="unassignTicket({{ $ticket->id }})" 
                                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Unassign
                                                        </button>
                                                    @endif
                                                    @foreach($assignableUsers as $user)
                                                        @if(!$ticket->assignedUser || $ticket->assignedUser->id !== $user->id)
                                                            <button wire:click="assignTicket({{ $ticket->id }}, {{ $user->id }})" 
                                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                Assign to {{ $user->name }}
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Chat -->
                                        <a href="{{ route('super-admin.chat', $ticket->id) }}" wire:navigate 
                                           class="text-primary-600 hover:text-primary-900 p-1 rounded-full hover:bg-primary-50" 
                                           title="Open Chat">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $supportTickets->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($search || $statusFilter || $priorityFilter || $categoryFilter || $assignedFilter)
                        Try adjusting your search or filter criteria.
                    @else
                        No support tickets have been created yet.
                    @endif
                </p>
                @if($search || $statusFilter || $priorityFilter || $categoryFilter || $assignedFilter)
                    <div class="mt-6">
                        <button wire:click="$set('search', '')" 
                                wire:click="$set('statusFilter', '')"
                                wire:click="$set('priorityFilter', '')"
                                wire:click="$set('categoryFilter', '')"
                                wire:click="$set('assignedFilter', '')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Clear all filters
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Summary Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $supportTickets->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Open Tickets</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">High Priority</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \App\Models\SupportTicket::whereIn('priority', ['high', 'urgent'])->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Unassigned</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \App\Models\SupportTicket::whereNull('assigned_to')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
