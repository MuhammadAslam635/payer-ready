<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Organizations -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="building-office-2" class="w-6 h-6 text-blue-600" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Organizations</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalOrganizations']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeOrganizations'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="users" class="w-6 h-6 text-green-600" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Providers</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalDoctors']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeDoctors'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Clinics -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="building-office" class="w-6 h-6" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Clinics</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalClinics']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeClinics'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <x-ui.icon name="user" class="w-6 h-6" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Users</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalUsers']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">All user types</p>
                </div>
            </div>
        </div>
    </div>
