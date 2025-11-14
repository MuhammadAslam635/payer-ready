<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-slate-800">My Notifications</h1>
                @if($notifications->where('read_at', null)->count() > 0)
                    <x-ui.button
                        type="button"
                        variant="ghost"
                        size="sm"
                        class="!text-primary-600 hover:!text-primary-700"
                        wire:click="markAllAsRead">
                        Mark all as read
                    </x-ui.button>
                @endif
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-end">
                <!-- Search Input -->
                {{-- <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" 
                               type="text" 
                               class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
                               placeholder="Search notifications...">
                        @if($search)
                            <button wire:click="clearSearch" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-4 w-4 text-slate-400 hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div> --}}

                <!-- Filters and Controls -->
                <div class="flex items-center gap-4">
                    <!-- Per Page Selector -->
                    <div class="flex items-center gap-2">
                        <label for="perPage" class="text-sm font-medium text-slate-700">Show:</label>
                        <x-ui.select wire:model.live="perPage" class="w-full">
                            <x-ui.select.option value="10">10</x-ui.select.option>
                            <x-ui.select.option value="15">15</x-ui.select.option>
                            <x-ui.select.option value="25">25</x-ui.select.option>
                            <x-ui.select.option value="50">50</x-ui.select.option>
                        </x-ui.select>
                    </div>

                    <!-- Sort Controls -->
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-slate-700">Sort by:</span>
                        <div class="flex gap-1">
                            <x-ui.button
                                type="button"
                                size="xs"
                                variant="outline"
                                wire:click="sortBy('created_at')"
                                class="{{ $sortBy === 'created_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50' }}">
                                Date
                                @if($sortBy === 'created_at')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </x-ui.button>
                            <x-ui.button
                                type="button"
                                size="xs"
                                variant="outline"
                                wire:click="sortBy('read_at')"
                                class="{{ $sortBy === 'read_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50' }}">
                                Status
                                @if($sortBy === 'read_at')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-slate-100">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-slate-50 transition-colors">
                    <div class="flex items-start space-x-4">
                        <!-- Status Indicator -->
                        <div class="flex-shrink-0 mt-2">
                            @if($notification->read_at)
                                <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                            @else
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            @endif
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1">
                            @php
                                $data = $notification->data;
                            @endphp
                            
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $data['title'] ?? 'New Notification' }}
                                    </p>
                                    <p class="text-sm text-slate-600 mt-1">
                                        {{ $data['message'] ?? 'You have a new notification' }}
                                    </p>
                                    
                                    @if(isset($data['task_details']))
                                        <div class="mt-2 text-xs text-slate-500">
                                            <span class="font-medium">Task:</span> {{ $data['task_details'] }}
                                            @if(isset($data['due_date']))
                                                <span class="ml-2">
                                                    <span class="font-medium">Due:</span> 
                                                    {{ \Carbon\Carbon::parse($data['due_date'])->format('M d, Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <p class="text-xs text-slate-400 mt-2">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                
                                @if(!$notification->read_at)
                                    <x-ui.button
                                        type="button"
                                        variant="ghost"
                                        size="xs"
                                        class="ml-4 !text-blue-600 hover:!text-blue-800"
                                        wire:click="markAsRead('{{ $notification->id }}')">
                                        Mark as read
                                    </x-ui.button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-slate-100">
                        <x-ui.icon name="bell-slash" class="h-6 w-6 text-slate-400" />
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No notifications found</h3>
                    @if($search)
                        <p class="mt-1 text-sm text-slate-500">No notifications match your search criteria.</p>
                        <x-ui.button
                            type="button"
                            variant="ghost"
                            size="sm"
                            class="mt-3 !text-primary-600 hover:!text-primary-700"
                            wire:click="clearSearch">
                            Clear search
                        </x-ui.button>
                    @else
                        <p class="mt-1 text-sm text-slate-500">You have no notifications at this time.</p>
                    @endif
                </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $notifications->links() }}
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">
                        Showing {{ $notifications->count() }} of {{ $notifications->total() }} notification{{ $notifications->total() !== 1 ? 's' : '' }}
                        @if($notifications->where('read_at', null)->count() > 0)
                            ({{ $notifications->where('read_at', null)->count() }} unread)
                        @endif
                        @if($search)
                            for "{{ $search }}"
                        @endif
                    </p>
                    @if($search)
                        <x-ui.button
                            type="button"
                            variant="ghost"
                            size="sm"
                            class="!text-primary-600 hover:!text-primary-700"
                            wire:click="clearSearch">
                            Clear search
                        </x-ui.button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>