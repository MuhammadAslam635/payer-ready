<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="invoice-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeInvoiceModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-6 py-5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900" id="invoice-modal-title">Invoice Details</h3>
                    <button wire:click="closeInvoiceModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
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
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="text-sm font-medium text-gray-900">{{ $selectedInvoice->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $selectedInvoice->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
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

                    <!-- Payment History -->
                    @if($selectedInvoice->transactions && $selectedInvoice->transactions->count() > 0)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Payment History</h4>
                            <div class="space-y-2">
                                @foreach($selectedInvoice->transactions as $transaction)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    Payment via {{ $transaction->payment_gateway ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Transaction ID: {{ $transaction->gateway_transaction_id ?? 'N/A' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Date: {{ $transaction->created_at->format('M d, Y h:i A') }}
                                                </p>
                                                @php
                                                    $payment = $transaction->userGatewayPayment();
                                                @endphp
                                                @if($payment && $payment->screenshot_path)
                                                    <a href="{{ url($payment->screenshot_path) }}" target="_blank" class="text-xs text-teal-600 hover:text-teal-800 mt-1 inline-block">
                                                        View Screenshot
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-900">${{ number_format($transaction->amount, 2) }}</p>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    @if($transaction->status === 'completed' || $transaction->status === 'paid') bg-green-100 text-green-800
                                                    @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">No payments linked to this invoice yet.</p>
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
                @if($selectedInvoice->status === 'pending')
                    <button wire:click="openPayoutFromInvoice"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 text-base font-medium text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Submit Payout
                    </button>
                @endif
                <button wire:click="closeInvoiceModal"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

