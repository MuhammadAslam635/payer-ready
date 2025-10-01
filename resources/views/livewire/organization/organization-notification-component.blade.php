<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-slate-800">Organization Notifications</h1>
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
                        <div class="flex-1">
                            @php
                                $data = $notification->data;
                                $notifiableUser = \App\Models\User::find($notification->notifiable_id);
                            @endphp
                            
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $data['title'] ?? 'New Notification' }}
                                    </p>
                                    <p class="text-sm text-slate-600 mt-1">
                                        {{ $data['message'] ?? 'You have a new notification' }}
                                    </p>
                                    
                                    @if($notifiableUser)
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="font-medium">User:</span> {{ $notifiableUser->name }} 
                            <span class="text-slate-400">({{ $notifiableUser->email }})</span>
                        </p>
                    @endif
                                    
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
                                    <button wire:click="markAsRead('{{ $notification->id }}')" 
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium ml-4">
                                        Mark as read
                                    </button>
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
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No notifications</h3>
                    <p class="mt-1 text-sm text-slate-500">No organization notifications found.</p>
                </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $notifications->links() }}
            </div>
            
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