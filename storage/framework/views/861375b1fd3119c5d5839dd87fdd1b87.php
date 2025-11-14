<div class="space-y-6">
    <!-- Professional Payout Message -->
    <div class="bg-gradient-to-r from-teal-50 to-blue-50 border border-teal-200 rounded-lg p-6 shadow-sm">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Payment & Payout Management</h3>
                <p class="text-sm text-slate-700 mb-3">
                    You can add payments on behalf of your doctors. Use the payout link below to submit payment transaction details. 
                    The admin will process these payments and update the invoice status accordingly.
                </p>
                <button wire:click="openAddModal"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Submit Payout for Doctor
                </button>
            </div>
        </div>
    </div>

    <!-- Pending Invoices Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Pending Invoices</h2>
                    <p class="mt-1 text-sm text-slate-600">Select a doctor to view their pending invoices.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Select Doctor</label>
                    <select wire:model.live="selectedDoctorId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Select Doctor</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doctor->id); ?>"><?php echo e($doctor->name); ?> (<?php echo e($doctor->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($selectedDoctorId): ?>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Search Invoice</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'magnifying-glass','class' => 'h-5 w-5 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'magnifying-glass','class' => 'h-5 w-5 text-slate-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                            </div>
                            <input wire:model.live="invoiceSearch" type="text"
                                class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                placeholder="Search by invoice number...">
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php if($selectedDoctorId): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $pendingInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer <?php echo e($selectedInvoiceId == $invoice->id ? 'ring-2 ring-teal-500 border-teal-500' : ''); ?>"
                             wire:click="openInvoiceModal(<?php echo e($invoice->id); ?>)">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-900"><?php echo e($invoice->invoice_number); ?></h3>
                                    <p class="text-xs text-slate-500 mt-1">Due: <?php echo e($invoice->due_date?->format('M d, Y') ?? 'N/A'); ?></p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </div>
                            <div class="mt-3">
                                <p class="text-lg font-bold text-teal-600">$<?php echo e(number_format($invoice->total, 2)); ?></p>
                                <p class="text-xs text-slate-500 mt-1"><?php echo e($invoice->invoiceItems->count()); ?> item(s)</p>
                            </div>
                            <button wire:click.stop="openPayoutFromInvoice(<?php echo e($invoice->id); ?>)" 
                                    class="mt-3 w-full text-xs px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md transition-colors">
                                Pay Now
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full py-12 text-center">
                            <div class="text-slate-500">
                                <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'document-text','class' => 'mx-auto h-12 w-12 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'document-text','class' => 'mx-auto h-12 w-12 text-slate-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                                <h3 class="mt-2 text-sm font-medium text-slate-900">No pending invoices</h3>
                                <p class="mt-1 text-sm text-slate-500">This doctor has no pending invoices.</p>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php else: ?>
                <div class="py-12 text-center">
                    <div class="text-slate-500">
                        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'user','class' => 'mx-auto h-12 w-12 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user','class' => 'mx-auto h-12 w-12 text-slate-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                        <h3 class="mt-2 text-sm font-medium text-slate-900">Select a doctor</h3>
                        <p class="mt-1 text-sm text-slate-500">Please select a doctor to view their pending invoices.</p>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Doctor Invoice Payments</h1>
                    <p class="mt-1 text-sm text-slate-600">Payments submitted by doctors you created.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'magnifying-glass','class' => 'h-5 w-5 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'magnifying-glass','class' => 'h-5 w-5 text-slate-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                        </div>
                        <input wire:model.live="search" type="text"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                            placeholder="Search by gateway or transaction id...">
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <select wire:model.live="perPage" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
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
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Gateway</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Screenshot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $transaction = \App\Models\Transaction::where('metadata->user_gateway_payment_id', $payment->id)
                                ->with('invoice')
                                ->first();
                            $invoice = $transaction?->invoice;
                            $status = $transaction?->status ?? 'pending';
                        ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900"><?php echo e($payment->user->name ?? '—'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <!--[if BLOCK]><![endif]--><?php if(($payment->paymentGateway->barcode_screenshot_path ?? null)): ?>
                                        <img src="<?php echo e(asset($payment->paymentGateway->barcode_screenshot_path)); ?>" alt="barcode" class="h-8 w-8 rounded object-cover">
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div>
                                        <div class="text-sm font-medium text-slate-900"><?php echo e($payment->paymentGateway->name ?? 'Unknown'); ?></div>
                                        <div class="text-xs text-slate-500"><?php echo e($payment->paymentGateway->provider ?? ''); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!--[if BLOCK]><![endif]--><?php if($invoice): ?>
                                    <div class="text-sm font-medium text-slate-900"><?php echo e($invoice->invoice_number); ?></div>
                                    <div class="text-xs text-slate-500">$<?php echo e(number_format($invoice->total, 2)); ?></div>
                                <?php else: ?>
                                    <span class="text-slate-400 text-sm">—</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900"><?php echo e($payment->transaction_id); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!--[if BLOCK]><![endif]--><?php if($status === 'completed' || $status === 'paid'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!--[if BLOCK]><![endif]--><?php if($payment->screenshot_path): ?>
                                    <?php
                                        // Check if it's a full URL or a storage path
                                        if (str_starts_with($payment->screenshot_path, 'http')) {
                                            $imageUrl = $payment->screenshot_path;
                                        } elseif (str_starts_with($payment->screenshot_path, '/storage/')) {
                                            $imageUrl = asset($payment->screenshot_path);
                                        } else {
                                            $imageUrl = url($payment->screenshot_path);
                                        }
                                    ?>
                                    <a href="<?php echo e($imageUrl); ?>" target="_blank" class="inline-block group">
                                        <img src="<?php echo e($imageUrl); ?>" alt="Screenshot" class="h-12 w-12 rounded object-cover border border-slate-200 group-hover:border-teal-400 transition-colors cursor-pointer" 
                                             onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.png')); ?>';" />
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400 text-sm">—</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900"><?php echo e($payment->created_at->format('m/d/Y h:i A')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-slate-500">
                                    <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'document-text','class' => 'mx-auto h-12 w-12 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'document-text','class' => 'mx-auto h-12 w-12 text-slate-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                                    <h3 class="mt-2 text-sm font-medium text-slate-900">No payments found</h3>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4"><?php echo e($payments->links()); ?></div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($showAddModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 py-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Payment</h3>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Doctor</label>
                                <select wire:model.live="selectedDoctorId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">Select Doctor</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($doctor->id); ?>"><?php echo e($doctor->name); ?> (<?php echo e($doctor->email); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedDoctorId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Invoice Selection (shown only when doctor is selected) -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedDoctorId): ?>
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Select Invoice (Optional)</label>
                                    <select wire:model.live="selectedInvoiceId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                        <option value="">No specific invoice (General payment)</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $pendingInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($invoice->id); ?>">
                                                <?php echo e($invoice->invoice_number); ?> - $<?php echo e(number_format($invoice->total, 2)); ?> (Due: <?php echo e($invoice->due_date?->format('M d, Y') ?? 'N/A'); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php if($selectedInvoiceId): ?>
                                        <?php
                                            $selectedInv = $pendingInvoices->firstWhere('id', $selectedInvoiceId);
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php if($selectedInv): ?>
                                            <p class="mt-1 text-xs text-teal-600">
                                                Invoice: <?php echo e($selectedInv->invoice_number); ?> | Amount: $<?php echo e(number_format($selectedInv->total, 2)); ?>

                                            </p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Payment Gateway</label>
                                <select wire:model.live="selectedGatewayId" class="w-full text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                    <option value="">Select Gateway</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!--[if BLOCK]><![endif]--><?php if($gateway->is_active): ?>
                                            <option value="<?php echo e($gateway->id); ?>"><?php echo e($gateway->name); ?></option>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedGatewayId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if($selectedGateway): ?>
                            <div class="flex flex-col items-center justify-center space-y-3 py-4">
                                <!--[if BLOCK]><![endif]--><?php if($selectedGateway->barcode_screenshot_path): ?>
                                    <img src="<?php echo e(asset($selectedGateway->barcode_screenshot_path)); ?>" alt="barcode" class="h-64 w-64 rounded object-contain border border-slate-200 shadow-sm" />
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($selectedGateway->wallet_uri): ?>
                                    <a href="<?php echo e($selectedGateway->wallet_uri); ?>" target="_blank" class="text-teal-600 hover:text-teal-800 text-sm font-medium">Open Wallet/Pay Link</a>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Transaction ID</label>
                                <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'text','wire:model.defer' => 'transactionId','placeholder' => 'Enter transaction/reference id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model.defer' => 'transactionId','placeholder' => 'Enter transaction/reference id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['transactionId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Screenshot (optional)</label>
                                <input type="file" wire:model="screenshot" accept="image/*"
                                    class="block w-full text-sm border border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500" />
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['screenshot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($screenshot): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo e($screenshot->temporaryUrl()); ?>" alt="Preview" class="h-24 w-24 rounded object-cover border border-slate-200" />
                                        <p class="text-xs text-slate-500 mt-1">Preview</p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div wire:loading wire:target="screenshot" class="mt-1">
                                    <p class="text-xs text-teal-600">Uploading...</p>
                                </div>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Invoice Detail Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showInvoiceModal && $selectedInvoice): ?>
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
                                    <p class="text-lg font-semibold text-gray-900"><?php echo e($selectedInvoice->invoice_number); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        <?php if($selectedInvoice->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($selectedInvoice->status === 'paid'): ?> bg-green-100 text-green-800
                                        <?php else: ?> bg-gray-100 text-gray-800
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($selectedInvoice->status ?? 'Pending')); ?>

                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Doctor</p>
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($selectedInvoice->user->name ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Due Date</p>
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($selectedInvoice->due_date?->format('M d, Y') ?? 'N/A'); ?></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Total Amount</p>
                                    <p class="text-lg font-bold text-teal-600">$<?php echo e(number_format($selectedInvoice->total, 2)); ?></p>
                                </div>
                            </div>

                            <!-- Invoice Items -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedInvoice->invoiceItems && $selectedInvoice->invoiceItems->count() > 0): ?>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Invoice Items</h4>
                                    <div class="space-y-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedInvoice->invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-gray-900"><?php echo e($item->description); ?></p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            Quantity: <?php echo e($item->quantity); ?> × $<?php echo e(number_format($item->unit_price, 2)); ?>

                                                        </p>
                                                    </div>
                                                    <p class="text-sm font-semibold text-gray-900">$<?php echo e(number_format($item->amount, 2)); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Totals -->
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">$<?php echo e(number_format($selectedInvoice->subtotal, 2)); ?></span>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($selectedInvoice->discount > 0): ?>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Discount</span>
                                        <span class="text-gray-900">-$<?php echo e(number_format($selectedInvoice->discount, 2)); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($selectedInvoice->tax > 0): ?>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="text-gray-900">$<?php echo e(number_format($selectedInvoice->tax, 2)); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="flex justify-between text-base font-bold pt-2 border-t">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-teal-600">$<?php echo e(number_format($selectedInvoice->total, 2)); ?></span>
                                </div>
                            </div>

                            <!-- Notes -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedInvoice->notes): ?>
                                <div class="border-t pt-4">
                                    <p class="text-sm font-semibold text-gray-900 mb-2">Notes</p>
                                    <p class="text-sm text-gray-600"><?php echo e($selectedInvoice->notes); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <!-- Footer with Payout Button -->
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        <button wire:click="openPayoutFromInvoice"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-teal-600 text-base font-medium text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Submit Payout
                        </button>
                        <button wire:click="closeInvoiceModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<script>
    // Listen for invoice modal event from notifications
    window.addEventListener('open-invoice-modal', event => {
        window.Livewire.find('<?php echo e($_instance->getId()); ?>').openInvoiceModal(event.detail.invoiceId);
    });
</script>


<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/organization/doctor-invoice-payments-component.blade.php ENDPATH**/ ?>