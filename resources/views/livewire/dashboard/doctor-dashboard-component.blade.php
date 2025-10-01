<div class="space-y-6">
    <!-- Page Header -->


    <!-- Main Stats Cards -->
    <x-breadcrumbs tagline="Manage your professional credentials and reference providers" />

    <!-- User Profile Card -->
    <x-provider-profile-section />

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Licenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Licenses</h3>
            </div>
            <div class="p-6">
                @if ($stats['latestLicenses']->count() > 0)
                    <div class="space-y-4">
                        @foreach ($stats['latestLicenses'] as $license)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $license['license_number'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $license['state'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $license['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
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
                @if ($stats['latestDocuments']->count() > 0)
                    <div class="space-y-4">
                        @foreach ($stats['latestDocuments'] as $document)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $document['document_type'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $document['original_filename'] }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
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
</div>
