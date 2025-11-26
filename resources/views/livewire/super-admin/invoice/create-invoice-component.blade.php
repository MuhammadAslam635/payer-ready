<div>
    <!-- Page Header -->
    <x-breadcrumbs tagline="Create New Invoice" />


    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form wire:submit.prevent="createInvoice">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Invoice Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Doctor Selection -->
                        <div>
                            <x-ui.label>
                                Select Doctor
                            </x-ui.label>
                            <x-ui.select
                                class="w-full"
                                placeholder="Search and select doctor..."
                                icon="user-circle"
                                wire:model.live="selectedDoctor"
                                searchable
                                clearable
                            >
                                @foreach($doctors as $doctor)
                                    <x-ui.select.option value="{{ $doctor->id }}" icon="user">
                                        {{ $doctor->name }}
                                    </x-ui.select.option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.error name="selectedDoctor" />
                        </div>

                        <!-- Item Selection Buttons -->
                        @if($selectedDoctor)
                            <div>
                                <x-ui.label>Add Items to Invoice</x-ui.label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <x-ui.button
                                        wire:click="openItemModal('certificates')"
                                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Add Certificates
                                    </x-ui.button>

                                    <x-ui.button
                                        wire:click="openItemModal('licenses')"
                                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2 12.5 12.5 0 01-.1 1.606c-.06.357-.23.694-.47.984l-2.755 3.4c-.14.172-.331.29-.541.29H8a2 2 0 01-2-2v-7a2 2 0 012-2h3m7 0V5a2 2 0 00-2-2H9.5a2 2 0 00-2 2v2m7 0h.01"></path>
                                        </svg>
                                        Add Licenses
                                    </x-ui.button>

                                    <x-ui.button
                                        wire:click="openItemModal('credentials')"
                                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        Add Credentials
                                    </x-ui.button>
                                </div>
                            </div>

                            <!-- Manual Item Entry -->
                            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-4 mt-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                                        </svg>
                                        Add Custom Service
                                    </h4>
                                    <span class="text-xs text-gray-500">Use when no predefined item fits</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-1">
                                        <x-ui.label>Service Name</x-ui.label>
                                        <x-ui.input
                                            type="text"
                                            wire:model.live="manualItemName"
                                            placeholder="e.g., Expedited Application"
                                            class="mt-1 block w-full"
                                        />
                                        <x-ui.error name="manualItemName" />
                                    </div>
                                    <div class="sm:col-span-1">
                                        <x-ui.label>Amount (USD)</x-ui.label>
                                        <x-ui.input
                                            type="number"
                                            wire:model.live="manualItemAmount"
                                            min="0"
                                            step="0.01"
                                            placeholder="0.00"
                                            class="mt-1 block w-full"
                                        />
                                        <x-ui.error name="manualItemAmount" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-ui.label>Description (optional)</x-ui.label>
                                        <textarea
                                            wire:model.live="manualItemDescription"
                                            rows="2"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            placeholder="Add any details about this service..."
                                        ></textarea>
                                        <x-ui.error name="manualItemDescription" />
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <x-ui.button
                                        type="button"
                                        wire:click="addManualItem"
                                        wire:loading.attr="disabled"
                                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <span wire:loading.remove wire:target="addManualItem">Add Custom Item</span>
                                        <span wire:loading wire:target="addManualItem">Adding...</span>
                                    </x-ui.button>
                                </div>
                            </div>
                        @endif

                        <!-- Invoice Details -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-ui.label>
                                    Due Date
                                </x-ui.label>
                                <x-ui.input
                                    type="date"
                                    wire:model="dueDate"
                                    class="mt-1 block w-full"
                                 />
                                 <x-ui.error name="dueDate" />
                            </div>

                            <div>
                                <x-ui.label>
                                    Discount ($)
                                </x-ui.label>
                                <x-ui.input
                                    type="number"
                                    wire:model.live="discount"
                                    step="0.1"
                                    min="0"
                                    class="mt-1 block w-full"
                                    placeholder="0.00"
                                />
                                <x-ui.error name="discount" />
                            </div>
                        </div>

                        <div>
                            <x-ui.label>
                                Tax ($)
                            </x-ui.label>
                            <x-ui.input
                                type="number"
                                id="tax"
                                wire:model.live="tax"
                                step="0.1"
                                min="0"
                                class="mt-1 block w-full"
                                placeholder="0.00"
                            />
                            <x-ui.error name="tax" />
                        </div>

                        <div>
                            <label for="invoiceNotes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes
                            </label>
                            <textarea
                                id="invoiceNotes"
                                wire:model="invoiceNotes"
                                rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Additional notes for this invoice..."
                            ></textarea>
                            @error('invoiceNotes')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Cart Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 sticky top-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                                Invoice Items
                                @if($cartCount > 0)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </h3>

                            @if(count($cartItems) > 0)
                                <div class="space-y-3 mb-4">
                                    @foreach($cartItems as $item)
                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h4>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $item['options']['description'] }}</p>
                                                    <div class="mt-2">
                                                        <x-ui.input
                                                            type="number"
                                                            wire:change="updateCartItemPrice('{{ $item['rowId'] }}', $event.target.value)"
                                                            value="{{ $item['price'] }}"
                                                            step="0.01"
                                                            min="0"
                                                            class="w-20 text-xs border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                                                        />
                                                        <span class="text-xs text-gray-500 ml-1">USD</span>
                                                    </div>
                                                </div>
                                                <button
                                                    type="button"
                                                    wire:click="removeFromCart('{{ $item['rowId'] }}')"
                                                    class="ml-2 text-red-400 hover:text-red-600"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Cart Totals -->
                                <div class="border-t border-gray-200 pt-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-medium">${{ number_format($cartSubtotal, 2) }}</span>
                                    </div>
                                    @if($discount > 0)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Discount:</span>
                                            <span class="font-medium text-red-600">-${{ number_format($discount, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($tax > 0)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Tax:</span>
                                            <span class="font-medium">+${{ number_format($tax, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between text-base font-semibold border-t border-gray-200 pt-2">
                                        <span>Total:</span>
                                        <span>${{ number_format($cartSubtotal - (float) $discount + (float) $tax, 2) }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No items added</h3>
                                    <p class="mt-1 text-sm text-gray-500">Select a doctor and add items to create an invoice.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3 border-t border-gray-200 pt-6">
                    <button
                        type="button"
                        onclick="window.history.back()"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(count($cartItems) === 0) disabled @endif
                    >
                        <span wire:loading.remove wire:target="createInvoice">Create Invoice</span>
                        <span wire:loading wire:target="createInvoice">Creating...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Item Selection Modal -->
    @if($showItemModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Add {{ ucfirst($itemType) }}
                                </h3>

                                @if(count($availableItems) > 0)
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @foreach($availableItems as $item)
                                            <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h4>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $item['description'] }}</p>
                                                        <p class="text-sm font-medium text-green-600 mt-2">${{ number_format($item['price'], 2) }}</p>
                                                    </div>
                                                    <button
                                                        type="button"
                                                        wire:click="addToCart({{ $item['id'] }})"
                                                        class="ml-3 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    >
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No {{ $itemType }} found</h3>
                                        <p class="mt-1 text-sm text-gray-500">This doctor doesn't have any {{ $itemType }} available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
