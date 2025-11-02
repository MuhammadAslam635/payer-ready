<div>
    <!-- Page Header -->
    <x-breadcrumbs tagline="Overview of doctor credentials statistics and recent activity" />

    <!-- Information Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Provider Credentials Information</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>This section displays all provider credentials including professional certifications, licenses, and qualifications. Credentials are essential for provider verification and compliance with healthcare regulations.</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        <li><strong>Credential Name:</strong> The official name of the credential or certification</li>
                        <li><strong>Issuing Organization:</strong> The authority that issued the credential</li>
                        <li><strong>Status:</strong> Current status of the credential (Active, Pending, Expired, etc.)</li>
                        <li><strong>Verification:</strong> Whether the credential has been verified by administrators</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 my-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <x-ui.label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</x-ui.label>
                    <x-ui.input 
                        type="text" 
                        id="search"
                        class="w-full" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Doctor name, email, credential name..."
                    />
                </div>

                <!-- Status Filter -->
                <div>
                    <x-ui.label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Status</x-ui.label>
                    <x-ui.select class="w-full" wire:model.live="statusFilter" id="statusFilter">
                        <x-ui.select.option value="">All Statuses</x-ui.select.option>
                        @foreach($credentialStatuses as $value => $label)
                            <x-ui.select.option value="{{ $value }}">{{ $label }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                </div>

                <!-- State Filter -->
                <div>
                    <x-ui.label for="stateFilter" class="block text-sm font-medium text-gray-700 mb-2">State</x-ui.label>
                    <x-ui.select class="w-full" wire:model.live="stateFilter" id="stateFilter">
                        <x-ui.select.option value="">All States</x-ui.select.option>
                        @foreach($states as $state)
                            <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                </div>

                <!-- Payer Filter -->
                <div>
                    <x-ui.label for="payerFilter" class="block text-sm font-medium text-gray-700 mb-2">Payer</x-ui.label>
                    <x-ui.select class="w-full" wire:model.live="payerFilter" id="payerFilter">
                        <x-ui.select.option value="">All Payers</x-ui.select.option>
                        @foreach($payers as $payer)
                            <x-ui.select.option value="{{ $payer->id }}">{{ $payer->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                </div>

                <!-- Verification Filter -->
                <div>
                    <x-ui.label for="verificationFilter" class="block text-sm font-medium text-gray-700 mb-2">Verification</x-ui.label>
                    <x-ui.select class="w-full" wire:model.live="verificationFilter" id="verificationFilter">
                        <x-ui.select.option value="">All</x-ui.select.option>
                        <x-ui.select.option value="1">Verified</x-ui.select.option>
                        <x-ui.select.option value="0">Unverified</x-ui.select.option>
                    </x-ui.select>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-200">
                <!-- Start Date -->
                <div>
                    <x-ui.label for="startDate" class="block text-sm font-medium text-gray-700 mb-2">Start Date</x-ui.label>
                    <x-ui.input 
                        type="date" 
                        id="startDate"
                        class="w-full" 
                        wire:model.live="startDate"
                    />
                </div>

                <!-- End Date -->
                <div>
                    <x-ui.label for="endDate" class="block text-sm font-medium text-gray-700 mb-2">End Date</x-ui.label>
                    <x-ui.input 
                        type="date" 
                        id="endDate"
                        class="w-full" 
                        wire:model.live="endDate"
                    />
                </div>
            </div>

            <!-- Clear Filters Button -->
            <div class="mt-4 flex justify-end">
                <x-ui.button icon="arrow-path" size="sm" variant="primary"
                 class="bg-primary-500 rounded-md text-white" wire:click="clearFilters">
                  Clear Filters
                </x-ui.button>
            </div>
        </div>
    </div>

    <!-- Credentials Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            ID
                            @if($sortBy === 'id')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('credential_name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Credential Name
                            @if($sortBy === 'credential_name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuing Organization</th>
                        <th wire:click="sortBy('credential_number')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Credential Number
                            @if($sortBy === 'credential_number')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('status')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Status
                            @if($sortBy === 'status')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('expiration_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Expiration
                            @if($sortBy === 'expiration_date')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Created
                            @if($sortBy === 'created_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($credentials as $credential)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $credential->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $credential->credential_name ?: 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $credential->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $credential->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $credential->issuing_organization ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $credential->credential_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'requested' => 'bg-blue-100 text-blue-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'suspended' => 'bg-yellow-100 text-yellow-800',
                                        'revoked' => 'bg-red-100 text-red-800',
                                        'working' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800'
                                    ];
                                    $color = $statusColors[$credential->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($credential->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($credential->expiration_date)
                                    <span class="{{ $credential->expiration_date->isPast() ? 'text-red-600' : '' }}">
                                        {{ $credential->expiration_date->format('M d, Y') }}
                                    </span>
                                    @if($credential->expiration_date->isPast())
                                        <div class="text-xs text-red-600">Expired</div>
                                    @elseif($credential->expiration_date->diffInDays() <= 30)
                                        <div class="text-xs text-yellow-600">Expires soon</div>
                                    @endif
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($credential->is_verified)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Verified
                                    </span>
                                    @if($credential->verified_at)
                                        <div class="text-xs text-gray-500 mt-1">{{ $credential->verified_at->format('M d, Y') }}</div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $credential->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <x-ui.button 
                                        size="sm" 
                                        variant="primary" 
                                        wire:click="editCredential({{ $credential->id }})"
                                        class="bg-primary-500 rounded-md"
                                    >
                                        Edit Credential
                                    </x-ui.button>
                                    <x-ui.button 
                                        size="sm" 
                                        variant="danger" 
                                        wire:click="confirmDelete({{ $credential->id }})"
                                        class="bg-red-500 rounded-md"
                                    >
                                        Delete Credential
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-search text-4xl mb-4"></i>
                                    <p class="text-lg">No credentials found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($credentials->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $credentials->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Credential Modal -->
    @if($showEditModal && $selectedCredential)
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0,0,0,0.5);">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Edit Credential - {{ $selectedCredential->credential_name }}</h3>
                        <x-ui.button icon="clock" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" wire:click="closeModal">
                            
                        </x-ui.button>
                    </div>
                    <form wire:submit.prevent="updateCredential">
                        <div class="px-6 py-4">
                            <!-- Doctor Info (Read-only) -->
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <div class="text-sm">
                                    <strong>Doctor:</strong> {{ $selectedCredential->user->name }} ({{ $selectedCredential->user->email }})<br>
                                    <strong>State:</strong> {{ $selectedCredential->state->name ?? 'N/A' }}<br>
                                    <strong>Payer:</strong> {{ $selectedCredential->payer->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Credential Name -->
                                <div>
                                    <x-ui.label for="editCredentialName" class="block text-sm font-medium text-gray-700 mb-2">Credential Name *</x-ui.label>
                                    <x-ui.input 
                                        type="text"  
                                        wire:model="editCredentialName"
                                    />
                                    <x-ui.error name="editCredentialName" />
                                </div>

                                <!-- Issuing Organization -->
                                <div>
                                    <x-ui.label for="editIssuingOrganization" class="block text-sm font-medium text-gray-700 mb-2">Issuing Organization *</x-ui.label>
                                    <x-ui.input 
                                        type="text" 
                                        wire:model="editIssuingOrganization"
                                    />
                                 <x-ui.error name="editIssuingOrganization" />
                                </div>

                                <!-- Credential Number -->
                                <div>
                                    <x-ui.label for="editCredentialNumber" class="block text-sm font-medium text-gray-700 mb-2">Credential Number *</x-ui.label>
                                    <x-ui.input 
                                        type="text" 
                                        wire:model="editCredentialNumber"
                                    />
                                    <x-ui.label name="editCredentialNumber" />
                                </div>

                                <!-- Status -->
                                <div>
                                    <x-ui.label for="editStatus" class="block text-sm font-medium text-gray-700 mb-2">Status *</x-ui.label>
                                    <x-ui.select class="w-full"  wire:model="editStatus">
                                        <x-ui.select.option value="">Select Status</x-ui.select.option>
                                        @foreach($credentialStatuses as $value => $label)
                                            <x-ui.select.option value="{{ $value }}">{{ $label }}</x-ui.select.option>
                                        @endforeach
                                    </x-ui.select>
                                    <x-ui.error name="editStatus" />
                                </div>

                                <!-- Issue Date -->
                                <div>
                                    <x-ui.label for="editIssueDate" class="block text-sm font-medium text-gray-700 mb-2">Issue Date</x-ui.label>
                                    <x-ui.input 
                                        type="date" 
                                        wire:model="editIssueDate"
                                    />
                                    <x-ui.error name="editIssueDate" />
                                </div>

                                <!-- Expiration Date -->
                                <div>
                                    <x-ui.label for="editExpirationDate" class="block text-sm font-medium text-gray-700 mb-2">Expiration Date</x-ui.label>
                                    <x-ui.input 
                                        type="date" 
                                        wire:model="editExpirationDate"
                                    />
                                    <x-ui.label name="editExpirationDate" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <x-ui.label for="editDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</x-ui.label>
                                <x-ui.textarea
                                    wire:model="editDescription"
                                 />
                                 <x-ui.error name="editDescription" />
                            </div>

                            <!-- Verification Status -->
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                        wire:model="editIsVerified"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">Mark as Verified</span>
                                </label>
                            </div>

                            <!-- Verification Notes -->
                            <div class="mt-4">
                                <x-ui.label for="editVerificationNotes" class="block text-sm font-medium text-gray-700 mb-2">Verification Notes</x-ui.label>
                                <textarea 
                                    id="editVerificationNotes"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('editVerificationNotes') border-red-500 @enderror" 
                                    rows="3" 
                                    wire:model="editVerificationNotes"
                                ></textarea>
                                @error('editVerificationNotes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                            <x-ui.button type="button" variant="outline" class="outline-primary-500 rounded-md" wire:click="closeModal">Cancel</x-ui.button>
                            <x-ui.button type="submit" variant="primary" class="bg-primary-500 rounded-md">Update Credential</x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $selectedCredential)
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0,0,0,0.5);">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
                        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" wire:click="closeModal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="px-6 py-4">
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                                <div>
                                    <strong class="text-yellow-800">Warning!</strong>
                                    <p class="text-yellow-700 text-sm mt-1">This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">Are you sure you want to delete this credential?</p>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm">
                                <strong>Credential Name:</strong> {{ $selectedCredential->credential_name }}<br>
                                <strong>Doctor:</strong> {{ $selectedCredential->user->name }}<br>
                                <strong>Credential Number:</strong> {{ $selectedCredential->credential_number }}<br>
                                <strong>Status:</strong> {{ ucfirst($selectedCredential->status) }}
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                        <x-ui.button type="button" variant="outline" wire:click="closeModal">Cancel</x-ui.button>
                        <x-ui.button type="button" variant="danger" wire:click="deleteCredential">
                            <i class="fas fa-trash mr-2"></i> Delete Credential
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
