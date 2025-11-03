<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">User Profile</h1>
            <p class="text-slate-600 mt-1">View user information and details</p>
        </div>
        <a href="{{ route('super-admin.users') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Users
        </a>
    </div>

    <!-- User Card -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6">
            <!-- Profile Header -->
            <div class="flex items-center space-x-6 mb-6 pb-6 border-b border-slate-200">
                <div>
                    @if($user->profile_photo_url)
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}"
                             class="w-24 h-24 rounded-full object-cover border-4 border-slate-200">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center border-4 border-slate-200">
                            <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-slate-600">{{ $user->email }}</p>
                    @php
                        $cssClasses = \App\Enums\UserType::cssClass();
                    @endphp
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium mt-2 {{ $cssClasses[$user->user_type->value] }}">
                        {{ \App\Enums\UserType::label($user->user_type) }}
                    </span>
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium ml-2 mt-2 {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-b border-slate-200 mb-6">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button wire:click="setActiveTab('information')" @class([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'information',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'information',
                    ])>
                        Basic Information
                    </button>
                    @if($user->user_type->value === \App\Enums\UserType::DOCTOR->value)
                    <button wire:click="setActiveTab('practice')" @class([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'practice',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'practice',
                    ])>
                        Practice Locations
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Tab Content -->
            <div>
                @if($activeTab === 'information')
                    <!-- Basic Information Tab -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Personal Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                                <div class="text-sm text-slate-900">{{ $user->name }}</div>
                            </div>

                            @if($user->date_of_birth)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
                                <div class="text-sm text-slate-900">{{ $user->date_of_birth }}</div>
                            </div>
                            @endif

                            @if($user->phone)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                                <div class="text-sm text-slate-900">{{ $user->phone }}</div>
                            </div>
                            @endif

                            @if($user->business_name)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Business Name</label>
                                <div class="text-sm text-slate-900">{{ $user->business_name }}</div>
                            </div>
                            @endif
                        </div>

                        <!-- Professional Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Professional Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <div class="text-sm text-slate-900">{{ $user->email }}</div>
                            </div>

                            @if($user->npi_number)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">NPI Number</label>
                                <div class="text-sm text-slate-900">{{ $user->npi_number }}</div>
                            </div>
                            @endif

                            @if($user->provider_type)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Provider Type</label>
                                <div class="text-sm text-slate-900">{{ $user->provider_type }}</div>
                            </div>
                            @endif

                            @if($user->taxonomy_code)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Taxonomy Code</label>
                                <div class="text-sm text-slate-900">{{ $user->taxonomy_code }}</div>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Account Status</label>
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Member Since</label>
                                <div class="text-sm text-slate-900">{{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>

                @elseif($activeTab === 'practice' && $user->user_type->value === \App\Enums\UserType::DOCTOR->value)
                    <!-- Practice Locations Tab -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900">Practice Locations</h3>
                        
                        @forelse($practiceLocations as $location)
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h4 class="font-semibold text-slate-900">{{ $location->practice_name }}</h4>
                                            @if($location->is_primary)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-teal-100 text-teal-800">
                                                    Primary
                                                </span>
                                            @endif
                                        </div>
                                        <div class="space-y-1 text-sm text-slate-600">
                                            <p>{{ $location->address_line_1 }}</p>
                                            @if($location->address_line_2)
                                                <p>{{ $location->address_line_2 }}</p>
                                            @endif
                                            <p>{{ $location->city }}, {{ $location->state }} {{ $location->zip_code }}</p>
                                            @if($location->specialty)
                                                <p class="mt-2"><span class="font-medium">Specialty:</span> {{ $location->specialty }}</p>
                                            @endif
                                            @if($location->npi_type_1)
                                                <p><span class="font-medium">NPI Type 1:</span> {{ $location->npi_type_1 }}</p>
                                            @endif
                                            @if($location->npi_type_2)
                                                <p><span class="font-medium">NPI Type 2:</span> {{ $location->npi_type_2 }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-center py-8">No practice locations added.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
