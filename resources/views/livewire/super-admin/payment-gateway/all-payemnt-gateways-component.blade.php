<div>
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Payment Gateways</h1>
                <p class="mt-1 text-sm text-gray-600">Manage payment gateways and their configurations</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button wire:click="openCreateModal"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Payment Gateway
                </button>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Search payment gateways...">
                    </div>
                </div>
                <div class="sm:w-48">
                    <select wire:model.live="statusFilter"
                        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Gateways Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h5 class="text-lg font-semibold text-gray-900 mb-0">
                <i class="fas fa-credit-card mr-2 text-blue-600"></i>Payment Gateways
            </h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paymentGateways as $gateway)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($gateway->barcode_screenshot_path)
                                        <div class="mr-3">
                                            <img src="{{ asset($gateway->barcode_screenshot_path) }}"
                                                alt="Barcode" class="w-10 h-10 rounded shadow-sm object-cover">
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $gateway->name }}</div>
                                        @if ($gateway->description)
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ Str::limit($gateway->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $gateway->code }}</code>
                                @if ($gateway->wallet_uri)
                                    <div class="mt-1">
                                        <small class="text-blue-600">
                                            <i class="fas fa-link mr-1"></i>URI Available
                                        </small>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-900">{{ $gateway->provider }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $gateway->is_local_payment ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    <i class="fas {{ $gateway->is_local_payment ? 'fa-map-marker-alt' : 'fa-globe' }} mr-1"></i>
                                    {{ $gateway->is_local_payment ? 'Local' : 'Online' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $gateway->is_test_mode ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    <i
                                        class="fas {{ $gateway->is_test_mode ? 'fa-flask' : 'fa-check-circle' }} mr-1"></i>
                                    {{ $gateway->is_test_mode ? 'Test' : 'Live' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $gateway->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $gateway->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-md text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200"
                                        wire:click="openEditModal({{ $gateway->id }})" title="Edit Gateway">
                                        <x-ui.icon  name="pencil-square" class="mr-3" />Edit
                                    </button>
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-all duration-200"
                                        wire:click="openDeleteModal({{ $gateway->id }})" title="Delete Gateway">
                                        <x-ui.icon name="trash" class="mr-3"></x-ui.icon>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <div class="mb-4">
                                        <i class="fas fa-credit-card text-4xl text-gray-300"></i>
                                    </div>
                                    <h5 class="text-lg font-medium text-gray-900 mb-3">No payment gateways found</h5>
                                    <p class="text-gray-500 mb-4">Get started by adding your first payment gateway</p>
                                    <button type="button"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 transition-colors"
                                        wire:click="openCreateModal">
                                        <i class="fas fa-plus mr-2"></i>Add First Payment Gateway
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if ($paymentGateways->hasPages())
                <div class="flex justify-center py-4 border-t border-gray-200 bg-gray-50">
                    {{ $paymentGateways->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($showCreateModal || $showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModals">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full">
                    <form wire:submit.prevent="{{ $showCreateModal ? 'create' : 'update' }}">
                        <div class="bg-teal-600 text-white px-6 py-4 flex items-center justify-between">
                            <h3 class="text-xl font-bold flex items-center" id="modal-title">
                                <x-ui.icon name="{{ $showCreateModal ? 'plus' : 'pencil-square' }}" />
                                {{ $showCreateModal ? 'Create New Payment Gateway' : 'Edit Payment Gateway' }}
                            </h3>
                            <button type="button" class="text-white hover:text-gray-200 transition-colors"
                                wire:click="closeModals">
                                <x-ui.icon name="clock" />
                            </button>
                        </div>
                        <div class="p-6 max-h-[70vh] overflow-y-auto">
                            <div class="grid grid-cols-1 gap-4">
                                <!-- Basic Information Section -->
                                <div class="w-full">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg">
                                        <div class="px-4 py-3 border-b border-gray-200">
                                            <h6 class="text-teal-600 font-bold mb-0 flex items-center">
                                                <x-ui.icon name="information-circle" />Basic Information
                                            </h6>
                                        </div>
                                        <div class="p-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name
                                                        *</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror"
                                                        wire:model="name" placeholder="e.g., PayPal, Stripe">
                                                    @error('name')
                                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Code
                                                        *</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('code') border-red-500 @enderror"
                                                        wire:model="code"
                                                        placeholder="e.g., paypal, stripe, bkash_qr">
                                                    @error('code')
                                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-gray-500 text-sm">For local payments, use this
                                                        for barcode/QR code or wallet URI</small>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                                    <textarea
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('description') border-red-500 @enderror"
                                                        wire:model="description" rows="3" placeholder="Brief description of the payment method"></textarea>
                                                    @error('description')
                                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 mb-2">Provider
                                                        *</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('provider') border-red-500 @enderror"
                                                        wire:model="provider"
                                                        placeholder="e.g., PayPal Inc., bKash, Nagad">
                                                    @error('provider')
                                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="flex items-center">
                                                    <label class="flex items-center">
                                                        <input
                                                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2"
                                                            type="checkbox" wire:model.live="is_local_payment">
                                                        <span class="ml-2 text-sm font-semibold text-gray-700">Local
                                                            Payment Method</span>
                                                    </label>
                                                    <div class="ml-2">
                                                        <small class="text-gray-500 text-sm">Enable for QR codes,
                                                            bKash, Nagad, etc.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Local Payment Configuration -->
                                @if ($is_local_payment)
                                    <div class="w-full">
                                        <div class="bg-teal-50 border border-teal-100 rounded-lg">
                                            <div class="px-4 py-3 border-b border-teal-100">
                                                <h6 class="text-teal-600 font-bold mb-0 flex items-center">
                                                    <i class="fas fa-mobile-alt mr-2"></i>Local Payment Configuration
                                                </h6>
                                            </div>
                                            <div class="p-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Wallet
                                                            URI</label>
                                                        <input type="text"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('wallet_uri') border-red-500 @enderror"
                                                            wire:model="wallet_uri"
                                                            placeholder="e.g., bkash://pay?amount=">
                                                        @error('wallet_uri')
                                                            <div class="text-red-500 text-sm mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                        <small class="text-gray-500 text-sm">Deep link URI for mobile
                                                            wallet apps</small>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Barcode/QR
                                                            Screenshot</label>
                                                        <input type="file"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('barcode_screenshot') border-red-500 @enderror"
                                                            wire:model.live="barcode_screenshot" accept="image/*">
                                                        @error('barcode_screenshot')
                                                            <div class="text-red-500 text-sm mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                        <small class="text-gray-500 text-sm">Upload QR code or barcode
                                                            image (max 2MB)</small>
                                                    </div>
                                                </div>
                                                @if ($barcode_screenshot)
                                                    <div class="mt-3">
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Preview:</label>
                                                        <div class="text-center">
                                                            <img src="{{ $barcode_screenshot->temporaryUrl() }}"
                                                                alt="Preview"
                                                                class="border border-gray-200 rounded-lg shadow-sm max-w-[200px] max-h-[200px] mx-auto">
                                                        </div>
                                                    </div>
                                                @elseif($editingGateway && $editingGateway->barcode_screenshot_path)
                                                    <div class="mt-3">
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Current
                                                            Image:</label>
                                                        <div class="text-center">
                                                            <img src="{{ asset($editingGateway->barcode_screenshot_path) }}"
                                                                alt="Current"
                                                                class="border border-gray-200 rounded-lg shadow-sm max-w-[200px] max-h-[200px] mx-auto">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Online Gateway Configuration -->
                                    <div class="w-full">
                                        <div class="bg-teal-50 border border-teal-100 rounded-lg">
                                            <div class="px-4 py-3 border-b border-teal-100">
                                                <h6 class="text-teal-600 font-bold mb-0 flex items-center">
                                                    <i class="fas fa-globe mr-2"></i>Gateway Configuration
                                                </h6>
                                            </div>
                                            <div class="p-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">API
                                                            Key</label>
                                                        <input type="text"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('api_key') border-red-500 @enderror"
                                                            wire:model="api_key" placeholder="Gateway API Key">
                                                        @error('api_key')
                                                            <div class="text-red-500 text-sm mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">API
                                                            Secret</label>
                                                        <input type="password"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('api_secret') border-red-500 @enderror"
                                                            wire:model="api_secret" placeholder="Gateway API Secret">
                                                        @error('api_secret')
                                                            <div class="text-red-500 text-sm mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label
                                                            class="block text-sm font-semibold text-gray-700 mb-2">Webhook
                                                            URL</label>
                                                        <input type="url"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('webhook_url') border-red-500 @enderror"
                                                            wire:model="webhook_url"
                                                            placeholder="https://example.com/webhook">
                                                        @error('webhook_url')
                                                            <div class="text-red-500 text-sm mt-1">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Settings -->
                                <div class="w-full">
                                    <div class="bg-teal-50 border border-teal-100 rounded-lg">
                                        <div class="px-4 py-3 border-b border-teal-100">
                                            <h6 class="text-teal-600 font-bold mb-0 flex items-center">
                                                <i class="fas fa-cog mr-2"></i>Settings
                                            </h6>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex items-center space-x-6">
                                                <label class="flex items-center">
                                                    <input type="checkbox" wire:model="is_active"
                                                        class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2">
                                                    <span
                                                        class="ml-2 text-sm font-semibold text-gray-700">Active</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="checkbox" wire:model="is_test_mode"
                                                        class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2">
                                                    <span
                                                        class="ml-2 text-sm font-semibold text-gray-700">Test Mode</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $showCreateModal ? 'Create' : 'Update' }}
                            </button>
                            <button type="button" wire:click="closeModals"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto @if ($showDeleteModal) block @else hidden @endif">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModals"></div>
            <div
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-red-600 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Deletion
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="closeModals">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-trash-alt text-red-500 text-5xl"></i>
                    </div>
                    <h4 class="font-bold mb-3 text-gray-900">Are you sure you want to delete this payment gateway?</h4>
                    @if ($gatewayToDelete)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center text-yellow-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <div class="text-left">
                                    <div><strong>Gateway:</strong> {{ $gatewayToDelete->name }}</div>
                                    <div><strong>Provider:</strong> {{ $gatewayToDelete->provider }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <p class="text-gray-600 mb-6 flex items-center justify-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        This action cannot be undone and will permanently remove all associated data.
                    </p>
                </div>
                <div class="flex justify-center space-x-3">
                    <button type="button"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200 flex items-center"
                        wire:click="closeModals">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="button"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center"
                        wire:click="delete">
                        <i class="fas fa-trash mr-2"></i>Delete Gateway
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Backdrop -->
    @if ($showCreateModal || $showEditModal || $showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    @endif
</div>
