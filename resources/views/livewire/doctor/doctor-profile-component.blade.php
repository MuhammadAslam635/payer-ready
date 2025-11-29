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
            <nav class="flex flex-wrap space-x-4 px-6 overflow-x-auto" aria-label="Tabs">
                <button wire:click="setActiveTab('personal')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'personal',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'personal',
                ])>
                    Personal Information
                </button>
                <button wire:click="setActiveTab('professional')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'professional',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'professional',
                ])>
                    Professional IDs
                </button>
                <button wire:click="setActiveTab('education')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'education',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'education',
                ])>
                    Educational Information
                </button>
                <button wire:click="setActiveTab('specialties')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'specialties',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'specialties',
                ])>
                    Specialties
                </button>
                <button wire:click="setActiveTab('practice')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'practice',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'practice',
                ])>
                    Practice Location
                </button>
                <button wire:click="setActiveTab('insurance')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'insurance',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'insurance',
                ])>
                    Professional Liability Insurance
                </button>
                <button wire:click="setActiveTab('portals')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'portals',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'portals',
                ])>
                    Portal Logins
                </button>
                <button wire:click="setActiveTab('documents')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'documents',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'documents',
                ])>
                    Documents
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'personal')
                <!-- Personal Information Tab -->
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
                                <x-ui.label for="npi_number">Individual NPI <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="npi_number" id="npi_number" placeholder="Enter NPI number" />
                                @error('npi_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900">Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <x-ui.label for="address">Address <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="address" id="address" placeholder="Enter full address" />
                                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="address_state_id">State <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.select wire:model="address_state_id" id="address_state_id" searchable>
                                    <x-ui.select.option value="">Select state...</x-ui.select.option>
                                    @foreach($states as $state)
                                        <x-ui.select.option value="{{ (string)$state->id }}">{{ $state->name }}</x-ui.select.option>
                                    @endforeach
                                </x-ui.select>
                                @error('address_state_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="address_country">Country</x-ui.label>
                                <x-ui.input wire:model="address_country" id="address_country" placeholder="US" />
                                @error('address_country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
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

            @elseif($activeTab === 'professional')
                <!-- Professional IDs Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Professional IDs</h3>
                    
                    <!-- DEA Information -->
                    <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                        <h4 class="font-medium text-slate-900 mb-4">DEA Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-ui.label for="dea_number">DEA Number</x-ui.label>
                                <x-ui.input wire:model="dea_number" id="dea_number" placeholder="Enter DEA number" />
                                @error('dea_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="dea_issue_date">Issue Date</x-ui.label>
                                <x-ui.input wire:model="dea_issue_date" type="date" id="dea_issue_date" />
                                @error('dea_issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="dea_expiry_date">Expiry Date</x-ui.label>
                                <x-ui.input wire:model="dea_expiry_date" type="date" id="dea_expiry_date" />
                                @error('dea_expiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <x-ui.button
                                type="button"
                                color="teal"
                                variant="primary"
                                icon="check"
                                class="!px-5 uppercase tracking-wide text-xs"
                                wire:click="saveDEAInfo">
                                Save DEA Information
                            </x-ui.button>
                        </div>
                    </div>

                    <!-- Licenses Section -->
                    <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                        <h4 class="font-medium text-slate-900 mb-4">License Information</h4>
                        
                        <!-- Add License Form -->
                        <div class="bg-slate-50 p-4 rounded-lg mb-4">
                            <h5 class="font-medium text-slate-900 mb-4">Add New License</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <x-ui.label for="license_license_number">License Number</x-ui.label>
                                    <x-ui.input wire:model="license_license_number" id="license_license_number" placeholder="Enter license number" />
                                    @error('license_license_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="license_license_type_id">License Type</x-ui.label>
                                    <select wire:model="license_license_type_id" id="license_license_type_id"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                        <option value="">Select license type...</option>
                                        @foreach($licenseTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('license_license_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="license_state_id">State</x-ui.label>
                                    <x-ui.select wire:model="license_state_id" id="license_state_id" searchable>
                                        <x-ui.select.option value="">Select state...</x-ui.select.option>
                                        @foreach($states as $state)
                                            <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}</x-ui.select.option>
                                        @endforeach
                                    </x-ui.select>
                                    @error('license_state_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="license_issue_date">Issue Date</x-ui.label>
                                    <x-ui.input wire:model="license_issue_date" type="date" id="license_issue_date" />
                                    @error('license_issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="license_expiry_date">Expiry Date</x-ui.label>
                                    <x-ui.input wire:model="license_expiry_date" type="date" id="license_expiry_date" />
                                    @error('license_expiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <x-ui.button
                                    type="button"
                                    color="teal"
                                    variant="primary"
                                    icon="plus"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="saveLicense">
                                    Add License
                                </x-ui.button>
                            </div>
                        </div>
                        
                        <!-- Existing Licenses -->
                        @if(count($licenses) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">License Number</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">State</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issue Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiration Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiration Alert</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @foreach($licenses as $license)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $license->license_number }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $license->state->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $license->licenseType->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $license->issue_date ? $license->issue_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $license->expiration_date ? $license->expiration_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if ($license->expiration_date)
                                                        @php
                                                            $daysRemaining = now()->diffInDays($license->expiration_date, false);
                                                            $badgeClass = $daysRemaining <= 0
                                                                ? 'bg-red-100 text-red-800'
                                                                : ($daysRemaining <= 90
                                                                    ? 'bg-amber-100 text-amber-800'
                                                                    : 'bg-emerald-100 text-emerald-800');
                                                            $label = $daysRemaining <= 0
                                                                ? 'Expired'
                                                                : ($daysRemaining <= 90 ? 'Expiring Soon' : 'Active');
                                                        @endphp
                                                        <div class="flex flex-col">
                                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                                                {{ $label }}
                                                            </span>
                                                            <span class="text-xs text-slate-500 mt-1">
                                                                @if ($daysRemaining <= 0)
                                                                    {{ abs($daysRemaining) }} day{{ abs($daysRemaining) === 1 ? '' : 's' }} ago
                                                                @else
                                                                    {{ $daysRemaining }} day{{ $daysRemaining === 1 ? '' : 's' }} remaining
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span class="text-slate-400">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $license->expiration_date && $license->expiration_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $license->expiration_date && $license->expiration_date->isFuture() ? 'Active' : 'Expired' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Certifications Section -->
                    <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                        <h4 class="font-medium text-slate-900 mb-4">G. Certifications</h4>
                        
                        <!-- Add Certification Form -->
                        <div class="bg-slate-50 p-4 rounded-lg mb-4">
                            <h5 class="font-medium text-slate-900 mb-4">Add New Certification</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <x-ui.label for="cert_certificate_number">Certification Number</x-ui.label>
                                    <x-ui.input wire:model="cert_certificate_number" id="cert_certificate_number" placeholder="Enter certification number" />
                                    @error('cert_certificate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="cert_certificate_type_id">Certificate Type</x-ui.label>
                                    <select wire:model="cert_certificate_type_id" id="cert_certificate_type_id"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                        <option value="">Select certificate type...</option>
                                        @foreach($certificateTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cert_certificate_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="cert_issuing_organization">H. Issuing Board</x-ui.label>
                                    <x-ui.input wire:model="cert_issuing_organization" id="cert_issuing_organization" placeholder="Enter issuing board" />
                                    @error('cert_issuing_organization') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="cert_issue_date">I. Issue Date</x-ui.label>
                                    <x-ui.input wire:model="cert_issue_date" type="date" id="cert_issue_date" />
                                    @error('cert_issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="cert_expiry_date">J. Expiry Date</x-ui.label>
                                    <x-ui.input wire:model="cert_expiry_date" type="date" id="cert_expiry_date" />
                                    @error('cert_expiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <x-ui.button
                                    type="button"
                                    color="teal"
                                    variant="primary"
                                    icon="plus"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="saveCertification">
                                    Add Certification
                                </x-ui.button>
                            </div>
                        </div>
                        
                        <!-- Existing Certifications -->
                        @if(count($certificates) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Certificate Name</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Certificate Number</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issuing Organization</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issue Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiration Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiration Alert</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @foreach($certificates as $certificate)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $certificate->certificate_name }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->certificate_number ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->issuing_organization }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->expiration_date ? $certificate->expiration_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if ($certificate->expiration_date)
                                                        @php
                                                            $daysRemaining = now()->diffInDays($certificate->expiration_date, false);
                                                            $badgeClass = $daysRemaining <= 0
                                                                ? 'bg-red-100 text-red-800'
                                                                : ($daysRemaining <= 90
                                                                    ? 'bg-amber-100 text-amber-800'
                                                                    : 'bg-emerald-100 text-emerald-800');
                                                            $label = $daysRemaining <= 0
                                                                ? 'Expired'
                                                                : ($daysRemaining <= 90 ? 'Expiring Soon' : 'Active');
                                                        @endphp
                                                        <div class="flex flex-col">
                                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                                                {{ $label }}
                                                            </span>
                                                            <span class="text-xs text-slate-500 mt-1">
                                                                @if ($daysRemaining <= 0)
                                                                    {{ abs($daysRemaining) }} day{{ abs($daysRemaining) === 1 ? '' : 's' }} ago
                                                                @else
                                                                    {{ $daysRemaining }} day{{ $daysRemaining === 1 ? '' : 's' }} remaining
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span class="text-slate-400">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $certificate->is_current ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ $certificate->is_current ? 'Current' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif($activeTab === 'education')
                <!-- Educational Information Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Educational Information</h3>
                    
                    <!-- Add/Edit Education Form -->
                    <div class="bg-white p-6 rounded-lg border border-slate-200">
                        <h4 class="font-medium text-slate-900 mb-4">{{ $editingEducationId ? 'Edit Educational Information' : 'Add Educational Information' }}</h4>
                        <div class="bg-slate-50 p-4 rounded-lg mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-ui.label for="edu_institution_name">School/Institute</x-ui.label>
                                    <x-ui.input wire:model="edu_institution_name" id="edu_institution_name" placeholder="Enter school/institute name" />
                                    @error('edu_institution_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="edu_degree">Degree (MSN, MD, etc.)</x-ui.label>
                                    <x-ui.input wire:model="edu_degree" id="edu_degree" placeholder="e.g., MD, MSN, DO" />
                                    @error('edu_degree') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-ui.label for="edu_completed_year">Year of Graduation</x-ui.label>
                                    <x-ui.input wire:model="edu_completed_year" type="date" id="edu_completed_year" />
                                    @error('edu_completed_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-4">
                                @if($editingEducationId)
                                    <x-ui.button
                                        type="button"
                                        variant="outline"
                                        color="slate"
                                        class="!px-5 uppercase tracking-wide text-xs"
                                        wire:click="resetEducationForm">
                                        Cancel
                                    </x-ui.button>
                                @endif
                                <x-ui.button
                                    type="button"
                                    color="teal"
                                    variant="primary"
                                    icon="{{ $editingEducationId ? 'check' : 'plus' }}"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="saveEducation">
                                    {{ $editingEducationId ? 'Update Education' : 'Add Education' }}
                                </x-ui.button>
                            </div>
                        </div>
                        
                        <!-- Existing Education Records -->
                        @if(count($educations) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">School/Institute</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Degree</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Year of Graduation</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @foreach($educations as $education)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-slate-900">{{ $education->institution_name }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $education->degree }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600">{{ $education->completed_year }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="pencil"
                                                            class="text-teal-600 hover:text-teal-800"
                                                            wire:click="editEducation({{ $education->id }})"
                                                            title="Edit" />
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="trash"
                                                            class="text-red-600 hover:text-red-800"
                                                            wire:click="deleteEducation({{ $education->id }})"
                                                            wire:confirm="Are you sure you want to delete this educational record?"
                                                            title="Delete" />
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif($activeTab === 'specialties')
                <!-- Specialties Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Specialties</h3>
                    
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
                            <x-ui.input wire:model="taxonomy_code" id="taxonomy_code" placeholder="e.g., 363LP0808X" />
                            <p class="mt-1 text-sm text-slate-500">Example: 363LP0808X - Psych Mental Health</p>
                            @error('taxonomy_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                        <h4 class="font-medium text-slate-900 mb-4">Sub Specialty</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($specialties as $specialty)
                                <div class="flex items-center p-2 hover:bg-slate-50 rounded">
                                    <x-ui.checkbox 
                                        wire:model="selectedSpecialties" 
                                        value="{{ $specialty->id }}" 
                                        id="specialty_{{ $specialty->id }}" 
                                        label="{{ $specialty->name }}" />
                                </div>
                            @endforeach
                        </div>
                        @if(count($specialties) === 0)
                            <p class="text-slate-500 text-center py-4">No specialties available.</p>
                        @endif
                    </div>

                    <!-- Save Button for Specialties Tab -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="saveSpecialty">
                            Save Specialties
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'insurance')
                <!-- Professional/General Liability Insurance Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Professional/General Liability Insurance</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-ui.label for="insurance_carrier">Name of Carrier/Insurance</x-ui.label>
                            <x-ui.input wire:model="insurance_carrier" id="insurance_carrier" placeholder="Enter insurance carrier name" />
                            @error('insurance_carrier') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-ui.label for="insurance_policy_number">Policy Number</x-ui.label>
                            <x-ui.input wire:model="insurance_policy_number" id="insurance_policy_number" placeholder="Enter policy number" />
                            @error('insurance_policy_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-ui.label for="insurance_coverage_amount_per_occurrence">Coverage Amount - Per Occurrence</x-ui.label>
                            <x-ui.input wire:model="insurance_coverage_amount_per_occurrence" id="insurance_coverage_amount_per_occurrence" type="number" placeholder="e.g., 1000000" />
                            <p class="mt-1 text-sm text-slate-500">Example: $1,000,000</p>
                            @error('insurance_coverage_amount_per_occurrence') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-ui.label for="insurance_coverage_amount_aggregate">Coverage Amount - Aggregate</x-ui.label>
                            <x-ui.input wire:model="insurance_coverage_amount_aggregate" id="insurance_coverage_amount_aggregate" type="number" placeholder="e.g., 3000000" />
                            <p class="mt-1 text-sm text-slate-500">Example: $3,000,000</p>
                            @error('insurance_coverage_amount_aggregate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-ui.label for="insurance_policy_effective_date">Policy Effective Date</x-ui.label>
                            <x-ui.input wire:model="insurance_policy_effective_date" type="date" id="insurance_policy_effective_date" />
                            @error('insurance_policy_effective_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-ui.label for="insurance_policy_expiration_date">Policy Expiration Date</x-ui.label>
                            <x-ui.input wire:model="insurance_policy_expiration_date" type="date" id="insurance_policy_expiration_date" />
                            @error('insurance_policy_expiration_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Save Button for Insurance Tab -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="saveInsurance">
                            Save Insurance Information
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'portals')
                <!-- Portal Logins Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Portal Login Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NPPES Portal -->
                        <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                            <h4 class="font-semibold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg border border-teal-200">NPPES Portal</h4>
                            <div>
                                <x-ui.label for="nppes_login">NPPES Login <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="nppes_login" id="nppes_login" placeholder="Enter NPPES login" />
                            </div>
                            <div>
                                <x-ui.label for="nppes_password">NPPES Password <span class="text-red-500">*</span></x-ui.label>
                                <div class="relative">
                                    <x-ui.input wire:model="nppes_password" type="{{ $showNppesPassword ? 'text' : 'password' }}" id="nppes_password" placeholder="Enter NPPES password" class="pr-12" />
                                    <button type="button" wire:click="$toggle('showNppesPassword')" class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 z-10 p-1">
                                        @if($showNppesPassword)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CAQH Portal -->
                        <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                            <h4 class="font-semibold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg border border-teal-200">CAQH Portal</h4>
                            <div>
                                <x-ui.label for="caqh_id">CAQH ID</x-ui.label>
                                <x-ui.input wire:model="caqh_id" id="caqh_id" placeholder="Enter CAQH ID" />
                            </div>
                            <div>
                                <x-ui.label for="caqh_login">CAQH Login (User ID) <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="caqh_login" id="caqh_login" placeholder="Enter CAQH login" />
                            </div>
                            <div>
                                <x-ui.label for="caqh_password">CAQH Password <span class="text-red-500">*</span></x-ui.label>
                                <div class="relative">
                                    <x-ui.input wire:model="caqh_password" type="{{ $showCaqhPassword ? 'text' : 'password' }}" id="caqh_password" placeholder="Enter CAQH password" class="pr-12" />
                                    <button type="button" wire:click="$toggle('showCaqhPassword')" class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 z-10 p-1">
                                        @if($showCaqhPassword)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Availity Portal -->
                        <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                            <h4 class="font-semibold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg border border-teal-200">Availity Portal</h4>
                            <div>
                                <x-ui.label for="availity_login">Availity Login (User ID) <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="availity_login" id="availity_login" placeholder="Enter Availity login" />
                            </div>
                            <div>
                                <x-ui.label for="availity_password">Availity Password <span class="text-red-500">*</span></x-ui.label>
                                <div class="relative">
                                    <x-ui.input wire:model="availity_password" type="{{ $showAvailityPassword ? 'text' : 'password' }}" id="availity_password" placeholder="Enter Availity password" class="pr-12" />
                                    <button type="button" wire:click="$toggle('showAvailityPassword')" class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 z-10 p-1">
                                        @if($showAvailityPassword)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- PECOS Portal -->
                        <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                            <h4 class="font-semibold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg border border-teal-200">PECOS Portal</h4>
                            <div>
                                <x-ui.label for="pecos_login">PECOS Login (User ID) <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="pecos_login" id="pecos_login" placeholder="Enter PECOS login" />
                            </div>
                            <div>
                                <x-ui.label for="pecos_password">PECOS Password <span class="text-red-500">*</span></x-ui.label>
                                <div class="relative">
                                    <x-ui.input wire:model="pecos_password" type="{{ $showPecosPassword ? 'text' : 'password' }}" id="pecos_password" placeholder="Enter PECOS password" class="pr-12" />
                                    <button type="button" wire:click="$toggle('showPecosPassword')" class="absolute inset-y-0 right-2 flex items-center text-slate-500 hover:text-slate-700 z-10 p-1">
                                        @if($showPecosPassword)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        @endif
                                    </button>
                                </div>
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
                <!-- Practice Location Tab -->
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
                                                <p><span class="font-medium">Group NPI:</span> {{ $location->npi_type_2 }}</p>
                                            @endif
                                            @if($location->tax_id)
                                                <p><span class="font-medium">Tax ID:</span> {{ $location->tax_id }}</p>
                                            @endif
                                            @if($location->office_phone)
                                                <p><span class="font-medium">Office Phone:</span> {{ $location->office_phone }}</p>
                                            @endif
                                            @if($location->office_fax)
                                                <p><span class="font-medium">Office Fax:</span> {{ $location->office_fax }}</p>
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
                            wire:click="openUploadModal">
                            Upload Document
                        </x-ui.button>
                    </div>

                    <!-- Documents Table -->
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900">Your Documents</h3>
                        </div>
                        
                        @if(count($documents) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Document Type
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                File Name
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Upload Date
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Size
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @foreach($documents as $document)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-slate-900">
                                                        {{ $document->documentType->name ?? 'Unknown' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-slate-900">{{ $document->original_filename }}</div>
                                                    @if($document->notes)
                                                        <div class="text-xs text-slate-500 mt-1">{{ Str::limit($document->notes, 50) }}</div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    {{ $document->upload_date?->format('M d, Y') ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $document->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ $document->is_verified ? 'Verified' : 'Pending' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    {{ $this->formatFileSize($document->file_size_bytes) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="arrow-down-tray"
                                                            class="border border-slate-300 text-slate-700 hover:text-slate-900"
                                                            wire:click="downloadDocument({{ $document->id }})" />
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="pencil-square"
                                                            class="border border-slate-300 text-slate-700 hover:text-slate-900"
                                                            wire:click="openEditModal({{ $document->id }})" />
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="trash"
                                                            class="border border-slate-300 text-slate-700 hover:text-red-700"
                                                            onclick="return confirm('Are you sure you want to delete this document?')"
                                                            wire:click="deleteDocument({{ $document->id }})" />
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-6 text-center">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-slate-900 mb-2">No documents uploaded</h3>
                                <p class="text-slate-500 mb-4">Upload your first document to get started.</p>
                                <x-ui.button
                                    type="button"
                                    color="teal"
                                    variant="primary"
                                    icon="cloud-arrow-up"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="openUploadModal">
                                    Upload Document
                                </x-ui.button>
                            </div>
                        @endif
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
                                        <x-ui.label for="practice_npi_type_1">Individual NPI</x-ui.label>
                                        <x-ui.input wire:model="practice_npi_type_1" id="practice_npi_type_1" placeholder="Individual NPI" />
                                        @error('practice_npi_type_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_npi_type_2">Group NPI</x-ui.label>
                                        <x-ui.input wire:model="practice_npi_type_2" id="practice_npi_type_2" placeholder="Organization/Group NPI" />
                                        @error('practice_npi_type_2') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- Tax ID, Office Phone and Fax -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-ui.label for="practice_tax_id">Tax ID</x-ui.label>
                                        <x-ui.input wire:model="practice_tax_id" id="practice_tax_id" placeholder="Enter Tax ID" />
                                        @error('practice_tax_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_office_phone">Office Phone</x-ui.label>
                                        <x-ui.input wire:model="practice_office_phone" id="practice_office_phone" placeholder="Enter office phone" />
                                        @error('practice_office_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <x-ui.label for="practice_office_fax">Office Fax</x-ui.label>
                                        <x-ui.input wire:model="practice_office_fax" id="practice_office_fax" placeholder="Enter office fax" />
                                        @error('practice_office_fax') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <!-- Location Type Checkboxes -->
                                <div class="space-y-3 mt-4">
                                    <div class="flex items-center p-3 bg-slate-50 rounded-lg border border-slate-200">
                                        <x-ui.checkbox wire:model="is_primary_location" id="is_primary_location" label="Set as Primary Location" />
                                    </div>
                                    <div class="flex items-center p-3 bg-slate-50 rounded-lg border border-slate-200">
                                        <x-ui.checkbox wire:model="is_secondary_location" id="is_secondary_location" label="Set as Secondary Location" />
                                    </div>
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

    <!-- Document Upload Modal -->
    @if($showUploadModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeUploadModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Upload Document</h3>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                squared
                                size="sm"
                                icon="x-mark"
                                class="text-slate-400 hover:text-slate-600"
                                wire:click="closeUploadModal" />
                        </div>

                        <form wire:submit.prevent="uploadDocument">
                            <div class="space-y-4">
                                <!-- Document Type Selection -->
                                <div>
                                    <label for="selectedDocumentType" class="block text-sm font-medium text-slate-700 mb-1">
                                        Document Type <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="selectedDocumentType" id="selectedDocumentType" 
                                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                        <option value="">Choose document type...</option>
                                        @foreach($documentTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedDocumentType') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label for="documentFile" class="block text-sm font-medium text-slate-700 mb-1">
                                        Document File <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="documentFile" type="file" id="documentFile" 
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
                                    <p class="mt-1 text-sm text-slate-500">Supported formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                                    @error('documentFile') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">
                                        Notes (Optional)
                                    </label>
                                    <textarea wire:model="notes" id="notes" rows="3" 
                                        placeholder="Add any additional notes about this document..."
                                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                                    @error('notes') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <x-ui.button
                                    type="button"
                                    variant="outline"
                                    color="slate"
                                    wire:click="closeUploadModal">
                                    Cancel
                                </x-ui.button>
                                <x-ui.button
                                    type="submit"
                                    color="teal"
                                    variant="primary"
                                    icon="cloud-arrow-up"
                                    wire:loading.attr="disabled"
                                    wire:target="uploadDocument">
                                    <span wire:loading.remove wire:target="uploadDocument">Upload Document</span>
                                    <span wire:loading wire:target="uploadDocument" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading...
                                    </span>
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Document Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeEditModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Edit Document</h3>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                squared
                                size="sm"
                                icon="x-mark"
                                class="text-slate-400 hover:text-slate-600"
                                wire:click="closeEditModal" />
                        </div>

                        @if($editingDocument)
                            <form wire:submit.prevent="updateDocument">
                                <div class="space-y-4">
                                    <!-- Document Info -->
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <h4 class="font-medium text-slate-900 mb-2">Document Information</h4>
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-slate-500">Type:</span>
                                                <span class="text-slate-900 ml-2">{{ $editingDocument->documentType->name ?? 'Unknown' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">File:</span>
                                                <span class="text-slate-900 ml-2">{{ $editingDocument->original_filename }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Upload Date:</span>
                                                <span class="text-slate-900 ml-2">{{ $editingDocument->upload_date?->format('M d, Y') ?? 'N/A' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Status:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-2
                                                    {{ $editingDocument->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $editingDocument->is_verified ? 'Verified' : 'Pending' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label for="editNotes" class="block text-sm font-medium text-slate-700 mb-1">
                                            Notes
                                        </label>
                                        <textarea wire:model="editNotes" id="editNotes" rows="3" 
                                            placeholder="Add or update notes about this document..."
                                            class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                                        @error('editNotes') 
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <x-ui.button
                                        type="button"
                                        variant="outline"
                                        color="slate"
                                        wire:click="closeEditModal">
                                        Cancel
                                    </x-ui.button>
                                    <x-ui.button
                                        type="submit"
                                        color="teal"
                                        variant="primary"
                                        icon="check"
                                        wire:loading.attr="disabled"
                                        wire:target="updateDocument">
                                        <span wire:loading.remove wire:target="updateDocument">Update Document</span>
                                        <span wire:loading wire:target="updateDocument" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Updating...
                                        </span>
                                    </x-ui.button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>