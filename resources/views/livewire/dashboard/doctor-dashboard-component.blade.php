<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Doctor Dashboard</h1>
                <p class="text-slate-600 mt-1">Manage your professional credentials and documents</p>
                @if($stats['clinic'])
                    <p class="text-sm text-slate-500 mt-1">{{ $stats['clinic']->business_name }}</p>
                @endif
            </div>
            <div class="text-sm text-slate-500">
                Last updated: {{ now()->format('M d, Y \a\t g:i A') }}
            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Licenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Licenses</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalLicenses']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['activeLicenses'] }}</span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Documents</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalDocuments']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium">{{ $stats['verifiedDocuments'] }}</span> verified
                    </p>
                </div>
            </div>
        </div>

        <!-- Work History -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Work History</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalWorkHistory']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Positions</p>
                </div>
            </div>
        </div>

        <!-- References -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">References</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['totalReferences']) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Professional</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Licenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Licenses</h3>
            </div>
            <div class="p-6">
                @if($stats['latestLicenses']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestLicenses'] as $license)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $license['license_number'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $license['state'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $license['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $license['is_active'] ? 'Active' : 'Expired' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No licenses found</p>
                @endif
            </div>
        </div>

        <!-- Latest Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Documents</h3>
            </div>
            <div class="p-6">
                @if($stats['latestDocuments']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestDocuments'] as $document)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $document['document_type'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $document['original_filename'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $document['is_verified'] ? 'Verified' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No documents found</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Work History and References -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Work History -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Work History</h3>
            </div>
            <div class="p-6">
                @if($stats['latestWorkHistory']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestWorkHistory'] as $work)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $work['organization_name'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $work['position_title'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $work['is_current'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $work['is_current'] ? 'Current' : 'Previous' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No work history found</p>
                @endif
            </div>
        </div>

        <!-- Latest References -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest References</h3>
            </div>
            <div class="p-6">
                @if($stats['latestReferences']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['latestReferences'] as $reference)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $reference['reference_full_name'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $reference['reference_title'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reference['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($reference['status']) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-center py-4">No references found</p>
                @endif
            </div>
        </div>
    </div>
</div>
