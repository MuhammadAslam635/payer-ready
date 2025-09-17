<header class="bg-white border-b border-slate-200 shadow-sm p-4 z-10">
    <div class="flex items-center justify-between">
        <!-- Organization/Practice Name -->
        <div class="flex items-center text-lg font-bold text-blue-900">
            @if($organization)
                <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>{{ $organization->business_name }}</span>
            @else
                <svg class="h-6 w-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span>PayerReady Dashboard</span>
            @endif
        </div>

        <!-- Search, Notifications, Profile -->
        <div class="flex items-center space-x-6">
            <!-- Search Bar -->
            <div class="relative hidden md:block">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchQuery"
                    placeholder="Search providers, applications..."
                    class="w-64 pl-10 pr-4 py-2 bg-slate-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500"
                />
            </div>

            <!-- Notifications -->
            <button class="relative text-slate-500 hover:text-blue-600 transition-colors" 
                    wire:click="$dispatch('open-notifications')">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
                </svg>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button wire:click="toggleProfileDropdown" class="flex items-center space-x-2">
                    <img
                        class="h-9 w-9 rounded-full object-cover bg-slate-200"
                        src="{{ $user->profile_photo_url }}"
                        alt="User avatar"
                    />
                    <div class="text-left hidden lg:block">
                        <p class="font-semibold text-sm text-slate-800">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->user_type->label() }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                @if($showProfileDropdown)
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-20">
                        <a href="{{ route('dashboard.settings', ['tab' => 'profile']) }}" 
                           wire:click="toggleProfileDropdown"
                           class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            My Profile
                        </a>
                        <a href="{{ route('dashboard.settings', ['tab' => 'billing']) }}" 
                           wire:click="toggleProfileDropdown"
                           class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            Billing
                        </a>
                        <a href="{{ route('dashboard.settings', ['tab' => 'notifications']) }}" 
                           wire:click="toggleProfileDropdown"
                           class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            Notifications
                        </a>
                        <div class="border-t border-slate-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                Logout
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
