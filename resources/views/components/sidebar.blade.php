<aside class="w-64 bg-primary-700 text-white flex flex-col p-4 flex-shrink-0 h-full">
    <!-- Mobile close button -->
    <div class="lg:hidden flex justify-end mb-4">
        <button @click="sidebarOpen = false"
            class="p-2 text-primary-200 hover:text-white hover:bg-primary-600 rounded-lg transition-colors">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="px-4 mb-8">
        <a href="/" wire:navigate class="flex items-center">
            <x-application-logo />
        </a>
    </div>


    <div class="px-4 mb-6">
        <div class="bg-primary-600 rounded-lg p-3">
            <div class="flex items-center">
                <div class="bg-primary-500 rounded-full p-2 mr-3 flex-shrink-0">
                    <x-ui.icon name="user-circle" class="w-4 h-4 sm:w-5 sm:h-5 text-primary-100" />
                </div>
                <div class="min-w-0 flex-1">

                    <p class="text-xs text-primary-100 truncate flex flex-col">
                        <span>{{ Auth::user()->name }}</span>
                        <span>{{ App\Enums\UserType::label(Auth::user()->user_type) }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Navigation -->
    <nav class="flex-grow space-y-2">

        @if (Auth::user()->user_type === \App\Enums\UserType::SUPER_ADMIN)
            <!-- Super Admin Management Section -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>

                <a href="{{ route('super-admin.specialties.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.specialties.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="academic-cap" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Specialties</span>
                </a>

                <a href="{{ route('super-admin.states.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.states.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="map" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">States</span>
                </a>

                <a href="{{ route('super-admin.certificate-types.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.certificate-types.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document-text" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Certificate Types</span>
                </a>

                <a href="{{ route('super-admin.task-types.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.task-types.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="clipboard-document-list"
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Task Types</span>
                </a>

                <a href="{{ route('super-admin.license-types.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.license-types.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="identification"
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">License Types</span>
                </a>
            </div>
        @endif
        @if (Auth::user()->user_type === \App\Enums\UserType::ORGANIZATION_ADMIN)
            <!-- Organization Admin Management Section -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>
            </div>
        @endif
        @if (Auth::user()->user_type === \App\Enums\UserType::COORDINATOR)
            <!-- Coordinator Management Section -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>
            </div>
        @endif
        @if (Auth::user()->user_type === \App\Enums\UserType::DOCTOR)
            <!-- Doctor Management Section -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>
            </div>

                <div class="px-4 mb-2">
                    <a href="{{ route('doctor.dashboard') }}" wire:navigate
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.dashboard') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <x-ui.icon name="squares-2x2"
                            class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                        <span class="truncate">Overview</span>
                    </a>
                    <a href="{{ route('doctor.tasks') }}" wire:navigate
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.tasks') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <x-ui.icon name="clipboard-document-list"
                            class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                        <span class="truncate">Tasks</span>
                    </a>
                    <a href="{{ route('doctor.invite-providers') }}" wire:navigate
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.invite-providers') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <x-ui.icon name="users"
                            class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                        <span class="truncate">Invite Providers</span>
                    </a>
                    <a href="{{ route('doctor.applications') }}" wire:navigate
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.applications') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <x-ui.icon name="document-text"
                            class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                        <span class="truncate">Applications</span>
                    </a>
                    <a href="{{ route('doctor.licensing') }}" wire:navigate
                        class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.licensing') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <x-ui.icon name="identification"
                            class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                        <span class="truncate">Licensing</span>
                    </a>
                </div>

        @endif

    </nav>

    <!-- Settings Link -->
    <div class="mt-4">
        <a href="{{ route('profile.show') }}" wire:navigate
            class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.show') ? 'bg-primary-500 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
            <x-ui.icon name="cog-6-tooth" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
            <span class="truncate">Settings</span>
        </a>
    </div>

    <!-- Logout -->
    <div class="mt-4">
        <form method="POST" action="{{ route('logout') }}" wire:submit.prevent="logout">
            @csrf
            <button type="submit"
                class="w-full flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-primary-300 hover:bg-primary-800 hover:text-white transition-colors">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="truncate">Logout</span>
            </button>
        </form>
    </div>
</aside>
