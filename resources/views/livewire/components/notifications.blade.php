<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="relative p-2 bg-teal-100 rounded-full hover:bg-teal-200 transition-colors">
        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-teal-600" style="color: #0d9488 !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 text-white text-xs font-medium items-center justify-center">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-20">
        <!-- Header -->
        <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                    Mark all read
                </button>
            @endif
        </div>

        <!-- Notification Items -->
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-50 {{ !$notification['read'] ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            @if(isset($notification['icon']) && $notification['icon'] === 'shopping-cart')
                                <!-- Cart Icon for Invoice Notifications -->
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            @else
                                <div class="w-2 h-2 {{ $notification['read'] ? 'bg-slate-300' : 'bg-blue-500' }} rounded-full mt-2"></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800">{{ $notification['title'] }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $notification['message'] }}</p>
                                    @if(isset($notification['invoice_number']))
                                        <p class="text-xs text-teal-600 mt-1 font-medium">Invoice: {{ $notification['invoice_number'] }}</p>
                                        @if(isset($notification['amount']))
                                            <p class="text-xs text-slate-600 mt-0.5">Amount: ${{ number_format($notification['amount'], 2) }}</p>
                                        @endif
                                    @endif
                                    <p class="text-xs text-slate-400 mt-1">{{ $notification['created_at'] }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-2">
                                    @if(!$notification['read'])
                                        <button wire:click="markAsRead('{{ $notification['id'] }}')"
                                                class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                                            Mark read
                                        </button>
                                    @endif
                                    @if(isset($notification['invoice_id']) && $notification['invoice_id'])
                                        <!-- Cart Icon Link to Invoice Details -->
                                        <button onclick="window.dispatchEvent(new CustomEvent('open-invoice-modal', { detail: { invoiceId: {{ $notification['invoice_id'] }} } }))"
                                                class="text-xs text-teal-600 hover:text-teal-700 font-medium inline-flex items-center"
                                                title="View Invoice Details">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                            View
                                        </button>
                                    @elseif($notification['url'] && $notification['url'] !== '#')
                                        <a href="{{ $notification['url'] }}"
                                           class="text-xs text-slate-500 hover:text-slate-700 font-medium">
                                            View →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="mx-auto h-8 w-8 text-slate-400 mb-2">
                        <x-ui.icon name="bell-slash" class="h-8 w-8" />
                    </div>
                    <p class="text-sm text-slate-500">No notifications</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if($notifications->count() > 0)
            <div class="px-4 py-2 border-t border-slate-100">
                @php
                    $user = Auth::user();
                    $notificationRoute = match($user->user_type) {
                        \App\Enums\UserType::SUPER_ADMIN => route('super-admin.notifications'),
                        \App\Enums\UserType::DOCTOR => route('doctor.notifications'),
                        \App\Enums\UserType::ORGANIZATION_ADMIN => route('organization-admin.notifications'),
                        default => '#'
                    };
                @endphp
                <a href="{{ $notificationRoute }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View all notifications
                </a>
            </div>
        @endif
    </div>
</div>
