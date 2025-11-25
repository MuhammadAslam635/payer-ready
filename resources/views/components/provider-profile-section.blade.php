<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-[#14b8a6] to-[#0d9488] px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                        @if(auth()->user()->profile_photo_url)
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-green-600">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-2xl font-bold text-white mb-2">
                        {{ auth()->user()->name }}
                        @if(auth()->user()->middle_name)
                            {{ auth()->user()->middle_name }}
                        @endif
                    </h2>
                    <p class="text-green-100 mb-3">
                        {{ auth()->user()->specialties->first()?->name ?? 'Medical Professional' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-2 text-sm text-green-100">
                        <span class="flex items-center justify-center sm:justify-start">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ auth()->user()->email }}
                        </span>
                        @if(auth()->user()->phone)
                            <span class="flex items-center justify-center sm:justify-start">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ auth()->user()->phone }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-green-600">
                        <svg class="w-2 h-2 mr-2 fill-current" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Pending Applications -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Pending Applications</h3>
                    @php
                        $pendingApplications = \App\Models\DoctorCredential::where('user_id', auth()->id())
                            ->where(function($query) {
                                $query->where('status', 'pending')
                                      ->orWhere('status', 'requested')
                                      ->orWhere('status', 'working');
                            })
                            ->count();
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Total Pending:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $pendingApplications > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $pendingApplications }}
                        </span>
                    </div>
                    @if($pendingApplications > 0)
                        <a href="{{ route('doctor.applications') }}" wire:navigate class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                            View Applications →
                        </a>
                    @else
                        <p class="text-sm text-slate-500">No pending applications</p>
                    @endif
                </div>

                <!-- Pending License -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Pending License</h3>
                    @php
                        $pendingLicenses = \App\Models\DoctorLicense::where('user_id', auth()->id())
                            ->whereIn('status', [\App\Enums\LicenseStatus::PENDING->value, \App\Enums\LicenseStatus::REQUESTED->value])
                            ->count();
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Total Pending:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $pendingLicenses > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $pendingLicenses }}
                        </span>
                    </div>
                    @if($pendingLicenses > 0)
                        <a href="{{ route('doctor.applications') }}" wire:navigate class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                            View Licenses →
                        </a>
                    @else
                        <p class="text-sm text-slate-500">No pending licenses</p>
                    @endif
                </div>

                <!-- Expirables -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Expirables</h3>
                    @php
                        $expiringLicenses = \App\Models\DoctorLicense::where('user_id', auth()->id())
                            ->whereNotNull('expiration_date')
                            ->where('expiration_date', '>', now())
                            ->where('expiration_date', '<=', now()->addDays(60))
                            ->count();
                        
                        $expiringCredentials = \App\Models\DoctorCredential::where('user_id', auth()->id())
                            ->whereNotNull('expiration_date')
                            ->where('expiration_date', '>', now())
                            ->where('expiration_date', '<=', now()->addDays(60))
                            ->count();
                        
                        $totalExpirables = $expiringLicenses + $expiringCredentials;
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Expiring Soon (60 days):</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $totalExpirables > 0 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                            {{ $totalExpirables }}
                        </span>
                    </div>
                    @if($totalExpirables > 0)
                        <a href="{{ route('doctor.expirables') }}" wire:navigate class="text-sm text-teal-600 hover:text-teal-800 font-medium">
                            View Expirables →
                        </a>
                    @else
                        <p class="text-sm text-slate-500">No items expiring soon</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('doctor.profile') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">

                        Provider Profile
                    </a>
                </div>
                <p class="text-sm text-slate-500 mt-4 text-center">
                    Keep your profile updated for better credentialing and verification processes.
                </p>
            </div>
        </div>
    </div>
