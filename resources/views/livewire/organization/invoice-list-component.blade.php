<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Doctor Invoices</h1>
                    <p class="mt-1 text-sm text-slate-600">View and manage invoices for your doctors.</p>
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
                            placeholder="Search by invoice number or doctor...">
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <select wire:model.live="doctorFilter" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="">All Doctors</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="statusFilter" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                    </select>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $invoice->invoice_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ $invoice->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ $invoice->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-teal-600">${{ number_format($invoice->total, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($invoice->status) }}">
                                    {{ ucfirst($invoice->status ?? 'Pending') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $invoice->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($invoice->status === 'pending')
                                    <button wire:click="openInvoiceModal({{ $invoice->id }})"
                                            class="text-teal-600 hover:text-teal-900 mr-3">
                                        View & Pay
                                    </button>
                                @else
                                    <button wire:click="openInvoiceModal({{ $invoice->id }})"
                                            class="text-slate-600 hover:text-slate-900">
                                        View
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-slate-500">
                                    <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No invoices found</h3>
                                    <p class="mt-1 text-sm text-slate-500">You don't have any invoices yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">{{ $invoices->links() }}</div>
    </div>

    <!-- Invoice Detail Modal -->
    @if($showInvoiceModal && $selectedInvoice)
        @include('livewire.organization.partials.invoice-detail-modal')
    @endif
</div>

<script>
    window.addEventListener('open-invoice-modal', event => {
        @this.openInvoiceModal(event.detail.invoiceId);
    });
</script>

