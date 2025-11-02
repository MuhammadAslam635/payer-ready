<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Invoice Payments</h1>
                    <p class="mt-1 text-sm text-slate-600">Submit manual payments with transaction ID and screenshot.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button wire:click="openAddModal"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Payment
                    </button>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Screenshot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($payments as $payment)
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payment->transaction_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->screenshot_path)
                                    <a href="{{url($payment->screenshot_path) }}" target="_blank" class="text-teal-600 hover:text-teal-800 text-sm">View</a>
                                @else
                                    <span class="text-slate-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $payment->created_at->format('m/d/Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
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
                            </div>

                            @if($selectedGateway)
                            <div class="flex items-center space-x-3">
                                @if($selectedGateway->barcode_screenshot_path)
                                    <img src="{{ asset($selectedGateway->barcode_screenshot_path) }}" alt="barcode" class="h-16 w-16 rounded object-cover border" />
                                @endif
                                @if($selectedGateway->wallet_uri)
                                    <a href="{{ $selectedGateway->wallet_uri }}" target="_blank" class="text-teal-600 hover:text-teal-800 text-sm">Open Wallet/Pay Link</a>
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
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="save" wire:target="save" wire:loading.attr="disabled"
                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-70 disabled:cursor-not-allowed sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading.remove wire:target="save">Submit</span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                        <button type="button" wire:click="closeAddModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


