<div>
    <!-- Page Header -->
    <x-breadcrumbs tagline="Overview of doctor certificate statistics and recent activity" />

    <!-- Filters Section -->
    <div class="bg-white shadow rounded-lg my-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <x-ui.label>Search</x-ui.label>
                    <x-ui.input type="text" class="w-full" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Doctor name, email, certificate name..." />
                </div>

                <!-- Certificate Type Filter -->
                <div>
                    <x-ui.label>Certificate Type</x-ui.label>
                    <x-ui.select class="w-full" 
                            wire:model.live="certificateTypeFilter">
                        <x-ui.select.option value="">All Types</x-ui.select.option>
                        @foreach($certificateTypes as $type)
                            <x-ui.select.option value="{{ $type->id }}">{{ $type->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div>
                    <x-ui.label>Status</x-ui.label>
                    <x-ui.select class="w-full" 
                            wire:model.live="statusFilter">
                        <x-ui.select.option value="">All Statuses</x-ui.select.option>
                        <x-ui.select.option value="current">Current</x-ui.select.option>
                        <x-ui.select.option value="expired">Expired</x-ui.select.option>
                    </x-ui.select>
                </div>
            </div>

            <!-- Clear Filters -->
            <div class="mt-4 flex justify-end">
                <x-ui.button size="sm" variant="primary" icon="arrow-path"
                 class="bg-primary-500 rounded-md text-white" 
                        wire:click="clearFilters">
                    Clear Filters
                </x-ui.button>
            </div>
        </div>
    </div>

    <!-- Certificates Table -->
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 select-none">
                            <div class="flex items-center">
                                ID
                                @if($sortBy === 'id')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('certificate_name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 select-none">
                            <div class="flex items-center">
                                Certificate Name
                                @if($sortBy === 'certificate_name')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuing Organization</th>
                        <th wire:click="sortBy('expiration_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 select-none">
                            <div class="flex items-center">
                                Expiration
                                @if($sortBy === 'expiration_date')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 select-none">
                            <div class="flex items-center">
                                Created
                                @if($sortBy === 'created_at')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($certificates as $certificate)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $certificate->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $certificate->certificate_name }}</div>
                                <div class="text-sm text-gray-500">{{ $certificate->certificate_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $certificate->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $certificate->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $certificate->certificateType->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $certificate->issuing_organization }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($certificate->expiration_date)
                                    <div class="{{ $certificate->expiration_date->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $certificate->expiration_date->format('M d, Y') }}
                                    </div>
                                    @if($certificate->expiration_date->isPast())
                                        <div class="text-xs text-red-600">Expired</div>
                                    @elseif($certificate->expiration_date->diffInDays() <= 30)
                                        <div class="text-xs text-yellow-600">Expires soon</div>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($certificate->is_current)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Current
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $certificate->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <x-ui.button size="sm" variant="primary" 
                                            wire:click="editCertificate({{ $certificate->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </x-ui.button>
                                    <x-ui.button size="sm" variant="danger" 
                                            wire:click="confirmDelete({{ $certificate->id }})"
                                            class="text-red-600 hover:text-red-900">
                                        Delete
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                No certificates found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $certificates->links() }}
        </div>
    </div>

    <!-- Edit Certificate Modal -->
    @if($showEditModal && $selectedCertificate)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Certificate</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <x-ui.label for="editCertificateName">Certificate Name</x-ui.label>
                                <x-ui.input type="text" id="editCertificateName" wire:model="editCertificateName" class="w-full" />
                                @error('editCertificateName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <x-ui.label for="editCertificateNumber">Certificate Number</x-ui.label>
                                <x-ui.input type="text" id="editCertificateNumber" wire:model="editCertificateNumber" class="w-full" />
                                @error('editCertificateNumber') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <x-ui.label for="editIssuingOrganization">Issuing Organization</x-ui.label>
                                <x-ui.input type="text" id="editIssuingOrganization" wire:model="editIssuingOrganization" class="w-full" />
                                @error('editIssuingOrganization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-ui.label for="editIssueDate">Issue Date</x-ui.label>
                                    <x-ui.input type="date" id="editIssueDate" wire:model="editIssueDate" class="w-full" />
                                    @error('editIssueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <x-ui.label for="editExpirationDate">Expiration Date</x-ui.label>
                                    <x-ui.input type="date" id="editExpirationDate" wire:model="editExpirationDate" class="w-full" />
                                    @error('editExpirationDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="editIsCurrent" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Is Current</span>
                                </label>
                            </div>
                            
                            <div>
                                <x-ui.label for="editNotes">Notes</x-ui.label>
                                <textarea id="editNotes" wire:model="editNotes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                @error('editNotes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <x-ui.button wire:click="updateCertificate" class="w-full sm:w-auto sm:ml-3 bg-indigo-600 hover:bg-indigo-700 text-white">
                            Update Certificate
                        </x-ui.button>
                        <x-ui.button wire:click="closeModal" variant="secondary" class="mt-3 w-full sm:mt-0 sm:w-auto">
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $selectedCertificate)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Certificate</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete the certificate "{{ $selectedCertificate->certificate_name }}"? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <x-ui.button wire:click="deleteCertificate" class="w-full sm:w-auto sm:ml-3 bg-red-600 hover:bg-red-700 text-white">
                            Delete
                        </x-ui.button>
                        <x-ui.button wire:click="closeModal" variant="secondary" class="mt-3 w-full sm:mt-0 sm:w-auto">
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>

