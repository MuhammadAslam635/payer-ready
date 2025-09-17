<div class="bg-white shadow rounded-lg p-4 mb-6">
    <!-- Search and Filter Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <!-- Search Bar -->
        <div class="flex-1 max-w-lg">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchQuery"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Search..."
                />
                @if($searchQuery)
                    <button wire:click="clearSearch" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Filter and Sort Controls -->
        <div class="flex items-center space-x-3">
            <!-- Sort Dropdown -->
            <div class="relative">
                <select wire:model.live="sortBy" class="appearance-none bg-white border border-gray-300 rounded-md px-3 py-2 pr-8 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Sort by...</option>
                    <option value="name">Name</option>
                    <option value="created_at">Date Created</option>
                    <option value="updated_at">Last Updated</option>
                    <option value="status">Status</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <!-- Sort Direction Toggle -->
            @if($sortBy)
                <button wire:click="updatedSortDirection" class="p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                    @if($sortDirection === 'asc')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                    @else
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                        </svg>
                    @endif
                </button>
            @endif

            <!-- Filter Toggle -->
            <button wire:click="toggleFilters" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
                @if(!empty($filters))
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ count($filters) }}
                    </span>
                @endif
            </button>

            <!-- Reset Filters -->
            @if($searchQuery || !empty($filters) || $sortBy)
                <button wire:click="resetFilters" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </button>
            @endif
        </div>
    </div>

    <!-- Active Filters -->
    @if(!empty($filters))
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach($filters as $key => $value)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                    <button wire:click="clearFilter('{{ $key }}')" class="ml-2 inline-flex items-center justify-center w-4 h-4 rounded-full text-blue-400 hover:bg-blue-200 hover:text-blue-500 focus:outline-none">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </span>
            @endforeach
        </div>
    @endif

    <!-- Filter Panel -->
    @if($showFilters)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="filters.status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                    <div class="flex space-x-2">
                        <input type="date" wire:model.live="filters.date_from" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <input type="date" wire:model.live="filters.date_to" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select wire:model.live="filters.type" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Types</option>
                        <option value="provider">Provider</option>
                        <option value="organization">Organization</option>
                        <option value="application">Application</option>
                    </select>
                </div>
            </div>

            <!-- Apply Filters Button -->
            <div class="mt-4 flex justify-end">
                <button wire:click="applyFilters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Apply Filters
                </button>
            </div>
        </div>
    @endif
</div>
