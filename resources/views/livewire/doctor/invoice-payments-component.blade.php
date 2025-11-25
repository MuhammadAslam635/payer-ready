<div class="space-y-6">
    <div class="flex justify-end">
        <button wire:click="openAddModal"
            class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            Pay Invoice
        </button>
    </div>

    <!-- Pending Invoices Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Pending Invoices</h2>
                    <p class="mt-1 text-sm text-slate-600">Select an invoice to make payment.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-ui.icon name="magnifying-glass" class="h-5 w-5 text-slate-400" />
                    </div>
                    <input wire:model.live="invoiceSearch" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                        placeholder="Search invoices by invoice number...">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($pendingInvoices as $invoice)
                    <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer {{ $selectedInvoiceId == $invoice->id ? 'ring-2 ring-teal-500 border-teal-500' : '' }}"
                         wire:click="openInvoiceModal({{ $invoice->id }})">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $invoice->invoice_number }}</h3>
                                <p class="text-xs text-slate-500 mt-1">Due: {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>
                        <div class="mt-3">
                            <p class="text-lg font-bold text-teal-600">${{ number_format($invoice->total, 2) }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $invoice->invoiceItems->count() }} item(s)</p>
                        </div>
                        <button wire:click.stop="openPayoutFromInvoice({{ $invoice->id }})" 
                                class="mt-3 w-full text-xs px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md transition-colors">
                            Pay Now
                        </button>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="text-slate-500">
                            <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                            <h3 class="mt-2 text-sm font-medium text-slate-900">No pending invoices</h3>
                            <p class="mt-1 text-sm text-slate-500">All your invoices are paid or you don't have any invoices yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Invoice Payments</h1>
                    <p class="mt-1 text-sm text-slate-600">Submit manual payments with transaction ID and screenshot.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <x-ui.button
                        type="button"
                        color="teal"
                        variant="primary"
                        icon="plus"
                        class="!px-5 uppercase tracking-wide text-xs"
                        wire:click="openAddModal">
                        Pay Invoice
                    </x-ui.button>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-ui.icon name="magnifying-glass" class="h-5 w-5 text-slate-400" />
                        </div>
                        <input wire:model.live="search" type="text"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                            placeholder="Search by gateway or transaction id...">
                    </div>
                </div>
                <div>
                    <select wire:model.live="perPage" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Gateway</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Screenshot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($payments as $payment)
                        @php
                            $transaction = \App\Models\Transaction::where('metadata->user_gateway_payment_id', $payment->id)
                                ->with('invoice')
                                ->first();
                            $invoice = $transaction?->invoice;
                            $status = $transaction?->status ?? 'pending';
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if(($payment->paymentGateway->barcode_screenshot_path ?? null))
                                        <img src="{{ asset($payment->paymentGateway->barcode_screenshot_path) }}" alt="barcode" class="h-8 w-8 rounded object-cover">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $payment->paymentGateway->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-slate-500">{{ $payment->paymentGateway->provider ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($invoice)
                                    <div class="text-sm font-medium text-slate-900">{{ $invoice->invoice_number }}</div>
                                    <div class="text-xs text-slate-500">${{ number_format($invoice->total, 2) }}</div>
                                @else
                                    <span class="text-slate-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payment->transaction_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($status === 'completed' || $status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->screenshot_path)
                                    @php
                                        // Check if it's a full URL or a storage path
                                        if (str_starts_with($payment->screenshot_path, 'http')) {
                                            $imageUrl = $payment->screenshot_path;
                                        } elseif (str_starts_with($payment->screenshot_path, '/storage/')) {
                                            $imageUrl = asset($payment->screenshot_path);
                                        } else {
                                            $imageUrl = url($payment->screenshot_path);
                                        }
                                    @endphp
                                    <a href="{{ $imageUrl }}" target="_blank" class="inline-block group">
                                        <img src="{{ $imageUrl }}" alt="Screenshot" class="h-12 w-12 rounded object-cover border border-slate-200 group-hover:border-teal-400 transition-colors cursor-pointer" 
                                             onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';" />
                                    </a>
                                @else
                                    <span class="text-slate-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payment->created_at->format('m/d/Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-slate-500">
                                    <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No payments submitted yet</h3>
                                    <p class="mt-1 text-sm text-slate-500">Click Add Payment to submit one.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">{{ $payments->links() }}</div>
    </div>

    @if($showAddModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Payment</h3>

                        <div class="mt-4 space-y-4">
                            <!-- Invoice Selection -->
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Select Invoice (Optional)</label>
                                <select wire:model.live="selectedInvoiceId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">No specific invoice (General payment)</option>
                                    @foreach($pendingInvoices as $invoice)
                                        <option value="{{ $invoice->id }}">
                                            {{ $invoice->invoice_number }} - ${{ number_format($invoice->total, 2) }} (Due: {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($selectedInvoiceId)
                                    @php
                                        $selectedInv = $pendingInvoices->firstWhere('id', $selectedInvoiceId);
                                    @endphp
                                    @if($selectedInv)
                                        <p class="mt-1 text-xs text-teal-600">
                                            Invoice: {{ $selectedInv->invoice_number }} | Amount: ${{ number_format($selectedInv->total, 2) }}
                                        </p>
                                    @endif
                                @endif
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Payment Gateway</label>
                                <select wire:model.live="selectedGatewayId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">Select Gateway</option>
                                    @foreach($gateways as $gateway)
                                        @if($gateway->is_active)
                                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('selectedGatewayId') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            @if($selectedGateway)
                            <div class="flex flex-col items-center justify-center space-y-3 py-4">
                                @if($selectedGateway->barcode_screenshot_path)
                                    <img src="{{ asset($selectedGateway->barcode_screenshot_path) }}" alt="barcode" class="h-64 w-64 rounded object-contain border border-slate-200 shadow-sm" />
                                @endif
                                @if($selectedGateway->wallet_uri)
                                    <a href="{{ $selectedGateway->wallet_uri }}" target="_blank" class="text-teal-600 hover:text-teal-800 text-sm font-medium">Open Wallet/Pay Link</a>
                                @endif
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Transaction ID</label>
                                <x-ui.input type="text" wire:model.defer="transactionId" placeholder="Enter transaction/reference id" />
                                @error('transactionId') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Screenshot (optional)</label>
                                <input type="file" wire:model="screenshot" accept="image/*"
                                    class="block w-full text-sm border border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500" />
                                @error('screenshot') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                @if($screenshot)
                                    <div class="mt-2">
                                        <img src="{{ $screenshot->temporaryUrl() }}" alt="Preview" class="h-24 w-24 rounded object-cover border border-slate-200" />
                                        <p class="text-xs text-slate-500 mt-1">Preview</p>
                                    </div>
                                @endif
                                <div wire:loading wire:target="screenshot" class="mt-1">
                                    <p class="text-xs text-teal-600">Uploading...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 sm:flex sm:flex-row-reverse gap-2">
                        <x-ui.button
                            type="button"
                            color="teal"
                            variant="primary"
                            class="sm:ml-3 sm:w-auto"
                            wire:click="save"
                            wire:target="save"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Submit</span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </x-ui.button>
                        <x-ui.button
                            type="button"
                            variant="outline"
                            color="slate"
                            class="mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto"
                            wire:click="closeAddModal">
                            Cancel
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Invoice Detail Modal -->
    @if($showInvoiceModal && $selectedInvoice)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="invoice-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeInvoiceModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-6 py-5">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900" id="invoice-modal-title">Invoice Details</h3>
                            <button wire:click="closeInvoiceModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Invoice Header Info -->
                            <div class="grid grid-cols-2 gap-4 pb-4 border-b">
                                <div>
                                    <p class="text-sm text-gray-500">Invoice Number</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $selectedInvoice->invoice_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if($selectedInvoice->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($selectedInvoice->status === 'paid') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($selectedInvoice->status ?? 'Pending') }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Due Date</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $selectedInvoice->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Amount</p>
                                    <p class="text-lg font-bold text-teal-600">${{ number_format($selectedInvoice->total, 2) }}</p>
                                </div>
                            </div>

                            <!-- Invoice Items -->
                            @if($selectedInvoice->invoiceItems && $selectedInvoice->invoiceItems->count() > 0)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Invoice Items</h4>
                                    <div class="space-y-2">
                                        @foreach($selectedInvoice->invoiceItems as $item)
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ $item->description }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            Quantity: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                                        </p>
                                                    </div>
                                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($item->amount, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Totals -->
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">${{ number_format($selectedInvoice->subtotal, 2) }}</span>
                                </div>
                                @if($selectedInvoice->discount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Discount</span>
                                        <span class="text-gray-900">-${{ number_format($selectedInvoice->discount, 2) }}</span>
                                    </div>
                                @endif
                                @if($selectedInvoice->tax > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="text-gray-900">${{ number_format($selectedInvoice->tax, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-base font-bold pt-2 border-t">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-teal-600">${{ number_format($selectedInvoice->total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($selectedInvoice->notes)
                                <div class="border-t pt-4">
                                    <p class="text-sm font-semibold text-gray-900 mb-2">Notes</p>
                                    <p class="text-sm text-gray-600">{{ $selectedInvoice->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer with Payout Button -->
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        <button wire:click="openPayoutFromInvoice"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 text-base font-medium text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Pay Invoice
                        </button>
                        <button wire:click="closeInvoiceModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    // Listen for invoice modal event from notifications
    window.addEventListener('open-invoice-modal', event => {
        @this.openInvoiceModal(event.detail.invoiceId);
    });
</script>


