<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Organization Staff Dashboard</h1>
                <p class="text-slate-600 mt-1">View your organization's activity and colleagues</p>
                @if($stats['organization'])
                    <p class="text-sm text-slate-500 mt-1">{{ $stats['organization']->business_name }} • {{ $stats['userRole'] }}</p>
                @endif
            </div>
            <div class="text-sm text-slate-500">
                Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Colleagues -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Colleagues</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalColleagues']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeColleagues'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Doctors</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalDoctors']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeDoctors'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Colleagues -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Recent Colleagues</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['recentColleagues']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Last 30 days</p>
                </div>
            </div>
        </div>

        <!-- Recent Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Recent Doctors</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['recentDoctors']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Last 30 days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Colleagues -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Colleagues</h3>
            </div>
            <div class="p-6">
                @if($stats['latestColleagues']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestColleagues'] as $colleague)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="{{ $colleague['profile_photo_url'] }}" alt="{{ $colleague['name'] }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $colleague['name'] }}</p>
                                    <p class="text-sm text-slate-500 truncate">{{ $colleague['role'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colleague['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $colleague['is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No colleagues found</p>
                @endif
            </div>
        </div>

        <!-- Latest Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Doctors</h3>
            </div>
            <div class="p-6">
                @if($stats['latestDoctors']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestDoctors'] as $doctor)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="{{ $doctor['profile_photo_url'] }}" alt="{{ $doctor['name'] }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $doctor['name'] }}</p>
                                    <p class="text-sm text-slate-500 truncate">{{ $doctor['specialty'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doctor['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $doctor['is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No doctors found</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Latest Activities -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Latest Activities</h3>
        </div>
        <div class="p-6">
            @if($stats['latestActivities']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['latestActivities'] as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center
                                    @if($activity['type'] === 'staff_joined') bg-green-100 text-green-600
                                    @elseif($activity['type'] === 'license_update') bg-blue-100 text-blue-600
                                    @elseif($activity['type'] === 'document_upload') bg-purple-100 text-purple-600
                                    @elseif($activity['type'] === 'profile_complete') bg-orange-100 text-orange-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    @if($activity['type'] === 'staff_joined')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                    @elseif($activity['type'] === 'license_update')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    @elseif($activity['type'] === 'document_upload')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @elseif($activity['type'] === 'profile_complete')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900">{{ $activity['activity'] }}</p>
                                <p class="text-sm text-slate-500">{{ $activity['description'] }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $activity['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-500 text-center py-4">No recent activities found</p>
            @endif
        </div>
    </div>
</div>
