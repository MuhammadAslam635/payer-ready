<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Transactions -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Latest Transactions</h3>
                <a href="{{ route('super-admin.all_transactions') }}" wire:navigate
                    class="text-sm text-primary-600 hover:text-primary-800 font-medium">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($stats['latestTransactions'] as $transaction)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900">{{ $transaction['description'] }}</p>
                                <p class="text-xs text-slate-500">{{ $transaction['user']->name }} •
                                    {{ $transaction['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">
                                ${{ number_format($transaction['amount'], 2) }}</p>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($transaction['status']) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 flex flex-col items-center">
                        <x-ui.icon name="currency-dollar" class="w-12 h-12 text-slate-400" />
                        <p class="mt-2 text-sm text-slate-500">No recent transactions</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Latest Registered Users -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Latest Registered Users</h3>
                <a href="{{ route('super-admin.users') }}" wire:navigate class="text-sm text-primary-600 hover:text-primary-800 font-medium">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($stats['latestUsers'] as $user)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full object-cover bg-slate-200"
                                    src="{{ $user['profile_photo_url'] }}" alt="{{ $user['name'] }}">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900">{{ $user['name'] }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ ucfirst(str_replace('_', ' ', $user['user_type'])) }} •
                                    {{ $user['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user['is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 flex flex-col items-center">
                        <x-ui.icon name="users" class="w-12 h-12 text-slate-400" />
                        <p class="mt-2 text-sm text-slate-500">No recent users</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>