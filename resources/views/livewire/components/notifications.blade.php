<!-- Notification Bell (Fixed Position) -->
<div class="fixed bottom-4 right-4 z-50">
    <button wire:click="toggle" class="relative p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-200">
        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>
</div>

<!-- Notification Panel -->
@if($show)
    <div class="fixed bottom-20 right-4 z-50 w-80 max-w-sm">
        <div class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                <div class="flex items-center space-x-2">
                    @if($unreadCount > 0)
                        <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800">
                            Mark all read
                        </button>
                    @endif
                    <button wire:click="toggle" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-150 {{ !$notification['read'] ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                @switch($notification['type'])
                                    @case('success')
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        @break
                                    @case('warning')
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        @break
                                    @case('error')
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        @break
                                    @default
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                @endswitch
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $notification['title'] }}
                                    </p>
                                    @if(!$notification['read'])
                                        <div class="flex-shrink-0 ml-2">
                                            <div class="h-2 w-2 bg-blue-500 rounded-full"></div>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $notification['message'] }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $notification['created_at']->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex-shrink-0 flex items-center space-x-1">
                                @if(!$notification['read'])
                                    <button wire:click="markAsRead({{ $notification['id'] }})" 
                                            class="text-xs text-blue-600 hover:text-blue-800"
                                            title="Mark as read">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                @endif
                                <button wire:click="removeNotification({{ $notification['id'] }})" 
                                        class="text-xs text-gray-400 hover:text-red-600"
                                        title="Delete">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            @if($notifications->count() > 0)
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <a href="{{ route('dashboard.notifications') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View all notifications
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Backdrop -->
@if($show)
    <div class="fixed inset-0 z-40" wire:click="toggle"></div>
@endif
