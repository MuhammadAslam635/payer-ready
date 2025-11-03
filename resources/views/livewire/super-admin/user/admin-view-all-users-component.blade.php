<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Users</h1>
        <p class="text-gray-600 dark:text-gray-400">Manage doctors and organization administrators</p>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       placeholder="Search by name or email..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- User Type Filter -->
            <div>
                <label for="userTypeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">User Type</label>
                <select wire:model.live="userTypeFilter" 
                        id="userTypeFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Types</option>
                    @foreach($userTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select wire:model.live="statusFilter" 
                        id="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($users as $user)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                <!-- User Image -->
                <div class="p-4 text-center">
                    @if($user->profile_photo_url)
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}"
                             class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-gray-200 dark:border-gray-600">
                    @else
                        <div class="w-20 h-20 rounded-full mx-auto bg-gray-300 dark:bg-gray-600 flex items-center justify-center border-4 border-gray-200 dark:border-gray-600">
                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="px-4 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center mb-2">
                        {{ $user->name }}
                    </h3>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-3">
                        {{ $user->email }}
                    </p>

                    <!-- User Type Badge -->
                    @php
                        $cssClasses = \App\Enums\UserType::cssClass();
                    @endphp
                    <div class="flex justify-center mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $cssClasses[$user->user_type->value] }}">
                            {{ \App\Enums\UserType::label($user->user_type) }}
                        </span>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex justify-center gap-2">
                        <button wire:click="toggleUserStatus({{ $user->id }})"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ $user->is_active 
                                    ? 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-800 dark:text-green-100 dark:hover:bg-green-700' 
                                    : 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-800 dark:text-red-100 dark:hover:bg-red-700' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </button>
                        <button wire:click="viewProfile({{ $user->id }})"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-100 dark:hover:bg-blue-700">
                            Profile
                        </button>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400 text-center">
                        @if($user->phone)
                            <p>{{ $user->phone }}</p>
                        @endif
                        <p>Joined {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Try adjusting your search or filter criteria.
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
