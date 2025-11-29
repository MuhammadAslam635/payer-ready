<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Organization Profile</h1>
            <p class="text-slate-600 mt-1">Manage your organization information and credentials</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex flex-wrap space-x-4 px-6 overflow-x-auto" aria-label="Tabs">
                <button wire:click="setActiveTab('information')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'information',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'information',
                ])>
                    Organization Information
                </button>
                <button wire:click="setActiveTab('ids')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'ids',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'ids',
                ])>
                    Organization IDs
                </button>
                <button wire:click="setActiveTab('certificate')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'certificate',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'certificate',
                ])>
                    Organization Certificate
                </button>
                <button wire:click="setActiveTab('portals')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'portals',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'portals',
                ])>
                    Portals
                </button>
                <button wire:click="setActiveTab('providers')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                    'border-teal-500 text-teal-600' => $activeTab === 'providers',
                    'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== 'providers',
                ])>
                    Number of Providers
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
            @if($activeTab === 'information')
                <!-- Organization Information Tab -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Organization Details -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900">Organization Details</h3>
                            
                            <div>
                                <x-ui.label for="organization_type">Type of Organization <span class="text-red-500">*</span></x-ui.label>
                                <select wire:model.live="organization_type" id="organization_type"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                    <option value="">Select organization type...</option>
                                    @foreach($organizationTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('organization_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="business_name">Organization Name <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="business_name" id="business_name" placeholder="Enter organization name" />
                                @error('business_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="dba_name">DBA (if applicable)</x-ui.label>
                                <x-ui.input wire:model="dba_name" id="dba_name" placeholder="Enter DBA name" />
                                @error('dba_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="tax_id">Tax ID/EIN <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="tax_id" id="tax_id" placeholder="Enter Tax ID/EIN" />
                                @error('tax_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="npi_number">NPI <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="npi_number" id="npi_number" placeholder="Enter NPI number" />
                                @error('npi_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="taxonomy_code">Taxonomy</x-ui.label>
                                <x-ui.input wire:model="taxonomy_code" id="taxonomy_code" placeholder="Enter taxonomy code" />
                                @error('taxonomy_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-slate-900">Contact Information</h3>
                            
                            <div>
                                <x-ui.label for="address">Address</x-ui.label>
                                <x-ui.input wire:model="address" id="address" placeholder="Enter full address" />
                                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="address_state_id">State</x-ui.label>
                                <x-ui.select wire:model.live="address_state_id" id="address_state_id" searchable>
                                    <x-ui.select.option value="">Select state...</x-ui.select.option>
                                    @foreach($states as $state)
                                        <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}</x-ui.select.option>
                                    @endforeach
                                </x-ui.select>
                                @error('address_state_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="phone">Office Phone Number <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="phone" id="phone" placeholder="Enter phone number" />
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="fax_number">Office Fax</x-ui.label>
                                <x-ui.input wire:model="fax_number" id="fax_number" placeholder="Enter fax number" />
                                @error('fax_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <x-ui.label for="website">Website</x-ui.label>
                                <x-ui.input wire:model="website" id="website" type="url" placeholder="https://example.com" />
                                @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end pt-4">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            class="!px-5 uppercase tracking-wide text-xs"
                            wire:click="saveOrganizationInformation">
                            Save Information
                        </x-ui.button>
                    </div>
                </div>

            @elseif($activeTab === 'ids')
                <!-- Organization IDs Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Organization License Information</h3>
                    
                    <!-- Add License Form -->
                    <div class="bg-slate-50 p-4 rounded-lg mb-4">
                        <h4 class="font-medium text-slate-900 mb-4">{{ $editingLicenseId ? 'Edit License' : 'Add New License' }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <x-ui.label for="org_license_number">Org License Number <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_license_number" id="org_license_number" placeholder="Enter license number" />
                                @error('org_license_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="org_license_issue_date">Issue Date <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_license_issue_date" type="date" id="org_license_issue_date" />
                                @error('org_license_issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="org_license_expiry_date">Expiry Date <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_license_expiry_date" type="date" id="org_license_expiry_date" />
                                @error('org_license_expiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-3">
                                <x-ui.label for="org_license_issuing_authority">Issuing Authority</x-ui.label>
                                <x-ui.input wire:model="org_license_issuing_authority" id="org_license_issuing_authority" placeholder="Enter issuing authority" />
                                @error('org_license_issuing_authority') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            @if($editingLicenseId)
                                <x-ui.button
                                    type="button"
                                    variant="outline"
                                    color="slate"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="resetLicenseForm">
                                    Cancel
                                </x-ui.button>
                            @endif
                            <x-ui.button
                                type="button"
                                color="teal"
                                variant="primary"
                                icon="{{ $editingLicenseId ? 'check' : 'plus' }}"
                                class="!px-5 uppercase tracking-wide text-xs"
                                wire:click="saveLicense">
                                {{ $editingLicenseId ? 'Update License' : 'Add License' }}
                            </x-ui.button>
                        </div>
                    </div>
                    
                    <!-- Existing Licenses -->
                    @if(count($org_licenses) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">License Number</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issue Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiry Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issuing Authority</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($org_licenses as $license)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-slate-900">{{ $license->license_number }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $license->issue_date ? $license->issue_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $license->expiration_date ? $license->expiration_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $license->issuing_authority ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $license->expiration_date && $license->expiration_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $license->expiration_date && $license->expiration_date->isFuture() ? 'Active' : 'Expired' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <x-ui.button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        squared
                                                        icon="pencil"
                                                        class="text-teal-600 hover:text-teal-800"
                                                        wire:click="editLicense({{ $license->id }})"
                                                        title="Edit" />
                                                    <x-ui.button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        squared
                                                        icon="trash"
                                                        class="text-red-600 hover:text-red-800"
                                                        wire:click="deleteLicense({{ $license->id }})"
                                                        wire:confirm="Are you sure you want to delete this license?"
                                                        title="Delete" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-slate-500 text-center py-8">No licenses added yet.</p>
                    @endif
                </div>

            @elseif($activeTab === 'certificate')
                <!-- Organization Certificate Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Organization Certificate Information</h3>
                    
                    <!-- Add Certificate Form -->
                    <div class="bg-slate-50 p-4 rounded-lg mb-4">
                        <h4 class="font-medium text-slate-900 mb-4">{{ $editingCertificateId ? 'Edit Certificate' : 'Add New Certificate' }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <x-ui.label for="org_certificate_number">Certificate Number <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_certificate_number" id="org_certificate_number" placeholder="Enter certificate number" />
                                @error('org_certificate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="org_certificate_issue_date">Issue Date <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_certificate_issue_date" type="date" id="org_certificate_issue_date" />
                                @error('org_certificate_issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-ui.label for="org_certificate_expiry_date">Expiry Date <span class="text-red-500">*</span></x-ui.label>
                                <x-ui.input wire:model="org_certificate_expiry_date" type="date" id="org_certificate_expiry_date" />
                                @error('org_certificate_expiry_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-3">
                                <x-ui.label for="org_certificate_issuing_organization">Issuing Organization</x-ui.label>
                                <x-ui.input wire:model="org_certificate_issuing_organization" id="org_certificate_issuing_organization" placeholder="Enter issuing organization" />
                                @error('org_certificate_issuing_organization') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4">
                            @if($editingCertificateId)
                                <x-ui.button
                                    type="button"
                                    variant="outline"
                                    color="slate"
                                    class="!px-5 uppercase tracking-wide text-xs"
                                    wire:click="resetCertificateForm">
                                    Cancel
                                </x-ui.button>
                            @endif
                            <x-ui.button
                                type="button"
                                color="teal"
                                variant="primary"
                                icon="{{ $editingCertificateId ? 'check' : 'plus' }}"
                                class="!px-5 uppercase tracking-wide text-xs"
                                wire:click="saveCertificate">
                                {{ $editingCertificateId ? 'Update Certificate' : 'Add Certificate' }}
                            </x-ui.button>
                        </div>
                    </div>
                    
                    <!-- Existing Certificates -->
                    @if(count($org_certificates) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Certificate Number</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issue Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Expiry Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Issuing Organization</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($org_certificates as $certificate)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-slate-900">{{ $certificate->certificate_number }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->expiration_date ? $certificate->expiration_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $certificate->issuing_organization ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $certificate->expiration_date && $certificate->expiration_date->isFuture() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $certificate->expiration_date && $certificate->expiration_date->isFuture() ? 'Active' : 'Expired' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <x-ui.button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        squared
                                                        icon="pencil"
                                                        class="text-teal-600 hover:text-teal-800"
                                                        wire:click="editCertificate({{ $certificate->id }})"
                                                        title="Edit" />
                                                    <x-ui.button
                                                        type="button"
                                                        variant="ghost"
                                                        size="sm"
                                                        squared
                                                        icon="trash"
                                                        class="text-red-600 hover:text-red-800"
                                                        wire:click="deleteCertificate({{ $certificate->id }})"
                                                        wire:confirm="Are you sure you want to delete this certificate?"
                                                        title="Delete" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-slate-500 text-center py-8">No certificates added yet.</p>
                    @endif
                </div>

            @elseif($activeTab === 'portals')
                <!-- Portals Tab -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-900">Portal Logins</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- NPPES Portal -->
                        <div class="space-y-4 bg-white p-6 rounded-lg border border-slate-200">
                            <h4 class="font-semibold text-teal-600 bg-teal-50 px-4 py-2 rounded-lg border border-teal-200">NPPES Portal</h4>
                            <div>
                                <x-ui.label for="nppes_login">NPPES Login (User ID)</x-ui.label>
                                <x-ui.input wire:model="nppes_login" id="nppes_login" placeholder="Enter NPPES login" />
                            </div>
                            <div>
                                <x-ui.label for="nppes_password">NPPES Password</x-ui.label>
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
                                <x-ui.label for="caqh_login">CAQH Login (User ID)</x-ui.label>
                                <x-ui.input wire:model="caqh_login" id="caqh_login" placeholder="Enter CAQH login" />
                            </div>
                            <div>
                                <x-ui.label for="caqh_password">CAQH Password</x-ui.label>
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
                                <x-ui.label for="availity_login">Availity Login (User ID)</x-ui.label>
                                <x-ui.input wire:model="availity_login" id="availity_login" placeholder="Enter Availity login" />
                            </div>
                            <div>
                                <x-ui.label for="availity_password">Availity Password</x-ui.label>
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
                    </div>

                    <!-- Save Button -->
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

            @elseif($activeTab === 'providers')
                <!-- Number of Providers Tab -->
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-slate-900">Number of Providers</h3>
                        <p class="text-sm text-slate-600">Total: {{ count($providers) }} providers</p>
                    </div>
                    
                    @if(count($providers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Ind NPI</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Phone</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Email</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">CAQH ID</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($providers as $provider)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-slate-900">{{ $provider->name }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $provider->npi_number ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $provider->phone ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $provider->email ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-600">{{ $provider->caqh_id ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50 rounded-lg border border-slate-200">
                            <p class="text-slate-500">No providers found for this organization.</p>
                        </div>
                    @endif
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
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Document Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">File Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Upload Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
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
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ $document->is_verified ? 'Verified' : 'Pending' }}
                                                    </span>
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
                                                            icon="pencil"
                                                            class="text-teal-600 hover:text-teal-800"
                                                            wire:click="openEditModal({{ $document->id }})" />
                                                        <x-ui.button
                                                            type="button"
                                                            variant="ghost"
                                                            size="sm"
                                                            squared
                                                            icon="trash"
                                                            class="text-red-600 hover:text-red-800"
                                                            wire:click="deleteDocument({{ $document->id }})"
                                                            wire:confirm="Are you sure you want to delete this document?" />
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-slate-500">No documents uploaded yet. Click "Upload Document" to get started.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Document Modal -->
    @if($showUploadModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeUploadModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Upload Document</h3>
                        <x-ui.button
                            type="button"
                            variant="ghost"
                            squared
                            size="sm"
                            icon="x-mark"
                            class="text-slate-400 hover:text-slate-600"
                            wire:click="closeUploadModal" />
                    </div>
                    <div class="space-y-4">
                        <div>
                            <x-ui.label for="selectedDocumentType">Document Type <span class="text-red-500">*</span></x-ui.label>
                            <select wire:model="selectedDocumentType" id="selectedDocumentType"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md">
                                <option value="">Select document type...</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedDocumentType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-ui.label for="documentFile">File <span class="text-red-500">*</span></x-ui.label>
                            <input type="file" wire:model="documentFile" id="documentFile" 
                                   class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
                            @error('documentFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-ui.label for="notes">Notes</x-ui.label>
                            <textarea wire:model="notes" id="notes" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                            @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="cloud-arrow-up"
                            wire:loading.attr="disabled"
                            wire:target="uploadDocument"
                            wire:click="uploadDocument">
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
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Document Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeEditModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Edit Document Notes</h3>
                        <x-ui.button
                            type="button"
                            variant="ghost"
                            squared
                            size="sm"
                            icon="x-mark"
                            class="text-slate-400 hover:text-slate-600"
                            wire:click="closeEditModal" />
                    </div>
                    <div>
                        <x-ui.label for="editNotes">Notes</x-ui.label>
                        <textarea wire:model="editNotes" id="editNotes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                        @error('editNotes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                            type="button"
                            color="teal"
                            variant="primary"
                            icon="check"
                            wire:loading.attr="disabled"
                            wire:target="updateDocument"
                            wire:click="updateDocument">
                            <span wire:loading.remove wire:target="updateDocument">Update</span>
                            <span wire:loading wire:target="updateDocument">Updating...</span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
