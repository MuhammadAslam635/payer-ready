<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Provider Certifications</h1>
                    <p class="mt-1 text-sm text-slate-600">Manage your professional certifications and credentials.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <x-ui.button icon="plus" variant="primary" wire:click="openAddModal">
                        Add Certificate
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="px-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                <button wire:click="setActiveTab('all')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'all' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    All
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'all' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $certificateCounts['all'] }}
                    </span>
                </button>
                <button wire:click="setActiveTab('current')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'current' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Current
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'current' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $certificateCounts['current'] }}
                    </span>
                </button>
                <button wire:click="setActiveTab('expiring')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'expiring' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Expiring Soon
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'expiring' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $certificateCounts['expiring'] }}
                    </span>
                </button>
                <button wire:click="setActiveTab('expired')"
                    class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'expired' ? 'border-teal-500 text-teal-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                    Expired
                    <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $activeTab === 'expired' ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-900' }}">
                        {{ $certificateCounts['expired'] }}
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
                        placeholder="Search certificates...">
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-slate-700">Sort by:</label>
                    <select wire:change="sortBy($event.target.value)"
                        class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="created_at">Date Added</option>
                        <option value="certificate_name">Certificate Name</option>
                        <option value="expiration_date">Expiry Date</option>
                        <option value="issuing_organization">Issuing Organization</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificates Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Provider Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Certificate Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Certificate Number/ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Type of Certificate
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Issuing Entity/Board
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Expiry Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($this->certificates as $certificate)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-teal-800">
                                                {{ substr($certificate->user->name ?? 'U', 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $certificate->user->name ?? 'Unknown Provider' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $certificate->certificate_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $certificate->certificate_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $certificate->certificateType->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $certificate->issuing_organization }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = $certificate->is_current ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                    $statusText = $certificate->is_current ? 'Current' : 'Expired';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                @if ($certificate->expiration_date)
                                    {{ $certificate->expiration_date->format('m/d/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewCertificate({{ $certificate->id }})" class="text-teal-600 hover:text-teal-900" title="View Certificate Details">
                                        <x-ui.icon name="eye" class="w-4 h-4" />
                                    </button>
                                    <button wire:click="editCertificate({{ $certificate->id }})" class="text-blue-600 hover:text-blue-900" title="Edit Certificate">
                                        <x-ui.icon name="pencil" class="w-4 h-4" />
                                    </button>
                                    <button wire:click="delete({{ $certificate->id }})" class="text-red-600 hover:text-red-900" title="Delete Certificate">
                                        <x-ui.icon name="trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">
                                No certificates found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($this->certificates->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $this->certificates->links() }}
            </div>
        @endif
    </div>

    <!-- Add Certificate Modal -->
    <div x-data="{ show: @entangle('showAddModal') }" x-show="show" x-cloak>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$wire.closeAddModal()"></div>
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Add New Certificate</h3>
                <button wire:click="closeAddModal" class="text-slate-400 hover:text-slate-600">
                    <x-ui.icon name="x-mark" class="w-6 h-6" />
                </button>
            </div>

            <form wire:submit="saveCertificate" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-ui.label for="add_certificate_type_id">Type of Certificate <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.select wire:model="addForm.certificate_type_id" id="add_certificate_type_id">
                            <option value="">Select certificate type...</option>
                            @foreach($certificateTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                    @if($type->default_amount)
                                        - ${{ number_format($type->default_amount, 2) }}
                                    @endif
                                </option>
                            @endforeach
                        </x-ui.select>
                        <p class="mt-1 text-xs text-slate-500">Default Amount: The standard cost for obtaining this certificate type</p>
                        @error('addForm.certificate_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="add_certificate_name">Certificate Name <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="addForm.certificate_name" id="add_certificate_name" placeholder="Enter certificate name" />
                        @error('addForm.certificate_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="add_certificate_number">Certificate Number/ID <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="addForm.certificate_number" id="add_certificate_number" placeholder="Enter certificate number" />
                        @error('addForm.certificate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="add_issuing_organization">Issuing Entity/Board <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="addForm.issuing_organization" id="add_issuing_organization" placeholder="Enter issuing organization" />
                        @error('addForm.issuing_organization') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="add_issue_date">Issue Date <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="addForm.issue_date" type="date" id="add_issue_date" />
                        @error('addForm.issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="add_expiration_date">Expiry Date</x-ui.label>
                        <x-ui.input wire:model="addForm.expiration_date" type="date" id="add_expiration_date" />
                        @error('addForm.expiration_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <x-ui.label for="add_notes">Notes</x-ui.label>
                    <x-ui.textarea wire:model="addForm.notes" id="add_notes" rows="3" placeholder="Enter any additional notes..." />
                    @error('addForm.notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="addForm.is_current" id="add_is_current" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                    <x-ui.label for="add_is_current" class="ml-2">This certificate is currently valid</x-ui.label>
                </div>

                <div class="flex justify-end space-x-3">
                    <x-ui.button type="button" variant="ghost" wire:click="closeAddModal">Cancel</x-ui.button>
                    <x-ui.button type="submit" variant="primary">Add Certificate</x-ui.button>
                </div>
            </form>
        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Certificate Modal -->
    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-cloak>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$wire.closeEditModal()"></div>
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Edit Certificate</h3>
                <button wire:click="closeEditModal" class="text-slate-400 hover:text-slate-600">
                    <x-ui.icon name="x-mark" class="w-6 h-6" />
                </button>
            </div>

            <form wire:submit="updateCertificate" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-ui.label for="edit_certificate_type_id">Type of Certificate <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.select wire:model="editForm.certificate_type_id" id="edit_certificate_type_id">
                            <option value="">Select certificate type...</option>
                            @foreach($certificateTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                    @if($type->default_amount)
                                        - ${{ number_format($type->default_amount, 2) }}
                                    @endif
                                </option>
                            @endforeach
                        </x-ui.select>
                        <p class="mt-1 text-xs text-slate-500">Default Amount: The standard cost for obtaining this certificate type</p>
                        @error('editForm.certificate_type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="edit_certificate_name">Certificate Name <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="editForm.certificate_name" id="edit_certificate_name" placeholder="Enter certificate name" />
                        @error('editForm.certificate_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="edit_certificate_number">Certificate Number/ID <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="editForm.certificate_number" id="edit_certificate_number" placeholder="Enter certificate number" />
                        @error('editForm.certificate_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="edit_issuing_organization">Issuing Entity/Board <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="editForm.issuing_organization" id="edit_issuing_organization" placeholder="Enter issuing organization" />
                        @error('editForm.issuing_organization') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="edit_issue_date">Issue Date <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.input wire:model="editForm.issue_date" type="date" id="edit_issue_date" />
                        @error('editForm.issue_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-ui.label for="edit_expiration_date">Expiry Date</x-ui.label>
                        <x-ui.input wire:model="editForm.expiration_date" type="date" id="edit_expiration_date" />
                        @error('editForm.expiration_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <x-ui.label for="edit_notes">Notes</x-ui.label>
                    <x-ui.textarea wire:model="editForm.notes" id="edit_notes" rows="3" placeholder="Enter any additional notes..." />
                    @error('editForm.notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="editForm.is_current" id="edit_is_current" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                    <x-ui.label for="edit_is_current" class="ml-2">This certificate is currently valid</x-ui.label>
                </div>

                <div class="flex justify-end space-x-3">
                    <x-ui.button type="button" variant="ghost" wire:click="closeEditModal">Cancel</x-ui.button>
                    <x-ui.button type="submit" variant="primary">Update Certificate</x-ui.button>
                </div>
            </form>
        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Certificate Modal -->
    <div x-data="{ show: @entangle('showViewModal') }" x-show="show" x-cloak>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$wire.closeViewModal()"></div>
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Certificate Details</h3>
                <button wire:click="closeViewModal" class="text-slate-400 hover:text-slate-600">
                    <x-ui.icon name="x-mark" class="w-6 h-6" />
                </button>
            </div>

            @if($selectedCertificate)
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Provider Name</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Certificate Name</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->certificate_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Certificate Number/ID</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->certificate_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Type of Certificate</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->certificateType->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Issuing Entity/Board</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->issuing_organization }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <p class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $selectedCertificate->is_current ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $selectedCertificate->is_current ? 'Current' : 'Expired' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Issue Date</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->issue_date ? $selectedCertificate->issue_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Expiry Date</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->expiration_date ? $selectedCertificate->expiration_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($selectedCertificate->notes)
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Notes</label>
                            <p class="mt-1 text-sm text-slate-900">{{ $selectedCertificate->notes }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex justify-end mt-6">
                <x-ui.button type="button" variant="ghost" wire:click="closeViewModal">Close</x-ui.button>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-cloak>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$wire.cancelDelete()"></div>
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <x-ui.icon name="exclamation-triangle" class="w-6 h-6 text-red-600" />
            </div>
            <div class="text-center">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Delete Certificate</h3>
                <p class="text-sm text-slate-600 mb-6">Are you sure you want to delete this certificate? This action cannot be undone.</p>
                <div class="flex justify-center space-x-3">
                    <x-ui.button type="button" variant="ghost" wire:click="cancelDelete">Cancel</x-ui.button>
                    <x-ui.button type="button" variant="danger" wire:click="confirmDelete">Delete</x-ui.button>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
