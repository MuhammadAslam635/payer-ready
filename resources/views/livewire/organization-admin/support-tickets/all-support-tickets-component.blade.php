<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Support Tickets</h1>
                <p class="text-gray-600 mt-1">Manage support tickets for your organization's doctors</p>
            </div>
            <a href="{{ route('organization-admin.create_support_ticket') }}" wire:navigate
               class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Ticket
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="ticket" class="w-4 h-4 text-blue-600" />
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="check-circle" class="w-4 h-4 text-blue-600" />
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Open</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['open'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="clock" class="w-4 h-4 text-yellow-600" />
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['in_progress'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="check-circle" class="w-4 h-4 text-green-600" />
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Resolved</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['resolved'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="x-circle" class="w-4 h-4 text-gray-600" />
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Closed</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['closed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <x-ui.label>Search</x-ui.label>
                <x-ui.input wire:model.live.debounce.300ms="search" placeholder="Search tickets..." />
            </div>

            <!-- Status Filter -->
            <div>
                <x-ui.label>Status</x-ui.label>
                <x-ui.select wire:model.live="statusFilter">
                    <x-ui.select.option value="">All Status</x-ui.select.option>
                    <x-ui.select.option value="open">Open</x-ui.select.option>
                    <x-ui.select.option value="in_progress">In Progress</x-ui.select.option>
                    <x-ui.select.option value="resolved">Resolved</x-ui.select.option>
                    <x-ui.select.option value="closed">Closed</x-ui.select.option>
                </x-ui.select>
            </div>

            <!-- Priority Filter -->
            <div>
                <x-ui.label>Priority</x-ui.label>
                <x-ui.select wire:model.live="priorityFilter">
                    <x-ui.select.option value="">All Priority</x-ui.select.option>
                    <x-ui.select.option value="low">Low</x-ui.select.option>
                    <x-ui.select.option value="medium">Medium</x-ui.select.option>
                    <x-ui.select.option value="high">High</x-ui.select.option>
                    <x-ui.select.option value="urgent">Urgent</x-ui.select.option>
                </x-ui.select>
            </div>

            <!-- Doctor Filter -->
            <div>
                <x-ui.label>Doctor</x-ui.label>
                <x-ui.select wire:model.live="doctorFilter">
                    <x-ui.select.option value="">All Doctors</x-ui.select.option>
                    @foreach($doctors as $doctor)
                        <x-ui.select.option value="{{ $doctor->id }}">{{ $doctor->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
            </div>

            <!-- Sort -->
            <div>
                <x-ui.label>Sort By</x-ui.label>
                <x-ui.select wire:model.live="sortBy">
                    <x-ui.select.option value="created_at">Created Date</x-ui.select.option>
                    <x-ui.select.option value="updated_at">Updated Date</x-ui.select.option>
                    <x-ui.select.option value="subject">Subject</x-ui.select.option>
                    <x-ui.select.option value="priority">Priority</x-ui.select.option>
                    <x-ui.select.option value="status">Status</x-ui.select.option>
                </x-ui.select>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('ticket_number')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Ticket #</span>
                                    @if($sortBy === 'ticket_number')
                                        <x-ui.icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('subject')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Subject</span>
                                    @if($sortBy === 'subject')
                                        <x-ui.icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created By
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('priority')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Priority</span>
                                    @if($sortBy === 'priority')
                                        <x-ui.icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('status')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Status</span>
                                    @if($sortBy === 'status')
                                        <x-ui.icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('created_at')" class="flex items-center space-x-1 hover:text-gray-700">
                                    <span>Created</span>
                                    @if($sortBy === 'created_at')
                                        <x-ui.icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $ticket->ticket_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <div class="font-medium">{{ $ticket->subject }}</div>
                                        <div class="text-gray-500 truncate max-w-xs">
                                            {{ Str::limit($ticket->description, 60) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $ticket->created_by_admin->name ?? 'Organization Admin' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $ticket->created_by_admin->email ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPriorityColor($ticket->priority) }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($ticket->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <x-ui.button variant="ghost" size="sm" href="{{ route('organization-admin.chat_support_tickets', $ticket->id) }}" wire:navigate>
                                        View Chat
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-ui.icon name="ticket" class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">No support tickets</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new support ticket.</p>
                <div class="mt-6">
                    <a href="{{ route('organization-admin.create_support_ticket') }}" wire:navigate
                       class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 -ml-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Ticket
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
