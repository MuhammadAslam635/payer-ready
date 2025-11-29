<div class="space-y-6">

    <!-- Information Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Application Status Management</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p><strong>Status Changes:</strong> Payer enrollment application statuses can be changed manually by organization administrators.</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        <li><strong>Manual Control:</strong> Use the quick action buttons next to each application to change status</li>
                        <li><strong>Available Statuses:</strong> Requested, Working, Pending, Completed, Return for Correction</li>
                        <li><strong>Workflow:</strong> Requested → Working → Pending → Completed</li>
                        <li><strong>Quick Actions:</strong> Click status buttons for immediate status updates</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Doctor Payer Enrollments</h1>
        <button wire:click="openRequestModal"
            class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Request New Payer</span>
        </button>
    </div>

    <!-- Tabs Section -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setActiveTab('all')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'all' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                All
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['all'] ?? 0 }}</span>
            </button>
            <button wire:click="setActiveTab('requested')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'requested' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Requested
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['requested'] ?? 0 }}</span>
            </button>
            <button wire:click="setActiveTab('working')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'working' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Working
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['working'] ?? 0 }}</span>
            </button>
            <button wire:click="setActiveTab('pending')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'pending' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pending Payer
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['pending'] ?? 0 }}</span>
            </button>
            <button wire:click="setActiveTab('completed')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'completed' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Completed
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['completed'] ?? 0 }}</span>
            </button>
            <button wire:click="setActiveTab('return_for_correction')"
                class="py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'return_for_correction' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Return for Correction
                <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs">{{ $stats['return_for_correction'] ?? 0 }}</span>
            </button>
        </nav>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PAYER</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">REQUEST TYPE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PROVIDER</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $enrollment->payer->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->state->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \App\Enums\CredentialRequest::from($enrollment->request_type)->label() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $enrollment['status'] === 'Completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($enrollment['status'] === 'Working'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($enrollment['status'] === 'Requested'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $enrollment['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @php
                                        $currentStatus = strtolower(str_replace(' ', '_', (string)$enrollment->status));
                                    @endphp
                                    
                                    @if($currentStatus === 'requested')
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'working')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded hover:bg-yellow-100 transition-colors"
                                                title="Start Working">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1"/>
                                            </svg>
                                            Start Working
                                        </button>
                                    @elseif($currentStatus === 'working')
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'pending')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition-colors"
                                                title="Move to Pending">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Pending
                                        </button>
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'completed')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded hover:bg-green-100 transition-colors"
                                                title="Complete">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Complete
                                        </button>
                                    @elseif($currentStatus === 'pending')
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'working')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded hover:bg-yellow-100 transition-colors"
                                                title="Back to Working">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                            </svg>
                                            Back to Working
                                        </button>
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'completed')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded hover:bg-green-100 transition-colors"
                                                title="Complete">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Complete
                                        </button>
                                    @elseif($currentStatus === 'completed')
                                        <button wire:click="updateEnrollmentStatus({{ $enrollment->id }}, 'working')" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded hover:bg-yellow-100 transition-colors"
                                                title="Reopen">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                            </svg>
                                            Reopen
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Loading applications...</p>
                                    <p class="text-sm text-gray-400 mt-1">Your payer enrollment applications will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Request New Payer Modal -->
    @if ($showRequestModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeRequestModal"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900" id="modal-title">Request New Payer Enrollment</h3>
                            <button wire:click="closeRequestModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <form wire:submit="submitRequest">
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-teal-500 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">1</div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select Provider Type</h4>
                                        <p class="text-xs text-gray-500">Choose provider type for this enrollment request</p>
                                    </div>
                                </div>
                                <x-ui.select wire:model.live="providerType" :invalid="$errors->has('providerType')">
                                    <x-ui.select.option value="">Select provider type...</x-ui.select.option>
                                    <x-ui.select.option value="provider">Provider</x-ui.select.option>
                                    <x-ui.select.option value="organization">Organization</x-ui.select.option>
                                </x-ui.select>
                                <x-ui.error name="providerType" />
                            </div>

                            @if($providerType === 'organization')
                                <div class="mb-6">
                                    <div class="flex items-center mb-3">
                                        <div class="w-8 h-8 {{ $providerType ? 'bg-teal-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">2</div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Organization</h4>
                                            <p class="text-xs text-gray-500">Organization name (read-only)</p>
                                        </div>
                                    </div>
                                    <input type="text" 
                                           value="{{ Auth::user()->business_name ?? Auth::user()->name }}" 
                                           readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                            @elseif($providerType === 'provider')
                                <div class="mb-6">
                                    <div class="flex items-center mb-3">
                                        <div class="w-8 h-8 {{ $providerType ? 'bg-teal-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">2</div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Select Provider</h4>
                                            <p class="text-xs text-gray-500">Choose the individual provider for this enrollment request</p>
                                        </div>
                                    </div>
                                    <x-ui.select wire:model="selectedProvider" searchable :invalid="$errors->has('selectedProvider')">
                                        <x-ui.select.option value="">Select a provider...</x-ui.select.option>
                                        @foreach ($this->individualProviders as $provider)
                                            <x-ui.select.option value="{{ $provider->id }}">{{ $provider->name }}</x-ui.select.option>
                                        @endforeach
                                    </x-ui.select>
                                    <x-ui.error name="selectedProvider" />
                                </div>
                            @endif

                            @if($providerType)
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 {{ $selectedPayer ? 'bg-teal-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">3</div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select Payer</h4>
                                        <p class="text-xs text-gray-500">Choose a payer. Payers the provider is already enrolled with are hidden.</p>
                                    </div>
                                </div>
                                <x-ui.select wire:model.live="selectedPayer" searchable :invalid="$errors->has('selectedPayer')">
                                    <x-ui.select.option value="">Select a payer...</x-ui.select.option>
                                    @foreach ($payers as $payer)
                                        <x-ui.select.option value="{{ $payer->id }}">{{ $payer->name }}</x-ui.select.option>
                                    @endforeach
                                </x-ui.select>
                                <x-ui.error name="selectedPayer" />
                            </div>

                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 {{ $selectedState ? 'bg-teal-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">4</div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select State</h4>
                                        <p class="text-xs text-gray-500">Choose the state for this enrollment</p>
                                    </div>
                                </div>
                                <x-ui.select wire:model.live="selectedState" searchable :invalid="$errors->has('selectedState')">
                                    <x-ui.select.option value="">Select a state...</x-ui.select.option>
                                    @foreach ($states as $state)
                                        <x-ui.select.option value="{{ $state->id }}">{{ $state->name }} ({{ $state->code }})</x-ui.select.option>
                                    @endforeach
                                </x-ui.select>
                                <x-ui.error name="selectedState" />
                            </div>

                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 {{ $selectedRequestType ? 'bg-teal-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">5</div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select Request Type</h4>
                                        <p class="text-xs text-gray-500">Is this a new enrollment or re-credentialing?</p>
                                    </div>
                                </div>
                                <x-ui.select wire:model.live="selectedRequestType" :invalid="$errors->has('selectedRequestType')">
                                    <x-ui.select.option value="">Select request type...</x-ui.select.option>
                                    @foreach (\App\Enums\CredentialRequest::values() as $requestType)
                                        <x-ui.select.option value="{{ $requestType }}">{{ $requestType }}</x-ui.select.option>
                                    @endforeach
                                </x-ui.select>
                                <x-ui.error name="selectedRequestType" />
                            </div>
                            @endif
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">Submit Request</button>
                                <button type="button" wire:click="closeRequestModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


