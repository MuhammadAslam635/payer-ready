@php
    $user = Auth::user();
    $organization = $user->organizationStaff->first()?->organization;
@endphp

<header class="bg-white border-b border-slate-200 shadow-sm p-4 z-10">
    <div class="flex items-center justify-between">
        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <span class="sr-only">Open sidebar</span>
                <!-- Hamburger icon -->
                <svg x-show="!sidebarOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Close icon -->
                <svg x-show="sidebarOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Organization/Practice Name -->
        <div class="flex items-center text-sm sm:text-lg font-bold text-primary-600">
            <a href="/" wire:navigate class="flex items-center">
                <x-application-logo />
            </a>
        </div>

        <!-- Search, Notifications, Profile -->
        <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-6">
            <!-- Search Bar -->
            <div class="relative hidden lg:block">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search providers, applications..."
                    class="w-48 xl:w-64 pl-10 pr-4 py-2 bg-slate-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500" />
            </div>

            <!-- Mobile Search Button -->
            <div class="lg:hidden">
                <button class="p-2 text-slate-500 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <!-- Notifications Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="relative text-slate-500 p-2 bg-primary-100 rounded-full hover:text-primary-600 transition-colors">
                    <x-ui.icon name="bell-alert" class="h-5 w-5 sm:h-6 sm:w-6" />
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-20">
                    <!-- Header -->
                    <div class="px-4 py-2 border-b border-slate-100">
                        <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
                    </div>

                    <!-- Notification Items -->
                    <div class="max-h-64 overflow-y-auto">
                        <a href="#"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-50">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800">New application submitted</p>
                                    <p class="text-xs text-slate-500 mt-1">Dr. John Smith submitted a new application
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">2 minutes ago</p>
                                </div>
                            </div>
                        </a>

                        <a href="#"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-50">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800">Application approved</p>
                                    <p class="text-xs text-slate-500 mt-1">Dr. Jane Doe's application has been approved
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">1 hour ago</p>
                                </div>
                            </div>
                        </a>

                        <a href="#"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-50">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800">Document review needed</p>
                                    <p class="text-xs text-slate-500 mt-1">License document requires review</p>
                                    <p class="text-xs text-slate-400 mt-1">3 hours ago</p>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-slate-300 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800">System maintenance</p>
                                    <p class="text-xs text-slate-500 mt-1">Scheduled maintenance completed successfully
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">1 day ago</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 py-2 border-t border-slate-100">
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-1 sm:space-x-2">
                    <img class="h-8 w-8 sm:h-9 sm:w-9 rounded-full object-cover bg-slate-200"
                        src="{{ $user->profile_photo_url }}" alt="User avatar" />
                    <div class="text-left hidden sm:block">
                        <p class="font-semibold text-xs sm:text-sm text-slate-800 truncate max-w-20 sm:max-w-none">
                            {{ $user->name }}</p>
                        <p class="text-xs text-slate-500 hidden lg:block">{{ $user->user_type }}</p>
                    </div>
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-slate-400 hidden sm:block" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-44 sm:w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-20">
                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                        My Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                        Billing
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                        Notifications
                    </a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
