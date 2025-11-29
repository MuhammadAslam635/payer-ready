<aside class="w-64 bg-primary-700 text-white flex flex-col p-4 flex-shrink-0 h-screen overflow-y-auto scrollbar-hide">
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
            <!-- Section 1: Management -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>

                <a href="{{ route('super-admin.view_all_license') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.view_all_license') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document-text" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider License</span>
                </a>
                <a href="{{ route('super-admin.view_all_credentials') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.view_all_credentials') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="key" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Applications</span>
                </a>
                <a href="{{ route('super-admin.all_certificates') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.all_certificates') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="newspaper" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Certificates</span>
                </a>
                <a href="{{ route('super-admin.all_tasks') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.all_tasks') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="paper-clip" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Tasks</span>
                </a>
                <a href="{{ route('super-admin.sub_users') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.sub_users.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="users" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">System Users</span>
                </a>
                <a href="{{ route('super-admin.users') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.users.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="users" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Users</span>
                </a>
                <a href="{{ route('super-admin.support-tickets') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.support-tickets') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="ticket" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Support Tickets</span>
                </a>
                <a href="{{ route('super-admin.all_invoices') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.all_invoices') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="newspaper" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Invoices</span>
                </a>
            </div>

            <!-- Section 2: Admin System -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Admin System</h3>
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
                <a href="{{ route('super-admin.payers.index') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.payers.*') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="building-library"
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Payers</span>
                </a>
                <a href="{{ route('super-admin.all_payment_gateways') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.all_payment_gateways') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="banknotes" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">All Payment Gateways</span>
                </a>
                <a href="{{ route('super-admin.all_transactions') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('super-admin.all_transactions') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="currency-dollar"
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">All Transactions</span>
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
            <div class="px-4 mb-2">
                <a href="{{ route('organization_admin.dashboard') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization_admin.dashboard') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="squares-2x2" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Overview</span>
                </a>
                <a href="{{ route('organization-admin.profile') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.profile') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="identification" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Organization Profile</span>
                </a>
                <a href="{{ route('organization-admin.manage_staff') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.manage_staff') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="users" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Manage Staff</span>
                </a>
                <a href="{{ route('organization-admin.doctor_tasks') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_tasks') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="clipboard-document-list" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Tasks</span>
                </a>
                <a href="{{ route('organization-admin.doctor_licenses') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_licenses') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="identification" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Licenses</span>
                </a>
                <a href="{{ route('organization-admin.doctor_applications') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_applications') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document-text" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Applications</span>
                </a>
                <a href="{{ route('organization-admin.doctor_expirables') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_expirables') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="calendar-days" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Expirables</span>
                </a>
                <a href="{{ route('organization-admin.doctor_reports') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_reports') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="clipboard-document-list" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Reports</span>
                </a>
                <a href="{{ route('organization-admin.doctor_invoice_payments') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_invoice_payments') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="banknotes" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Invoice Payments</span>
                </a>
                <!-- <a href="{{ route('organization-admin.doctor_documents') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.doctor_documents') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Documents</span>
                </a> -->
                <a href="{{ route('organization-admin.all_support_tickets') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization-admin.all_support_tickets') || request()->routeIs('organization-admin.create_support_ticket') || request()->routeIs('organization-admin.chat_support_tickets') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="chat-bubble-left-right" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Support Tickets</span>
                </a>

            </div>
        @endif
        @if (Auth::user()->user_type === \App\Enums\UserType::COORDINATOR || Auth::user()->user_type === \App\Enums\UserType::ORGANIZATION_COORDINATOR)
            <!-- Coordinator Management Section -->
            <div class="pt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</h3>
                </div>
            </div>
            <div class="px-4 mb-2">
                <a href="{{ route('coordinator.dashboard') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.dashboard') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="squares-2x2" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Overview</span>
                </a>
                <a href="{{ route('coordinator.tasks') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.tasks') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="clipboard-document-list" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Tasks</span>
                </a>
                <a href="{{ route('coordinator.applications') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.applications') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document-text" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Applications</span>
                </a>
                <a href="{{ route('coordinator.licensing') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.licensing') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="identification" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Licensing</span>
                </a>
                <a href="{{ route('coordinator.expirables') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.expirables') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="calendar-days" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Expirables</span>
                </a>
                <a href="{{ route('coordinator.reports') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.reports') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="chart-bar" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Reports</span>
                </a>
                <a href="{{ route('coordinator.invoice-payments') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('coordinator.invoice-payments') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="banknotes" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Invoice Payments</span>
                </a>
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
                    <x-ui.icon name="squares-2x2" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Overview</span>
                </a>
                <a href="{{ route('doctor.tasks') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.tasks') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="clipboard-document-list"
                        class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Tasks</span>
                </a>
                <a href="{{ route('doctor.profile') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.invite-providers') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="user" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Provider Profile</span>
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
                <a href="{{ route('doctor.expirables') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.expirables') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="calendar-days" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Expirables</span>
                </a>
                <a href="{{ route('doctor.reports') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.reports') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="chart-bar" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Reports</span>
                </a>
				<a href="{{ route('doctor.invoice-payments') }}" wire:navigate
					class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.invoice-payments') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
					<x-ui.icon name="banknotes" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
					<span class="truncate">Invoice Payments</span>
				</a>
                <!-- <a href="{{ route('doctor.documents') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.documents') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="document" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Documents</span>
                </a> -->
                <!-- <a href="{{ route('doctor.certifications') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.certifications') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="academic-cap" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Certifications</span>
                </a> -->
                <a href="{{ route('doctor.all_support_tickets') }}" wire:navigate
                    class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctor.all_support_tickets') ? 'bg-primary-600 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                    <x-ui.icon name="ticket" class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-primary-100 flex-shrink-0" />
                    <span class="truncate">Support Tickets</span>
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
