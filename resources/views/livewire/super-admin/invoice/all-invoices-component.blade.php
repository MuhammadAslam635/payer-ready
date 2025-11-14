<div>
    <!-- Page Header -->
    <div class="mb-6 bg-white p-5 rounded-md">
        <div class="flex flex-col lg:flex-row justify-between gap-2">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Invoice Management</h1>
                <p class="text-gray-600 mt-2">Manage all invoices and billing records</p>
            </div>
            <div>
                <a href="{{ route('super-admin.create_invoice') }}" wire:navigate
                    class="inline-block px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition duration-300">
                    Create Invoice
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_invoices']) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Amount</p>
                    <p class="text-2xl font-semibold text-gray-900">${{ number_format($stats['total_amount'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pending_invoices']) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Overdue</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['overdue_invoices']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" wire:model.live="search" placeholder="Invoice Number, Notes, User..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- User Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                    <select wire:model.live="userFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date" wire:model.live="dateFrom"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date" wire:model.live="dateTo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button wire:click="clearFilters"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Clear Filters
                </button>

                <button wire:click="downloadAllInvoices"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download All (CSV)
                </button>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Invoice Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tax</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <!-- Invoice Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}
                                </div>
                                @if ($invoice->notes)
                                    <div class="text-sm text-gray-500 truncate max-w-xs"
                                        title="{{ $invoice->notes }}">
                                        {{ Str::limit($invoice->notes, 50) }}
                                    </div>
                                @endif
                            </td>

                            <!-- User Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($invoice->user)
                                    <div class="text-sm font-medium text-gray-900">{{ $invoice->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $invoice->user->email }}</div>
                                @else
                                    <span class="text-sm text-gray-400">N/A</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusColor($invoice->status) }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>

                            <!-- Subtotal -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($invoice->subtotal, 2) }}
                                </div>
                            </td>

                            <!-- Discount -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    ${{ number_format($invoice->discount, 2) }}
                                </div>
                            </td>

                            <!-- Tax -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    ${{ number_format($invoice->tax, 2) }}
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($invoice->total, 2) }}
                                </div>
                            </td>

                            <!-- Due Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $invoice->created_at->format('H:i:s') }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- Download Button -->
                                    <button wire:click="downloadInvoice({{ $invoice->id }})"
                                        class="text-blue-600 hover:text-blue-900 p-1 rounded"
                                        title="Download Invoice">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Status Update Dropdown -->
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="text-green-600 hover:text-green-900 p-1 rounded"
                                            title="Update Status">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                            <div class="py-1">
                                                @foreach ($statusOptions as $status => $label)
                                                    @if ($status !== $invoice->status)
                                                        <button
                                                            wire:click="updateStatus({{ $invoice->id }}, '{{ $status }}')"
                                                            @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Change to {{ $label }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    @if($invoice->status === 'pending')
                                        <!-- Link Payment Button -->
                                        <button wire:click="openLinkPaymentModal({{ $invoice->id }})"
                                                class="text-teal-600 hover:text-teal-900 p-1 rounded" 
                                                title="Link Payment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <!-- View Details Button -->
                                    <button class="text-gray-600 hover:text-gray-900 p-1 rounded" title="View Details"
                                        x-data=""
                                        @click="$dispatch('open-modal', 'invoice-{{ $invoice->id }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Invoice Details Modal -->
                        <div x-data="{ show: false }"
                            @open-modal.window="show = ($event.detail === 'invoice-{{ $invoice->id }}')"
                            @close-modal.window="show = false" x-show="show"
                            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                            <div class="flex items-center justify-center min-h-screen px-4">
                                <div class="fixed inset-0 bg-black opacity-50" @click="show = false"></div>
                                <div class="relative bg-white rounded-lg max-w-2xl w-full p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Invoice Details</h3>
                                        <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</div>
                                        <div><strong>Status:</strong> <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusColor($invoice->status) }}">{{ ucfirst($invoice->status) }}</span>
                                        </div>
                                        <div><strong>Subtotal:</strong> ${{ number_format($invoice->subtotal, 2) }}</div>
                                        <div><strong>Discount:</strong> ${{ number_format($invoice->discount, 2) }}</div>
                                        <div><strong>Tax:</strong> ${{ number_format($invoice->tax, 2) }}</div>
                                        <div><strong>Total:</strong> ${{ number_format($invoice->total, 2) }}</div>
                                        <div><strong>User:</strong>
                                            {{ $invoice->user ? $invoice->user->name : 'N/A' }}</div>
                                        <div><strong>Email:</strong>
                                            {{ $invoice->user ? $invoice->user->email : 'N/A' }}</div>
                                        <div><strong>Due Date:</strong>
                                            {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}</div>
                                        <div><strong>Created:</strong>
                                            {{ $invoice->created_at->format('M d, Y H:i:s') }}</div>
                                    </div>

                                    @if ($invoice->notes)
                                        <div class="mt-4">
                                            <strong>Notes:</strong>
                                            <p class="mt-1 text-gray-700">{{ $invoice->notes }}</p>
                                        </div>
                                    @endif

                                    @if ($invoice->invoiceItems && $invoice->invoiceItems->count() > 0)
                                        <div class="mt-4">
                                            <strong>Invoice Items:</strong>
                                            <div class="mt-2 space-y-2">
                                                @foreach ($invoice->invoiceItems as $item)
                                                    <div class="bg-gray-50 p-3 rounded text-sm">
                                                        <div><strong>{{ $item->description }}</strong></div>
                                                        <div>Quantity: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }} = ${{ number_format($item->amount, 2) }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No invoices found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria or filters.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($invoices->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

    <!-- Link Payment Modal -->
    @if($showLinkPaymentModal && $selectedInvoiceForLink)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="link-payment-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeLinkPaymentModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 py-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900" id="link-payment-modal-title">Link Payment to Invoice</h3>
                            <button wire:click="closeLinkPaymentModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Invoice Info -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Invoice Number</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $selectedInvoiceForLink->invoice_number }}</p>
                                <p class="text-sm text-gray-500 mt-1">Amount: <span class="font-semibold text-teal-600">${{ number_format($selectedInvoiceForLink->total, 2) }}</span></p>
                                <p class="text-sm text-gray-500">User: {{ $selectedInvoiceForLink->user->name ?? 'N/A' }}</p>
                            </div>

                            <!-- Payment Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Payment</label>
                                @php
                                    $availablePayments = $this->getAvailablePayments();
                                @endphp
                                
                                @if($availablePayments->count() > 0)
                                    <select wire:model="selectedTransactionId" class="w-full border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                        <option value="">Select a payment...</option>
                                        @foreach($availablePayments as $payment)
                                            @php
                                                $userPayment = $payment->userGatewayPayment();
                                            @endphp
                                            <option value="{{ $payment->id }}">
                                                {{ $payment->payment_gateway ?? 'N/A' }} - 
                                                Txn ID: {{ $payment->gateway_transaction_id ?? 'N/A' }} - 
                                                ${{ number_format($payment->amount, 2) }} - 
                                                {{ $payment->created_at->format('M d, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selectedTransactionId') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-sm text-yellow-800">No available payments found for this user.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        @if($availablePayments->count() > 0)
                            <button wire:click="linkPayment"
                                    wire:target="linkPayment"
                                    wire:loading.attr="disabled"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 text-base font-medium text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 sm:ml-3 sm:w-auto sm:text-sm">
                                <span wire:loading.remove wire:target="linkPayment">Link Payment</span>
                                <span wire:loading wire:target="linkPayment" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Linking...
                                </span>
                            </button>
                        @endif
                        <button wire:click="closeLinkPaymentModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700">Loading...</span>
        </div>
    </div>
</div>
