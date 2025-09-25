<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Provider Licensing</h1>
                    <p class="mt-1 text-sm text-slate-600">Manage provider licenses, renewals, and regulations.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex flex-col lg:flex-row space-x-3">
                    <x-ui.button variant="ghost" class="bg-slate-100 text-slate-900 text-xs hover:bg-slate-200 rounded-md">Export CSV</x-ui.button>
                    <x-ui.button icon="plus" variant="primary" wire:click.prevent="openAddModal" wire:target="openAddModal" wire:loading.attr="disabled"
                        class="bg-teal-500 rounded-md text-white text-xs hover:bg-teal-600">
                        Add License
                    </x-ui.button>
                    <x-ui.button icon="plus" variant="primary"
                        class="bg-black rounded-md text-white text-xs hover:bg-gray-900" wire:click="openRequestModal">
                        Request License
                    </x-ui.button>

                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="px-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button wire:click="$set('activeTab', 'all')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'all' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    All
                    <span
                        class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'all' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $licenseCounts['all'] }}
                    </span>
                </button>
                <button wire:click="$set('activeTab', 'active')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'active' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Active
                    <span
                        class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'active' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $licenseCounts['active'] }}
                    </span>
                </button>
                <button wire:click="$set('activeTab', 'expiring')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'expiring' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Expiring
                    <span
                        class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'expiring' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $licenseCounts['expiring'] }}
                    </span>
                </button>
                <button wire:click="$set('activeTab', 'expired')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'expired' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Expired
                    <span
                        class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'expired' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $licenseCounts['expired'] }}
                    </span>
                </button>
                <button wire:click="$set('activeTab', 'pending')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'pending' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Pending
                    <span
                        class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'pending' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $licenseCounts['pending'] }}
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex-1 max-w-lg">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-ui.icon name="magnifying-glass" class="h-5 w-5 text-slate-400" />
                    </div>
                    <input wire:model.live="search" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                        placeholder="Search provider, license, number...">
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-slate-700">Sort by:</label>
                    <select wire:change="sortBy($event.target.value)"
                        class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="created_at">Date Added</option>
                        <option value="license_type">License Type</option>
                        <option value="expiration_date">Expiry Date</option>
                        <option value="state">State</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Licenses Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Provider
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            License Type
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Number
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Expiry Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($licenses as $license)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-teal-800">
                                                {{ substr($license->user->name ?? 'U', 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $license->user->name ?? 'Unknown Provider' }}
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            {{ $license->state->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ $license->licenseType->name ?? 'N/A' }}</div>
                                <div class="text-sm text-slate-500">{{ $license->licenseType->code ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $license->license_number ?? 'Pending' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                @if ($license->expiration_date)
                                    {{ $license->expiration_date->format('m/d/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = match ($license->status->value ?? 'pending') {
                                        'active' => 'bg-green-100 text-green-800',
                                        'expired' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($license->status->value ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewLicense({{ $license->id }})" class="text-teal-600 hover:text-teal-900" title="View License Details">
                                        <x-ui.icon name="eye" class="w-4 h-4" />
                                    </button>
                                    @if($license->status->value !== 'pending')
                                    <button wire:click="editLicense({{ $license->id }})" class="text-blue-600 hover:text-blue-900" title="Edit License">
                                        <x-ui.icon name="pencil" class="w-4 h-4" />
                                    </button>
                                    @endif
                                    <button wire:click="delete({{ $license->id }})" class="text-red-600 hover:text-red-900" title="Delete License">
                                        <x-ui.icon name="trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-500">
                                    <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No licenses match your search
                                    </h3>
                                    <p class="mt-1 text-sm text-slate-500">Try adjusting your search or filter to find
                                        what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add License Modal -->
    @if($showAddModal)
    <x-doctor.add-license-modal :selectedProvider="$selectedProvider" />
    @endif
    
    <!-- Request New License Modal -->
    @if($showRequestModal)
    <x-doctor.request-license-modal />
    @endif

    <!-- View License Modal -->
    @if($showViewModal && $selectedLicense)
    <x-doctor.view-license-modal :license="$selectedLicense" />
    @endif

    <!-- Edit License Modal -->
    @if($showEditModal && $selectedLicense)
    <x-doctor.edit-license-modal :license="$selectedLicense" :license-types="$licenseTypes" :states="$states" />
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <x-ui.icon name="exclamation-triangle" class="h-6 w-6 text-red-600" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete License
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this license? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmDelete"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button wire:click="cancelDelete"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
