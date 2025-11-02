<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeViewModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                            License Details
                        </h3>

                        @if($license)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Provider Information -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Provider Information</h4>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Provider Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $license->user->name ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $license->user->email ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">State</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $license->state->name ?? 'N/A' }} ({{ $license->state->code ?? 'N/A' }})</p>
                                </div>
                            </div>

                            <!-- License Information -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">License Information</h4>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">License Type</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $license->licenseType->name ?? 'N/A' }} ({{ $license->licenseType->code ?? 'N/A' }})</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">License Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $license->license_number ?? 'Pending' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    @php
                                    $statusClass = match ($license->status->value ?? 'pending') {
                                        'active' => 'bg-green-100 text-green-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'requested' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($license->status->value ?? 'pending') }}
                                    </span>
                                </div>
                            </div>

                            <!-- License Details -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">License Details</h4>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $license->issue_date ? $license->issue_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Expiration Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $license->expiration_date ? $license->expiration_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $license->created_at ? $license->created_at->format('M d, Y g:i A') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Issuing Authority</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $license->issuing_authority ?? 'N/A' }}</p>
                            </div>

                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    @if($license->is_verified)
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-green-600 font-medium">Verified</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-600">Not Verified</span>
                                    @endif
                                </div>

                                @if($license->urgent)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-red-600 font-medium">Urgent Request</span>
                                </div>
                                @endif
                            </div>

                            @if($license->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <p class="text-sm text-gray-900">{{ $license->notes }}</p>
                            </div>
                            @endif

                            @if($license->document)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">License Document</label>
                                <div class="mt-2 flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ basename($license->document) }}
                                        </p>
                                        <p class="text-sm text-gray-500">License Document</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ asset('/' . $license->document) }}" target="_blank" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            View Document
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700">License Document</label>
                                <p class="mt-1 text-sm text-gray-500">No document uploaded</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                @if($license && $license->status->value !== 'pending')
                <button type="button"
                        wire:click="editLicense({{ $license->id }})"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Edit License
                </button>
                @endif
                <button type="button"
                        wire:click="closeViewModal"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
