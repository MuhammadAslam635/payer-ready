<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Provider Profile</h1>
            <p class="text-slate-600 mt-1">Manage your professional information and credentials</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="setActiveTab('information')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'information',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'information',
                ])>
                    Information and Account Status
                </button>
                <button wire:click="setActiveTab('specialty')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'specialty',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'specialty',
                ])>
                    Specialty and Taxonomy Code
                </button>
                <button wire:click="setActiveTab('documents')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'documents',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'documents',
                ])>
                    Documents
                </button>
                <button wire:click="setActiveTab('portals')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'portals',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'portals',
                ])>
                    Portal Logins
                </button>
                <button wire:click="setActiveTab('practice')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'practice',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'practice',
                ])>
                    Practice Location Information
                </button>
            </nav>
                </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'information')
                <!-- Information and Account Status Tab -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900">Personal Information</h3>
                            
                            <div>
                                <x-ui.label for="name">Full Name <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="name" id="name" placeholder="Enter full name" />
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="date_of_birth">Date of Birth <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="date_of_birth" type="date" id="date_of_birth" />
                                @error('date_of_birth') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                            <div>
                                <x-ui.label for="ssn_encrypted">SSN</x-ui.label>
                                <x-ui.input wire:model="ssn_encrypted" id="ssn_encrypted" placeholder="XXX-XX-XXXX" />
                                @error('ssn_encrypted') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

                            <div>
                                <label for="provider_type" class="block text-sm font-medium text-slate-700 mb-1">
                                    Provider Type <span class="text-red-500">*</span>
                                </label>
                                <select wire:model.live="provider_type" id="provider_type"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                    <option value="">Select provider type...</option>
                                    @foreach($providerTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('provider_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900">Contact Information</h3>
                            
                            <div>
                                <x-ui.label for="email">Email <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="email" type="email" id="email" placeholder="Enter email address" />
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="phone">Contact Number <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="phone" id="phone" placeholder="Enter phone number" />
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="fax_number">Fax Number</x-ui.label>
                                <x-ui.input wire:model="fax_number" id="fax_number" placeholder="Enter fax number" />
                                @error('fax_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="npi_number">NPI Number <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="npi_number" id="npi_number" placeholder="Enter NPI number" />
                                @error('npi_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900">Address Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-ui.label for="address_line_1">Address Line 1 <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="address_line_1" id="address_line_1" placeholder="Enter street address" />
                                @error('address_line_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="address_line_2">Address Line 2</x-ui.label>
                                <x-ui.input wire:model="address_line_2" id="address_line_2" placeholder="Apartment, suite, etc." />
                                @error('address_line_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                            <div>
                                <x-ui.label for="city">City <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="city" id="city" placeholder="Enter city" />
                                @error('city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                            <div>
                                <x-ui.label for="state">State <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="state" id="state" placeholder="Enter state" />
                                @error('state') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
                            <div>
                                <x-ui.label for="zip_code">ZIP Code <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="zip_code" id="zip_code" placeholder="Enter ZIP code" />
                                @error('zip_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

                    <!-- Account Status -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900">Account Status</h3>
                        <div class="flex items-center space-x-4">
                            <x-ui.checkbox wire:model="is_active" id="is_active" label="Account is active" />
                    </div>
                    </div>

                    <!-- Save Button for Information Tab -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="saveInformation">
                            Save Information
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'specialty')
                <!-- Specialty and Taxonomy Code Tab -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="primary_specialty_id" class="block text-sm font-medium text-slate-700 mb-1">
                                Primary Specialty <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.live="primary_specialty_id" id="primary_specialty_id"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                <option value="">Select primary specialty...</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                            @error('primary_specialty_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

                        <div>
                            <x-ui.label for="taxonomy_code">Taxonomy Code <span class="text-red-500">*</span></x-ui.label>
                            <x-ui.input wire:model="taxonomy_code" id="taxonomy_code" placeholder="e.g., 261QM0801X" />
                            <p class="mt-1 text-sm text-slate-500">Example: 261QM0801X - Clinic/Center - Mental Health</p>
                            @error('taxonomy_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">About Taxonomy Codes</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Taxonomy codes are used to categorize healthcare providers by their specialty and practice setting. They help insurance companies and healthcare systems identify the type of services you provide.</p>
                    </div>
                </div>
            </div>
                    </div>

                    <!-- Save Button for Specialty Tab -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="saveSpecialty">
                            Save Specialty &amp; Taxonomy
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'documents')
                <!-- Documents Tab -->
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-900">Document Management</h3>
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="cloud-arrow-up"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="$dispatch('open-document-upload')">
                            Upload Document
                        </x-ui.button>
        </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- License Documents -->
                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <x-ui.icon name="identification" class="w-5 h-5 text-blue-600" />
            </div>
                                <h4 class="ml-3 font-medium text-slate-900">Licenses</h4>
                                    </div>
                            <p class="text-sm text-slate-600">Medical licenses, professional licenses, and certifications</p>
                                    </div>

                        <!-- Educational Documents -->
                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <x-ui.icon name="academic-cap" class="w-5 h-5 text-green-600" />
                                </div>
                                <h4 class="ml-3 font-medium text-slate-900">Educational Documents</h4>
                            </div>
                            <p class="text-sm text-slate-600">Degrees, transcripts, and training certificates</p>
                        </div>

                        <!-- DEA Documents -->
                        <div class="bg-white border border-slate-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <x-ui.icon name="shield-check" class="w-5 h-5 text-purple-600" />
                                </div>
                                <h4 class="ml-3 font-medium text-slate-900">DEA Documents</h4>
                            </div>
                            <p class="text-sm text-slate-600">DEA registration and controlled substance licenses</p>
                        </div>
                    </div>

                    <!-- Document List -->
                    <div class="bg-white border border-slate-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h4 class="font-medium text-slate-900">Recent Documents</h4>
                        </div>
                        <div class="p-6">
                            <p class="text-slate-500 text-center py-4">No documents uploaded yet. Click "Upload Document" to get started.</p>
                        </div>
                    </div>
                </div>

            @elseif($activeTab === 'portals')
                <!-- Portal Logins Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Portal Login Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NPPES Portal -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-900">NPPES Portal</h4>
                            <div>
                                <x-ui.label for="nppes_login">NPPES Login</x-ui.label>
                                <x-ui.input wire:model="nppes_login" id="nppes_login" placeholder="Enter NPPES login" />
                            </div>
                            <div>
                                <x-ui.label for="nppes_password">NPPES Password</x-ui.label>
                                <x-ui.input wire:model="nppes_password" type="password" id="nppes_password" placeholder="Enter NPPES password" />
            </div>
        </div>

                        <!-- CAQH Portal -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-900">CAQH Portal</h4>
                            <div>
                                <x-ui.label for="caqh_login">CAQH Login</x-ui.label>
                                <x-ui.input wire:model="caqh_login" id="caqh_login" placeholder="Enter CAQH login" />
                            </div>
                            <div>
                                <x-ui.label for="caqh_password">CAQH Password</x-ui.label>
                                <x-ui.input wire:model="caqh_password" type="password" id="caqh_password" placeholder="Enter CAQH password" />
                </div>
                        </div>

                        <!-- Availity Portal -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-900">Availity Portal</h4>
                            <div>
                                <x-ui.label for="availity_login">Availity Login</x-ui.label>
                                <x-ui.input wire:model="availity_login" id="availity_login" placeholder="Enter Availity login" />
                            </div>
                            <div>
                                <x-ui.label for="availity_password">Availity Password</x-ui.label>
                                <x-ui.input wire:model="availity_password" type="password" id="availity_password" placeholder="Enter Availity password" />
                </div>
            </div>

                        <!-- PECOS Portal -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-slate-900">PECOS Portal</h4>
                            <div>
                                <x-ui.label for="pecos_login">PECOS Login</x-ui.label>
                                <x-ui.input wire:model="pecos_login" id="pecos_login" placeholder="Enter PECOS login" />
                            </div>
                            <div>
                                <x-ui.label for="pecos_password">PECOS Password</x-ui.label>
                                <x-ui.input wire:model="pecos_password" type="password" id="pecos_password" placeholder="Enter PECOS password" />
                            </div>
                        </div>
                    </div>

                    <!-- Save Button for Portal Logins Tab -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="savePortalLogins">
                            Save Portal Logins
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'practice')
                <!-- Practice Location Information Tab -->
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-900">Practice Location Information</h3>
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="plus"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="openPracticeModal">
                            Add Practice Location
                        </x-ui.button>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Practice Location Details</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Add your practice locations including the practice name, address, specialty, and NPI information. You can have multiple practice locations.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Practice Locations List -->
                    <div class="space-y-4">
                        @forelse($practiceLocations as $location)
                            <div class="bg-white border border-slate-200 rounded-lg p-4 hover:border-slate-300 transition-colors">
                                <div class="flex justify-between items-start">
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
                                            <p class="mt-2"><span class="font-medium">Specialty:</span> {{ $location->specialty }}</p>
                                            @if($location->npi_type_1)
                                                <p><span class="font-medium">NPI Type 1:</span> {{ $location->npi_type_1 }}</p>
                                            @endif
                                            @if($location->npi_type_2)
                                                <p><span class="font-medium">NPI Type 2:</span> {{ $location->npi_type_2 }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4">
                                        <x-ui.button
                                            type="button"
                                            variant="ghost"
                                            size="sm"
                                            squared
                                            icon="pencil"
                                            class="text-teal-600 hover:text-teal-800"
                                            wire:click="editPracticeLocation({{ $location->id }})"
                                            title="Edit" />
                                        <x-ui.button
                                            type="button"
                                            variant="ghost"
                                            size="sm"
                                            squared
                                            icon="trash"
                                            class="text-red-600 hover:text-red-800"
                                            wire:click="deletePracticeLocation({{ $location->id }})"
                                            wire:confirm="Are you sure you want to delete this practice location?"
                                            title="Delete" />
                                    </div>
                                </div>
                            </div>
                        @empty
                        <p class="text-slate-500 text-center py-8">No practice locations added yet. Click "Add Practice Location" to get started.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Practice Location Modal -->
    @if($showPracticeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closePracticeModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="savePracticeLocation">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                    {{ $editingPracticeId ? 'Edit Practice Location' : 'Add Practice Location' }}
                                </h3>
                                <x-ui.button
                                    type="button"
                                    variant="ghost"
                                    squared
                                    size="sm"
                                    icon="x-mark"
                                    class="text-gray-400 hover:text-gray-600"
                                    wire:click="closePracticeModal">
                                    <span class="sr-only">Close</span>
                                </x-ui.button>
                            </div>
                            
                            <div class="space-y-4">
                                <!-- Practice Name -->
                                <div>
                                    <x-ui.label for="practice_name">Practice Name <span class="text-red-500">*</span></x-ui.label>
                                    <x-ui.input wire:model="practice_name" id="practice_name" placeholder="Enter practice name" />
                                    @error('practice_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Address Line 1 -->
                                <div>
                                    <x-ui.label for="practice_address_line_1">Practice Address <span class="text-red-500">*</span></x-ui.label>
                                    <x-ui.input wire:model="practice_address_line_1" id="practice_address_line_1" placeholder="Street address" />
                                    @error('practice_address_line_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Address Line 2 -->
                                <div>
                                    <x-ui.label for="practice_address_line_2">Mailing Address</x-ui.label>
                                    <x-ui.input wire:model="practice_address_line_2" id="practice_address_line_2" placeholder="Apartment, suite, etc." />
                                    @error('practice_address_line_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- City, State, Zip -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-ui.label for="practice_city">City <span class="text-red-500">*</span></x-ui.label>
                                        <x-ui.input wire:model="practice_city" id="practice_city" placeholder="City" />
                                        @error('practice_city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_state">State <span class="text-red-500">*</span></x-ui.label>
                                        <x-ui.input wire:model="practice_state" id="practice_state" placeholder="State" />
                                        @error('practice_state') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_zip_code">ZIP Code <span class="text-red-500">*</span></x-ui.label>
                                        <x-ui.input wire:model="practice_zip_code" id="practice_zip_code" placeholder="ZIP" />
                                        @error('practice_zip_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- Specialty -->
                                <div>
                                    <x-ui.label for="practice_specialty">Specialty <span class="text-red-500">*</span></x-ui.label>
                                    <x-ui.input wire:model="practice_specialty" id="practice_specialty" placeholder="Enter specialty" />
                                    @error('practice_specialty') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- NPI Numbers -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-ui.label for="practice_npi_type_1">NPI Type 1 (Individual)</x-ui.label>
                                        <x-ui.input wire:model="practice_npi_type_1" id="practice_npi_type_1" placeholder="Individual NPI" />
                                        @error('practice_npi_type_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_npi_type_2">NPI Type 2 (Organization)</x-ui.label>
                                        <x-ui.input wire:model="practice_npi_type_2" id="practice_npi_type_2" placeholder="Organization NPI" />
                                        @error('practice_npi_type_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- Is Primary -->
                                <div class="flex items-center">
                                    <x-ui.checkbox wire:model="is_primary_location" id="is_primary_location" label="Set as primary location" />
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <x-ui.button
                                type="submit"
                                color="teal"
                                variant="primary"
                                class="w-full sm:w-auto sm:ml-3"
                                wire:loading.attr="disabled"
                                wire:target="savePracticeLocation">
                                <span wire:loading.remove wire:target="savePracticeLocation">
                                    {{ $editingPracticeId ? 'Update' : 'Add' }} Location
                                </span>
                                <span wire:loading wire:target="savePracticeLocation" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Saving...
                                </span>
                            </x-ui.button>
                            <x-ui.button
                                type="button"
                                variant="outline"
                                color="slate"
                                class="mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto"
                                wire:click="closePracticeModal">
                                Cancel
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
    @endif
</div>