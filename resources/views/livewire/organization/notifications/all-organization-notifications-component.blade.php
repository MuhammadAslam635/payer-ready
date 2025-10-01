<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-slate-800">Notifications</h1>
                @if($notifications->where('read_at', null)->count() > 0)
                    <button wire:click="markAllAsRead" 
                            class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Mark all as read
                    </button>
                @endif
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
                        <div class="flex-1 min-w-0">
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
                                            @if(isset($data['priority']))
                                                <span class="ml-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                        {{ $data['priority'] === 'high' ? 'bg-red-100 text-red-800' : 
                                                           ($data['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                        {{ ucfirst($data['priority']) }} Priority
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->read_at)
                                        <button wire:click="markAsRead('{{ $notification->id }}')"
                                                class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                                            Mark as read
                                        </button>
                                    @endif
                                    
                                    @if(isset($data['url']))
                                        <a href="{{ $data['url'] }}" 
                                           class="text-xs text-slate-500 hover:text-slate-700 font-medium">
                                            View →
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamp -->
                            <p class="text-xs text-slate-400 mt-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto h-12 w-12 text-slate-400">
                        <x-ui.icon name="bell-slash" class="h-12 w-12" />
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No notifications</h3>
                    <p class="mt-1 text-sm text-slate-500">You're all caught up! No new notifications at this time.</p>
                </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
            <!-- Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500">
                    Showing {{ $notifications->count() }} notification{{ $notifications->count() !== 1 ? 's' : '' }}
                    @if($notifications->where('read_at', null)->count() > 0)
                        ({{ $notifications->where('read_at', null)->count() }} unread)
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
